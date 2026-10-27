<?php

namespace Database\Seeders;

use App\Models\Domain;
use Illuminate\Database\Seeder;

class DomainSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Global / Nigeria / Rest of World Domain
        Domain::updateOrCreate(
            ['code' => 'global'],
            [
                'name' => 'Torre Tórò International (Nigeria & Global)',
                'hostnames' => ['torretoro.com', 'www.torretoro.com', 'localhost', '127.0.0.1'],
                'currency' => 'NGN',
                'phone' => '+234 813 600 1221',
                'email' => 'hello@torretoro.com',
                'address' => '16a Da Silva Street Lekki Phase 1, Lekki Lagos, NIGERIA',
                'meta_title' => 'Commercial Interior Design & Architecture Firm | Torre Tórò',
                'meta_description' => 'At Torre Toro, we transform commercial spaces into vibrant environments where creativity thrives and businesses flourish.',
                'social_links' => [
                    'instagram' => 'https://www.instagram.com/torretorong/',
                    'facebook' => 'https://facebook.com/torretorong',
                    'twitter' => 'https://x.com/torretorong',
                    'linkedin' => 'https://linkedin.com/company/torretoro',
                    'youtube' => 'https://youtube.com/@torretoro',
                ],
                'is_default' => true,
                'is_active' => true,
            ]
        );

        // 2. United Kingdom Domain
        Domain::updateOrCreate(
            ['code' => 'uk'],
            [
                'name' => 'Torre Tórò UK',
                'hostnames' => ['torretoro.co.uk', 'www.torretoro.co.uk', 'uk.torretoro.com', 'uk.localhost'],
                'currency' => 'GBP',
                'phone' => '+44 20 7946 0991',
                'email' => 'uk@torretoro.com',
                'address' => '45 Berkeley Square, Mayfair, London W1J 5AS, United Kingdom',
                'meta_title' => 'Commercial Workspace Architecture & Interior Design UK | Torre Tórò',
                'meta_description' => 'Torre Tórò UK delivers bespoke workplace consultancy, commercial fit-outs, and architectural excellence for modern workspaces across the United Kingdom.',
                'social_links' => [
                    'instagram' => 'https://www.instagram.com/torretorouk/',
                    'linkedin' => 'https://linkedin.com/company/torretoro-uk',
                    'twitter' => 'https://x.com/torretorouk',
                ],
                'is_default' => false,
                'is_active' => true,
            ]
        );
    }
}
