<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class TrackOrderController extends Controller
{
    public function index()
    {
        return view('track-order');
    }

    public function track(Request $request)
    {
        $request->validate([
            'order_number' => 'required',
            'email' => 'nullable|email',
        ]);

        $query = Order::where('order_number', $request->order_number);

        if ($request->email) {
            $query->where('email', $request->email);
        }

        $order = $query->first();

        if (!$order) {
            return back()
                ->withErrors(['Order not found. Please check details.'])
                ->withInput();
        }

        return view('track-order', compact('order'));
    }
}
