@props(['route', 'active', 'icon', 'label'])

@php
$icons = [
    'home' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3',
    'users' => 'M17 20h5v-2a3 3 0 00-5.356-1.857',
    'id-badge' => 'M12 4.354a4 4 0 110 5.292',
    'calendar' => 'M8 7V3m8 4V3m-9 8h10',
    'bar-chart' => 'M9 17v-2m3 2v-4m3 4v-6',
];

$isActive = request()->is($active) ? 'bg-gray-200 font-medium' : '';
@endphp

<li>
    <a href="{{ route($route) }}"
       class="flex items-center px-3 py-2.5 text-gray-700 hover:bg-gray-100 rounded-lg transition {{ $isActive }}">
        <svg class="h-5 w-5 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icons[$icon] }}" />
        </svg>
        {{ $label }}
    </a>
</li>
