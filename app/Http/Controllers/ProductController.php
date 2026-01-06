<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function show($id)
    {
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
    }
}
