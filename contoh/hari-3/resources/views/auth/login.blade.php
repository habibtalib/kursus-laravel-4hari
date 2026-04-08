<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Masuk — Sistem Zakat Kedah</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-emerald-800 via-emerald-600 to-teal-500 flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        {{-- Logo & Tajuk --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-full mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white">Sistem Zakat Kedah</h1>
            <p class="text-emerald-100 mt-1">Pusat Zakat Negeri Kedah</p>
        </div>

        {{-- Kad Log Masuk --}}
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-6 text-center">Log Masuk</h2>

            {{-- Mesej Kejayaan --}}
            @if (session('success'))
                <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- E-mel --}}
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mel</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                           placeholder="contoh@email.com" autofocus
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-colors @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kata Laluan --}}
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Laluan</label>
                    <input type="password" name="password" id="password"
                           placeholder="Masukkan kata laluan"
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-colors @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Ingat Saya --}}
                <div class="mb-6">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}
                               class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                        <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                    </label>
                </div>

                {{-- Butang Log Masuk --}}
                <button type="submit"
                        class="w-full py-2.5 px-4 bg-emerald-600 text-white font-medium rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-colors">
                    Log Masuk
                </button>
            </form>

            {{-- Pautan Daftar --}}
            <p class="mt-6 text-center text-sm text-gray-600">
                Belum mempunyai akaun?
                <a href="{{ route('register') }}" class="text-emerald-600 hover:text-emerald-800 font-medium">
                    Daftar di sini
                </a>
            </p>
        </div>
    </div>

</body>
</html>
