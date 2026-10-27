<?php

namespace Tests\Feature;

use App\Models\Domain;
use App\Models\Page;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageEditorAndPhoneSettingsTest extends TestCase
{
    use RefreshDatabase;

    protected Domain $globalDomain;
    protected Domain $ukDomain;
    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $this->globalDomain = Domain::where('code', 'global')->first();
        $this->ukDomain = Domain::where('code', 'uk')->first();
        $this->adminUser = User::where('email', 'admin@torretoro.com')->first();
    }

    public function test_settings_page_displays_real_phone_numbers_and_dedicated_fields(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.settings.index'));

        $response->assertStatus(200);
        $response->assertSee('+234 813 600 1221');
        $response->assertSee('Primary Business Phone');
        $response->assertSee('Secondary Business Phone');
    }

    public function test_updating_settings_updates_primary_and_secondary_phones(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.settings.update'), [
                'phone' => '+234 813 600 1221',
                'secondary_phone' => '+234 011 336 54',
                'header_phone' => '+234 813 600 1221',
                'header_cta_label' => 'Call Us Now',
                'email' => 'hello@torretoro.com',
                'secondary_email' => 'dami@torretoro.com',
                'address' => '16a Da Silva Street Lekki Phase 1, Lekki Lagos, NIGERIA',
                'currency' => 'NGN',
                'office_hours' => 'Monday - Friday: 8:00 AM - 6:00 PM',
            ]);

        $response->assertRedirect();

        $this->globalDomain->refresh();
        $this->assertEquals('+234 813 600 1221', $this->globalDomain->phone);

        $secondarySetting = Setting::forDomain($this->globalDomain)->where('key', 'secondary_phone')->first();
        $this->assertNotNull($secondarySetting);
        $this->assertEquals('+234 011 336 54', $secondarySetting->value);
    }

    public function test_about_us_page_editor_loads_and_saves_structured_story_and_team(): void
    {
        $aboutPage = Page::updateOrCreate(
            ['domain_id' => $this->globalDomain->id, 'slug' => 'about-us'],
            [
                'title' => 'About Us',
                'hero_badge' => 'ABOUT US',
                'hero_title' => 'CRAFTING EXPERIENCES',
                'hero_subtitle' => 'Torre Toro was born from a simple idea.',
                'hero_image' => '/storage/uploads/about/about-page.png',
                'sections' => [
                    'story' => [
                        'heading' => 'Original Heading',
                        'paragraph_1' => 'Para 1',
                        'paragraph_2' => 'Para 2',
                        'image' => '/storage/uploads/about/about-story.png',
                    ],
                    'team' => [
                        'members' => [
                            [
                                'name' => 'Adeboye Damilola',
                                'role' => 'MD/CEO',
                                'bio' => 'Founder Bio',
                                'image' => '/storage/uploads/team/adeboye-damilola.png',
                            ],
                        ],
                    ],
                ],
                'is_published' => true,
            ]
        );

        $editResponse = $this->actingAs($this->adminUser)
            ->get(route('admin.pages.edit', $aboutPage));

        $editResponse->assertStatus(200);
        $editResponse->assertSee('Our Story & Narrative', false);
        $editResponse->assertSee('Leadership & Team Roster', false);
        $editResponse->assertSee('Adeboye Damilola');

        // Test updating about-us page
        $updateResponse = $this->actingAs($this->adminUser)
            ->put(route('admin.pages.update', $aboutPage), [
                'title' => 'About Us - Torre Toro',
                'hero_badge' => 'EXCLUSIVE DESIGN',
                'hero_title' => 'CRAFTING EXPERIENCES EVERYWHERE',
                'hero_subtitle' => 'Updated subtitle narrative.',
                'hero_image' => '/storage/uploads/about/about-page.png',
                'story_badge' => 'OUR HERITAGE',
                'story_heading' => 'A Legacy of Spatial Excellence',
                'story_p1' => 'We create workspaces that redefine productivity.',
                'story_p2' => 'Operating seamlessly in Nigeria and the UK.',
                'story_image' => '/storage/uploads/about/about-story.png',
                'vision' => 'To inspire businesses globally through human-centric design.',
                'mission' => 'To deliver high performance commercial environments.',
                'values_list' => 'Excellence, Integrity, Innovation, Precision',
                'team_badge' => 'EXECUTIVE LEADERSHIP',
                'team_heading' => 'The Minds Behind Torre Toro',
                'team_members' => [
                    [
                        'name' => 'Adeboye Damilola',
                        'role' => 'MD/CEO',
                        'bio' => 'Visionary commercial spatial leader.',
                        'image' => '/storage/uploads/team/adeboye-damilola.png',
                    ],
                    [
                        'name' => 'Kater Titus',
                        'role' => 'Chief Technology Officer (CTO)',
                        'bio' => 'Smart infrastructure and digital architectural systems.',
                        'image' => '/storage/uploads/team/kater-titus.jpg',
                    ],
                ],
                'is_published' => '1',
            ]);

        $updateResponse->assertRedirect(route('admin.pages.edit', $aboutPage));

        $aboutPage->refresh();
        $this->assertEquals('About Us - Torre Toro', $aboutPage->title);
        $this->assertEquals('A Legacy of Spatial Excellence', $aboutPage->sections['story']['heading']);
        $this->assertCount(2, $aboutPage->sections['team']['members']);
        $this->assertEquals('Kater Titus', $aboutPage->sections['team']['members'][1]['name']);
    }

    public function test_contact_us_page_editor_saves_phone_numbers_and_map(): void
    {
        $contactPage = Page::updateOrCreate(
            ['domain_id' => $this->globalDomain->id, 'slug' => 'contact-us'],
            [
                'title' => 'Contact Us',
                'hero_badge' => 'GET IN TOUCH',
                'hero_title' => 'Contact Us',
                'hero_image' => '/storage/uploads/about/contact-header.png',
                'sections' => [],
                'is_published' => true,
            ]
        );

        $updateResponse = $this->actingAs($this->adminUser)
            ->put(route('admin.pages.update', $contactPage), [
                'title' => 'Contact Us',
                'hero_badge' => 'REACH OUT TO OUR STUDIO',
                'hero_title' => 'Let us build together',
                'hero_subtitle' => 'Our studio is ready for your project.',
                'hero_image' => '/storage/uploads/about/contact-header.png',
                'form_button_text' => 'BOOK CONSULTATION →',
                'phone_1' => '+234 813 600 1221',
                'phone_2' => '+234 011 336 54',
                'email_1' => 'hello@torretoro.com',
                'email_2' => 'dami@torretoro.com',
                'address' => '16a Da Silva Street Lekki Phase 1, Lekki Lagos, NIGERIA',
                'working_hours' => 'Mon-Fri: 8am-6pm',
                'map_image' => '/storage/uploads/maps/map-location.png',
                'map_embed_url' => 'https://maps.google.com/embed/test',
                'map_directions_url' => 'https://maps.google.com/directions/test',
                'is_published' => '1',
            ]);

        $updateResponse->assertRedirect(route('admin.pages.edit', $contactPage));

        $contactPage->refresh();
        $this->assertEquals('BOOK CONSULTATION →', $contactPage->sections['form_info']['button_text']);
        $this->assertEquals('+234 813 600 1221', $contactPage->sections['form_info']['phone_1']);
        $this->assertEquals('+234 011 336 54', $contactPage->sections['form_info']['phone_2']);
        $this->assertEquals('/storage/uploads/maps/map-location.png', $contactPage->sections['map']['map_image']);
    }

    public function test_api_page_endpoint_serves_structured_sections_and_domain(): void
    {
        $response = $this->getJson('/api/v1/pages/about-us');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'slug',
                'hero_title',
                'sections',
                'domain' => [
                    'code',
                    'name',
                    'phone',
                    'email',
                ],
            ],
        ]);

        $data = $response->json('data');
        $this->assertEquals('+234 813 600 1221', $data['domain']['phone']);
    }
}
