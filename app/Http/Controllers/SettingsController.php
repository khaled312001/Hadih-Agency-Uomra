<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $settings = $this->getSettings();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string|max:20',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'registration_enabled' => 'boolean',
            'maintenance_mode' => 'boolean',
        ]);

        $settings = [
            'site_name' => $request->site_name,
            'site_description' => $request->site_description,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'facebook_url' => $request->facebook_url,
            'twitter_url' => $request->twitter_url,
            'instagram_url' => $request->instagram_url,
            'registration_enabled' => $request->has('registration_enabled'),
            'maintenance_mode' => $request->has('maintenance_mode'),
            'updated_at' => now(),
        ];

        $this->saveSettings($settings);

        return redirect()->route('admin.settings.index')
            ->with('success', 'تم حفظ الإعدادات بنجاح');
    }

    private function getSettings()
    {
        $defaultSettings = [
            'site_name' => 'هدية',
            'site_description' => 'منصة حجز حزم العمرة',
            'contact_email' => 'info@hadiyah.com',
            'contact_phone' => '+966501234567',
            'meta_keywords' => 'عمرة, حج, حزم عمرة, رحلات عمرة',
            'meta_description' => 'منصة حجز حزم العمرة والحج بأفضل الأسعار والخدمات',
            'facebook_url' => '',
            'twitter_url' => '',
            'instagram_url' => '',
            'registration_enabled' => true,
            'maintenance_mode' => false,
        ];

        if (Storage::exists('settings.json')) {
            $savedSettings = json_decode(Storage::get('settings.json'), true);
            return array_merge($defaultSettings, $savedSettings);
        }

        return $defaultSettings;
    }

    private function saveSettings($settings)
    {
        Storage::put('settings.json', json_encode($settings, JSON_UNESCAPED_UNICODE));
    }

    public static function get($key, $default = null)
    {
        $controller = new self();
        $settings = $controller->getSettings();
        return $settings[$key] ?? $default;
    }
}
