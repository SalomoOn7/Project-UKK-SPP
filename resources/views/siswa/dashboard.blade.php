<x-sidebar-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="bg-white p-6 rounded shadow">
        <h3 class="text-lg font-semibold">Selamat datang, {{ Auth::user()->nama }}</h3>
        <p class="mt-2 text-gray-600">Ini tampilan dashboard Siswa</p>
    </div>
</x-sidebar-layout>
