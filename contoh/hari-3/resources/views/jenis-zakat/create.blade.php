@extends('layouts.app')

@section('title', 'Tambah Jenis Zakat — Sistem Zakat Kedah')

@section('content')
    <div class="mb-6">
        <a href="{{ route('jenis-zakat.index') }}" class="text-emerald-600 hover:text-emerald-800 text-sm">
            &larr; Kembali ke Senarai Jenis Zakat
        </a>
    </div>

    <x-card title="Tambah Jenis Zakat Baru">
        <form method="POST" action="{{ route('jenis-zakat.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama --}}
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Jenis Zakat <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                           placeholder="Contoh: Zakat Fitrah"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('nama') border-red-500 @enderror">
                    @error('nama')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kadar --}}
                <div>
                    <label for="kadar" class="block text-sm font-medium text-gray-700 mb-1">Kadar (%) <span class="text-red-500">*</span></label>
                    <input type="number" name="kadar" id="kadar" value="{{ old('kadar') }}"
                           step="0.0001" min="0"
                           placeholder="Contoh: 2.5"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('kadar') border-red-500 @enderror">
                    @error('kadar')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Penerangan --}}
                <div class="md:col-span-2">
                    <label for="penerangan" class="block text-sm font-medium text-gray-700 mb-1">Penerangan</label>
                    <textarea name="penerangan" id="penerangan" rows="3"
                              placeholder="Huraian ringkas tentang jenis zakat ini..."
                              class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('penerangan') border-red-500 @enderror">{{ old('penerangan') }}</textarea>
                    @error('penerangan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status Aktif --}}
                <div class="md:col-span-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_aktif" value="1"
                               {{ old('is_aktif', true) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500">
                        <span class="ml-2 text-sm text-gray-700">Status Aktif</span>
                    </label>
                </div>
            </div>

            {{-- Butang --}}
            <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                <a href="{{ route('jenis-zakat.index') }}"
                   class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 transition-colors">
                    Batal
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-colors">
                    Simpan Jenis Zakat
                </button>
            </div>
        </form>
    </x-card>
@endsection
