<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Services\CartService;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Request $request): \Illuminate\View\View
    {
        try {
            $cart = $this->cartService->getOrCreateCart($request);
            $items = $cart->items;
            $total = $this->cartService->getTotal($cart);

            return view('cart', compact('items', 'total'));
        } catch (\Exception $e) {
            Log::error('Cart index error: ' . $e->getMessage());
            return view('cart', ['items' => collect(), 'total' => 0])
                ->with('error', 'An error occurred while loading your cart.');
        }
    }

    public function count(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $token = $request->cookie('cart_token');
            $cart = $this->cartService->getCartByToken($token);

            $count = $cart ? $this->cartService->getItemCount($cart) : 0;

            return response()->json(['count' => $count]);
        } catch (\Exception $e) {
            Log::error('Cart count error: ' . $e->getMessage());
            return response()->json(['count' => 0]);
        }
    }

    public function add(Request $request): \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
    {
        try {
            $data = $request->validate([
                'product_id' => 'nullable|integer|exists:products,id',
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'img' => 'nullable|string|max:500',
                'qty' => 'nullable|integer|min:1',
            ]);

            $cart = $this->cartService->getOrCreateCart($request);
            $this->cartService->addItem($cart, $data);
            
            $count = $this->cartService->getItemCount($cart);

            if ($request->expectsJson()) {
                return response()->json(['ok' => true, 'count' => $count]);
            }

            return redirect()->back()->with('success', 'Added to cart!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json(['ok' => false, 'errors' => $e->errors()], 422);
            }
            return redirect()->back()->withErrors($e->errors());
        } catch (\Exception $e) {
            Log::error('Cart add error: ' . $e->getMessage());
            if ($request->expectsJson()) {
                return response()->json(['ok' => false, 'message' => 'Failed to add item to cart'], 500);
            }
            return redirect()->back()->with('error', 'Failed to add item to cart. Please try again.');
        }
    }

    public function update(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $request->validate([
                'id' => 'required|integer|exists:cart_items,id',
                'qty' => 'required|integer|min:1',
            ]);

            $token = $request->cookie('cart_token');
            $cart = $this->cartService->getCartByToken($token);
            
            if (!$cart) {
                return response()->json(['ok' => false, 'message' => 'Cart not found'], 404);
            }

            $item = $this->cartService->updateItem($cart, $data['id'], (int)$data['qty']);
            
            $cart->refresh();
            $count = $this->cartService->getItemCount($cart);
            $subtotal = $this->cartService->getTotal($cart);

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
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['ok' => false, 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Cart update error: ' . $e->getMessage());
            return response()->json(['ok' => false, 'message' => 'Failed to update cart item'], 500);
        }
    }

    public function remove(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $request->validate([
                'id' => 'required|integer|exists:cart_items,id',
            ]);

            $token = $request->cookie('cart_token');
            $cart = $this->cartService->getCartByToken($token);
            
            if (!$cart) {
                return response()->json(['ok' => false, 'message' => 'Cart not found'], 404);
            }

            $this->cartService->removeItem($cart, $data['id']);

            $cart->refresh();
            $count = $this->cartService->getItemCount($cart);
            $subtotal = $this->cartService->getTotal($cart);

            return response()->json([
                'ok' => true,
                'count' => $count,
                'subtotal' => $subtotal,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['ok' => false, 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Cart remove error: ' . $e->getMessage());
            return response()->json(['ok' => false, 'message' => 'Failed to remove item from cart'], 500);
        }
    }

    public function clear(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $token = $request->cookie('cart_token');
            $cart = $this->cartService->getCartByToken($token);

            if ($cart) {
                $this->cartService->clearCart($cart);
            }

            return response()->json(['ok' => true]);
        } catch (\Exception $e) {
            Log::error('Cart clear error: ' . $e->getMessage());
            return response()->json(['ok' => false, 'message' => 'Failed to clear cart'], 500);
        }
    }
}
