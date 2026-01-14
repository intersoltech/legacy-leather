<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserDashboardController extends Controller
{
    /**
     * Display the user dashboard with order history.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        
        // Base query for user's orders (properly grouped to avoid SQL issues)
        // This ensures we only get orders that belong to this user
        $baseQuery = Order::where(function($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->orWhere('email', $user->email);
        });
        
        // Get orders with proper grouping
        $orders = (clone $baseQuery)
            ->latest()
            ->paginate(10);

        // Calculate statistics with proper grouping
        $stats = [
            'total_orders' => (clone $baseQuery)->count(),
            'pending_orders' => (clone $baseQuery)
                ->where('status', 'pending')
                ->count(),
            'completed_orders' => (clone $baseQuery)
                ->where('status', 'completed')
                ->count(),
            'total_spent' => (clone $baseQuery)
                ->where('status', '!=', 'cancelled')
                ->sum('total'), // Prices are stored as dollars, not cents
        ];

        return view('user.dashboard', compact('orders', 'stats'));
    }

    /**
     * Show a specific order.
     */
    public function showOrder(Request $request, Order $order): View
    {
        $this->authorize('view', $order);

        $order->load('items');

        return view('user.order-detail', compact('order'));
    }
}

