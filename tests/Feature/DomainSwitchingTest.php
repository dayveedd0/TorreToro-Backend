<?php

namespace Tests\Feature;

use App\Models\Domain;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DomainSwitchingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_admin_can_switch_domain_via_get_request(): void
    {
        $admin = User::first() ?? User::factory()->create(['email' => 'admin@torretoro.com']);

        $response = $this->actingAs($admin)
            ->get(route('admin.switch_domain_get', ['code' => 'uk']));

        $response->assertRedirect();
        $response->assertSessionHas('admin_domain_code', 'uk');
        $response->assertCookie('admin_domain_code', 'uk');
    }

    public function test_admin_can_switch_domain_via_post_request(): void
    {
        $admin = User::first() ?? User::factory()->create(['email' => 'admin@torretoro.com']);

        $response = $this->actingAs($admin)
            ->post(route('admin.switch_domain'), ['code' => 'uk']);

        $response->assertRedirect();
        $response->assertSessionHas('admin_domain_code', 'uk');
        $response->assertCookie('admin_domain_code', 'uk');
    }

    public function test_active_domain_resolves_to_uk_when_session_is_set(): void
    {
        $admin = User::first() ?? User::factory()->create(['email' => 'admin@torretoro.com']);

        $response = $this->actingAs($admin)
            ->withSession(['admin_domain_code' => 'uk'])
            ->get(route('admin.home_editor.edit'));

        $response->assertStatus(200);
        $response->assertHeader('X-Active-Domain', 'uk');
        $response->assertSee('Torre Tórò UK');
    }

    public function test_active_domain_resolves_to_global_when_session_is_global(): void
    {
        $admin = User::first() ?? User::factory()->create(['email' => 'admin@torretoro.com']);

        $response = $this->actingAs($admin)
            ->withSession(['admin_domain_code' => 'global'])
            ->get(route('admin.home_editor.edit'));

        $response->assertStatus(200);
        $response->assertHeader('X-Active-Domain', 'global');
        $response->assertSee('Torre Tórò International');
    }

    public function test_updating_home_editor_in_uk_domain_persists_to_uk_record_only(): void
    {
        $admin = User::first() ?? User::factory()->create(['email' => 'admin@torretoro.com']);
        $ukDomain = Domain::where('code', 'uk')->firstOrFail();
        $globalDomain = Domain::where('code', 'global')->firstOrFail();

        $response = $this->actingAs($admin)
            ->withSession(['admin_domain_code' => 'uk'])
            ->put(route('admin.home_editor.update'), [
                'hero_title' => 'Inspiring London Workspaces by Torre Tórò UK',
                'hero_badge' => 'UK Architectural Studio',
                'hero_subtitle' => 'Bespoke corporate architecture in Mayfair, London.',
                'about_heading' => 'Leading Commercial Fit-outs in the United Kingdom',
            ]);

        $response->assertRedirect();

        // Verify UK Page was updated
        $ukPage = \App\Models\Page::where('domain_id', $ukDomain->id)->where('slug', 'home')->first();
        $this->assertNotNull($ukPage);
        $this->assertEquals('Inspiring London Workspaces by Torre Tórò UK', $ukPage->hero_title);
        $this->assertEquals('UK Architectural Studio', $ukPage->hero_badge);

        // Verify Global Page remains intact
        $globalPage = \App\Models\Page::where('domain_id', $globalDomain->id)->where('slug', 'home')->first();
        $this->assertNotNull($globalPage);
        $this->assertNotEquals('Inspiring London Workspaces by Torre Tórò UK', $globalPage->hero_title);
    }
}
