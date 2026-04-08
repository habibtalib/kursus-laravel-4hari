<?php

namespace Tests\Feature;

use App\Models\Pembayar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PembayarTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Pengguna yang belum log masuk diarah ke halaman login.
     */
    public function test_tetamu_tidak_boleh_akses_pembayar(): void
    {
        $response = $this->get('/pembayar');
        $response->assertRedirect('/login');
    }

    /**
     * Pengguna yang sudah log masuk boleh melihat senarai pembayar.
     */
    public function test_pengguna_boleh_lihat_senarai_pembayar(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/pembayar');
        $response->assertStatus(200);
        $response->assertSee('Senarai Pembayar');
    }

    /**
     * Pengguna boleh mendaftar pembayar baru.
     */
    public function test_pengguna_boleh_daftar_pembayar(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/pembayar', [
            'nama' => 'Ahmad bin Test',
            'no_ic' => '901215145678',
            'alamat' => 'Jalan Ujian, Alor Setar',
            'no_tel' => '0123456789',
            'email' => 'ahmad@test.com',
            'pekerjaan' => 'Jurutera',
            'pendapatan_bulanan' => 5000,
        ]);

        $response->assertRedirect(route('pembayar.index'));
        $this->assertDatabaseHas('pembayars', [
            'nama' => 'Ahmad bin Test',
            'no_ic' => '901215145678',
        ]);
    }

    /**
     * No IC mestilah 12 digit.
     */
    public function test_no_ic_mestilah_12_digit(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/pembayar', [
            'nama' => 'Test',
            'no_ic' => '12345', // Kurang 12 digit
            'alamat' => 'Alamat',
            'no_tel' => '012345',
        ]);

        $response->assertSessionHasErrors('no_ic');
    }

    /**
     * Pengguna boleh melihat maklumat pembayar.
     */
    public function test_pengguna_boleh_lihat_pembayar(): void
    {
        $user = User::factory()->create();
        $pembayar = Pembayar::create([
            'nama' => 'Siti Aminah',
            'no_ic' => '880101145678',
            'alamat' => 'Kedah',
            'no_tel' => '0198765432',
        ]);

        $response = $this->actingAs($user)->get("/pembayar/{$pembayar->id}");
        $response->assertStatus(200);
        $response->assertSee('Siti Aminah');
    }

    /**
     * Pengguna boleh mengemaskini pembayar.
     */
    public function test_pengguna_boleh_kemaskini_pembayar(): void
    {
        $user = User::factory()->create();
        $pembayar = Pembayar::create([
            'nama' => 'Asal Nama',
            'no_ic' => '770101145678',
            'alamat' => 'Kedah',
            'no_tel' => '0112345678',
        ]);

        $response = $this->actingAs($user)->put("/pembayar/{$pembayar->id}", [
            'nama' => 'Nama Baharu',
            'no_ic' => '770101145678',
            'alamat' => 'Alamat Baharu',
            'no_tel' => '0112345678',
        ]);

        $response->assertRedirect(route('pembayar.show', $pembayar));
        $this->assertDatabaseHas('pembayars', ['nama' => 'Nama Baharu']);
    }

    /**
     * Pengguna boleh memadamkan pembayar.
     */
    public function test_pengguna_boleh_padam_pembayar(): void
    {
        $user = User::factory()->create();
        $pembayar = Pembayar::create([
            'nama' => 'Untuk Dipadam',
            'no_ic' => '660101145678',
            'alamat' => 'Kedah',
            'no_tel' => '0131234567',
        ]);

        $response = $this->actingAs($user)->delete("/pembayar/{$pembayar->id}");
        $response->assertRedirect(route('pembayar.index'));
        $this->assertDatabaseMissing('pembayars', ['id' => $pembayar->id]);
    }
}
