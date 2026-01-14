<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class SocialLinkController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        try {
            $socialLinks = SocialLink::orderBy('order')->get();
            return view('admin.social-links.index', compact('socialLinks'));
        } catch (\Exception $e) {
            Log::error('Social links index error: ' . $e->getMessage());
            return view('admin.social-links.index', ['socialLinks' => collect()])
                ->with('error', 'An error occurred while loading social links.');
        }
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $data = $request->validate([
                'platform' => 'required|string|max:255',
                'url' => 'required|url|max:255',
                'icon_class' => 'nullable|string|max:255',
                'aria_label' => 'nullable|string|max:255',
                'order' => 'nullable|integer|min:0',
                'is_active' => 'nullable|boolean',
            ]);

            SocialLink::create([
                'platform' => $data['platform'],
                'url' => $data['url'],
                'icon_class' => $data['icon_class'] ?? 'bi-' . strtolower($data['platform']),
                'aria_label' => $data['aria_label'] ?? ucfirst($data['platform']),
                'order' => $data['order'] ?? 0,
                'is_active' => $data['is_active'] ?? true,
            ]);

            // Clear cache
            Cache::forget('active_social_links');

            return redirect()->route('admin.social-links.index')->with('success', 'Social link added successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Social link store error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to add social link. Please try again.');
        }
    }

    public function update(Request $request, SocialLink $socialLink): \Illuminate\Http\RedirectResponse
    {
        try {
            $data = $request->validate([
                'platform' => 'required|string|max:255',
                'url' => 'required|url|max:255',
                'icon_class' => 'nullable|string|max:255',
                'aria_label' => 'nullable|string|max:255',
                'order' => 'nullable|integer|min:0',
                'is_active' => 'nullable|boolean',
            ]);

            $socialLink->update($data);

            // Clear cache
            Cache::forget('active_social_links');

            return redirect()->route('admin.social-links.index')->with('success', 'Social link updated successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Social link update error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update social link. Please try again.');
        }
    }

    public function destroy(SocialLink $socialLink): \Illuminate\Http\RedirectResponse
    {
        try {
            $socialLink->delete();

            // Clear cache
            Cache::forget('active_social_links');

            return redirect()->route('admin.social-links.index')->with('success', 'Social link deleted successfully');
        } catch (\Exception $e) {
            Log::error('Social link delete error: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete social link. Please try again.');
        }
    }
}

