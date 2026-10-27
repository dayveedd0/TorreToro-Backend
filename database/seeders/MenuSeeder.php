<?php

namespace Database\Seeders;

use App\Models\Domain;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $domains = Domain::all();

        foreach ($domains as $domain) {
            // 1. Primary Header Menu
            $headerMenu = Menu::updateOrCreate(
                ['domain_id' => $domain->id, 'location' => 'header'],
                ['name' => 'Main Navigation (Header)']
            );

            $headerItems = [
                ['title' => 'Home', 'url' => '/', 'order' => 1],
                ['title' => 'Services', 'url' => '/services', 'order' => 2, 'children' => [
                    ['title' => 'Commercial Architecture', 'url' => '/services/architectural-design'],
                    ['title' => 'Commercial Interiors', 'url' => '/services/interior-design'],
                    ['title' => 'Construction Consultancy', 'url' => '/services/building-construction'],
                    ['title' => 'Procurement Services', 'url' => '/services/consultancy-and-procurement'],
                    ['title' => 'Real Estate', 'url' => '/services/real-estate'],
                ]],
                ['title' => 'Portfolio', 'url' => '/portfolio', 'order' => 3],
                ['title' => 'News', 'url' => '/news', 'order' => 4],
                ['title' => 'About Us', 'url' => '/about-us', 'order' => 5],
                ['title' => 'Contact Us', 'url' => '/contact-us', 'order' => 6],
            ];

            $this->createMenuItems($headerMenu, $headerItems);

            // 2. Footer Quick Links
            $quickLinksMenu = Menu::updateOrCreate(
                ['domain_id' => $domain->id, 'location' => 'footer_quick_links'],
                ['name' => 'Footer Quick Links']
            );

            $quickLinks = [
                ['title' => 'About Company', 'url' => '/about-us', 'order' => 1],
                ['title' => 'Our Services', 'url' => '/services', 'order' => 2],
                ['title' => 'Our Projects', 'url' => '/portfolio', 'order' => 3],
                ['title' => 'Pricing', 'url' => '/contact-us', 'order' => 4],
                ['title' => 'Contacts', 'url' => '/contact-us', 'order' => 5],
            ];
            $this->createMenuItems($quickLinksMenu, $quickLinks);

            // 3. Footer Client Support
            $supportMenu = Menu::updateOrCreate(
                ['domain_id' => $domain->id, 'location' => 'footer_client_support'],
                ['name' => 'Footer Client Support']
            );

            $supportLinks = [
                ['title' => 'Careers', 'url' => '/contact-us?subject=careers', 'order' => 1],
                ['title' => 'Our Process', 'url' => '/about-us#our-process', 'order' => 2],
                ['title' => 'FAQs', 'url' => '/about-us#faqs', 'order' => 3],
                ['title' => 'Clients Testimonials', 'url' => '/#testimonials', 'order' => 4],
                ['title' => 'Our Blog', 'url' => '/news', 'order' => 5],
            ];
            $this->createMenuItems($supportMenu, $supportLinks);

            // 4. Top Bar Links
            $topBarMenu = Menu::updateOrCreate(
                ['domain_id' => $domain->id, 'location' => 'top_bar'],
                ['name' => 'Top Bar Navigation']
            );

            $topBarItems = [
                ['title' => 'Support', 'url' => '/contact-us', 'order' => 1],
                ['title' => 'Partners', 'url' => '/about-us#partners', 'order' => 2],
                ['title' => 'Careers', 'url' => '/contact-us?subject=careers', 'order' => 3],
            ];
            $this->createMenuItems($topBarMenu, $topBarItems);
        }
    }

    private function createMenuItems(Menu $menu, array $items): void
    {
        $menu->items()->delete();

        foreach ($items as $data) {
            $children = $data['children'] ?? null;
            unset($data['children']);

            $item = $menu->items()->create($data);

            if ($children) {
                foreach ($children as $cIdx => $child) {
                    $child['menu_id'] = $menu->id;
                    $child['parent_id'] = $item->id;
                    $child['order'] = $cIdx + 1;
                    MenuItem::create($child);
                }
            }
        }
    }
}
