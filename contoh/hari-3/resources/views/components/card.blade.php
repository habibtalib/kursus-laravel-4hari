@props(['title' => null])

<div {{ $attributes->merge(['class' => 'bg-white rounded-lg shadow-md overflow-hidden']) }}>
    @if($title)
        <div class="px-6 py-4 bg-emerald-50 border-b border-emerald-100">
            <h2 class="text-lg font-semibold text-emerald-800">{{ $title }}</h2>
        </div>
    @endif
    <div class="p-6">
        {{ $slot }}
    </div>
</div>
