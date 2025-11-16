<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body x-data class="font-sans antialiased bg-gray-100">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-white shadow-md flex flex-col">

        {{-- Logo Sekolah --}}
        <div class="p-4 border-b flex items-center justify-center">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-blue-600 rounded-lg flex justify-center items-center shadow-sm">
                    <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 14l9-5-9-5-9 5 9 5z" />
                    </svg>
                </div>
                <div>
                    <div class="font-bold text-gray-800 text-sm">SMK TIP Cimahi</div>
                </div>
            </div>
        </div>

        {{-- MENU --}}
        <nav class="flex-1 py-4">
            <ul class="space-y-1 px-3">

                {{-- ==== ADMIN ==== --}}
                @if(Auth::user()->level === 'admin')

                    <x-admin-menu-item
                        route="admin.dashboard"
                        active="admin/dashboard"
                        icon="home"
                        label="Dashboard"
                    />

                    <x-admin-menu-item
                        route="admin.petugas.index"
                        active="admin/petugas*"
                        icon="id-badge"
                        label="Manajemen Petugas"
                    />

                    <x-admin-menu-item
                        route="admin.kelas.index"
                        active="admin/kelas*"
                        icon="id-badge"
                        label="Manajemen Kelas"
                    />

                    <x-admin-menu-item
                        route="admin.spp.index"
                        active="admin/spp*"
                        icon="id-badge"
                        label="Manajemen SPP"
                    />

                @endif

                {{-- ==== PETUGAS ==== --}}
                @if(Auth::user()->level === 'petugas')
                    <x-admin-menu-item
                        route="petugas.dashboard"
                        active="petugas/dashboard"
                        icon="home"
                        label="Dashboard"
                    />
                @endif

            </ul>
        </nav>
    </aside>

    {{-- KONTEN --}}
    <div class="flex-1 flex flex-col">

        {{-- HEADER --}}
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-4 px-6 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">@yield('title', 'Dashboard')</h2>

                <div>
                    @include('layouts.navigation')
                </div>
            </div>
        </header>

        {{-- HALAMAN --}}
        <main class="p-6">
            {{ $slot }}
        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>
