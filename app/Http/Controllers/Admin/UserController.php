<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of users (customers and staff).
     */
    public function index(Request $request): \Illuminate\View\View
    {
        try {
            $query = User::query();

            // Search functionality
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }

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
        } catch (\Exception $e) {
            Log::error('Users index error: ' . $e->getMessage());
            return view('admin.users.index', ['users' => collect()])
                ->with('error', 'An error occurred while loading users.');
        }
    }

    /**
     * Update user admin status.
     */
    public function updateAdminStatus(Request $request, User $user): \Illuminate\Http\RedirectResponse
    {
        try {
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
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (\Exception $e) {
            Log::error('User admin status update error: ' . $e->getMessage());
            return back()->with('error', 'Failed to update user status. Please try again.');
        }
    }
}

