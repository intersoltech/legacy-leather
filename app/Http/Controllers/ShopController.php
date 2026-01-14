<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class ShopController extends Controller
{
    public function index(): View
    {
        try {
            $category = request()->get('cat', 'all');
            
            $query = Product::where('is_active', true);
            
            if ($category !== 'all') {
                $query->where('category', $category);
            }
            
            $products = $query->latest()->get();
            $banners = Banner::where('type', 'shop')
                ->where('is_active', true)
                ->orderBy('order')
                ->get();
            
            return view('shop', compact('products', 'banners', 'category'));
        } catch (\Exception $e) {
            Log::error('Shop index error: ' . $e->getMessage());
            return view('shop', [
                'products' => collect(),
                'banners' => collect(),
                'category' => 'all'
            ])->with('error', 'An error occurred while loading products.');
        }
    }
}
