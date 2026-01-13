<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Services\StripeService;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    protected $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }
    public function index(Request $request)
    {
        // Ensure user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to proceed with checkout.');
        }

        $token = $request->cookie('cart_token');
        $cart  = $token ? Cart::with('items')->where('token', $token)->first() : null;

        $items = $cart?->items ?? collect();
        $total = $items->sum(fn($i) => (int)$i->price * (int)$i->qty);

        if ($items->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty. Add items before checkout.');
        }

        return view('checkout', compact('items', 'total'));
    }

    public function place(Request $request)
    {
        // Ensure user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to place an order.');
        }

        $token = $request->cookie('cart_token');
        $cart  = $token ? Cart::with('items')->where('token', $token)->first() : null;

        if (!$cart || $cart->items->count() === 0) {
            return redirect()->route('cart')->with('error', 'Cart is empty.');
        }

        // Validation
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'phone'      => 'required|string|max:50',
            'address'    => 'required|string|max:500',
            'city'       => 'required|string|max:255',
            'country'    => 'required|string|max:255',
            'postal_code'=> 'nullable|string|max:20',
            'notes'      => 'nullable|string',
            'payment_method' => 'required|string|in:cod,card,bank,stripe',
        ]);

        $total = $cart->items->sum(fn($i) => (int)$i->price * (int)$i->qty);

        // Generate order reference
        $orderRef = 'LLW-' . strtoupper(substr(bin2hex(random_bytes(6)), 0, 12));
        
        // Generate order number (sequential or based on timestamp)
        $orderNumber = $this->generateOrderNumber();
        
        // Link to user if logged in
        $userId = auth()->id();
        $userEmail = auth()->user()?->email ?? $data['email'];

        // If Stripe payment, create checkout session
        if ($data['payment_method'] === 'stripe') {
            return $this->handleStripeCheckout($cart, $data, $orderRef, $total, $userId, $userEmail);
        }

        // For other payment methods, create order directly
        $order = Order::create([
            'user_id' => $userId,
            'order_ref' => $orderRef,
            'order_number' => $orderNumber,
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $userEmail,
            'phone'      => $data['phone'],
            'address'    => $data['address'],
            'city'       => $data['city'],
            'country'    => $data['country'],
            'postal_code'=> $data['postal_code'] ?? null,
            'notes'      => $data['notes'] ?? null,
            'payment_method' => $data['payment_method'],
            'subtotal'   => (int)$total,
            'shipping'   => 0,
            'total'      => (int)$total,
            'status'     => $data['payment_method'] === 'cod' ? 'pending' : 'pending',
        ]);

        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_name' => $item->name,
                'product_image' => $item->img ?? null,
                'unit_price' => (int)$item->price,
                'qty'   => (int)$item->qty,
                'line_total' => (int)$item->price * (int)$item->qty,
            ]);
        }

        // Create payment record for non-Stripe payment methods
        $paymentStatus = $data['payment_method'] === 'cod' ? 'pending' : 'pending';
        Payment::create([
            'order_id' => $order->id,
            'payment_method' => $data['payment_method'],
            'provider' => null, // COD and bank transfers don't have a provider
            'status' => $paymentStatus,
            'amount' => (int)$total,
            'currency' => 'USD',
        ]);

        // Clear cart after order
        $cart->items()->delete();

        return redirect()->route('thankyou', ['order' => $order->order_ref]);
    }

    /**
     * Handle Stripe checkout session creation
     */
    protected function handleStripeCheckout($cart, $data, $orderRef, $total, $userId, $userEmail)
    {
        try {
            // Generate order number
            $orderNumber = $this->generateOrderNumber();
            
            // Create order first (pending status)
            $order = Order::create([
                'user_id' => $userId,
                'order_ref' => $orderRef,
                'order_number' => $orderNumber,
                'first_name' => $data['first_name'],
                'last_name'  => $data['last_name'],
                'email'      => $userEmail,
                'phone'      => $data['phone'],
                'address'    => $data['address'],
                'city'       => $data['city'],
                'country'    => $data['country'],
                'postal_code'=> $data['postal_code'] ?? null,
                'notes'      => $data['notes'] ?? null,
                'payment_method' => 'stripe',
                'subtotal'   => (int)$total,
                'shipping'   => 0,
                'total'      => (int)$total,
                'status'     => 'pending',
            ]);

            // Create order items
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_name' => $item->name,
                    'product_image' => $item->img ?? null,
                    'unit_price' => (int)$item->price,
                    'qty'   => (int)$item->qty,
                    'line_total' => (int)$item->price * (int)$item->qty,
                ]);
            }

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

            // Create payment record
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => 'stripe',
                'provider' => 'stripe',
                'status' => 'pending',
                'amount' => (int)$total,
                'currency' => 'USD',
                'provider_session_id' => $session->id,
            ]);

            // Redirect to Stripe Checkout
            return redirect($session->url);

        } catch (\Exception $e) {
            Log::error('Stripe checkout failed: ' . $e->getMessage());
            return redirect()->route('checkout')
                ->with('error', 'Failed to process payment. Please try again.');
        }
    }

    /**
     * Handle Stripe checkout success
     */
    public function stripeSuccess(Request $request)
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

                    // Clear cart
                    $token = $request->cookie('cart_token');
                    if ($token) {
                        $cart = Cart::where('token', $token)->first();
                        if ($cart) {
                            $cart->items()->delete();
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
    public function stripeCancel(Request $request)
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

    public function thankYou(Request $request)
    {
        $orderRef = $request->get('order');
        $order = $orderRef ? Order::where('order_ref', $orderRef)->with('items')->first() : null;

        return view('thank-you', compact('order'));
    }

    /**
     * Generate a unique order number
     * Format: ORD-YYYYMMDD-XXXXX (e.g., ORD-20260112-12345)
     */
    protected function generateOrderNumber(): string
    {
        $date = now()->format('Ymd');
        $random = strtoupper(substr(bin2hex(random_bytes(3)), 0, 5));
        
        $orderNumber = "ORD-{$date}-{$random}";
        
        // Ensure uniqueness
        while (Order::where('order_number', $orderNumber)->exists()) {
            $random = strtoupper(substr(bin2hex(random_bytes(3)), 0, 5));
            $orderNumber = "ORD-{$date}-{$random}";
        }
        
        return $orderNumber;
    }
}
