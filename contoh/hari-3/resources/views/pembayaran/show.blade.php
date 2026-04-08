@extends('layouts.app')

@section('title', 'Pembayaran ' . $pembayaran->no_resit . ' — Sistem Zakat Kedah')

@section('content')
    <div class="mb-6">
        <a href="{{ route('pembayaran.index') }}" class="text-emerald-600 hover:text-emerald-800 text-sm">
            &larr; Kembali ke Senarai Pembayaran
        </a>
    </div>

    <x-card title="Maklumat Pembayaran">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-500">No. Resit</p>
                <p class="text-base font-medium text-gray-900">{{ $pembayaran->no_resit }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Status</p>
                <p class="mt-1">
                    <x-badge :type="$pembayaran->status">{{ ucfirst($pembayaran->status) }}</x-badge>
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Pembayar</p>
                <p class="text-base font-medium text-gray-900">
                    <a href="{{ route('pembayar.show', $pembayaran->pembayar) }}" class="text-emerald-600 hover:text-emerald-800">
                        {{ $pembayaran->pembayar->nama }}
                    </a>
                </p>
                <p class="text-sm text-gray-500">{{ $pembayaran->pembayar->ic_format }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Jenis Zakat</p>
                <p class="text-base font-medium text-gray-900">{{ $pembayaran->jenisZakat->nama }}</p>
                <p class="text-sm text-gray-500">Kadar: {{ number_format($pembayaran->jenisZakat->kadar, 2) }}%</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Jumlah</p>
                <p class="text-xl font-bold text-emerald-700">{{ $pembayaran->jumlah_format }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Tarikh Bayar</p>
                <p class="text-base font-medium text-gray-900">{{ $pembayaran->tarikh_bayar->format('d/m/Y') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Cara Bayar</p>
                <p class="text-base font-medium text-gray-900">{{ ucfirst($pembayaran->cara_bayar) }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Tarikh Dicipta</p>
                <p class="text-base font-medium text-gray-900">{{ $pembayaran->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <div class="flex space-x-3 mt-6 pt-4 border-t">
            @can('update', $pembayaran)
            <a href="{{ route('pembayaran.edit', $pembayaran) }}"
               class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                Kemaskini
            </a>
            @endcan
            @can('delete', $pembayaran)
            <form action="{{ route('pembayaran.destroy', $pembayaran) }}" method="POST"
                  onsubmit="return confirm('Adakah anda pasti mahu memadam pembayaran ini?')">
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
