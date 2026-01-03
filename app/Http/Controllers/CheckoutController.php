<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $token = $request->cookie('cart_token');
        $cart  = $token ? Cart::with('items')->where('token', $token)->first() : null;

        $items = $cart?->items ?? collect();
        $total = $items->sum(fn($i) => (int)$i->price * (int)$i->qty);

        return view('checkout', compact('items', 'total'));
    }

    public function place(Request $request)
    {
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
        ]);

        $total = $cart->items->sum(fn($i) => (int)$i->price * (int)$i->qty);

        // Generate order reference
        $orderRef = 'LLW-' . strtoupper(substr(bin2hex(random_bytes(6)), 0, 12));
        
        // Link to user if logged in
        $userId = auth()->id();
        $userEmail = auth()->user()?->email ?? $data['email'];

        $order = Order::create([
            'user_id' => $userId,
            'order_ref' => $orderRef,
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $userEmail,
            'phone'      => $data['phone'],
            'address'    => $data['address'],
            'city'       => $data['city'],
            'country'    => $data['country'],
            'postal_code'=> $data['postal_code'] ?? null,
            'notes'      => $data['notes'] ?? null,
            'subtotal'   => (int)$total,
            'shipping'   => 0,
            'total'      => (int)$total,
            'status'     => 'pending',
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

        // Clear cart after order
        $cart->items()->delete();

        return redirect()->route('thankyou', ['order' => $order->order_ref]);
    }

    public function thankYou(Request $request)
    {
        $orderRef = $request->get('order');
        $order = $orderRef ? Order::where('order_ref', $orderRef)->with('items')->first() : null;

        return view('thank-you', compact('order'));
    }
}
