<?php

namespace Tests\Feature;

use App\Models\Pembayar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiPembayarTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_senarai_pembayar(): void
    {
        Pembayar::create([
            'nama' => 'Test API',
            'no_ic' => '950101145678',
            'alamat' => 'Kedah',
            'no_tel' => '0123456789',
        ]);

        $response = $this->getJson('/api/v1/pembayar');
        $response->assertStatus(200)
                 ->assertJsonStructure(['status', 'data']);
    }

    public function test_api_cipta_pembayar(): void
    {
        $response = $this->postJson('/api/v1/pembayar', [
            'nama' => 'API Pembayar',
            'no_ic' => '940101145678',
            'alamat' => 'Jalan API',
            'no_tel' => '0191234567',
        ]);

        $response->assertStatus(201)
                 ->assertJson(['status' => 'success']);
        $this->assertDatabaseHas('pembayars', ['nama' => 'API Pembayar']);
    }

    public function test_api_lihat_pembayar(): void
    {
        $pembayar = Pembayar::create([
            'nama' => 'Lihat API',
            'no_ic' => '930101145678',
            'alamat' => 'Kedah',
            'no_tel' => '0171234567',
        ]);

        $response = $this->getJson("/api/v1/pembayar/{$pembayar->id}");
        $response->assertStatus(200)
                 ->assertJson(['status' => 'success']);
    }

    public function test_api_pengesahan_gagal(): void
    {
        $response = $this->postJson('/api/v1/pembayar', []);
        $response->assertStatus(422);
    }
}
