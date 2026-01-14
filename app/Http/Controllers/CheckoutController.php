<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Services\StripeService;
use App\Services\OrderService;
use App\Services\CartService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    protected $stripeService;
    protected $orderService;
    protected $cartService;

    public function __construct(
        StripeService $stripeService,
        OrderService $orderService,
        CartService $cartService
    ) {
        $this->stripeService = $stripeService;
        $this->orderService = $orderService;
        $this->cartService = $cartService;
    }

    public function index(Request $request): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        // Ensure user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to proceed with checkout.');
        }

        try {
            $token = $request->cookie('cart_token');
            $cart = $this->cartService->getCartByToken($token);

            if (!$cart || $cart->items->isEmpty()) {
                return redirect()->route('cart')->with('error', 'Your cart is empty. Add items before checkout.');
            }

            $items = $cart->items;
            $total = $this->cartService->getTotal($cart);

            return view('checkout', compact('items', 'total'));
        } catch (\Exception $e) {
            Log::error('Checkout index error: ' . $e->getMessage());
            return redirect()->route('cart')->with('error', 'An error occurred. Please try again.');
        }
    }

    public function place(StoreOrderRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $token = $request->cookie('cart_token');
            $cart = $this->cartService->getCartByToken($token);

            if (!$cart || $cart->items->count() === 0) {
                return redirect()->route('cart')->with('error', 'Cart is empty.');
            }

            $data = $request->validated();
            $total = $this->orderService->calculateCartTotal($cart);
            $userId = auth()->id();

            // If Stripe payment, create checkout session
            if ($data['payment_method'] === 'stripe') {
                $orderRef = $this->orderService->generateOrderRef();
                $userEmail = auth()->user()?->email ?? $data['email'];
                return $this->handleStripeCheckout($cart, $data, $orderRef, $total, $userId, $userEmail);
            }

            // For other payment methods, create order using service
            $order = $this->orderService->createOrderFromCart($cart, $data, $userId, $total);

            return redirect()->route('thankyou', ['order' => $order->order_ref])
                ->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            Log::error('Order placement failed: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'cart_token' => $request->cookie('cart_token'),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('checkout')
                ->with('error', 'Failed to create order. Please try again or contact support.');
        }
    }

    /**
     * Handle Stripe checkout session creation
     */
    protected function handleStripeCheckout($cart, $data, $orderRef, $total, $userId, $userEmail): \Illuminate\Http\RedirectResponse
    {
        try {
            DB::beginTransaction();

            // Create order using service
            $order = $this->orderService->createOrderFromCart(
                $cart,
                array_merge($data, ['payment_method' => 'stripe']),
                $userId,
                $total
            );

            // Prepare line items for Stripe
            $lineItems = [];
            foreach ($cart->items as $item) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $item->name,
                            'images' => $item->img ? [image_url($item->img)] : [],
                        ],
                        'unit_amount' => (int)($item->price * 100), // Convert to cents
                    ],
                    'quantity' => (int)$item->qty,
                ];
            }

            // Create Stripe checkout session
            $session = $this->stripeService->createCheckoutSession(
                $lineItems,
                $orderRef,
                $data,
                route('checkout.stripe.success', ['order' => $orderRef]),
                route('checkout.stripe.cancel', ['order' => $orderRef])
            );

            // Create payment record using service
            $this->orderService->createPayment($order, 'stripe', $total, $session->id);

            DB::commit();

            // Redirect to Stripe Checkout
            return redirect($session->url);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Stripe checkout failed: ' . $e->getMessage());
            return redirect()->route('checkout')
                ->with('error', 'Failed to process payment. Please try again.');
        }
    }

    /**
     * Handle Stripe checkout success
     */
    public function stripeSuccess(Request $request): \Illuminate\Http\RedirectResponse
    {
        $orderRef = $request->get('order');
        $sessionId = $request->get('session_id');

        if ($sessionId) {
            try {
                $session = $this->stripeService->retrieveSession($sessionId);
                $payment = Payment::where('provider_session_id', $sessionId)->first();

                if ($payment && $session->payment_status === 'paid') {
                    // Update payment
                    $payment->update([
                        'status' => 'completed',
                        'provider_payment_id' => $session->payment_intent,
                        'provider_customer_id' => $session->customer ?? null,
                        'paid_at' => now(),
                    ]);

                    // Update order status
                    $payment->order->update([
                        'status' => 'paid',
                    ]);

                    // Clear cart using service
                    $token = $request->cookie('cart_token');
                    if ($token) {
                        $cart = $this->cartService->getCartByToken($token);
                        if ($cart) {
                            $this->cartService->clearCart($cart);
                        }
                    }

                    return redirect()->route('thankyou', ['order' => $payment->order->order_ref]);
                }
            } catch (\Exception $e) {
                Log::error('Stripe success handler error: ' . $e->getMessage());
            }
        }

        // Fallback to order ref lookup
        if ($orderRef) {
            $order = Order::where('order_ref', $orderRef)->first();
            if ($order) {
                return redirect()->route('thankyou', ['order' => $orderRef]);
            }
        }

        return redirect()->route('checkout')->with('error', 'Order not found.');
    }

    /**
     * Handle Stripe checkout cancellation
     */
    public function stripeCancel(Request $request): \Illuminate\Http\RedirectResponse
    {
        $orderRef = $request->get('order');
        
        if ($orderRef) {
            $order = Order::where('order_ref', $orderRef)->first();
            if ($order) {
                // Update payment status to cancelled
                $payment = $order->payments()->where('status', 'pending')->first();
                if ($payment) {
                    $payment->update([
                        'status' => 'cancelled',
                    ]);
                }
            }
        }

        return redirect()->route('checkout')
            ->with('error', 'Payment was cancelled. You can try again.');
    }

    public function thankYou(Request $request): \Illuminate\View\View
    {
        try {
            $orderRef = $request->get('order');
            $order = $orderRef ? Order::where('order_ref', $orderRef)->with('items')->first() : null;

            if (!$order) {
                return view('thank-you', ['order' => null])
                    ->with('error', 'Order not found.');
            }

            return view('thank-you', compact('order'));
        } catch (\Exception $e) {
            Log::error('Thank you page error: ' . $e->getMessage());
            return view('thank-you', ['order' => null])
                ->with('error', 'An error occurred while loading order details.');
        }
    }

}
