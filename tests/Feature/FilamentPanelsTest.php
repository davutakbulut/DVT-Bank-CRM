<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class FilamentPanelsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['name' => 'super_admin']);
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'user']);
    }

    public function test_super_admin_can_access_super_panel(): void
    {
        $superAdmin = User::factory()->create();
        $superAdmin->assignRole('super_admin');

        $response = $this->actingAs($superAdmin)->get('/super');
        $response->assertSuccessful();
    }

    public function test_admin_can_access_admin_panel(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertSuccessful();
    }

    public function test_super_admin_can_access_admin_panel(): void
    {
        $superAdmin = User::factory()->create();
        $superAdmin->assignRole('super_admin');

        $response = $this->actingAs($superAdmin)->get('/admin');
        $response->assertSuccessful();
    }

    public function test_regular_user_cannot_access_super_panel(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $response = $this->actingAs($user)->get('/super');
        $response->assertForbidden();
    }

    public function test_regular_user_cannot_access_admin_panel(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $response = $this->actingAs($user)->get('/admin');
        $response->assertForbidden();
    }

    public function test_admin_cannot_access_super_panel(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get('/super');
        $response->assertForbidden();
    }

    public function test_admin_panel_resources_render(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin)->get('/admin/pages')->assertSuccessful();
        $this->actingAs($admin)->get('/admin/faqs')->assertSuccessful();
        $this->actingAs($admin)->get('/admin/announcements')->assertSuccessful();
        $this->actingAs($admin)->get('/admin/contact-messages')->assertSuccessful();
        $this->actingAs($admin)->get('/admin/system-banks')->assertSuccessful();
        $this->actingAs($admin)->get('/admin/system-categories')->assertSuccessful();
        $this->actingAs($admin)->get('/admin/users')->assertSuccessful();
        $this->actingAs($admin)->get('/admin/support-tickets')->assertSuccessful();
    }

    public function test_super_admin_panel_resources_render(): void
    {
        $superAdmin = User::factory()->create();
        $superAdmin->assignRole('super_admin');

        $this->actingAs($superAdmin)->get('/super/plans')->assertSuccessful();
        $this->actingAs($superAdmin)->get('/super/settings')->assertSuccessful();
        $this->actingAs($superAdmin)->get('/super/audit-logs')->assertSuccessful();
        $this->actingAs($superAdmin)->get('/super/users')->assertSuccessful();
        $this->actingAs($superAdmin)->get('/super/subscriptions')->assertSuccessful();
        $this->actingAs($superAdmin)->get('/super/import-jobs')->assertSuccessful();
        $this->actingAs($superAdmin)->get('/super/backup-page')->assertSuccessful();
    }
}
