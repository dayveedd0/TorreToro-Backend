<?php

namespace Tests\Feature;

use App\Mail\ContactFormSubmissionAlert;
use App\Models\Domain;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class InquiryEmailAndLoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }
    public function test_contact_form_submission_dispatches_email_alert_to_kater()
    {
        Mail::fake();

        $domain = Domain::firstOrCreate(
            ['code' => 'global'],
            ['name' => 'Torre Tórò Global', 'is_default' => true, 'is_active' => true]
        );

        $payload = [
            'name' => 'Michael Scott',
            'email' => 'michael@dundermifflin.com',
            'phone' => '+234 813 600 1221',
            'company' => 'Dunder Mifflin',
            'type' => 'consultation',
            'service_requested' => 'Commercial Interiors',
            'message' => 'Need a complete workspace redesign.',
        ];

        $response = $this->postJson('/api/v1/inquiries', $payload, ['X-Domain' => 'global']);

        $response->assertStatus(201)
            ->assertJsonPath('data.name', 'Michael Scott');

        Mail::assertSent(ContactFormSubmissionAlert::class, function ($mail) {
            return $mail->hasTo('kater@torretoro.com') &&
                   $mail->inquiry->name === 'Michael Scott' &&
                   $mail->inquiry->email === 'michael@dundermifflin.com';
        });
    }

    public function test_admin_login_page_does_not_reveal_credentials()
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
        $response->assertDontSee('admin@torretoro.com / password');
        $response->assertDontSee('value="password"', false);
    }

    public function test_admin_sidebar_layout_does_not_contain_figma_badge()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertDontSee('text-[10px] bg-amber-400/20 text-amber-300 border border-amber-400/40 px-1.5 py-0.5 rounded uppercase font-mono font-bold tracking-tight', false);
        $response->assertDontSee('>Figma<', false);
    }
}
