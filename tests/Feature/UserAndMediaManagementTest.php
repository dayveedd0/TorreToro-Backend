<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserAndMediaManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_login_page_renders_with_brand_logo(): void
    {
        $response = $this->get(route('admin.login'));
        $response->assertStatus(200);
        $response->assertSee('/storage/uploads/branding/logo-white.png');
    }

    public function test_media_api_returns_json_asset_collection(): void
    {
        $admin = User::first();
        $response = $this->actingAs($admin)->getJson(route('admin.media.api'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'data' => [
                '*' => ['name', 'path', 'url', 'is_image', 'is_video', 'folder'],
            ],
        ]);
    }

    public function test_admin_can_view_users_list(): void
    {
        $admin = User::first();
        $response = $this->actingAs($admin)->get(route('admin.users.index'));

        $response->assertStatus(200);
        $response->assertSee('Admin Users, Roles & Permissions', false);
        $response->assertSee($admin->name);
    }

    public function test_admin_can_create_new_user_with_role_and_permissions(): void
    {
        $admin = User::first();
        
        $response = $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'Kater Titus',
            'email' => 'kater@torretoro.com',
            'phone' => '+234 813 600 121',
            'password' => 'secret12345',
            'password_confirmation' => 'secret12345',
            'role' => User::ROLE_EDITOR,
            'permissions' => ['manage_pages', 'manage_services', 'manage_projects', 'manage_media'],
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'name' => 'Kater Titus',
            'email' => 'kater@torretoro.com',
            'role' => User::ROLE_EDITOR,
            'is_active' => true,
        ]);

        $createdUser = User::where('email', 'kater@torretoro.com')->first();
        $this->assertTrue($createdUser->hasPermission('manage_pages'));
        $this->assertTrue($createdUser->hasPermission('manage_media'));
        $this->assertFalse($createdUser->hasPermission('manage_settings'));
    }

    public function test_admin_can_update_user(): void
    {
        $admin = User::first();
        $editor = User::create([
            'name' => 'Olamide Roberts',
            'email' => 'olamide@torretoro.com',
            'password' => Hash::make('password123'),
            'role' => User::ROLE_AUTHOR,
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->put(route('admin.users.update', $editor), [
            'name' => 'Olamide Roberts Lead',
            'email' => 'olamide@torretoro.com',
            'phone' => '+234 813 1111 444',
            'role' => User::ROLE_EDITOR,
            'permissions' => ['manage_posts', 'manage_media'],
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'id' => $editor->id,
            'name' => 'Olamide Roberts Lead',
            'role' => User::ROLE_EDITOR,
        ]);
    }

    public function test_admin_cannot_delete_themselves(): void
    {
        $admin = User::first();
        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $admin));

        $response->assertSessionHas('error', 'You cannot delete your own logged-in admin account.');
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }
}
