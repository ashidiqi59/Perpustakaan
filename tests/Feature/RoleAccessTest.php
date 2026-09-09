<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $petugas;
    private User $pengunjung;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'npm' => 'ADM001',
        ]);

        $this->petugas = User::factory()->create([
            'role' => User::ROLE_PETUGAS,
            'name' => 'Petugas User',
            'email' => 'petugas@test.com',
            'npm' => 'PTG001',
        ]);

        $this->pengunjung = User::factory()->create([
            'role' => User::ROLE_PENGUNJUNG,
            'name' => 'Pengunjung User',
            'email' => 'pengunjung@test.com',
            'npm' => 'PGJ001',
        ]);
    }

    /** 1. Guest can access public pages */
    public function test_guest_can_access_public_pages(): void
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);

        $response = $this->get(route('books.collection'));
        $response->assertStatus(200);

        $response = $this->get(route('login'));
        $response->assertStatus(200);
    }

    /** 2. Guest is redirected to login for protected pages */
    public function test_guest_is_redirected_to_login(): void
    {
        $this->get(route('my-loans'))->assertRedirect(route('login'));
        $this->get(route('profile'))->assertRedirect(route('login'));
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
        $this->get(route('petugas.dashboard'))->assertRedirect(route('login'));
    }

    /** 3. Admin is force redirected to admin dashboard when accessing visitor pages */
    public function test_admin_cannot_access_visitor_pages(): void
    {
        $this->actingAs($this->admin);

        // Beranda
        $this->get(route('home'))->assertRedirect(route('admin.dashboard'));

        // Koleksi
        $this->get(route('books.collection'))->assertRedirect(route('admin.dashboard'));

        // Peminjaman Saya
        $this->get(route('my-loans'))->assertRedirect(route('admin.dashboard'));

        // Profil
        $this->get(route('profile'))->assertRedirect(route('admin.dashboard'));
    }

    /** 4. Petugas is force redirected to petugas dashboard when accessing visitor pages */
    public function test_petugas_cannot_access_visitor_pages(): void
    {
        $this->actingAs($this->petugas);

        // Beranda
        $this->get(route('home'))->assertRedirect(route('petugas.dashboard'));

        // Koleksi
        $this->get(route('books.collection'))->assertRedirect(route('petugas.dashboard'));

        // Peminjaman Saya
        $this->get(route('my-loans'))->assertRedirect(route('petugas.dashboard'));

        // Profil
        $this->get(route('profile'))->assertRedirect(route('petugas.dashboard'));
    }

    /** 5. Pengunjung CANNOT access admin pages and is redirected to home */
    public function test_pengunjung_cannot_access_admin_pages(): void
    {
        $this->actingAs($this->pengunjung);

        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('home'))
            ->assertSessionHas('error');

        $this->get(route('admin.users.index'))
            ->assertRedirect(route('home'))
            ->assertSessionHas('error');

        $this->get(route('admin.books.index'))
            ->assertRedirect(route('home'))
            ->assertSessionHas('error');
    }

    /** 6. Pengunjung CANNOT access petugas pages and is redirected to home */
    public function test_pengunjung_cannot_access_petugas_pages(): void
    {
        $this->actingAs($this->pengunjung);

        $this->get(route('petugas.dashboard'))
            ->assertRedirect(route('home'))
            ->assertSessionHas('error');
    }

    /** 7. Petugas CANNOT access admin pages and is redirected to petugas dashboard */
    public function test_petugas_cannot_access_admin_pages(): void
    {
        $this->actingAs($this->petugas);

        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('petugas.dashboard'))
            ->assertSessionHas('error');
    }

    /** 8. Admin CAN access admin dashboard and petugas scanner */
    public function test_admin_can_access_admin_and_petugas_pages(): void
    {
        $this->actingAs($this->admin);

        $this->get(route('admin.dashboard'))->assertStatus(200);
        $this->get(route('petugas.dashboard'))->assertStatus(200);
    }

    /** 9. Petugas CAN access petugas dashboard */
    public function test_petugas_can_access_petugas_dashboard(): void
    {
        $this->actingAs($this->petugas);

        $this->get(route('petugas.dashboard'))->assertStatus(200);
    }

    /** 10. Pengunjung CAN access visitor pages */
    public function test_pengunjung_can_access_visitor_pages(): void
    {
        $this->actingAs($this->pengunjung);

        $this->get(route('home'))->assertStatus(200);
        $this->get(route('books.collection'))->assertStatus(200);
        $this->get(route('my-loans'))->assertStatus(200);
        $this->get(route('profile'))->assertStatus(200);
    }

    /** 11. Logged in users are redirected away from login and register pages */
    public function test_logged_in_users_redirected_from_login(): void
    {
        $this->actingAs($this->admin);
        $this->get(route('login'))->assertRedirect(route('admin.dashboard'));

        $this->actingAs($this->petugas);
        $this->get(route('login'))->assertRedirect(route('petugas.dashboard'));

        $this->actingAs($this->pengunjung);
        $this->get(route('login'))->assertRedirect(route('home'));
    }
}
