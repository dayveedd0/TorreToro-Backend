<?php

namespace Database\Seeders;

use App\Models\Domain;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $domains = Domain::all();

        foreach ($domains as $domain) {
            $isUk = $domain->code === 'uk';

            $settings = [
                ['group' => 'general', 'key' => 'site_name', 'value' => 'Torre Tórò', 'type' => 'string'],
                ['group' => 'general', 'key' => 'tagline', 'value' => 'Designing Spaces that Inspire Success', 'type' => 'string'],
                ['group' => 'branding', 'key' => 'site_logo', 'value' => '/storage/uploads/branding/logo.png', 'type' => 'string'],
                ['group' => 'branding', 'key' => 'site_logo_white', 'value' => '/storage/uploads/branding/logo-white.png', 'type' => 'string'],
                ['group' => 'branding', 'key' => 'site_symbol', 'value' => '/storage/uploads/branding/logo-symbol.png', 'type' => 'string'],
                ['group' => 'branding', 'key' => 'site_symbol_white', 'value' => '/storage/uploads/branding/logo-symbol-white.png', 'type' => 'string'],
                ['group' => 'branding', 'key' => 'site_favicon', 'value' => '/storage/uploads/branding/favicon.png', 'type' => 'string'],
                ['group' => 'branding', 'key' => 'site_video', 'value' => '/storage/uploads/branding/corporate-logo.mp4', 'type' => 'string'],
                ['group' => 'header', 'key' => 'header_cta_label', 'value' => 'Call Us Today', 'type' => 'string'],
                ['group' => 'header', 'key' => 'header_phone', 'value' => $isUk ? '+44 20 7946 0991' : '+234 813 600 1221', 'type' => 'string'],
                ['group' => 'footer', 'key' => 'copyright_text', 'value' => 'Torre Toro Projects © All rights reserved Copyrights 2025', 'type' => 'string'],
                ['group' => 'stats', 'key' => 'experience_years', 'value' => '7+', 'type' => 'string'],
                ['group' => 'stats', 'key' => 'projects_count', 'value' => '14', 'type' => 'string'],
                ['group' => 'stats', 'key' => 'stats_headline', 'value' => 'We Govern and Manage Place and Privacy policies', 'type' => 'string'],
                ['group' => 'contact', 'key' => 'office_address', 'value' => $isUk ? '45 Berkeley Square, Mayfair, London W1J 5AS, United Kingdom' : '16a Da Silva Street Lekki Phase 1, Lekki Lagos, NIGERIA', 'type' => 'string'],
                ['group' => 'contact', 'key' => 'contact_email', 'value' => $isUk ? 'uk@torretoro.com' : 'hello@torretoro.com', 'type' => 'string'],
                ['group' => 'contact', 'key' => 'contact_email_secondary', 'value' => 'dami@torretoro.com', 'type' => 'string'],
                ['group' => 'contact', 'key' => 'secondary_email', 'value' => 'dami@torretoro.com', 'type' => 'string'],
                ['group' => 'contact', 'key' => 'contact_phone', 'value' => $isUk ? '+44 20 7946 0991' : '+234 813 600 1221', 'type' => 'string'],
                ['group' => 'contact', 'key' => 'contact_phone_secondary', 'value' => $isUk ? '+44 20 7946 0912' : '+234 011 336 54', 'type' => 'string'],
                ['group' => 'contact', 'key' => 'secondary_phone', 'value' => $isUk ? '+44 20 7946 0912' : '+234 011 336 54', 'type' => 'string'],
                ['group' => 'contact', 'key' => 'office_hours', 'value' => 'Monday - Friday: 8:00 AM - 6:00 PM', 'type' => 'string'],
            ];

            foreach ($settings as $item) {
                Setting::updateOrCreate(
                    ['domain_id' => $domain->id, 'key' => $item['key']],
                    $item
                );
            }
        }
    }
}
