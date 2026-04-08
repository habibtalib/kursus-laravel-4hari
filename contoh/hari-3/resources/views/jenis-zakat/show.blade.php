@extends('layouts.app')

@section('title', $jenisZakat->nama . ' — Sistem Zakat Kedah')

@section('content')
    <div class="mb-6">
        <a href="{{ route('jenis-zakat.index') }}" class="text-emerald-600 hover:text-emerald-800 text-sm">
            &larr; Kembali ke Senarai Jenis Zakat
        </a>
    </div>

    <x-card title="Maklumat Jenis Zakat">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-500">Nama Jenis Zakat</p>
                <p class="text-base font-medium text-gray-900">{{ $jenisZakat->nama }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Kadar</p>
                <p class="text-base font-medium text-gray-900">{{ number_format($jenisZakat->kadar, 2) }}%</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Status</p>
                <p class="mt-1">
                    @if($jenisZakat->is_aktif)
                        <x-badge type="aktif">Aktif</x-badge>
                    @else
                        <x-badge type="tidak aktif">Tidak Aktif</x-badge>
                    @endif
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Bilangan Pembayaran</p>
                <p class="text-base font-medium text-gray-900">{{ $jenisZakat->pembayarans_count }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-sm text-gray-500">Penerangan</p>
                <p class="text-base font-medium text-gray-900">{{ $jenisZakat->penerangan ?? '-' }}</p>
            </div>
        </div>

        <div class="flex space-x-3 mt-6 pt-4 border-t">
            @can('update', $jenisZakat)
            <a href="{{ route('jenis-zakat.edit', $jenisZakat) }}"
               class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                Kemaskini
            </a>
            @endcan
            @can('delete', $jenisZakat)
            <form action="{{ route('jenis-zakat.destroy', $jenisZakat) }}" method="POST"
                  onsubmit="return confirm('Adakah anda pasti mahu memadam jenis zakat ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                    Padam
                </button>
            </form>
            @endcan
        </div>
    </x-card>
@endsection
