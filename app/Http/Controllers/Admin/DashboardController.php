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
        
        // Today's sales
        $todaySales = Order::whereDate('created_at', today())
            ->where('status', '!=', 'cancelled')
            ->count();
        
        // Today's revenue
        $todayRevenue = Order::whereDate('created_at', today())
            ->where('status', '!=', 'cancelled')
            ->sum('total');
        
        // This month's revenue
        $monthRevenue = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('status', '!=', 'cancelled')
            ->sum('total');
        
        // Total customers
        $customersCount = \App\Models\User::where('is_admin', false)->count();
        
        // Recent orders (last 10)
        $recentOrders = Order::with('user')->latest()->take(10)->get();
        
        // Orders by status
        $ordersByStatus = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
        
        // Revenue by month (last 6 months) for chart
        $revenueByMonth = Order::where('status', '!=', 'cancelled')
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(total) as revenue')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        // Sales data for last 7 days (for reports chart)
        $salesData = [];
        $revenueData = [];
        $customersData = [];
        $dates = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dates[] = $date->toISOString();
            
            $daySales = Order::whereDate('created_at', $date->toDateString())
                ->where('status', '!=', 'cancelled')
                ->count();
            $salesData[] = $daySales;
            
            $dayRevenue = Order::whereDate('created_at', $date->toDateString())
                ->where('status', '!=', 'cancelled')
                ->sum('total');
            $revenueData[] = round($dayRevenue, 2);
            
            $dayCustomers = \App\Models\User::whereDate('created_at', $date->toDateString())
                ->where('is_admin', false)
                ->count();
            $customersData[] = $dayCustomers;
        }
        
        // Top selling products (by order items) with images
        $topProducts = DB::table('order_items')
            ->select(
                'product_name',
                'product_image',
                DB::raw('SUM(qty) as total_sold'),
                DB::raw('SUM(line_total) as total_revenue'),
                DB::raw('AVG(unit_price) as avg_price')
            )
            ->groupBy('product_name', 'product_image')
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
            'todaySales',
            'todayRevenue',
            'monthRevenue',
            'customersCount',
            'recentOrders',
            'ordersByStatus',
            'revenueByMonth',
            'topProducts',
            'salesData',
            'revenueData',
            'customersData',
            'dates'
        ));
    }
}

