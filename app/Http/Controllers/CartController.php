<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $this->getCart($request);
        $items = $cart->items()->get();
        $total = $items->sum(fn($i) => (int)$i->price * (int)$i->qty);

        return view('cart', compact('items','total'));
    }

    public function count(Request $request)
    {
        $token = $request->cookie('cart_token');
        if(!$token){
            return response()->json(['count'=>0]);
        }

        $cart = Cart::where('token',$token)->first();
        if(!$cart){
            return response()->json(['count'=>0]);
        }

        return response()->json(['count'=>(int)$cart->items()->sum('qty')]);
    }

    public function add(Request $request)
    {
        // dd($request->all());
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0', // Changed from integer to numeric to accept floats
            'img'   => 'nullable|string|max:500',
            'qty'   => 'nullable|integer|min:1',
        ]);

        // dd($data);

        $cart = $this->getCart($request);
        $qty  = (int)($data['qty'] ?? 1);

        // dd($cart->id);

        $item = CartItem::where('cart_id', $cart->id)
            ->where('name', $data['name'])
            ->first();

            // dd($item);

        if ($item) {
            $item->qty += $qty;
            $item->price = (int)round($data['price']); // Update price in case it changed
            $item->save();
        } else {
            $cart->items()->create([
                'name'  => $data['name'],
                'price' => (int)round($data['price']), // Convert to integer (prices stored as cents or whole dollars)
                'img'   => $data['img'] ?? null,
                'qty'   => $qty,
            ]);
        }

        $count = (int)$cart->items()->sum('qty');

        if ($request->expectsJson()) {
            return response()->json(['ok'=>true,'count'=>$count]);
        }

        return redirect()->back()->with('success', 'Added to cart!');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'id'  => 'required|integer|exists:cart_items,id',
            'qty' => 'required|integer|min:1',
        ]);

        $token = $request->cookie('cart_token');
        $cart = Cart::where('token',$token)->firstOrFail();

        $item = CartItem::where('cart_id',$cart->id)->where('id',$data['id'])->firstOrFail();
        $item->qty = (int)$data['qty'];
        $item->save();

        // Return updated cart data
        $cart->refresh();
        $items = $cart->items()->get();
        $count = (int)$cart->items()->sum('qty');
        $subtotal = $items->sum(fn($i) => (int)$i->price * (int)$i->qty);

        return response()->json([
            'ok' => true,
            'count' => $count,
            'subtotal' => $subtotal,
            'item' => [
                'id' => $item->id,
                'qty' => $item->qty,
                'price' => $item->price,
                'line_total' => (int)$item->price * (int)$item->qty,
            ]
        ]);
    }

    public function remove(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|integer|exists:cart_items,id',
        ]);

        $token = $request->cookie('cart_token');
        $cart = Cart::where('token',$token)->firstOrFail();

        CartItem::where('cart_id',$cart->id)->where('id',$data['id'])->delete();

        // Return updated cart data
        $cart->refresh();
        $count = (int)$cart->items()->sum('qty');
        $items = $cart->items()->get();
        $subtotal = $items->sum(fn($i) => (int)$i->price * (int)$i->qty);

        return response()->json([
            'ok' => true,
            'count' => $count,
            'subtotal' => $subtotal,
        ]);
    }

    public function clear(Request $request)
    {
        $token = $request->cookie('cart_token');
        $cart = Cart::where('token',$token)->first();

        if($cart){
            $cart->items()->delete();
        }

        return response()->json(['ok'=>true]);
    }

    private function getCart(Request $request)
    {
        $token = $request->cookie('cart_token');

        if ($token) {
            $cart = Cart::where('token', $token)->first();
            if ($cart) return $cart;
        }

        $cart = Cart::create([
            'token' => bin2hex(random_bytes(16)),
        ]);

        cookie()->queue(cookie('cart_token', $cart->token, 60 * 24 * 30));

        return $cart;
    }
}
