<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::orderBy('key')->get()->groupBy(function($item) {
            // Group by prefix (e.g., 'contact_', 'social_', etc.)
            $parts = explode('_', $item->key);
            return count($parts) > 1 ? $parts[0] : 'general';
        });
        
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        
        foreach ($data as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '', 'type' => 'string']
            );
        }

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully');
    }
}

