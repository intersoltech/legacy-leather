<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Models\Banner;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic counts
        $productsCount = Product::count();
        $ordersCount = Order::count();
        $categoriesCount = Category::count();
        $bannersCount = Banner::count();

        // Order statistics
        $totalRevenue = Order::where('status', '!=', 'cancelled')
            ->sum('total');
        
        $pendingOrders = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        
        // Recent orders (last 5)
        $recentOrders = Order::latest()->take(5)->get();
        
        // Orders by status
        $ordersByStatus = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
        
        // Revenue by month (last 6 months)
        $revenueByMonth = Order::where('status', '!=', 'cancelled')
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(total) as revenue')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        // Top selling products (by order items)
        $topProducts = DB::table('order_items')
            ->select('product_name', DB::raw('SUM(qty) as total_sold'))
            ->groupBy('product_name')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'productsCount',
            'ordersCount',
            'categoriesCount',
            'bannersCount',
            'totalRevenue',
            'pendingOrders',
            'completedOrders',
            'recentOrders',
            'ordersByStatus',
            'revenueByMonth',
            'topProducts'
        ));
    }
}

