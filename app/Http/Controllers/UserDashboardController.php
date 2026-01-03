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
        
        $orders = Order::where('user_id', $user->id)
            ->orWhere('email', $user->email)
            ->latest()
            ->paginate(10);

        $stats = [
            'total_orders' => Order::where('user_id', $user->id)
                ->orWhere('email', $user->email)
                ->count(),
            'pending_orders' => Order::where(function($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhere('email', $user->email);
            })->where('status', 'pending')->count(),
            'completed_orders' => Order::where(function($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhere('email', $user->email);
            })->where('status', 'completed')->count(),
            'total_spent' => Order::where(function($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhere('email', $user->email);
            })->where('status', '!=', 'cancelled')->sum('total'),
        ];

        return view('user.dashboard', compact('orders', 'stats'));
    }

    /**
     * Show a specific order.
     */
    public function showOrder(Request $request, Order $order): View
    {
        $user = $request->user();
        
        // Ensure user owns this order
        if ($order->user_id !== $user->id && $order->email !== $user->email) {
            abort(403, 'Unauthorized access to this order.');
        }

        $order->load('items');

        return view('user.order-detail', compact('order'));
    }
}

