<x-sidebar-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola Kelas
        </h2>
    </x-slot>

    {{-- Tombol Tambah --}}
    <div class="py-4">
        <x-primary-button x-on:click="$dispatch('open-modal', 'tambah-kelas')">
            + Tambah Kelas
        </x-primary-button>
    </div>

    {{-- Tabel kelas --}}
    <div class="bg-white shadow-md rounded-lg p-4">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="px-4 py-2 text-left">Nama Kelas</th>
                    <th class="px-4 py-2 text-left">Kompetensi Keahlian</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($kelas as $k)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $k->nama_kelas }}</td>
                        <td class="px-4 py-2">{{ $k->kompetensi_keahlian }}</td>

                        <td class="px-4 py-2 flex gap-2">
                            <x-secondary-button
                                x-on:click="$dispatch('open-modal', 'edit-kelas-{{ $k->id_kelas }}')">
                                Edit
                            </x-secondary-button>

                            <form action="{{ route('admin.kelas.destroy', $k->id_kelas) }}" 
                                  method="POST"
                                  onsubmit="return confirm('Yakin hapus kelas ini?');">
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

    {{-- ====================================== --}}
    {{-- MODAL TAMBAH KELAS                     --}}
    {{-- ====================================== --}}
    <x-modal name="tambah-kelas">
        <form method="POST" action="{{ route('admin.kelas.store') }}" class="p-6">
            @csrf

            <h2 class="text-lg font-semibold">Tambah Kelas</h2>

            <div class="mt-4">
                <x-input-label value="Nama Kelas" />
                <x-text-input name="nama_kelas" class="mt-1 block w-full" required />
            </div>

            <div class="mt-4">
                <x-input-label value="Kompetensi Keahlian" />
                <x-text-input name="kompetensi_keahlian" class="mt-1 block w-full" required />
            </div>

            <div class="mt-6 flex justify-end gap-2">
                <x-secondary-button 
                    x-on:click="$dispatch('close-modal', 'tambah-kelas')">
                    Batal
                </x-secondary-button>

                <x-primary-button>Simpan</x-primary-button>
            </div>
        </form>
    </x-modal>


    {{-- ====================================== --}}
    {{-- MODAL EDIT KELAS                       --}}
    {{-- ====================================== --}}
    @foreach ($kelas as $k)
        <x-modal name="edit-kelas-{{ $k->id_kelas }}">
            <form method="POST" action="{{ route('admin.kelas.update', $k->id_kelas) }}" class="p-6">
                @csrf
                @method('PUT')

                <h2 class="text-lg font-semibold">Edit Kelas</h2>

                <div class="mt-4">
                    <x-input-label value="Nama Kelas" />
                    <x-text-input name="nama_kelas" 
                        value="{{ $k->nama_kelas }}" 
                        class="mt-1 block w-full" required />
                </div>

                <div class="mt-4">
                    <x-input-label value="Kompetensi Keahlian" />
                    <x-text-input name="kompetensi_keahlian" 
                        value="{{ $k->kompetensi_keahlian }}" 
                        class="mt-1 block w-full" required />
                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <x-secondary-button 
                        x-on:click="$dispatch('close-modal', 'edit-kelas-{{ $k->id_kelas }}')">
                        Batal
                    </x-secondary-button>

                    <x-primary-button>Update</x-primary-button>
                </div>
            </form>
        </x-modal>
    @endforeach

</x-sidebar-layout>
