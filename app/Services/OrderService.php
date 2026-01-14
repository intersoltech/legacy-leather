<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderService
{
    /**
     * Generate a unique order reference
     */
    public function generateOrderRef(): string
    {
        return 'LLW-' . strtoupper(substr(bin2hex(random_bytes(6)), 0, 12));
    }

    /**
     * Generate a unique order number
     * Format: ORD-YYYYMMDD-XXXXX
     */
    public function generateOrderNumber(): string
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

    /**
     * Create an order from cart with transaction
     *
     * @param Cart $cart
     * @param array $data Order data (first_name, last_name, email, etc.)
     * @param int $userId
     * @param int $total
     * @return Order
     * @throws \Exception
     */
    public function createOrderFromCart(Cart $cart, array $data, ?int $userId, int $total): Order
    {
        return DB::transaction(function () use ($cart, $data, $userId, $total) {
            $orderRef = $this->generateOrderRef();
            $orderNumber = $this->generateOrderNumber();
            $userEmail = auth()->user()?->email ?? $data['email'];

            // Create order
            $order = Order::create([
                'user_id' => $userId,
                'order_ref' => $orderRef,
                'order_number' => $orderNumber,
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $userEmail,
                'phone' => $data['phone'],
                'address' => $data['address'],
                'city' => $data['city'],
                'country' => $data['country'],
                'postal_code' => $data['postal_code'] ?? null,
                'notes' => $data['notes'] ?? null,
                'payment_method' => $data['payment_method'],
                'subtotal' => $total,
                'shipping' => 0,
                'total' => $total,
                'status' => 'pending',
            ]);

            // Create order items
            $this->createOrderItems($order, $cart->items);

            // Create payment record
            $this->createPayment($order, $data['payment_method'], $total);

            // Clear cart
            $cart->items()->delete();

            return $order;
        });
    }

    /**
     * Create order items from cart items
     *
     * @param Order $order
     * @param \Illuminate\Database\Eloquent\Collection $cartItems
     * @return void
     */
    protected function createOrderItems(Order $order, $cartItems): void
    {
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id ?? null,
                'product_name' => $item->name,
                'product_image' => $item->img ?? null,
                'unit_price' => (int)$item->price,
                'qty' => (int)$item->qty,
                'line_total' => (int)$item->price * (int)$item->qty,
            ]);
        }
    }

    /**
     * Create payment record for order
     *
     * @param Order $order
     * @param string $paymentMethod
     * @param int $amount
     * @param string|null $providerSessionId
     * @return Payment
     */
    public function createPayment(Order $order, string $paymentMethod, int $amount, ?string $providerSessionId = null): Payment
    {
        $status = $paymentMethod === 'cod' ? 'pending' : 'pending';
        $provider = $paymentMethod === 'stripe' ? 'stripe' : null;

        return Payment::create([
            'order_id' => $order->id,
            'payment_method' => $paymentMethod,
            'provider' => $provider,
            'status' => $status,
            'amount' => $amount,
            'currency' => 'USD',
            'provider_session_id' => $providerSessionId,
        ]);
    }

    /**
     * Calculate cart total
     *
     * @param Cart $cart
     * @return int
     */
    public function calculateCartTotal(Cart $cart): int
    {
        return (int)$cart->items->sum(fn($item) => (int)$item->price * (int)$item->qty);
    }
}
