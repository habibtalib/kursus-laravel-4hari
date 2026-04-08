@props(['type' => 'default'])

@php
    $classes = match($type) {
        'aktif', 'sah', 'success'       => 'bg-green-100 text-green-800',
        'tidak aktif', 'batal', 'error'  => 'bg-red-100 text-red-800',
        'pending', 'warning'             => 'bg-yellow-100 text-yellow-800',
        'info'                           => 'bg-blue-100 text-blue-800',
        default                          => 'bg-gray-100 text-gray-800',
    };
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $classes }}">
    {{ $slot }}
</span>
