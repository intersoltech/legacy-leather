<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of users (customers and staff).
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filter by role
        if ($request->has('role')) {
            if ($request->role === 'admin') {
                $query->where('is_admin', true);
            } elseif ($request->role === 'customer') {
                $query->where('is_admin', false);
            }
        }

        $users = $query->latest()->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Update user admin status.
     */
    public function updateAdminStatus(Request $request, User $user)
    {
        $request->validate([
            'is_admin' => 'required|boolean',
        ]);

        // Prevent removing admin status from yourself
        if ($user->id === auth()->id() && !$request->is_admin) {
            return back()->with('error', 'You cannot remove admin status from yourself.');
        }

        $user->update(['is_admin' => $request->is_admin]);

        $status = $request->is_admin ? 'granted admin access' : 'removed from admin access';
        return back()->with('success', "User {$status} successfully.");
    }
}

