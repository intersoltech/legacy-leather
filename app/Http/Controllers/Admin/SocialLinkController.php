<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class SocialLinkController extends Controller
{
    public function index()
    {
        $socialLinks = SocialLink::orderBy('order')->get();
        return view('admin.social-links.index', compact('socialLinks'));
    }

    public function store(Request $request)
    {
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

        return redirect()->route('admin.social-links.index')->with('success', 'Social link added successfully');
    }

    public function update(Request $request, SocialLink $socialLink)
    {
        $data = $request->validate([
            'platform' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'icon_class' => 'nullable|string|max:255',
            'aria_label' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $socialLink->update($data);
        return redirect()->route('admin.social-links.index')->with('success', 'Social link updated successfully');
    }

    public function destroy(SocialLink $socialLink)
    {
        $socialLink->delete();
        return redirect()->route('admin.social-links.index')->with('success', 'Social link deleted successfully');
    }
}

