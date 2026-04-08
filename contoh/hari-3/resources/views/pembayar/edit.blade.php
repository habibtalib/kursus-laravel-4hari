@extends('layouts.app')

@section('title', 'Kemaskini Pembayar — Sistem Zakat Kedah')

@section('content')
    <div class="mb-6">
        <a href="{{ route('pembayar.index') }}" class="text-emerald-600 hover:text-emerald-800 text-sm">
            &larr; Kembali ke Senarai Pembayar
        </a>
    </div>

    <x-card title="Kemaskini Pembayar: {{ $pembayar->nama }}">
        <form method="POST" action="{{ route('pembayar.update', $pembayar) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama --}}
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Penuh <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $pembayar->nama) }}"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('nama') border-red-500 @enderror">
                    @error('nama')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- No IC --}}
                <div>
                    <label for="no_ic" class="block text-sm font-medium text-gray-700 mb-1">No. IC <span class="text-red-500">*</span></label>
                    <input type="text" name="no_ic" id="no_ic" value="{{ old('no_ic', $pembayar->no_ic) }}" maxlength="12"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('no_ic') border-red-500 @enderror">
                    @error('no_ic')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- No Telefon --}}
                <div>
                    <label for="no_tel" class="block text-sm font-medium text-gray-700 mb-1">No. Telefon <span class="text-red-500">*</span></label>
                    <input type="text" name="no_tel" id="no_tel" value="{{ old('no_tel', $pembayar->no_tel) }}"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('no_tel') border-red-500 @enderror">
                    @error('no_tel')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Emel --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Emel</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $pembayar->email) }}"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Pekerjaan --}}
                <div>
                    <label for="pekerjaan" class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan</label>
                    <input type="text" name="pekerjaan" id="pekerjaan" value="{{ old('pekerjaan', $pembayar->pekerjaan) }}"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('pekerjaan') border-red-500 @enderror">
                    @error('pekerjaan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Pendapatan Bulanan --}}
                <div>
                    <label for="pendapatan_bulanan" class="block text-sm font-medium text-gray-700 mb-1">Pendapatan Bulanan (RM)</label>
                    <input type="number" name="pendapatan_bulanan" id="pendapatan_bulanan"
                           value="{{ old('pendapatan_bulanan', $pembayar->pendapatan_bulanan) }}"
                           step="0.01" min="0"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('pendapatan_bulanan') border-red-500 @enderror">
                    @error('pendapatan_bulanan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Alamat --}}
                <div class="md:col-span-2">
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat <span class="text-red-500">*</span></label>
                    <textarea name="alamat" id="alamat" rows="3"
                              class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('alamat') border-red-500 @enderror">{{ old('alamat', $pembayar->alamat) }}</textarea>
                    @error('alamat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Butang --}}
            <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                <a href="{{ route('pembayar.index') }}"
                   class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 transition-colors">
                    Batal
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-colors">
                    Kemaskini Pembayar
                </button>
            </div>
        </form>
    </x-card>
@endsection
