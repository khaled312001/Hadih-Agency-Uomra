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
        // Get existing settings to preserve fields not in this specific request
        $existingSettings = $this->getSettings();
        
        // Dynamic validation based on what's in the request
        $data = $request->except(['_token', '_method']);
        
        // Handle checkboxes (boolean values)
        $checkboxes = [
            'registration_enabled', 'maintenance_mode', 
            'payment_enabled', 'email_enabled'
        ];
        
        foreach ($checkboxes as $checkbox) {
            if ($request->hasAny(['site_name', 'payment_enabled', 'registration_enabled'])) { // Check if we are in a section that has checkboxes
                $data[$checkbox] = $request->has($checkbox);
            }
        }

        $settings = array_merge($existingSettings, $data);
        $settings['updated_at'] = now()->toDateTimeString();

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
            // Payment
            'payment_enabled' => true,
            'default_currency' => 'SAR',
            'payment_methods' => ['visa', 'mastercard', 'mada'],
            // Email
            'email_enabled' => false,
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => '587',
            'smtp_username' => '',
            // System
            'max_orders_per_user' => 10,
            'order_expiry_days' => 30,
        ];

        if (Storage::exists('settings.json')) {
            $savedSettings = json_decode(Storage::get('settings.json'), true);
            return array_merge($defaultSettings, is_array($savedSettings) ? $savedSettings : []);
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
