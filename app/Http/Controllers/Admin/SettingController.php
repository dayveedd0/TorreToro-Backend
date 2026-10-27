<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        $domain = app(Domain::class);
        $settings = Setting::forDomain($domain)->get()->keyBy('key');

        return view('admin.settings.index', compact('domain', 'settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $domain = app(Domain::class);

        // Update Domain Model base fields
        $domain->update([
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'currency' => $request->input('currency', 'NGN'),
            'meta_title' => $request->input('meta_title'),
            'meta_description' => $request->input('meta_description'),
            'social_links' => [
                'instagram' => $request->input('social_instagram'),
                'facebook' => $request->input('social_facebook'),
                'twitter' => $request->input('social_twitter'),
                'linkedin' => $request->input('social_linkedin'),
                'youtube' => $request->input('social_youtube'),
            ],
        ]);

        // Key-value settings
        $keys = [
            'site_name' => 'general',
            'tagline' => 'general',
            'site_logo' => 'branding',
            'site_logo_white' => 'branding',
            'site_symbol' => 'branding',
            'site_symbol_white' => 'branding',
            'site_favicon' => 'branding',
            'site_video' => 'branding',
            'header_cta_label' => 'header',
            'header_phone' => 'header',
            'copyright_text' => 'footer',
            'experience_years' => 'stats',
            'projects_count' => 'stats',
            'stats_headline' => 'stats',
            'google_maps_embed' => 'contact',
            'google_maps_directions' => 'contact',
            'contact_phone' => 'contact',
            'contact_phone_secondary' => 'contact',
            'secondary_phone' => 'contact',
            'contact_email' => 'contact',
            'contact_email_secondary' => 'contact',
            'secondary_email' => 'contact',
            'office_hours' => 'contact',
            'office_address' => 'contact',
        ];

        // Ensure aliases are set
        if ($request->filled('phone')) {
            $request->merge(['contact_phone' => $request->input('phone')]);
            if (! $request->filled('header_phone')) {
                $request->merge(['header_phone' => $request->input('phone')]);
            }
        }
        if ($request->filled('secondary_phone')) {
            $request->merge(['contact_phone_secondary' => $request->input('secondary_phone')]);
        }
        if ($request->filled('email')) {
            $request->merge(['contact_email' => $request->input('email')]);
        }
        if ($request->filled('secondary_email')) {
            $request->merge(['contact_email_secondary' => $request->input('secondary_email')]);
        }
        if ($request->filled('address')) {
            $request->merge(['office_address' => $request->input('address')]);
        }

        foreach ($keys as $key => $group) {
            if ($request->has($key)) {
                Setting::updateOrCreate(
                    ['domain_id' => $domain->id, 'key' => $key],
                    ['group' => $group, 'value' => $request->input($key), 'type' => 'string']
                );
            }
        }

        return back()->with('success', 'Domain and brand settings updated successfully.');
    }
}
