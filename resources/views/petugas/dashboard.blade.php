<x-sidebar-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Petugas
        </h2>
    </x-slot>

    <div class="p-6">

        {{-- Header Welcome --}}
        <div class="bg-white p-6 rounded shadow mb-6">
            <h3 class="text-lg font-semibold">
                Selamat datang, {{ Auth::user()->nama_petugas }}
            </h3>
            <p class="mt-1 text-gray-600">
                Berikut ringkasan data sistem pembayaran SPP.
            </p>
        </div>

        {{-- Statistik Card --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            {{-- Total Siswa --}}
            <div class="bg-white p-5 rounded shadow border-l-4 border-blue-600">
                <p class="text-sm text-gray-500">Total Siswa</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalSiswa }}</p>
            </div>

            {{-- Total Kelas --}}
            <div class="bg-white p-5 rounded shadow border-l-4 border-green-600">
                <p class="text-sm text-gray-500">Total Kelas</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalKelas }}</p>
            </div>

            {{-- Pembayaran Bulan Ini --}}
            <div class="bg-white p-5 rounded shadow border-l-4 border-yellow-500">
                <p class="text-sm text-gray-500">Pembayaran Bulan Ini</p>
                <p class="text-2xl font-bold text-gray-800">
                    Rp {{ number_format($totalPembayaranBulanIni, 0, ',', '.') }}
                </p>
            </div>

        </div>

        {{-- Menu Cepat --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">

            <a href="{{ route('petugas.pembayaran.index') }}" 
                class="bg-blue-600 hover:bg-blue-700 text-white p-5 rounded shadow text-center">
                Kelola Pembayaran
            </a>
        </div>

    </div>
</x-sidebar-layout>
