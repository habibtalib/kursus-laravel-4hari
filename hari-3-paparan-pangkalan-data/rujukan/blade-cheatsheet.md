# Rujukan Pantas Blade

## Memapar Data

| Sintaks | Tujuan | Contoh |
|---------|--------|--------|
| `{{ $var }}` | Papar data (HTML escaped) | `{{ $post->title }}` |
| `{!! $var !!}` | Papar HTML mentah (tidak escaped) | `{!! $post->body !!}` |
| `{{ $var ?? 'lalai' }}` | Papar dengan nilai lalai | `{{ $nama ?? 'Tetamu' }}` |

## Arahan Kawalan

```blade
{{-- Bersyarat --}}
@if($posts->count() > 0)
    <p>Ada {{ $posts->count() }} catatan.</p>
@elseif($posts->count() == 0)
    <p>Tiada catatan.</p>
@else
    <p>Ralat.</p>
@endif

{{-- Gelung --}}
@foreach($posts as $post)
    <h2>{{ $post->title }}</h2>
@endforeach

{{-- Gelung dengan kosong --}}
@forelse($posts as $post)
    <h2>{{ $post->title }}</h2>
@empty
    <p>Tiada catatan dijumpai.</p>
@endforelse

{{-- Semak pengesahan --}}
@auth
    <p>Selamat datang, {{ auth()->user()->name }}!</p>
@endauth

@guest
    <p>Sila log masuk.</p>
@endguest
```

## Layout & Warisan

```blade
{{-- Layout induk: layouts/app.blade.php --}}
<html>
<body>
    @yield('content')
</body>
</html>

{{-- Halaman anak --}}
@extends('layouts.app')

@section('content')
    <h1>Kandungan halaman</h1>
@endsection
```

## Borang

```blade
<form action="{{ route('posts.store') }}" method="POST">
    @csrf  {{-- Token CSRF — WAJIB untuk semua borang POST --}}

    <input type="text" name="title" value="{{ old('title') }}">
    @error('title')
        <span class="error">{{ $message }}</span>
    @enderror

    <button type="submit">Simpan</button>
</form>

{{-- Untuk PUT/PATCH/DELETE --}}
<form action="{{ route('posts.update', $post) }}" method="POST">
    @csrf
    @method('PUT')
    ...
</form>
```

## Sertakan Sub-Paparan

```blade
@include('partials.navbar')
@include('partials.footer')
@include('partials.card', ['post' => $post])
```
