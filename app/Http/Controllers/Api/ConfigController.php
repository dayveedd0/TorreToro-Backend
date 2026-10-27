<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\Menu;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $domain = app(Domain::class);

        // Fetch menus for active domain (with fallback to default)
        $menus = Menu::forDomain($domain)
            ->with(['items.children'])
            ->get()
            ->keyBy('location');

        // Fetch settings grouped
        $settings = Setting::forDomain($domain)->get()->mapWithKeys(function ($item) {
            $value = match ($item->type) {
                'json' => json_decode($item->value, true),
                'boolean' => filter_var($item->value, FILTER_VALIDATE_BOOLEAN),
                default => $item->value,
            };
            return [$item->key => $value];
        });

        $phone1 = $domain->phone ?: ($settings['contact_phone'] ?? '+234 813 600 1221');
        $phone2 = $settings['contact_phone_secondary'] ?? $settings['secondary_phone'] ?? '+234 011 336 54';
        $email1 = $domain->email ?: ($settings['contact_email'] ?? 'hello@torretoro.com');
        $email2 = $settings['contact_email_secondary'] ?? $settings['secondary_email'] ?? 'dami@torretoro.com';
        $address = $domain->address ?: ($settings['office_address'] ?? '16a Da Silva Street Lekki Phase 1, Lekki Lagos, NIGERIA');

        return response()->json([
            'domain' => [
                'code' => $domain->code,
                'name' => $domain->name,
                'currency' => $domain->currency,
                'phone' => $phone1,
                'phone_1' => $phone1,
                'phone_2' => $phone2,
                'phone_secondary' => $phone2,
                'email' => $email1,
                'email_1' => $email1,
                'email_2' => $email2,
                'email_secondary' => $email2,
                'address' => $address,
                'social_links' => $domain->social_links,
                'meta_title' => $domain->meta_title,
                'meta_description' => $domain->meta_description,
            ],
            'menus' => [
                'header' => $menus->get('header')?->items ?? [],
                'footer_quick_links' => $menus->get('footer_quick_links')?->items ?? [],
                'footer_client_support' => $menus->get('footer_client_support')?->items ?? [],
                'top_bar' => $menus->get('top_bar')?->items ?? [],
            ],
            'settings' => $settings,
        ]);
    }

    public function domains(): JsonResponse
    {
        $domains = Domain::where('is_active', true)->get(['id', 'code', 'name', 'currency', 'is_default']);

        return response()->json([
            'data' => $domains,
        ]);
    }
}
