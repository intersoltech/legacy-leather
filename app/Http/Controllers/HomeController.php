<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Banner;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index(): View
    {
        // Get featured/active products for the home page
        $products = Product::where('is_active', true)
            ->latest()
            ->take(8)
            ->get();
        
        // Get home page banners
        $banners = Banner::where('type', 'home')
            ->where('is_active', true)
            ->orderBy('order')
            ->get();
        
        return view('index', compact('products', 'banners'));
    }
}
