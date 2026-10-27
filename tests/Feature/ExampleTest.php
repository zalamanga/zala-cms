<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Page;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('ZalaCMS');
    }

    public function test_admin_can_login_and_open_dashboard(): void
    {
        User::updateOrCreate(
            ['email' => 'admin-test@zala.test'],
            ['name' => 'Test Admin', 'role' => 'admin', 'password' => Hash::make('password123')]
        );

        $response = $this->post('/login', [
            'email' => 'admin-test@zala.test',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
        $this->get('/admin')->assertStatus(200)->assertSee('Dashboard');
    }

    public function test_published_page_pretty_url_works(): void
    {
        Page::updateOrCreate(
            ['slug' => 'tentang-kami'],
            [
                'title' => 'Tentang Kami',
                'content' => 'Konten halaman tentang kami untuk test.',
                'status' => 'published',
                'template' => 'about',
                'show_in_nav' => true,
                'sort_order' => 1,
                'published_at' => now(),
            ]
        );

        $this->get('/tentang-kami')
            ->assertStatus(200)
            ->assertSee('Tentang Kami');
    }

    public function test_custom_404_page_is_rendered(): void
    {
        $this->get('/halaman-yang-tidak-ada')
            ->assertStatus(404)
            ->assertSee('Halaman ini belum tersedia');
    }

    public function test_admin_can_open_site_settings(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'settings-admin@zala.test'],
            ['name' => 'Settings Admin', 'role' => 'admin', 'password' => Hash::make('password123')]
        );

        $this->actingAs($admin)
            ->get('/admin/settings')
            ->assertStatus(200)
            ->assertSee('Site Settings');
    }
}
