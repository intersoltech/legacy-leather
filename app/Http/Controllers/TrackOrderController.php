<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class TrackOrderController extends Controller
{
    public function index(): View
    {
        return view('track-order');
    }

    public function track(Request $request): View|\Illuminate\Http\RedirectResponse
    {
        try {
            $request->validate([
                'order_number' => 'required|string',
                'email' => 'nullable|email',
            ]);

            $query = Order::where('order_number', $request->order_number);

            if ($request->email) {
                $query->where('email', $request->email);
            }

            $order = $query->first();

            if (!$order) {
                return back()
                    ->withErrors(['order_number' => 'Order not found. Please check your order number and email.'])
                    ->withInput();
            }

            return view('track-order', compact('order'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Track order error: ' . $e->getMessage());
            return back()
                ->withErrors(['order_number' => 'An error occurred while tracking your order.'])
                ->withInput();
        }
    }
}
