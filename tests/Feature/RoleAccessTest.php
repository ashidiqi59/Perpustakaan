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

    /** 12. Admin users show view differentiates staff from student/pengunjung */
    public function test_admin_user_show_distinguishes_staff_from_pengunjung(): void
    {
        $this->actingAs($this->admin);

        // Show Admin
        $responseAdmin = $this->get(route('admin.users.show', $this->admin->id));
        $responseAdmin->assertStatus(200);
        $responseAdmin->assertDontSee('Aktivitas Peminjaman Buku');
        $responseAdmin->assertDontSee('Nomor Pokok Mahasiswa (NPM)');
        $responseAdmin->assertDontSee('Program Studi / Jurusan');
        $responseAdmin->assertSee('Informasi Profil &amp; Kredensial Staf', false);
        $responseAdmin->assertSee('Wewenang &amp; Cakupan Akses Fitur', false);
        $responseAdmin->assertSee('Jabatan Operasional');

        // Show Petugas
        $responsePetugas = $this->get(route('admin.users.show', $this->petugas->id));
        $responsePetugas->assertStatus(200);
        $responsePetugas->assertDontSee('Aktivitas Peminjaman Buku');
        $responsePetugas->assertDontSee('Nomor Pokok Mahasiswa (NPM)');
        $responsePetugas->assertDontSee('Program Studi / Jurusan');
        $responsePetugas->assertSee('Informasi Profil &amp; Kredensial Staf', false);
        $responsePetugas->assertSee('Petugas Pelayanan &amp; Sirkulasi', false);

        // Show Pengunjung
        $responsePengunjung = $this->get(route('admin.users.show', $this->pengunjung->id));
        $responsePengunjung->assertStatus(200);
        $responsePengunjung->assertSee('Aktivitas Peminjaman Buku');
        $responsePengunjung->assertSee('Biodata Mahasiswa &amp; Anggota', false);
        $responsePengunjung->assertSee('Nomor Pokok Mahasiswa (NPM)');
        $responsePengunjung->assertSee('Program Studi / Jurusan');
        $responsePengunjung->assertDontSee('Wewenang &amp; Cakupan Akses Fitur', false);
    }

    /** 13. Edit user form locks admin role and hides NPM for staff */
    public function test_admin_user_edit_form_locks_admin_role_and_hides_npm(): void
    {
        $this->actingAs($this->admin);

        // Edit Admin: Role is locked, NPM is hidden
        $resAdmin = $this->get(route('admin.users.edit', $this->admin->id));
        $resAdmin->assertStatus(200);
        $resAdmin->assertSee('Peran Administrator bersifat permanen');
        $resAdmin->assertSee('type="hidden" name="role" value="admin"', false);
        $resAdmin->assertSee('id="npm-field-group" class="hidden"', false);

        // Edit Petugas: Role dropdown is available, NPM is hidden
        $resPetugas = $this->get(route('admin.users.edit', $this->petugas->id));
        $resPetugas->assertStatus(200);
        $resPetugas->assertSee('id="role-select"', false);
        $resPetugas->assertSee('id="npm-field-group" class="hidden"', false);

        // Edit Pengunjung: Role dropdown available, NPM is visible
        $resPengunjung = $this->get(route('admin.users.edit', $this->pengunjung->id));
        $resPengunjung->assertStatus(200);
        $resPengunjung->assertDontSee('id="npm-field-group" class="hidden"', false);
    }

    /** 14. Admin role cannot be changed via update request */
    public function test_admin_role_cannot_be_changed_via_update(): void
    {
        $this->actingAs($this->admin);

        $response = $this->put(route('admin.users.update', $this->admin->id), [
            'name'  => 'Admin Updated',
            'email' => $this->admin->email,
            'role'  => 'petugas', // attempt to change admin to petugas
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->admin->refresh();
        $this->assertEquals('admin', $this->admin->role);
        $this->assertEquals('Admin Updated', $this->admin->name);
    }
}
