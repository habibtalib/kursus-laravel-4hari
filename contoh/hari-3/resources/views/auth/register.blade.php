<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — Sistem Zakat Kedah</title>
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

        {{-- Kad Pendaftaran --}}
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-6 text-center">Daftar Akaun Baru</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Nama --}}
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                           placeholder="Nama penuh anda" autofocus
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-colors @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- E-mel --}}
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mel</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                           placeholder="contoh@email.com"
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-colors @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kata Laluan --}}
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Laluan</label>
                    <input type="password" name="password" id="password"
                           placeholder="Minimum 8 aksara"
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-colors @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Sahkan Kata Laluan --}}
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Sahkan Kata Laluan</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           placeholder="Masukkan semula kata laluan"
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-colors">
                </div>

                {{-- Butang Daftar --}}
                <button type="submit"
                        class="w-full py-2.5 px-4 bg-emerald-600 text-white font-medium rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-colors">
                    Daftar
                </button>
            </form>

            {{-- Pautan Log Masuk --}}
            <p class="mt-6 text-center text-sm text-gray-600">
                Sudah mempunyai akaun?
                <a href="{{ route('login') }}" class="text-emerald-600 hover:text-emerald-800 font-medium">
                    Log masuk di sini
                </a>
            </p>
        </div>
    </div>

</body>
</html>
