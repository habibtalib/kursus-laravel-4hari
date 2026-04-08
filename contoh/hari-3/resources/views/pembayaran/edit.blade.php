@extends('layouts.app')

@section('title', 'Kemaskini Pembayaran — Sistem Zakat Kedah')

@section('content')
    <div class="mb-6">
        <a href="{{ route('pembayaran.index') }}" class="text-emerald-600 hover:text-emerald-800 text-sm">
            &larr; Kembali ke Senarai Pembayaran
        </a>
    </div>

    <x-card title="Kemaskini Pembayaran: {{ $pembayaran->no_resit }}">
        <form method="POST" action="{{ route('pembayaran.update', $pembayaran) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Pembayar --}}
                <div>
                    <label for="pembayar_id" class="block text-sm font-medium text-gray-700 mb-1">Pembayar <span class="text-red-500">*</span></label>
                    <select name="pembayar_id" id="pembayar_id"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('pembayar_id') border-red-500 @enderror">
                        <option value="">-- Pilih Pembayar --</option>
                        @foreach($pembayars as $pembayar)
                            <option value="{{ $pembayar->id }}" {{ old('pembayar_id', $pembayaran->pembayar_id) == $pembayar->id ? 'selected' : '' }}>
                                {{ $pembayar->nama }} ({{ $pembayar->ic_format }})
                            </option>
                        @endforeach
                    </select>
                    @error('pembayar_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jenis Zakat --}}
                <div>
                    <label for="jenis_zakat_id" class="block text-sm font-medium text-gray-700 mb-1">Jenis Zakat <span class="text-red-500">*</span></label>
                    <select name="jenis_zakat_id" id="jenis_zakat_id"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('jenis_zakat_id') border-red-500 @enderror">
                        <option value="">-- Pilih Jenis Zakat --</option>
                        @foreach($jenisZakats as $jenis)
                            <option value="{{ $jenis->id }}" {{ old('jenis_zakat_id', $pembayaran->jenis_zakat_id) == $jenis->id ? 'selected' : '' }}>
                                {{ $jenis->nama }} ({{ number_format($jenis->kadar, 2) }}%)
                            </option>
                        @endforeach
                    </select>
                    @error('jenis_zakat_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jumlah --}}
                <div>
                    <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-1">Jumlah (RM) <span class="text-red-500">*</span></label>
                    <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah', $pembayaran->jumlah) }}"
                           step="0.01" min="1"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('jumlah') border-red-500 @enderror">
                    @error('jumlah')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tarikh Bayar --}}
                <div>
                    <label for="tarikh_bayar" class="block text-sm font-medium text-gray-700 mb-1">Tarikh Bayar <span class="text-red-500">*</span></label>
                    <input type="date" name="tarikh_bayar" id="tarikh_bayar"
                           value="{{ old('tarikh_bayar', $pembayaran->tarikh_bayar->format('Y-m-d')) }}"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('tarikh_bayar') border-red-500 @enderror">
                    @error('tarikh_bayar')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Cara Bayar --}}
                <div>
                    <label for="cara_bayar" class="block text-sm font-medium text-gray-700 mb-1">Cara Bayar <span class="text-red-500">*</span></label>
                    <select name="cara_bayar" id="cara_bayar"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('cara_bayar') border-red-500 @enderror">
                        <option value="">-- Pilih Cara Bayar --</option>
                        <option value="tunai" {{ old('cara_bayar', $pembayaran->cara_bayar) === 'tunai' ? 'selected' : '' }}>Tunai</option>
                        <option value="kad" {{ old('cara_bayar', $pembayaran->cara_bayar) === 'kad' ? 'selected' : '' }}>Kad</option>
                        <option value="fpx" {{ old('cara_bayar', $pembayaran->cara_bayar) === 'fpx' ? 'selected' : '' }}>FPX</option>
                        <option value="online" {{ old('cara_bayar', $pembayaran->cara_bayar) === 'online' ? 'selected' : '' }}>Online</option>
                    </select>
                    @error('cara_bayar')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                    <select name="status" id="status"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('status') border-red-500 @enderror">
                        <option value="pending" {{ old('status', $pembayaran->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="sah" {{ old('status', $pembayaran->status) === 'sah' ? 'selected' : '' }}>Sah</option>
                        <option value="batal" {{ old('status', $pembayaran->status) === 'batal' ? 'selected' : '' }}>Batal</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- No Resit (baca sahaja) --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. Resit</label>
                    <input type="text" value="{{ $pembayaran->no_resit }}" readonly
                           class="w-full rounded-lg border-gray-300 bg-gray-100 shadow-sm text-gray-600">
                </div>
            </div>

            {{-- Butang --}}
            <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                <a href="{{ route('pembayaran.index') }}"
                   class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 transition-colors">
                    Batal
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-colors">
                    Kemaskini Pembayaran
                </button>
            </div>
        </form>
    </x-card>
@endsection
