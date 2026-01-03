<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::latest()->paginate(25);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order){
        $items = OrderItem::where('order_id', $order->id)->get();
        return view('admin.orders.show', compact('order','items'));
    }

    public function updateStatus(Request $request, Order $order){
        $data = $request->validate([
            'status' => 'required|string',
        ]);

        $order->update(['status' => $data['status']]);

        return back()->with('success','Order status updated.');
    }
}
