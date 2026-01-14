<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Http\Requests\UpdateOrderStatusRequest;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        $orders = Order::latest()->paginate(25);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): \Illuminate\View\View
    {
        $this->authorize('view', $order);
        $order->load('user', 'items');
        $items = $order->items;
        return view('admin.orders.show', compact('order','items'));
    }

    public function updateStatus(UpdateOrderStatusRequest $request, Order $order): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('update', $order);
        $data = $request->validated();

        $order->update(['status' => $data['status']]);

        return back()->with('success','Order status updated.');
    }
}
