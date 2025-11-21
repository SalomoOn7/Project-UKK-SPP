<x-sidebar-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Siswa
        </h2>
    </x-slot>

    <div class="p-6">

        {{-- Header Welcome --}}
        <div class="bg-white p-6 rounded shadow mb-6">
            <h3 class="text-lg font-semibold">
                Selamat datang, {{ $siswa->nama }}
            </h3>
            <p class="mt-1 text-gray-600">
                Kelas: {{ $siswa->kelas->nama_kelas ?? '-' }}
            </p>
        </div>

        {{-- Ringkasan Pembayaran --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

            <div class="bg-white p-5 rounded shadow border-l-4 border-blue-600">
                <p class="text-sm text-gray-500">Bulan Sudah Dibayar</p>
                <p class="text-2xl font-bold text-gray-800">{{ count($bulanSudah) }} Bulan</p>
            </div>

            <div class="bg-white p-5 rounded shadow border-l-4 border-red-600">
                <p class="text-sm text-gray-500">Tunggakan</p>
                <p class="text-2xl font-bold text-gray-800">
                    Rp {{ number_format($tunggakan,0,',','.') }}
                </p>
            </div>

            <div class="bg-white p-5 rounded shadow border-l-4 border-green-600">
                <p class="text-sm text-gray-500">Total Bayar</p>
                <p class="text-2xl font-bold text-gray-800">
                    Rp {{ number_format($totalBayar,0,',','.') }}
                </p>
            </div>

        </div>

        {{-- Status Bulan --}}
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold mb-4">Status Pembayaran Bulan</h3>
            <div class="grid grid-cols-3 md:grid-cols-4 gap-2">
                @foreach($bulanSudah as $b)
                    <div class="p-2 bg-green-100 text-green-700 rounded text-center font-bold">
                        {{ $b }} ✔
                    </div>
                @endforeach
                @foreach($bulanBelum as $b)
                    <div class="p-2 bg-red-100 text-red-700 rounded text-center font-bold">
                        {{ $b }} ✘
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Menu Cepat --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
            <a href="{{ route('siswa.pembayaran.history') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white p-5 rounded shadow text-center">
                Riwayat Pembayaran
            </a>

            <a href="{{ route('siswa.pembayaran.detail') }}"
                class="bg-green-600 hover:bg-green-700 text-white p-5 rounded shadow text-center">
                Detail Pembayaran
            </a>
        </div>

    </div>
</x-sidebar-layout>
