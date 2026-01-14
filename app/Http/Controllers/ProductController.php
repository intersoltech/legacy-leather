<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function show(int $id): View
    {
        try {
            $product = Product::findOrFail($id);
            
            // Get related products (same category, excluding current product)
            $relatedProducts = Product::where('is_active', true)
                ->where('id', '!=', $product->id)
                ->where('category', $product->category)
                ->latest()
                ->limit(4)
                ->get();
            
            // If not enough related products, get any active products
            if ($relatedProducts->count() < 4) {
                $additionalProducts = Product::where('is_active', true)
                    ->where('id', '!=', $product->id)
                    ->whereNotIn('id', $relatedProducts->pluck('id'))
                    ->latest()
                    ->limit(4 - $relatedProducts->count())
                    ->get();
                
                $relatedProducts = $relatedProducts->merge($additionalProducts);
            }
            
            return view('product', compact('product', 'relatedProducts'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Product not found: ' . $id);
            abort(404, 'Product not found');
        } catch (\Exception $e) {
            Log::error('Product show error: ' . $e->getMessage());
            abort(500, 'An error occurred while loading the product.');
        }
    }
}
