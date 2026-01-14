<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CartService
{
    /**
     * Get or create cart for request
     *
     * @param Request $request
     * @return Cart
     */
    public function getOrCreateCart(Request $request): Cart
    {
        $token = $request->cookie('cart_token');

        if ($token) {
            $cart = Cart::where('token', $token)->first();
            if ($cart) {
                return $cart;
            }
        }

        $cart = Cart::create([
            'token' => bin2hex(random_bytes(16)),
        ]);

        Cookie::queue('cart_token', $cart->token, 60 * 24 * 30); // 30 days

        return $cart;
    }

    /**
     * Add item to cart
     *
     * @param Cart $cart
     * @param array $data
     * @return CartItem
     */
    public function addItem(Cart $cart, array $data): CartItem
    {
        $qty = (int)($data['qty'] ?? 1);

        // Try to find existing item by product_id if provided, otherwise by name
        $item = null;
        if (!empty($data['product_id'])) {
            $item = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $data['product_id'])
                ->first();
        }
        
        if (!$item) {
            $item = CartItem::where('cart_id', $cart->id)
                ->where('name', $data['name'])
                ->first();
        }

        if ($item) {
            $item->qty += $qty;
            $item->price = (int)round($data['price']);
            if (!empty($data['product_id']) && !$item->product_id) {
                $item->product_id = $data['product_id'];
            }
            $item->save();
            return $item;
        }

        return $cart->items()->create([
            'product_id' => $data['product_id'] ?? null,
            'name' => $data['name'],
            'price' => (int)round($data['price']),
            'img' => $data['img'] ?? null,
            'qty' => $qty,
        ]);
    }

    /**
     * Update cart item quantity
     *
     * @param Cart $cart
     * @param int $itemId
     * @param int $qty
     * @return CartItem
     */
    public function updateItem(Cart $cart, int $itemId, int $qty): CartItem
    {
        $item = CartItem::where('cart_id', $cart->id)
            ->where('id', $itemId)
            ->firstOrFail();
        
        $item->qty = $qty;
        $item->save();
        
        return $item;
    }

    /**
     * Remove item from cart
     *
     * @param Cart $cart
     * @param int $itemId
     * @return bool
     */
    public function removeItem(Cart $cart, int $itemId): bool
    {
        return CartItem::where('cart_id', $cart->id)
            ->where('id', $itemId)
            ->delete() > 0;
    }

    /**
     * Clear all items from cart
     *
     * @param Cart $cart
     * @return bool
     */
    public function clearCart(Cart $cart): bool
    {
        return $cart->items()->delete() > 0;
    }

    /**
     * Get cart total
     *
     * @param Cart $cart
     * @return int
     */
    public function getTotal(Cart $cart): int
    {
        return (int)$cart->items->sum(fn($item) => (int)$item->price * (int)$item->qty);
    }

    /**
     * Get cart item count
     *
     * @param Cart $cart
     * @return int
     */
    public function getItemCount(Cart $cart): int
    {
        return (int)$cart->items()->sum('qty');
    }

    /**
     * Get cart by token
     *
     * @param string|null $token
     * @return Cart|null
     */
    public function getCartByToken(?string $token): ?Cart
    {
        if (!$token) {
            return null;
        }

        return Cart::where('token', $token)->first();
    }
}
