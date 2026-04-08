@extends('layouts.app')

@section('title', $pembayar->nama . ' — Sistem Zakat Kedah')

@section('content')
    <div class="mb-6">
        <a href="{{ route('pembayar.index') }}" class="text-emerald-600 hover:text-emerald-800 text-sm">
            &larr; Kembali ke Senarai Pembayar
        </a>
    </div>

    {{-- Maklumat Pembayar --}}
    <x-card title="Maklumat Pembayar">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-500">Nama Penuh</p>
                <p class="text-base font-medium text-gray-900">{{ $pembayar->nama }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">No. IC</p>
                <p class="text-base font-medium text-gray-900">{{ $pembayar->ic_format }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">No. Telefon</p>
                <p class="text-base font-medium text-gray-900">{{ $pembayar->no_tel }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Emel</p>
                <p class="text-base font-medium text-gray-900">{{ $pembayar->email ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Pekerjaan</p>
                <p class="text-base font-medium text-gray-900">{{ $pembayar->pekerjaan ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Pendapatan Bulanan</p>
                <p class="text-base font-medium text-gray-900">{{ $pembayar->pendapatan_format }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-sm text-gray-500">Alamat</p>
                <p class="text-base font-medium text-gray-900">{{ $pembayar->alamat }}</p>
            </div>
        </div>

        <div class="flex space-x-3 mt-6 pt-4 border-t">
            @can('update', $pembayar)
            <a href="{{ route('pembayar.edit', $pembayar) }}"
               class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                Kemaskini
            </a>
            @endcan
            @can('delete', $pembayar)
            <form action="{{ route('pembayar.destroy', $pembayar) }}" method="POST"
                  onsubmit="return confirm('Adakah anda pasti mahu memadam pembayar ini?')">
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

    {{-- Senarai Pembayaran --}}
    <div class="mt-6">
        <x-card title="Sejarah Pembayaran (Jumlah Sah: RM {{ number_format($pembayar->jumlah_bayaran, 2) }})">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Resit</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis Zakat</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tarikh</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cara Bayar</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($pembayar->pembayarans as $bayaran)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                    <a href="{{ route('pembayaran.show', $bayaran) }}" class="text-emerald-600 hover:text-emerald-800">
                                        {{ $bayaran->no_resit }}
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $bayaran->jenisZakat->nama }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $bayaran->jumlah_format }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $bayaran->tarikh_bayar->format('d/m/Y') }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ ucfirst($bayaran->cara_bayar) }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <x-badge :type="$bayaran->status">{{ ucfirst($bayaran->status) }}</x-badge>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                    Tiada rekod pembayaran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
@endsection
