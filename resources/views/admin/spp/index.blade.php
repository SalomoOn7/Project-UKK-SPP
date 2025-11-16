<x-sidebar-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola SPP
        </h2>
    </x-slot>

    {{-- Tombol Tambah --}}
    <div class="py-4">
        <x-primary-button x-on:click="$dispatch('open-modal', 'tambah-spp')">
            + Tambah SPP
        </x-primary-button>
    </div>

    {{-- Tabel --}}
    <div class="bg-white shadow-md rounded-lg p-4">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="px-4 py-2 text-left">Tahun</th>
                    <th class="px-4 py-2 text-left">Nominal</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($spp as $s)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $s->tahun }}</td>
                        <td class="px-4 py-2">Rp {{ number_format($s->nominal, 0, ',', '.') }}</td>

                        <td class="px-4 py-2 flex gap-2">
                            <x-secondary-button
                                x-on:click="$dispatch('open-modal', 'edit-spp-{{ $s->id_spp }}')">
                                Edit
                            </x-secondary-button>

                            <form action="{{ route('admin.spp.destroy', $s->id_spp) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin hapus SPP ini?');">

                                @csrf
                                @method('DELETE')

                                <x-danger-button>Hapus</x-danger-button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- ===================== --}}
    {{-- MODAL TAMBAH SPP --}}
    {{-- ===================== --}}

    <x-modal name="tambah-spp">
        <form method="POST" action="{{ route('admin.spp.store') }}" class="p-6">
            @csrf

            <h2 class="text-lg font-semibold">Tambah SPP</h2>

            <div class="mt-4">
                <x-input-label value="Tahun" />
                <x-text-input name="tahun" type="number" class="mt-1 block w-full" required />
            </div>

            <div class="mt-4">
                <x-input-label value="Nominal" />
                <x-text-input name="nominal" type="number" class="mt-1 block w-full" required />
            </div>

            <div class="mt-6 flex justify-end gap-2">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'tambah-spp')">Batal</x-secondary-button>
                <x-primary-button>Simpan</x-primary-button>
            </div>
        </form>
    </x-modal>

    {{-- ===================== --}}
    {{-- MODAL EDIT SPP --}}
    {{-- ===================== --}}
    @foreach ($spp as $s)
        <x-modal name="edit-spp-{{ $s->id_spp }}">
            <form method="POST" action="{{ route('admin.spp.update', $s->id_spp) }}" class="p-6">
                @csrf
                @method('PUT')

                <h2 class="text-lg font-semibold">Edit SPP</h2>

                <div class="mt-4">
                    <x-input-label value="Tahun" />
                    <x-text-input name="tahun" type="number" value="{{ $s->tahun }}" class="mt-1 block w-full" required />
                </div>

                <div class="mt-4">
                    <x-input-label value="Nominal" />
                    <x-text-input name="nominal" type="number" value="{{ $s->nominal }}" class="mt-1 block w-full" required />
                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <x-secondary-button 
                        x-on:click="$dispatch('close-modal', 'edit-spp-{{ $s->id_spp }}')">
                        Batal
                    </x-secondary-button>

                    <x-primary-button>Update</x-primary-button>
                </div>
            </form>
        </x-modal>
    @endforeach

</x-sidebar-layout>
