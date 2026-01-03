<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;
use App\Models\SiteSetting;
use App\Models\SocialLink;

class ShopController extends Controller
{
    public function index()
    {
        $category = request()->get('cat', 'all');
        
        $query = Product::where('is_active', true);
        
        if ($category !== 'all') {
            $query->where('category', $category);
        }
        
        $products = $query->latest()->get();
        $banners = Banner::where('type', 'shop')->where('is_active', true)->orderBy('order')->get();
        
        return view('shop', compact('products', 'banners', 'category'));
    }
}
