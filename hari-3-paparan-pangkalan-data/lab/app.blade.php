{{--
    CONTOH LAYOUT UTAMA — Hari 3
    Simpan di: resources/views/layouts/app.blade.php
--}}

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blog Laravel')</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f4f4f4; color: #333; }

        /* Navigasi */
        nav { background: #1B2A4A; padding: 1rem 2rem; }
        nav a { color: white; text-decoration: none; margin-right: 1.5rem; font-weight: 500; }
        nav a:hover { color: #00A896; }

        /* Kandungan utama */
        .container { max-width: 900px; margin: 2rem auto; padding: 0 1rem; }

        /* Mesej kejayaan */
        .alert-success {
            background: #d4edda; border: 1px solid #c3e6cb;
            color: #155724; padding: 0.75rem 1rem; border-radius: 4px;
            margin-bottom: 1rem;
        }

        /* Mesej ralat */
        .alert-danger {
            background: #f8d7da; border: 1px solid #f5c6cb;
            color: #721c24; padding: 0.75rem 1rem; border-radius: 4px;
            margin-bottom: 1rem;
        }

        /* Butang */
        .btn {
            display: inline-block; padding: 0.5rem 1rem;
            border: none; border-radius: 4px; cursor: pointer;
            text-decoration: none; font-size: 0.9rem;
        }
        .btn-primary { background: #1B2A4A; color: white; }
        .btn-danger { background: #E74430; color: white; }
        .btn-success { background: #00A896; color: white; }

        /* Borang */
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.3rem; font-weight: 600; }
        .form-group input, .form-group textarea {
            width: 100%; padding: 0.5rem; border: 1px solid #ccc;
            border-radius: 4px; font-size: 1rem;
        }
        .form-group textarea { min-height: 150px; }
        .error { color: #E74430; font-size: 0.85rem; margin-top: 0.2rem; }

        /* Kad catatan */
        .post-card {
            background: white; padding: 1.5rem; border-radius: 6px;
            margin-bottom: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .post-card h2 { margin-bottom: 0.5rem; }
        .post-card p { color: #666; }
        .post-card .meta { font-size: 0.85rem; color: #999; margin-top: 0.5rem; }

        /* Footer */
        footer { text-align: center; padding: 2rem; color: #999; font-size: 0.85rem; }
    </style>
</head>
<body>
    {{-- Navigasi --}}
    <nav>
        <a href="{{ url('/') }}">Utama</a>
        <a href="{{ route('posts.index') }}">Catatan</a>
        <a href="{{ route('posts.create') }}">Tulis Catatan</a>
        <a href="{{ url('/tentang') }}">Tentang</a>
    </nav>

    {{-- Kandungan utama --}}
    <div class="container">
        {{-- Mesej kejayaan (flash message) --}}
        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Mesej ralat --}}
        @if(session('error'))
            <div class="alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>

    {{-- Footer --}}
    <footer>
        &copy; {{ date('Y') }} Blog Laravel — Kursus Laravel 4 Hari
    </footer>
</body>
</html>
