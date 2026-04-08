<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Zakat Kedah')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        zakat: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    {{-- Navigasi Utama --}}
    <nav class="bg-emerald-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                {{-- Logo & Jenama --}}
                <div class="flex items-center">
                    <a href="{{ route('pembayar.index') }}" class="flex items-center space-x-2">
                        <svg class="w-8 h-8 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-white font-bold text-lg">Sistem Zakat Kedah</span>
                    </a>
                </div>

                {{-- Pautan Navigasi --}}
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('pembayar.index') }}"
                       class="px-4 py-2 rounded-md text-sm font-medium transition-colors
                              {{ request()->routeIs('pembayar.*') ? 'bg-emerald-900 text-white' : 'text-emerald-100 hover:bg-emerald-700 hover:text-white' }}">
                        Pembayar
                    </a>
                    <a href="{{ route('jenis-zakat.index') }}"
                       class="px-4 py-2 rounded-md text-sm font-medium transition-colors
                              {{ request()->routeIs('jenis-zakat.*') ? 'bg-emerald-900 text-white' : 'text-emerald-100 hover:bg-emerald-700 hover:text-white' }}">
                        Jenis Zakat
                    </a>
                    <a href="{{ route('pembayaran.index') }}"
                       class="px-4 py-2 rounded-md text-sm font-medium transition-colors
                              {{ request()->routeIs('pembayaran.*') ? 'bg-emerald-900 text-white' : 'text-emerald-100 hover:bg-emerald-700 hover:text-white' }}">
                        Pembayaran
                    </a>

                    {{-- Maklumat Pengguna & Log Keluar --}}
                    @auth
                        <div class="ml-4 pl-4 border-l border-emerald-600 flex items-center space-x-3">
                            <span class="text-emerald-100 text-sm">{{ Auth::user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="px-3 py-1.5 bg-emerald-900 text-emerald-100 text-sm rounded-md hover:bg-red-700 hover:text-white transition-colors">
                                    Log Keluar
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>

                {{-- Menu Mudah Alih --}}
                <div class="md:hidden flex items-center">
                    <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')"
                            class="text-emerald-100 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Menu Mudah Alih (tersembunyi) --}}
        <div id="mobile-menu" class="hidden md:hidden bg-emerald-900">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('pembayar.index') }}"
                   class="block px-3 py-2 rounded-md text-sm font-medium
                          {{ request()->routeIs('pembayar.*') ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-700' }}">
                    Pembayar
                </a>
                <a href="{{ route('jenis-zakat.index') }}"
                   class="block px-3 py-2 rounded-md text-sm font-medium
                          {{ request()->routeIs('jenis-zakat.*') ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-700' }}">
                    Jenis Zakat
                </a>
                <a href="{{ route('pembayaran.index') }}"
                   class="block px-3 py-2 rounded-md text-sm font-medium
                          {{ request()->routeIs('pembayaran.*') ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-700' }}">
                    Pembayaran
                </a>
                @auth
                    <div class="border-t border-emerald-700 pt-2 mt-2">
                        <span class="block px-3 py-2 text-sm text-emerald-200">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="block w-full text-left px-3 py-2 rounded-md text-sm font-medium text-red-300 hover:bg-red-700 hover:text-white">
                                Log Keluar
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Mesej Flash --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        @if (session('success'))
            <x-alert type="success">{{ session('success') }}</x-alert>
        @endif

        @if (session('error'))
            <x-alert type="error">{{ session('error') }}</x-alert>
        @endif

        @if (session('warning'))
            <x-alert type="warning">{{ session('warning') }}</x-alert>
        @endif
    </div>

    {{-- Kandungan Utama --}}
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @yield('content')
    </main>

    {{-- Kaki Halaman --}}
    <footer class="bg-emerald-800 text-emerald-100 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col sm:flex-row justify-between items-center text-sm">
                <p>&copy; {{ date('Y') }} Pusat Zakat Negeri Kedah. Hak cipta terpelihara.</p>
                <p class="mt-2 sm:mt-0">Sistem Pengurusan Zakat &mdash; Kursus Laravel Hari 3</p>
            </div>
        </div>
    </footer>

</body>
</html>
