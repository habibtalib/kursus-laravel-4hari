# Hari 3 — Paparan Blade, Pengesahan Data, Auth, Polisi & Kebenaran, Cronjob

> **Sistem Pengurusan Zakat Kedah** — Kursus Laravel 4 Hari
> Tempoh: 6 jam | Prasyarat: Hari 1 & 2 selesai

---

## Pengenalan

Hari 3 membina di atas projek sedia ada daripada Hari 1 (Pembayar CRUD, persekitaran) dan Hari 2 (Routes, Controllers, Middleware). Hari ini kita akan menambah dua entiti baharu, membina komponen Blade boleh guna semula, menambah pengesahan pengguna (authentication), dan mempelajari penjadual tugas (task scheduler).

| # | Topik | Perkara |
|---|-------|---------|
| 1 | Blade Components | `<x-alert>`, `<x-badge>`, `<x-card>`, `@props` |
| 2 | CRUD Lanjutan | JenisZakat & Pembayaran — CRUD lengkap |
| 3 | Pengesahan Data | Validation rules, mesej BM, `@error` |
| 4 | Pengesahan Pengguna | Login, Register, middleware `auth`/`guest` |
| 5 | Polisi, Peranan & Kebenaran | Policy, Roles, `@can`, `$this->authorize()` |
| 6 | Cronjob & Scheduler | Artisan commands, task scheduling |
| 7 | Penghantaran E-mel | Mailable, Mail facade, paparan e-mel |

---

## Bahagian A: Blade Components

Komponen Blade membolehkan kita mencipta elemen UI boleh guna semula. Setiap komponen disimpan dalam `resources/views/components/`.

### Langkah 1: Cipta Komponen Alert

Fail: `resources/views/components/alert.blade.php`

```php
@props(['type' => 'info'])

@php
    $classes = match($type) {
        'success' => 'bg-green-50 border-green-400 text-green-800',
        'error'   => 'bg-red-50 border-red-400 text-red-800',
        'warning' => 'bg-yellow-50 border-yellow-400 text-yellow-800',
        'info'    => 'bg-blue-50 border-blue-400 text-blue-800',
        default   => 'bg-blue-50 border-blue-400 text-blue-800',
    };

    $iconColor = match($type) {
        'success' => 'text-green-400',
        'error'   => 'text-red-400',
        'warning' => 'text-yellow-400',
        'info'    => 'text-blue-400',
        default   => 'text-blue-400',
    };
@endphp

<div x-data="{ show: true }"
     x-show="show"
     x-init="setTimeout(() => show = false, 5000)"
     class="border-l-4 p-4 rounded-r-lg {{ $classes }} relative"
     role="alert">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            {{-- Ikon mengikut jenis --}}
            <span class="text-sm font-medium">{{ $slot }}</span>
        </div>
        <button onclick="this.closest('[role=alert]').remove()" class="ml-4 {{ $iconColor }} hover:opacity-75">
            &times;
        </button>
    </div>
</div>
```

**Penggunaan dalam layout:**

```blade
@if (session('success'))
    <x-alert type="success">{{ session('success') }}</x-alert>
@endif
```

**Konsep penting:**
- `@props` — mengisytihar atribut komponen dengan nilai lalai
- `$slot` — kandungan yang dihantar ke dalam komponen
- `match()` — ungkapan padanan PHP 8 untuk memilih kelas CSS

### Langkah 2: Cipta Komponen Badge

Fail: `resources/views/components/badge.blade.php`

```php
@props(['type' => 'default'])

@php
    $classes = match($type) {
        'aktif', 'sah', 'success'       => 'bg-green-100 text-green-800',
        'tidak aktif', 'batal', 'error'  => 'bg-red-100 text-red-800',
        'pending', 'warning'             => 'bg-yellow-100 text-yellow-800',
        'info'                           => 'bg-blue-100 text-blue-800',
        default                          => 'bg-gray-100 text-gray-800',
    };
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $classes }}">
    {{ $slot }}
</span>
```

**Penggunaan:**

```blade
<x-badge type="aktif">Aktif</x-badge>
<x-badge type="pending">Pending</x-badge>
<x-badge :type="$pembayaran->status">{{ ucfirst($pembayaran->status) }}</x-badge>
```

### Langkah 3: Cipta Komponen Card

Fail: `resources/views/components/card.blade.php`

```php
@props(['title' => null])

<div {{ $attributes->merge(['class' => 'bg-white rounded-lg shadow-md overflow-hidden']) }}>
    @if($title)
        <div class="px-6 py-4 bg-emerald-50 border-b border-emerald-100">
            <h2 class="text-lg font-semibold text-emerald-800">{{ $title }}</h2>
        </div>
    @endif
    <div class="p-6">
        {{ $slot }}
    </div>
</div>
```

**Penggunaan:**

```blade
<x-card title="Maklumat Pembayar">
    {{-- Kandungan kad --}}
</x-card>

<x-card class="mb-6">
    {{-- Kad tanpa tajuk --}}
</x-card>
```

**Konsep penting:**
- `$attributes->merge()` — gabungkan atribut HTML tambahan
- `@if($title)` — tajuk kad adalah pilihan (optional)

---

## Bahagian B: CRUD Jenis Zakat & Pembayaran

### Langkah 4: Cipta JenisZakatController

Jalankan arahan Artisan:

```bash
php artisan make:controller JenisZakatController --resource
```

Fail: `app/Http/Controllers/JenisZakatController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\JenisZakat;
use Illuminate\Http\Request;

class JenisZakatController extends Controller
{
    public function index()
    {
        $jenisZakats = JenisZakat::withCount('pembayarans')->orderBy('nama')->get();
        return view('jenis-zakat.index', compact('jenisZakats'));
    }

    public function create()
    {
        return view('jenis-zakat.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kadar' => 'required|numeric|min:0',
            'penerangan' => 'nullable|string',
            'is_aktif' => 'boolean',
        ], [
            'nama.required' => 'Nama jenis zakat wajib diisi.',
            'kadar.required' => 'Kadar zakat wajib diisi.',
            'kadar.numeric' => 'Kadar mestilah nombor.',
            'kadar.min' => 'Kadar tidak boleh negatif.',
        ]);

        $validated['is_aktif'] = $request->has('is_aktif');
        JenisZakat::create($validated);

        return redirect()->route('jenis-zakat.index')
            ->with('success', 'Jenis zakat berjaya ditambah.');
    }

    public function show(JenisZakat $jenisZakat)
    {
        $jenisZakat->loadCount('pembayarans');
        return view('jenis-zakat.show', compact('jenisZakat'));
    }

    public function edit(JenisZakat $jenisZakat)
    {
        return view('jenis-zakat.edit', compact('jenisZakat'));
    }

    public function update(Request $request, JenisZakat $jenisZakat)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kadar' => 'required|numeric|min:0',
            'penerangan' => 'nullable|string',
            'is_aktif' => 'boolean',
        ], [
            'nama.required' => 'Nama jenis zakat wajib diisi.',
            'kadar.required' => 'Kadar zakat wajib diisi.',
            'kadar.numeric' => 'Kadar mestilah nombor.',
            'kadar.min' => 'Kadar tidak boleh negatif.',
        ]);

        $validated['is_aktif'] = $request->has('is_aktif');
        $jenisZakat->update($validated);

        return redirect()->route('jenis-zakat.index')
            ->with('success', 'Jenis zakat berjaya dikemaskini.');
    }

    public function destroy(JenisZakat $jenisZakat)
    {
        $jenisZakat->delete();
        return redirect()->route('jenis-zakat.index')
            ->with('success', 'Jenis zakat berjaya dipadam.');
    }
}
```

### Langkah 5: Cipta Paparan Jenis Zakat

**5a. Senarai — `resources/views/jenis-zakat/index.blade.php`**

```blade
@extends('layouts.app')

@section('title', 'Senarai Jenis Zakat — Sistem Zakat Kedah')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Senarai Jenis Zakat</h1>
        <a href="{{ route('jenis-zakat.create') }}"
           class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700">
            Tambah Jenis Zakat
        </a>
    </div>

    <x-card>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kadar (%)</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bil. Bayaran</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($jenisZakats as $jenis)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 text-sm font-medium">{{ $jenis->nama }}</td>
                            <td class="px-4 py-3 text-sm">{{ number_format($jenis->kadar, 2) }}%</td>
                            <td class="px-4 py-3 text-sm">
                                @if($jenis->is_aktif)
                                    <x-badge type="aktif">Aktif</x-badge>
                                @else
                                    <x-badge type="tidak aktif">Tidak Aktif</x-badge>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm">{{ $jenis->pembayarans_count }}</td>
                            <td class="px-4 py-3 text-sm text-center">
                                <a href="{{ route('jenis-zakat.show', $jenis) }}" class="text-emerald-600 hover:text-emerald-800">Lihat</a>
                                <a href="{{ route('jenis-zakat.edit', $jenis) }}" class="ml-2 text-blue-600 hover:text-blue-800">Edit</a>
                                <form action="{{ route('jenis-zakat.destroy', $jenis) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Pasti mahu padam?')">
                                    @csrf @method('DELETE')
                                    <button class="ml-2 text-red-600 hover:text-red-800">Padam</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">Tiada rekod.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>
@endsection
```

**5b. Tambah — `resources/views/jenis-zakat/create.blade.php`**

```blade
@extends('layouts.app')
@section('title', 'Tambah Jenis Zakat')
@section('content')
    <x-card title="Tambah Jenis Zakat Baru">
        <form method="POST" action="{{ route('jenis-zakat.store') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                           class="w-full rounded-lg border-gray-300 @error('nama') border-red-500 @enderror">
                    @error('nama')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                {{-- Kadar, Penerangan, Is Aktif (lihat fail penuh) --}}
            </div>
            <div class="flex justify-end mt-6 pt-4 border-t">
                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg">Simpan</button>
            </div>
        </form>
    </x-card>
@endsection
```

> **Nota:** Fail penuh `create.blade.php`, `edit.blade.php`, dan `show.blade.php` telah disediakan dalam folder projek. Rujuk fail sebenar untuk kod lengkap.

### Langkah 6: Cipta PembayaranController

```bash
php artisan make:controller PembayaranController --resource
```

Fail: `app/Http/Controllers/PembayaranController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pembayar;
use App\Models\JenisZakat;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');

        $pembayarans = Pembayaran::with(['pembayar', 'jenisZakat'])
            ->when($status, fn ($query) => $query->where('status', $status))
            ->orderByDesc('tarikh_bayar')
            ->paginate(10)
            ->withQueryString();

        return view('pembayaran.index', compact('pembayarans', 'status'));
    }

    public function create()
    {
        $pembayars = Pembayar::orderBy('nama')->get();
        $jenisZakats = JenisZakat::aktif()->orderBy('nama')->get();
        $noResit = 'ZK-' . date('Y') . '-' . str_pad(Pembayaran::count() + 1, 4, '0', STR_PAD_LEFT);

        return view('pembayaran.create', compact('pembayars', 'jenisZakats', 'noResit'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pembayar_id' => 'required|exists:pembayars,id',
            'jenis_zakat_id' => 'required|exists:jenis_zakats,id',
            'jumlah' => 'required|numeric|min:1',
            'tarikh_bayar' => 'required|date',
            'cara_bayar' => 'required|in:tunai,kad,fpx,online',
            'no_resit' => 'required|string|unique:pembayarans,no_resit',
        ], [
            'pembayar_id.required' => 'Sila pilih pembayar.',
            'jenis_zakat_id.required' => 'Sila pilih jenis zakat.',
            'jumlah.required' => 'Jumlah bayaran wajib diisi.',
            'jumlah.min' => 'Jumlah minimum ialah RM 1.00.',
            'tarikh_bayar.required' => 'Tarikh bayar wajib diisi.',
            'cara_bayar.required' => 'Sila pilih cara bayar.',
            'no_resit.unique' => 'No. resit telah wujud.',
        ]);

        $validated['status'] = 'pending';
        Pembayaran::create($validated);

        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berjaya ditambah.');
    }

    public function show(Pembayaran $pembayaran)
    {
        $pembayaran->load(['pembayar', 'jenisZakat']);
        return view('pembayaran.show', compact('pembayaran'));
    }

    public function edit(Pembayaran $pembayaran)
    {
        $pembayars = Pembayar::orderBy('nama')->get();
        $jenisZakats = JenisZakat::aktif()->orderBy('nama')->get();
        return view('pembayaran.edit', compact('pembayaran', 'pembayars', 'jenisZakats'));
    }

    public function update(Request $request, Pembayaran $pembayaran)
    {
        $validated = $request->validate([
            'pembayar_id' => 'required|exists:pembayars,id',
            'jenis_zakat_id' => 'required|exists:jenis_zakats,id',
            'jumlah' => 'required|numeric|min:1',
            'tarikh_bayar' => 'required|date',
            'cara_bayar' => 'required|in:tunai,kad,fpx,online',
            'status' => 'required|in:pending,sah,batal',
        ], [
            'pembayar_id.required' => 'Sila pilih pembayar.',
            'jenis_zakat_id.required' => 'Sila pilih jenis zakat.',
            'jumlah.required' => 'Jumlah bayaran wajib diisi.',
            'jumlah.min' => 'Jumlah minimum ialah RM 1.00.',
            'tarikh_bayar.required' => 'Tarikh bayar wajib diisi.',
            'cara_bayar.required' => 'Sila pilih cara bayar.',
            'status.required' => 'Sila pilih status.',
        ]);

        $pembayaran->update($validated);

        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berjaya dikemaskini.');
    }

    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaran->delete();
        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berjaya dipadam.');
    }
}
```

### Langkah 7: Cipta Paparan Pembayaran

Empat fail paparan berikut telah disediakan dalam folder `resources/views/pembayaran/`:

- **`index.blade.php`** — Senarai pembayaran dengan penapis status dan paginasi
- **`create.blade.php`** — Borang tambah pembayaran (dropdown pembayar & jenis zakat, no resit auto-jana)
- **`show.blade.php`** — Paparan terperinci pembayaran
- **`edit.blade.php`** — Borang kemaskini pembayaran (termasuk tukar status)

Contoh penggunaan komponen dalam paparan pembayaran:

```blade
{{-- Badge status dinamik --}}
<x-badge :type="$bayaran->status">{{ ucfirst($bayaran->status) }}</x-badge>

{{-- Penapis status menggunakan Card --}}
<x-card class="mb-6">
    <form method="GET" action="{{ route('pembayaran.index') }}">
        <select name="status">
            <option value="">Semua Status</option>
            <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="sah" {{ $status === 'sah' ? 'selected' : '' }}>Sah</option>
            <option value="batal" {{ $status === 'batal' ? 'selected' : '' }}>Batal</option>
        </select>
        <button type="submit">Tapis</button>
    </form>
</x-card>
```

### Langkah 8: Tambah Laluan & Navigasi

Laluan sumber (resource routes) untuk ketiga-tiga entiti didaftarkan dalam `routes/web.php`. Lihat **Bahagian D** untuk versi lengkap dengan perlindungan auth.

---

## Bahagian C: Pengesahan Data (Validation)

### Langkah 9: Peraturan Pengesahan

Laravel menyediakan sistem pengesahan data yang berkuasa. Kita menggunakan `$request->validate()` dalam controller dengan mesej ralat dalam Bahasa Melayu.

**Contoh dalam PembayaranController@store:**

```php
$validated = $request->validate([
    'pembayar_id'   => 'required|exists:pembayars,id',
    'jenis_zakat_id'=> 'required|exists:jenis_zakats,id',
    'jumlah'        => 'required|numeric|min:1',
    'tarikh_bayar'  => 'required|date',
    'cara_bayar'    => 'required|in:tunai,kad,fpx,online',
    'no_resit'      => 'required|string|unique:pembayarans,no_resit',
], [
    'pembayar_id.required'   => 'Sila pilih pembayar.',
    'pembayar_id.exists'     => 'Pembayar tidak sah.',
    'jenis_zakat_id.required'=> 'Sila pilih jenis zakat.',
    'jumlah.required'        => 'Jumlah bayaran wajib diisi.',
    'jumlah.numeric'         => 'Jumlah mestilah nombor.',
    'jumlah.min'             => 'Jumlah minimum ialah RM 1.00.',
    'tarikh_bayar.required'  => 'Tarikh bayar wajib diisi.',
    'tarikh_bayar.date'      => 'Format tarikh tidak sah.',
    'cara_bayar.required'    => 'Sila pilih cara bayar.',
    'cara_bayar.in'          => 'Cara bayar tidak sah.',
    'no_resit.unique'        => 'No. resit telah wujud.',
]);
```

**Memaparkan ralat dalam Blade menggunakan `@error`:**

```blade
<div>
    <label for="jumlah">Jumlah (RM) <span class="text-red-500">*</span></label>
    <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah') }}"
           class="w-full rounded-lg border-gray-300 @error('jumlah') border-red-500 @enderror">
    @error('jumlah')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
```

**Jadual peraturan pengesahan yang digunakan:**

| Peraturan | Penerangan |
|-----------|-----------|
| `required` | Medan wajib diisi |
| `string` | Mestilah teks |
| `numeric` | Mestilah nombor |
| `min:1` | Nilai minimum |
| `max:255` | Panjang maksimum |
| `email` | Format e-mel sah |
| `date` | Format tarikh sah |
| `size:12` | Tepat 12 aksara |
| `unique:table,column` | Nilai unik dalam jadual |
| `exists:table,column` | Nilai wujud dalam jadual |
| `in:a,b,c` | Mestilah salah satu nilai |
| `confirmed` | Mesti ada medan `_confirmation` yang sepadan |
| `boolean` | Mestilah `true` atau `false` |
| `nullable` | Medan boleh kosong |

---

## Bahagian D: Pengesahan Pengguna (Authentication)

### Langkah 10: Cipta LoginController

```bash
mkdir -p app/Http/Controllers/Auth
```

Fail: `app/Http/Controllers/Auth/LoginController.php`

```php
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'E-mel wajib diisi.',
            'email.email' => 'Format e-mel tidak sah.',
            'password.required' => 'Kata laluan wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('pembayar.index'))
                ->with('success', 'Selamat datang, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'E-mel atau kata laluan tidak sepadan.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah berjaya log keluar.');
    }
}
```

**Penerangan aliran:**
1. `Auth::attempt($credentials)` — Cuba padankan e-mel dan kata laluan
2. `$request->session()->regenerate()` — Jana semula ID sesi untuk keselamatan
3. `redirect()->intended()` — Hala ke halaman asal sebelum redirect
4. `back()->withErrors()` — Kembali dengan mesej ralat

### Langkah 11: Cipta RegisterController

Fail: `app/Http/Controllers/Auth/RegisterController.php`

```php
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'E-mel wajib diisi.',
            'email.email' => 'Format e-mel tidak sah.',
            'email.unique' => 'E-mel ini telah didaftarkan.',
            'password.required' => 'Kata laluan wajib diisi.',
            'password.min' => 'Kata laluan mestilah sekurang-kurangnya 8 aksara.',
            'password.confirmed' => 'Pengesahan kata laluan tidak sepadan.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect()->route('pembayar.index')
            ->with('success', 'Pendaftaran berjaya! Selamat datang, ' . $user->name . '.');
    }
}
```

### Langkah 12: Cipta Paparan Login & Pendaftaran

Kedua-dua paparan adalah halaman **standalone** (mempunyai `<html>`, `<head>`, Tailwind CDN sendiri) dengan latar belakang gradient emerald dan kad putih di tengah.

**Paparan Login — `resources/views/auth/login.blade.php`**

Borang mengandungi:
- Medan **E-mel** dan **Kata Laluan**
- Kotak semak **Ingat Saya** (`remember`)
- Butang **Log Masuk**
- Pautan ke halaman pendaftaran

**Paparan Pendaftaran — `resources/views/auth/register.blade.php`**

Borang mengandungi:
- Medan **Nama**, **E-mel**, **Kata Laluan**, **Sahkan Kata Laluan**
- Butang **Daftar**
- Pautan ke halaman log masuk

> Rujuk fail sebenar dalam folder `resources/views/auth/` untuk kod lengkap.

### Langkah 13: Kemas Kini Laluan untuk Auth

Fail: `routes/web.php`

```php
<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PembayarController;
use App\Http\Controllers\JenisZakatController;
use App\Http\Controllers\PembayaranController;
use Illuminate\Support\Facades\Route;

// Auth (tetamu sahaja)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/daftar', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/daftar', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Laluan dilindungi (perlu log masuk)
Route::middleware('auth')->group(function () {
    Route::get('/', fn () => redirect()->route('pembayar.index'));
    Route::resource('pembayar', PembayarController::class);
    Route::resource('jenis-zakat', JenisZakatController::class);
    Route::resource('pembayaran', PembayaranController::class);
});
```

**Konsep:**
- `middleware('guest')` — hanya pengguna yang BELUM log masuk boleh akses
- `middleware('auth')` — hanya pengguna yang SUDAH log masuk boleh akses
- `->name('login')` — nama laluan ini khas; Laravel akan redirect ke sini jika pengguna belum log masuk

### Langkah 14: Kemas Kini Navigasi

Tambah blok `@auth` dalam `resources/views/layouts/app.blade.php` untuk memaparkan nama pengguna dan butang Log Keluar:

```blade
{{-- Dalam bahagian navigasi desktop --}}
@auth
    <div class="ml-4 pl-4 border-l border-emerald-600 flex items-center space-x-3">
        <span class="text-emerald-100 text-sm">{{ Auth::user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="px-3 py-1.5 bg-emerald-900 text-emerald-100 text-sm rounded-md hover:bg-red-700 hover:text-white">
                Log Keluar
            </button>
        </form>
    </div>
@endauth
```

### Langkah 15: Cipta Admin Seeder

Kemas kini `database/seeders/DatabaseSeeder.php` untuk menambah pengguna admin:

```php
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Cipta pengguna admin
        User::create([
            'name' => 'Admin Zakat',
            'email' => 'admin@zakat.test',
            'password' => Hash::make('password'),
        ]);

        $this->call([
            PembayarSeeder::class,
            JenisZakatSeeder::class,
            PembayaranSeeder::class,
        ]);
    }
}
```

Jalankan migrasi dan seeder:

```bash
php artisan migrate:fresh --seed
```

Log masuk dengan: `admin@zakat.test` / `password`

### Langkah 16: Konsep Authentication Laravel

| Konsep | Penerangan |
|--------|-----------|
| `Auth::attempt($credentials)` | Cuba log masuk — semak e-mel & kata laluan |
| `Auth::login($user)` | Log masuk pengguna secara manual (selepas daftar) |
| `Auth::logout()` | Log keluar pengguna semasa |
| `Auth::user()` | Dapatkan objek pengguna yang sedang log masuk |
| `Auth::check()` | Semak sama ada pengguna sudah log masuk (`true`/`false`) |
| `Hash::make($password)` | Hash kata laluan sebelum simpan ke DB |
| `middleware('auth')` | Halang akses jika belum log masuk |
| `middleware('guest')` | Halang akses jika sudah log masuk |
| `@auth ... @endauth` | Papar kandungan hanya untuk pengguna yang log masuk |
| `@guest ... @endguest` | Papar kandungan hanya untuk tetamu |
| `redirect()->intended()` | Redirect ke URL asal sebelum login redirect |
| `session()->regenerate()` | Jana semula ID sesi (keselamatan) |
| `session()->invalidate()` | Hapus semua data sesi (semasa logout) |

---

## Bahagian E: Polisi, Peranan & Kebenaran (Policy, Roles & Permissions)

Laravel menyediakan sistem kebenaran (authorization) melalui **Policy** dan **Gate**. Kita akan membina sistem peranan mudah (role-based access control) tanpa pakej luaran.

### Langkah 17: Tambah Peranan pada Jadual Pengguna

```bash
php artisan make:migration add_role_to_users_table --table=users
```

**Fail:** `database/migrations/2024_01_01_000004_add_role_to_users_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'pegawai', 'pemerhati'])->default('pemerhati')->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
```

**Peranan dalam sistem:**

| Peranan | Penerangan | Pembayar | Jenis Zakat | Pembayaran |
|---------|------------|----------|-------------|------------|
| `admin` | Pentadbir sistem | CRUD penuh | CRUD penuh | CRUD penuh |
| `pegawai` | Pegawai zakat | Cipta, Kemaskini, Lihat | Lihat sahaja | Cipta, Kemaskini, Lihat |
| `pemerhati` | Pemerhati / Auditor | Lihat sahaja | Lihat sahaja | Lihat sahaja |

### Langkah 18: Kemas Kini Model User

**Fail:** `app/Models/User.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // === Peranan (Roles) ===

    /**
     * Semak sama ada pengguna ialah admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Semak sama ada pengguna ialah pegawai.
     */
    public function isPegawai(): bool
    {
        return $this->role === 'pegawai';
    }

    /**
     * Semak sama ada pengguna ialah pemerhati.
     */
    public function isPemerhati(): bool
    {
        return $this->role === 'pemerhati';
    }

    /**
     * Semak sama ada pengguna mempunyai salah satu peranan.
     */
    public function hasRole(string ...$roles): bool
    {
        return in_array($this->role, $roles);
    }
}
```

### Langkah 19: Cipta Policy — PembayarPolicy

```bash
php artisan make:policy PembayarPolicy --model=Pembayar
```

**Fail:** `app/Policies/PembayarPolicy.php`

```php
<?php

namespace App\Policies;

use App\Models\Pembayar;
use App\Models\User;

class PembayarPolicy
{
    /**
     * Semak sama ada pengguna boleh melihat senarai pembayar.
     * Semua peranan dibenarkan.
     */
    public function viewAny(User $user): bool
    {
        return true; // Semua peranan boleh lihat senarai
    }

    /**
     * Semak sama ada pengguna boleh melihat seorang pembayar.
     */
    public function view(User $user, Pembayar $pembayar): bool
    {
        return true; // Semua peranan boleh lihat butiran
    }

    /**
     * Semak sama ada pengguna boleh mendaftar pembayar baru.
     * Hanya admin dan pegawai dibenarkan.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin', 'pegawai');
    }

    /**
     * Semak sama ada pengguna boleh mengemaskini pembayar.
     * Hanya admin dan pegawai dibenarkan.
     */
    public function update(User $user, Pembayar $pembayar): bool
    {
        return $user->hasRole('admin', 'pegawai');
    }

    /**
     * Semak sama ada pengguna boleh memadamkan pembayar.
     * Hanya admin dibenarkan.
     */
    public function delete(User $user, Pembayar $pembayar): bool
    {
        return $user->isAdmin();
    }
}
```

**Penjelasan:**
- Setiap kaedah policy menerima `User $user` dan (pilihan) model instance
- Return `true` = dibenarkan, `false` = ditolak
- `hasRole('admin', 'pegawai')` — Semak sama ada pengguna mempunyai salah satu peranan
- Laravel secara automatik memadankan nama policy berdasarkan nama model

### Langkah 20: Cipta Policy — JenisZakatPolicy & PembayaranPolicy

**Fail:** `app/Policies/JenisZakatPolicy.php`

```php
<?php

namespace App\Policies;

use App\Models\JenisZakat;
use App\Models\User;

class JenisZakatPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, JenisZakat $jenisZakat): bool
    {
        return true;
    }

    /**
     * Hanya admin boleh mengurus jenis zakat.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, JenisZakat $jenisZakat): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, JenisZakat $jenisZakat): bool
    {
        return $user->isAdmin();
    }
}
```

**Fail:** `app/Policies/PembayaranPolicy.php`

```php
<?php

namespace App\Policies;

use App\Models\Pembayaran;
use App\Models\User;

class PembayaranPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Pembayaran $pembayaran): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin', 'pegawai');
    }

    public function update(User $user, Pembayaran $pembayaran): bool
    {
        return $user->hasRole('admin', 'pegawai');
    }

    public function delete(User $user, Pembayaran $pembayaran): bool
    {
        return $user->isAdmin();
    }
}
```

### Langkah 21: Cipta Middleware Semak Peranan

```bash
php artisan make:middleware SemakPeranan
```

**Fail:** `app/Http/Middleware/SemakPeranan.php`

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SemakPeranan
{
    /**
     * Semak peranan pengguna.
     * Penggunaan: middleware('peranan:admin,pegawai')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!$request->user() || !$request->user()->hasRole(...$roles)) {
            abort(403, 'Anda tidak mempunyai kebenaran untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
```

**Penggunaan dalam laluan:**

```php
// Hanya admin boleh akses
Route::get('/tetapan', ...)->middleware('peranan:admin');

// Admin dan pegawai boleh akses
Route::resource('pembayar', ...)->middleware('peranan:admin,pegawai');
```

### Langkah 22: Daftar Middleware

**Fail:** `bootstrap/app.php`

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'peranan' => \App\Http\Middleware\SemakPeranan::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
```

### Langkah 23: Guna Policy dalam Controller

Tambah `$this->authorize()` pada setiap kaedah controller:

**Fail:** `app/Http/Controllers/PembayarController.php` (contoh)

```php
public function index(Request $request)
{
    $this->authorize('viewAny', Pembayar::class);

    $carian = $request->input('carian');
    // ... kod sedia ada
}

public function create()
{
    $this->authorize('create', Pembayar::class);
    return view('pembayar.create');
}

public function store(Request $request)
{
    $this->authorize('create', Pembayar::class);
    // ... pengesahan dan simpan
}

public function show(Pembayar $pembayar)
{
    $this->authorize('view', $pembayar);
    // ... kod sedia ada
}

public function edit(Pembayar $pembayar)
{
    $this->authorize('update', $pembayar);
    return view('pembayar.edit', compact('pembayar'));
}

public function update(Request $request, Pembayar $pembayar)
{
    $this->authorize('update', $pembayar);
    // ... pengesahan dan kemaskini
}

public function destroy(Pembayar $pembayar)
{
    $this->authorize('delete', $pembayar);
    $pembayar->delete();
    return redirect()->route('pembayar.index')->with('success', 'Pembayar berjaya dipadamkan.');
}
```

> **Nota:** Tambah corak yang sama pada `JenisZakatController` dan `PembayaranController`.

### Langkah 24: Sembunyikan Butang dengan @can dalam Blade

Gunakan arahan `@can` untuk menyembunyikan butang berdasarkan kebenaran:

```blade
{{-- Hanya papar butang jika pengguna mempunyai kebenaran --}}
@can('create', App\Models\Pembayar::class)
    <a href="{{ route('pembayar.create') }}">Daftar Pembayar Baru</a>
@endcan

@can('update', $pembayar)
    <a href="{{ route('pembayar.edit', $pembayar) }}">Kemaskini</a>
@endcan

@can('delete', $pembayar)
    <form action="{{ route('pembayar.destroy', $pembayar) }}" method="POST">
        @csrf @method('DELETE')
        <button>Padam</button>
    </form>
@endcan
```

> **Nota:** Gunakan corak yang sama pada paparan `jenis-zakat` dan `pembayaran`.

### Langkah 25: Cipta Pengguna Mengikut Peranan

**Fail:** `database/seeders/DatabaseSeeder.php`

```php
// Cipta pengguna mengikut peranan
User::create([
    'name' => 'Admin Zakat',
    'email' => 'admin@zakat.test',
    'password' => Hash::make('password'),
    'role' => 'admin',
]);

User::create([
    'name' => 'Pegawai Zakat',
    'email' => 'pegawai@zakat.test',
    'password' => Hash::make('password'),
    'role' => 'pegawai',
]);

User::create([
    'name' => 'Pemerhati',
    'email' => 'pemerhati@zakat.test',
    'password' => Hash::make('password'),
    'role' => 'pemerhati',
]);
```

### Langkah 26: Uji Kebenaran

| # | Ujian | Langkah | Jangkaan |
|---|-------|---------|----------|
| 1 | Log masuk sebagai admin | admin@zakat.test / password | Boleh CRUD semua |
| 2 | Log masuk sebagai pegawai | pegawai@zakat.test / password | Boleh cipta/kemaskini, tidak boleh padam |
| 3 | Log masuk sebagai pemerhati | pemerhati@zakat.test / password | Lihat sahaja, butang cipta/kemaskini/padam tersembunyi |
| 4 | Akses terus URL | /pembayar/create sebagai pemerhati | 403 Forbidden |

### Konsep Authorization dalam Laravel

| Konsep | Penerangan |
|--------|------------|
| `Policy` | Kelas yang mentakrifkan kebenaran untuk satu model |
| `Gate` | Kebenaran umum (tidak terikat model) — tidak digunakan di sini |
| `$this->authorize()` | Semak kebenaran dalam controller, throw 403 jika gagal |
| `@can` / `@cannot` | Arahan Blade untuk semak kebenaran dalam paparan |
| `$user->can()` | Semak kebenaran dalam kod PHP |
| `middleware('can:create,App\Models\Pembayar')` | Semak kebenaran melalui middleware laluan |
| `hasRole()` | Kaedah custom pada model User |

---

## Bahagian F: Cronjob & Task Scheduler

Laravel Task Scheduler membolehkan anda menjadualkan tugas-tugas automatik tanpa perlu mengurus crontab yang kompleks. Anda hanya perlu satu entri crontab, dan Laravel menguruskan yang selebihnya.

### Langkah 27: Cipta Arahan Artisan — Laporan Harian

```bash
php artisan make:command LaporanHarian
```

Fail: `app/Console/Commands/LaporanHarian.php`

```php
<?php

namespace App\Console\Commands;

use App\Models\Pembayaran;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class LaporanHarian extends Command
{
    protected $signature = 'zakat:laporan-harian';
    protected $description = 'Hasilkan laporan harian kutipan zakat';

    public function handle()
    {
        $tarikh = now()->format('d/m/Y');
        $jumlahHariIni = Pembayaran::whereDate('tarikh_bayar', today())->count();
        $kutipanHariIni = Pembayaran::whereDate('tarikh_bayar', today())
            ->where('status', 'sah')
            ->sum('jumlah');

        $jumlahKeseluruhan = Pembayaran::count();
        $kutipanKeseluruhan = Pembayaran::where('status', 'sah')->sum('jumlah');

        $this->info("====================================");
        $this->info("  LAPORAN HARIAN ZAKAT KEDAH");
        $this->info("  Tarikh: {$tarikh}");
        $this->info("====================================");
        $this->info("Transaksi hari ini : {$jumlahHariIni}");
        $this->info("Kutipan hari ini   : RM " . number_format($kutipanHariIni, 2));
        $this->info("------------------------------------");
        $this->info("Jumlah transaksi   : {$jumlahKeseluruhan}");
        $this->info("Jumlah kutipan     : RM " . number_format($kutipanKeseluruhan, 2));
        $this->info("====================================");

        // Log ke fail
        Log::info("Laporan Harian Zakat - {$tarikh}", [
            'transaksi_hari_ini' => $jumlahHariIni,
            'kutipan_hari_ini' => $kutipanHariIni,
            'jumlah_transaksi' => $jumlahKeseluruhan,
            'jumlah_kutipan' => $kutipanKeseluruhan,
        ]);

        $this->info('Laporan berjaya dilog ke storage/logs/laravel.log');
        return Command::SUCCESS;
    }
}
```

**Uji arahan:**

```bash
php artisan zakat:laporan-harian
```

Output jangkaan:

```
====================================
  LAPORAN HARIAN ZAKAT KEDAH
  Tarikh: 06/04/2026
====================================
Transaksi hari ini : 0
Kutipan hari ini   : RM 0.00
------------------------------------
Jumlah transaksi   : 20
Jumlah kutipan     : RM 5,481.00
====================================
Laporan berjaya dilog ke storage/logs/laravel.log
```

### Langkah 28: Cipta Arahan Artisan — Bersih Pembayaran Batal

```bash
php artisan make:command BersihkanPembayaranBatal
```

Fail: `app/Console/Commands/BersihkanPembayaranBatal.php`

```php
<?php

namespace App\Console\Commands;

use App\Models\Pembayaran;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class BersihkanPembayaranBatal extends Command
{
    protected $signature = 'zakat:bersih-batal';
    protected $description = 'Padamkan rekod pembayaran batal yang lebih 30 hari';

    public function handle()
    {
        $jumlah = Pembayaran::where('status', 'batal')
            ->where('created_at', '<', now()->subDays(30))
            ->count();

        if ($jumlah === 0) {
            $this->info('Tiada rekod batal untuk dipadamkan.');
            return Command::SUCCESS;
        }

        Pembayaran::where('status', 'batal')
            ->where('created_at', '<', now()->subDays(30))
            ->delete();

        $this->info("{$jumlah} rekod pembayaran batal telah dipadamkan.");
        Log::info("Pembersihan: {$jumlah} rekod batal dipadamkan.");
        return Command::SUCCESS;
    }
}
```

**Uji arahan:**

```bash
php artisan zakat:bersih-batal
```

### Langkah 29: Daftar Jadual (Schedule)

Fail: `routes/console.php`

```php
<?php

use Illuminate\Support\Facades\Schedule;

// Laporan harian — jalankan setiap hari pada jam 8 pagi
Schedule::command('zakat:laporan-harian')->dailyAt('08:00');

// Bersihkan pembayaran batal — jalankan setiap minggu pada hari Isnin
Schedule::command('zakat:bersih-batal')->weeklyOn(1, '02:00');
```

### Langkah 30: Jalankan Scheduler

**Lihat senarai jadual:**

```bash
php artisan schedule:list
```

Output jangkaan:

```
  zakat:laporan-harian .... 08:00 .............. Next Due: esok
  zakat:bersih-batal ...... Isnin jam 02:00 .... Next Due: Isnin
```

**Jalankan scheduler secara manual (untuk ujian):**

```bash
php artisan schedule:run
```

**Jadual kaedah scheduler yang berguna:**

| Kaedah | Penerangan |
|--------|-----------|
| `->daily()` | Setiap hari pada 00:00 |
| `->dailyAt('08:00')` | Setiap hari pada jam 8 pagi |
| `->hourly()` | Setiap jam |
| `->weeklyOn(1, '02:00')` | Setiap Isnin jam 2 pagi |
| `->monthly()` | Setiap bulan |
| `->everyMinute()` | Setiap minit (untuk ujian) |
| `->withoutOverlapping()` | Elak pertindihan jika masih berjalan |
| `->appendOutputTo(path)` | Log output ke fail |

**Setup crontab untuk production (Linux/macOS):**

```bash
crontab -e
```

Tambah baris berikut:

```
* * * * * cd /path/to/sistem-zakat && php artisan schedule:run >> /dev/null 2>&1
```

Ini menjalankan `schedule:run` setiap minit. Laravel akan menentukan arahan mana yang perlu dilaksanakan berdasarkan jadual yang didaftarkan.

**Pada Laragon (Windows):**

Laragon mempunyai sokongan scheduler terbina dalam. Anda boleh menambah tugas melalui menu Laragon > Scheduler.

---

## Bahagian G: Penghantaran E-mel (Mail)

Laravel menyediakan API e-mel yang ringkas melalui kelas `Mailable`. Untuk pembangunan, kita menggunakan pemandu `log` supaya e-mel direkod dalam fail log tanpa memerlukan pelayan SMTP sebenar.

### Langkah 31: Konfigurasi E-mel

Pastikan fail `.env` mempunyai tetapan berikut:

```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS="noreply@zakat.test"
MAIL_FROM_NAME="Sistem Zakat Kedah"
```

**Penjelasan:**
- `MAIL_MAILER=log` — E-mel direkod ke `storage/logs/laravel.log` (untuk pembangunan)
- Untuk pengeluaran, tukar kepada `smtp` dan tetapkan pelayan SMTP sebenar

### Langkah 32: Cipta Mailable — Selamat Datang

```bash
php artisan make:mail SelamatDatangMail
```

**Fail:** `app/Mail/SelamatDatangMail.php`

```php
<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SelamatDatangMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Cipta instance mel baru.
     */
    public function __construct(
        public User $user
    ) {}

    /**
     * Tetapkan sampul mel (subjek, pengirim).
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Selamat Datang ke Sistem Zakat Kedah',
        );
    }

    /**
     * Tetapkan kandungan mel.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.selamat-datang',
        );
    }
}
```

**Penjelasan:**
- `Mailable` — Kelas asas untuk semua e-mel dalam Laravel
- `envelope()` — Tetapkan subjek dan pengirim
- `content()` — Tetapkan paparan (view) yang digunakan sebagai kandungan e-mel
- `public User $user` — Data yang dihantar ke paparan e-mel (constructor promotion)
- `Queueable` — Membolehkan e-mel dihantar secara async melalui queue

### Langkah 33: Cipta Paparan E-mel Selamat Datang

**Fail:** `resources/views/emails/selamat-datang.blade.php`

```blade
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin:0; padding:0; background-color:#f4f5f7; font-family:'Segoe UI',Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f5f7; padding:40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background-color:#131F72; padding:30px; text-align:center;">
                            <h1 style="color:#ffffff; margin:0; font-size:24px;">Sistem Zakat Kedah</h1>
                            <p style="color:#a0aec0; margin:5px 0 0; font-size:14px;">Lembaga Zakat Negeri Kedah</p>
                        </td>
                    </tr>
                    <!-- Body -->
                    <tr>
                        <td style="padding:40px 30px;">
                            <h2 style="color:#131F72; margin:0 0 20px;">Assalamualaikum, {{ $user->name }}!</h2>
                            <p style="color:#333; font-size:16px; line-height:1.6;">
                                Selamat datang ke <strong>Sistem Pengurusan Zakat Kedah</strong>. Akaun anda telah berjaya didaftarkan.
                            </p>
                            <p style="color:#333; font-size:16px; line-height:1.6;">
                                Anda kini boleh menggunakan sistem ini untuk:
                            </p>
                            <ul style="color:#555; font-size:15px; line-height:2;">
                                <li>Mendaftar dan mengurus maklumat pembayar zakat</li>
                                <li>Merekod pembayaran zakat</li>
                                <li>Melihat laporan kutipan</li>
                            </ul>
                            <table cellpadding="0" cellspacing="0" style="margin:30px 0;">
                                <tr>
                                    <td style="background-color:#30AE20; border-radius:6px; padding:12px 30px;">
                                        <a href="{{ url('/') }}" style="color:#ffffff; text-decoration:none; font-size:16px; font-weight:bold;">
                                            Log Masuk Sekarang
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            <p style="color:#999; font-size:13px;">
                                Jika anda tidak mendaftar akaun ini, sila abaikan e-mel ini.
                            </p>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="background-color:#f8f9fa; padding:20px 30px; text-align:center; border-top:1px solid #e2e8f0;">
                            <p style="color:#999; font-size:12px; margin:0;">
                                &copy; {{ date('Y') }} Lembaga Zakat Negeri Kedah. Hak Cipta Terpelihara.<br>
                                <em>Zakat Anda Kami Agih</em>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
```

**Penjelasan:**
- Gunakan **inline CSS** (bukan kelas CSS) kerana kebanyakan klien e-mel tidak menyokong CSS luaran
- Struktur menggunakan `<table>` untuk keserasian merentas klien e-mel
- Akses data melalui `{{ $user->name }}` kerana `$user` dihantar dari Mailable

### Langkah 34: Hantar E-mel Semasa Pendaftaran

Kemas kini `RegisterController` untuk menghantar e-mel selamat datang selepas pendaftaran berjaya.

**Fail:** `app/Http/Controllers/Auth/RegisterController.php`

```php
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SelamatDatangMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /**
     * Papar borang pendaftaran.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Proses pendaftaran pengguna baru.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama tidak boleh melebihi 255 aksara.',
            'email.required' => 'E-mel wajib diisi.',
            'email.email' => 'Format e-mel tidak sah.',
            'email.unique' => 'E-mel ini telah didaftarkan.',
            'password.required' => 'Kata laluan wajib diisi.',
            'password.min' => 'Kata laluan mestilah sekurang-kurangnya 8 aksara.',
            'password.confirmed' => 'Pengesahan kata laluan tidak sepadan.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Hantar e-mel selamat datang  <-- BARIS BARU
        Mail::to($user->email)->send(new SelamatDatangMail($user));

        Auth::login($user);

        return redirect()->route('pembayar.index')
            ->with('success', 'Pendaftaran berjaya! Selamat datang, ' . $user->name . '.');
    }
}
```

**Penjelasan:**
- `Mail::to($user->email)` — Tetapkan penerima
- `->send(new SelamatDatangMail($user))` — Hantar e-mel secara segerak (synchronous)
- Untuk menghantar secara async: `Mail::to($user->email)->queue(new SelamatDatangMail($user))`

### Langkah 35: Cipta Mailable — Laporan Harian

```bash
php artisan make:mail LaporanHarianMail
```

**Fail:** `app/Mail/LaporanHarianMail.php`

```php
<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LaporanHarianMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Cipta instance mel baru.
     */
    public function __construct(
        public array $laporan
    ) {}

    /**
     * Tetapkan sampul mel.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Laporan Harian Zakat Kedah - ' . now()->format('d/m/Y'),
        );
    }

    /**
     * Tetapkan kandungan mel.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.laporan-harian',
        );
    }
}
```

### Langkah 36: Cipta Paparan E-mel Laporan

**Fail:** `resources/views/emails/laporan-harian.blade.php`

```blade
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
</head>
<body style="margin:0; padding:0; background-color:#f4f5f7; font-family:'Segoe UI',Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f5f7; padding:40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background-color:#131F72; padding:25px; text-align:center;">
                            <h1 style="color:#ffffff; margin:0; font-size:20px;">Laporan Harian Zakat Kedah</h1>
                            <p style="color:#a0aec0; margin:5px 0 0; font-size:14px;">{{ $laporan['tarikh'] }}</p>
                        </td>
                    </tr>
                    <!-- Stats -->
                    <tr>
                        <td style="padding:30px;">
                            <h3 style="color:#131F72; margin:0 0 15px;">Ringkasan Hari Ini</h3>
                            <table width="100%" cellpadding="10" cellspacing="0" style="border:1px solid #e2e8f0; border-radius:6px;">
                                <tr style="background-color:#f8f9fa;">
                                    <td style="font-weight:bold; color:#555; border-bottom:1px solid #e2e8f0;">Transaksi Hari Ini</td>
                                    <td style="text-align:right; color:#131F72; font-weight:bold; border-bottom:1px solid #e2e8f0;">{{ $laporan['transaksi_hari_ini'] }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:bold; color:#555; border-bottom:1px solid #e2e8f0;">Kutipan Hari Ini</td>
                                    <td style="text-align:right; color:#30AE20; font-weight:bold; font-size:18px; border-bottom:1px solid #e2e8f0;">RM {{ number_format($laporan['kutipan_hari_ini'], 2) }}</td>
                                </tr>
                                <tr style="background-color:#f8f9fa;">
                                    <td style="font-weight:bold; color:#555; border-bottom:1px solid #e2e8f0;">Jumlah Transaksi Keseluruhan</td>
                                    <td style="text-align:right; color:#131F72; border-bottom:1px solid #e2e8f0;">{{ $laporan['jumlah_transaksi'] }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:bold; color:#555;">Jumlah Kutipan Keseluruhan</td>
                                    <td style="text-align:right; color:#131F72; font-weight:bold; font-size:18px;">RM {{ number_format($laporan['jumlah_kutipan'], 2) }}</td>
                                </tr>
                            </table>
                            <p style="color:#999; font-size:13px; margin-top:20px;">
                                Laporan ini dijana secara automatik oleh Sistem Zakat Kedah.
                            </p>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="background-color:#f8f9fa; padding:15px; text-align:center; border-top:1px solid #e2e8f0;">
                            <p style="color:#999; font-size:12px; margin:0;">
                                &copy; {{ date('Y') }} Lembaga Zakat Negeri Kedah
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
```

### Langkah 37: Kemas Kini Cronjob untuk Hantar E-mel

Kemas kini arahan `LaporanHarian` supaya menghantar laporan melalui e-mel selain merekod ke log.

**Fail:** `app/Console/Commands/LaporanHarian.php`

```php
<?php

namespace App\Console\Commands;

use App\Mail\LaporanHarianMail;
use App\Models\Pembayaran;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LaporanHarian extends Command
{
    /**
     * Nama dan tandatangan arahan.
     */
    protected $signature = 'zakat:laporan-harian';

    /**
     * Penerangan arahan.
     */
    protected $description = 'Hasilkan laporan harian kutipan zakat';

    /**
     * Jalankan arahan.
     */
    public function handle()
    {
        $tarikh = now()->format('d/m/Y');
        $jumlahHariIni = Pembayaran::whereDate('tarikh_bayar', today())->count();
        $kutipanHariIni = Pembayaran::whereDate('tarikh_bayar', today())
            ->where('status', 'sah')
            ->sum('jumlah');

        $jumlahKeseluruhan = Pembayaran::count();
        $kutipanKeseluruhan = Pembayaran::where('status', 'sah')->sum('jumlah');

        $this->info("====================================");
        $this->info("  LAPORAN HARIAN ZAKAT KEDAH");
        $this->info("  Tarikh: {$tarikh}");
        $this->info("====================================");
        $this->info("Transaksi hari ini : {$jumlahHariIni}");
        $this->info("Kutipan hari ini   : RM " . number_format($kutipanHariIni, 2));
        $this->info("------------------------------------");
        $this->info("Jumlah transaksi   : {$jumlahKeseluruhan}");
        $this->info("Jumlah kutipan     : RM " . number_format($kutipanKeseluruhan, 2));
        $this->info("====================================");

        // Log ke fail
        Log::info("Laporan Harian Zakat - {$tarikh}", [
            'transaksi_hari_ini' => $jumlahHariIni,
            'kutipan_hari_ini' => $kutipanHariIni,
            'jumlah_transaksi' => $jumlahKeseluruhan,
            'jumlah_kutipan' => $kutipanKeseluruhan,
        ]);

        $this->info('Laporan berjaya dilog ke storage/logs/laravel.log');

        // Hantar laporan melalui e-mel  <-- BARIS BARU
        $laporan = [
            'tarikh' => $tarikh,
            'transaksi_hari_ini' => $jumlahHariIni,
            'kutipan_hari_ini' => $kutipanHariIni,
            'jumlah_transaksi' => $jumlahKeseluruhan,
            'jumlah_kutipan' => $kutipanKeseluruhan,
        ];

        Mail::to(config('mail.from.address'))->send(new LaporanHarianMail($laporan));
        $this->info('Laporan dihantar melalui e-mel.');

        return Command::SUCCESS;
    }
}
```

### Langkah 38: Uji Penghantaran E-mel

#### 28a. Uji e-mel pendaftaran

```bash
# Daftar pengguna baru melalui /daftar
# Kemudian semak log:
tail -50 storage/logs/laravel.log
```

Anda akan nampak kandungan e-mel HTML dalam fail log.

#### 28b. Uji e-mel laporan harian

```bash
php artisan zakat:laporan-harian
tail -50 storage/logs/laravel.log
```

#### 28c. Uji dengan Mailpit (pilihan)

Untuk melihat e-mel dalam format visual, gunakan [Mailpit](https://mailpit.axllent.org/):

```bash
# Pasang Mailpit
brew install axllent/tap/mailpit

# Jalankan Mailpit
mailpit

# Kemas kini .env
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_ENCRYPTION=null
```

Buka `http://localhost:8025` untuk melihat e-mel dalam peti masuk maya.

### Konsep E-mel dalam Laravel

| Konsep | Penerangan |
|--------|------------|
| `Mailable` | Kelas yang mewakili satu e-mel |
| `Mail::to()->send()` | Hantar e-mel secara segerak |
| `Mail::to()->queue()` | Hantar e-mel secara async (perlu queue driver) |
| `envelope()` | Tetapkan subjek, pengirim, CC, BCC |
| `content()` | Tetapkan view template untuk kandungan |
| `MAIL_MAILER=log` | Rekod e-mel ke fail log (pembangunan) |
| `MAIL_MAILER=smtp` | Hantar e-mel melalui pelayan SMTP (pengeluaran) |
| `Queueable` | Trait untuk membolehkan e-mel masuk queue |
| Inline CSS | Gaya CSS terus pada elemen HTML (keperluan klien e-mel) |

---

## Bahagian H: Jalankan & Uji

### Langkah 39: Migrasi & Seed

```bash
php artisan migrate:fresh --seed
```

Ini akan:
- Padam dan cipta semula semua jadual
- Masukkan 3 pengguna: admin (`admin@zakat.test`), pegawai (`pegawai@zakat.test`), pemerhati (`pemerhati@zakat.test`) — kata laluan: `password`
- Masukkan 10 pembayar, 5 jenis zakat, dan 20 pembayaran contoh

### Langkah 40: Uji CRUD

1. Buka `http://sistem-zakat.test` — akan redirect ke halaman login
2. Log masuk dengan `admin@zakat.test` / `password`
3. Uji CRUD Jenis Zakat:
   - Lihat senarai, tambah, kemaskini, padam
   - Cuba hantar borang kosong — lihat mesej pengesahan BM
4. Uji CRUD Pembayaran:
   - Tambah pembayaran baru (pilih pembayar & jenis zakat)
   - Tapis mengikut status
   - Kemaskini status pembayaran

### Langkah 41: Uji Auth

1. Log keluar (butang "Log Keluar" di navbar)
2. Cuba akses `/pembayar` — akan redirect ke `/login`
3. Daftar akaun baru di `/daftar`
4. Log masuk semula dengan akaun baru

### Langkah 42: Uji Peranan & Kebenaran

1. Log masuk sebagai admin (`admin@zakat.test`) — semua butang tampil
2. Log masuk sebagai pegawai (`pegawai@zakat.test`) — butang padam tersembunyi
3. Log masuk sebagai pemerhati (`pemerhati@zakat.test`) — hanya boleh lihat
4. Cuba akses `/pembayar/create` sebagai pemerhati — 403 Forbidden

### Langkah 43: Uji Cronjob

```bash
# Lihat senarai arahan zakat
php artisan list | grep zakat

# Jalankan laporan harian
php artisan zakat:laporan-harian

# Jalankan pembersihan
php artisan zakat:bersih-batal

# Lihat jadual
php artisan schedule:list

# Jalankan scheduler
php artisan schedule:run
```

---

## Struktur Fail Hari 3 (Fail Baru Sahaja)

```
sistem-zakat/
├── app/
│   ├── Console/Commands/
│   │   ├── LaporanHarian.php              ← Arahan laporan harian (+ e-mel)
│   │   └── BersihkanPembayaranBatal.php    ← Arahan bersih rekod batal
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   ├── LoginController.php         ← Log masuk
│   │   │   │   └── RegisterController.php      ← Pendaftaran (+ e-mel)
│   │   │   ├── JenisZakatController.php        ← CRUD jenis zakat (+ authorize)
│   │   │   └── PembayaranController.php        ← CRUD pembayaran (+ authorize)
│   │   └── Middleware/
│   │       └── SemakPeranan.php                ← Middleware semak peranan
│   ├── Mail/
│   │   ├── SelamatDatangMail.php           ← E-mel selamat datang
│   │   └── LaporanHarianMail.php           ← E-mel laporan harian
│   ├── Models/
│   │   ├── User.php                        ← Dikemaskini (+ role methods)
│   │   ├── JenisZakat.php                  ← Model jenis zakat
│   │   └── Pembayaran.php                  ← Model pembayaran
│   └── Policies/
│       ├── PembayarPolicy.php              ← Polisi kebenaran pembayar
│       ├── JenisZakatPolicy.php            ← Polisi kebenaran jenis zakat
│       └── PembayaranPolicy.php            ← Polisi kebenaran pembayaran
├── database/
│   ├── migrations/
│   │   ├── create_jenis_zakats_table.php   ← Migrasi jenis zakat
│   │   ├── create_pembayarans_table.php    ← Migrasi pembayaran
│   │   └── add_role_to_users_table.php     ← Migrasi tambah peranan
│   └── seeders/
│       ├── DatabaseSeeder.php              ← Dikemaskini (+ 3 pengguna peranan)
│       ├── JenisZakatSeeder.php            ← Data contoh jenis zakat
│       └── PembayaranSeeder.php            ← Data contoh pembayaran
├── resources/views/
│   ├── auth/
│   │   ├── login.blade.php                 ← Halaman log masuk
│   │   └── register.blade.php              ← Halaman pendaftaran
│   ├── components/
│   │   ├── alert.blade.php                 ← Komponen amaran
│   │   ├── badge.blade.php                 ← Komponen lencana
│   │   └── card.blade.php                  ← Komponen kad
│   ├── emails/
│   │   ├── selamat-datang.blade.php        ← Template e-mel selamat datang
│   │   └── laporan-harian.blade.php        ← Template e-mel laporan harian
│   ├── jenis-zakat/
│   │   ├── index.blade.php                 ← Senarai jenis zakat
│   │   ├── create.blade.php                ← Borang tambah
│   │   ├── show.blade.php                  ← Paparan terperinci
│   │   └── edit.blade.php                  ← Borang kemaskini
│   ├── pembayaran/
│   │   ├── index.blade.php                 ← Senarai pembayaran
│   │   ├── create.blade.php                ← Borang tambah
│   │   ├── show.blade.php                  ← Paparan terperinci
│   │   └── edit.blade.php                  ← Borang kemaskini
│   └── layouts/
│       └── app.blade.php                   ← Dikemaskini (+ auth nav)
├── routes/
│   ├── web.php                             ← Dikemaskini (+ auth routes)
│   └── console.php                         ← Dikemaskini (+ schedule)
```

---

## Rumusan

| Topik | Apa yang dipelajari |
|-------|-------------------|
| **Blade Components** | Cipta komponen boleh guna semula (`<x-alert>`, `<x-badge>`, `<x-card>`), `@props`, `$slot`, `$attributes->merge()` |
| **CRUD Lanjutan** | JenisZakat & Pembayaran — controller penuh, paparan Blade, eager loading, paginasi |
| **Pengesahan Data** | `$request->validate()` dengan mesej BM, `@error` dalam Blade, `old()` untuk kekalkan input |
| **Authentication** | `Auth::attempt()`, `Auth::login()`, `Hash::make()`, middleware `auth`/`guest`, `@auth`/`@guest` |
| **Policy & Roles** | `Policy`, `$this->authorize()`, `@can`/`@cannot`, `hasRole()`, middleware `peranan`, role-based access control |
| **Cronjob** | Artisan commands (`$signature`, `handle()`), `Schedule::command()`, `schedule:run`, crontab |
| **E-mel** | `Mailable`, `Mail::to()->send()`, `envelope()`, `content()`, inline CSS, `MAIL_MAILER=log` |

**Seterusnya (Hari 4):** REST API, Model Relationships lanjutan, Authentication API, dan Deployment.
