<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class BannerController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        try {
            $banners = Banner::orderBy('order')->latest()->paginate(15);
            return view('admin.banners.index', compact('banners'));
        } catch (\Exception $e) {
            Log::error('Banner index error: ' . $e->getMessage());
            return view('admin.banners.index', ['banners' => collect()])
                ->with('error', 'An error occurred while loading banners.');
        }
    }

    public function create(): \Illuminate\View\View
    {
        return view('admin.banners.create');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'kicker' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'category_filter' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'type' => 'nullable|string|max:255',
        ]);

        try {
            $imagePath = $request->file('image')->store('uploads/banners', 'public');

            Banner::create([
                'title' => $data['title'] ?? null,
                'kicker' => $data['kicker'] ?? null,
                'subtitle' => $data['subtitle'] ?? null,
                'image' => $imagePath,
                'category_filter' => $data['category_filter'] ?? null,
                'button_text' => $data['button_text'] ?? null,
                'button_link' => $data['button_link'] ?? null,
                'order' => $data['order'] ?? 0,
                'is_active' => $data['is_active'] ?? true,
                'type' => $data['type'] ?? 'shop',
            ]);

            return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully');
        } catch (\Exception $e) {
            Log::error('Banner store error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create banner. Please try again.');
        }
    }

    public function edit(Banner $banner): \Illuminate\View\View
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'kicker' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'category_filter' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'type' => 'nullable|string|max:255',
            'remove_image' => 'nullable|boolean',
        ]);

        if ($request->boolean('remove_image') && $banner->image) {
            Storage::disk('public')->delete($banner->image);
            $banner->image = null;
        }

        if ($request->hasFile('image')) {
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            $banner->image = $request->file('image')->store('uploads/banners', 'public');
        }

        try {
            $banner->title = $data['title'] ?? null;
            $banner->kicker = $data['kicker'] ?? null;
            $banner->subtitle = $data['subtitle'] ?? null;
            $banner->category_filter = $data['category_filter'] ?? null;
            $banner->button_text = $data['button_text'] ?? null;
            $banner->button_link = $data['button_link'] ?? null;
            $banner->order = $data['order'] ?? 0;
            $banner->is_active = $data['is_active'] ?? true;
            $banner->type = $data['type'] ?? 'shop';
            $banner->save();

            return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully');
        } catch (\Exception $e) {
            Log::error('Banner update error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update banner. Please try again.');
        }
    }

    public function destroy(Banner $banner): \Illuminate\Http\RedirectResponse
    {
        try {
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            $banner->delete();
            return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully');
        } catch (\Exception $e) {
            Log::error('Banner delete error: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete banner. Please try again.');
        }
    }
}

