<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class SiteSettingController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        try {
            $settings = SiteSetting::orderBy('key')->get()->groupBy(function($item) {
                // Group by prefix (e.g., 'contact_', 'social_', etc.)
                $parts = explode('_', $item->key);
                return count($parts) > 1 ? $parts[0] : 'general';
            });
            
            return view('admin.settings.index', compact('settings'));
        } catch (\Exception $e) {
            Log::error('Site settings index error: ' . $e->getMessage());
            return view('admin.settings.index', ['settings' => collect()])
                ->with('error', 'An error occurred while loading settings.');
        }
    }

    public function update(Request $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $data = $request->except(['_token', '_method']);
            
            foreach ($data as $key => $value) {
                SiteSetting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value ?? '', 'type' => 'string']
                );
            }

            // Clear cache after updating settings
            Cache::forget('site_settings');
            Cache::forget('active_categories');
            Cache::forget('active_social_links');

            return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully');
        } catch (\Exception $e) {
            Log::error('Site settings update error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update settings. Please try again.');
        }
    }
}

