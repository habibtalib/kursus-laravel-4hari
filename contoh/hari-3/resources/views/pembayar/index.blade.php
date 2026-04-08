@extends('layouts.app')

@section('title', 'Senarai Pembayar — Sistem Zakat Kedah')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Senarai Pembayar</h1>
        <a href="{{ route('pembayar.create') }}"
           class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Pembayar
        </a>
    </div>

    {{-- Borang Carian --}}
    <x-card class="mb-6">
        <form method="GET" action="{{ route('pembayar.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input type="text" name="carian" value="{{ $carian }}"
                       placeholder="Cari nama atau no. IC..."
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
            </div>
            <div class="flex gap-2">
                <button type="submit"
                        class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-colors">
                    Cari
                </button>
                @if($carian)
                    <a href="{{ route('pembayar.index') }}"
                       class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 transition-colors">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </x-card>

    {{-- Jadual Pembayar --}}
    <x-card>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. IC</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Tel</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pekerjaan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pendapatan</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pembayars as $pembayar)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $loop->iteration + ($pembayars->currentPage() - 1) * $pembayars->perPage() }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $pembayar->nama }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $pembayar->ic_format }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $pembayar->no_tel }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $pembayar->pekerjaan ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $pembayar->pendapatan_format }}</td>
                            <td class="px-4 py-3 text-sm text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('pembayar.show', $pembayar) }}"
                                       class="text-emerald-600 hover:text-emerald-800" title="Lihat">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('pembayar.edit', $pembayar) }}"
                                       class="text-blue-600 hover:text-blue-800" title="Kemaskini">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('pembayar.destroy', $pembayar) }}" method="POST"
                                          onsubmit="return confirm('Adakah anda pasti mahu memadam pembayar ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800" title="Padam">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                Tiada rekod pembayar dijumpai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginasi --}}
        @if($pembayars->hasPages())
            <div class="mt-4 border-t pt-4">
                {{ $pembayars->links() }}
            </div>
        @endif
    </x-card>
@endsection
