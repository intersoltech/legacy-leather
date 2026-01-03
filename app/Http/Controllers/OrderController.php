<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function place(Request $request)
    {
        // ✅ validation
        $request->validate([
            'firstName' => 'required',
            'lastName'  => 'required',
            'email'     => 'required|email',
            'phone'     => 'required',
            'address'   => 'required',
            'city'      => 'required',
            'country'   => 'required',
        ]);

        // ⚠️ Abhi DB nahi (international launch ke liye baad me)
        // yahan WhatsApp / Email redirect add karenge

        return redirect()
            ->route('checkout')
            ->with('success', 'Order received successfully');
    }
}
