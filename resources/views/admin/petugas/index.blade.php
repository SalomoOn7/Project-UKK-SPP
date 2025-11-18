<x-sidebar-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola Petugas
        </h2>
    </x-slot>

    {{-- Tombol Tambah --}}
    <div class="py-4">
        <x-primary-button x-on:click="$dispatch('open-modal', 'tambah-petugas')">
            + Tambah Petugas
        </x-primary-button>
    </div>

    {{-- Tabel Petugas --}}
    <div class="bg-white shadow-md rounded-lg p-4">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="px-4 py-2 text-left">Username</th>
                    <th class="px-4 py-2 text-left">Nama Petugas</th>
                    <th class="px-4 py-2 text-left">Level</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($petugas as $p)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $p->username }}</td>
                        <td class="px-4 py-2">{{ $p->nama_petugas }}</td>
                        <td class="px-4 py-2 capitalize">{{ $p->level }}</td>

                        <td class="px-4 py-2 gap-2 text-center">
                            <div class="flex justify-center gap-2">
                            <x-secondary-button
                                x-on:click="$dispatch('open-modal', 'edit-petugas-{{ $p->id_petugas }}')">
                                Edit
                            </x-secondary-button>

                            <form action="{{ route('admin.petugas.destroy', $p->id_petugas) }}" method="POST"
                                  onsubmit="return confirm('Yakin hapus?');">
                                @csrf
                                @method('DELETE')

                                <x-danger-button>Hapus</x-danger-button>
                            </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    {{-- ========================= --}}
    {{-- MODAL TAMBAH PETUGAS     --}}
    {{-- ========================= --}}

    <x-modal name="tambah-petugas">
        <form method="POST" action="{{ route('admin.petugas.store') }}" class="p-6">
            @csrf

            <h2 class="text-lg font-semibold">Tambah Petugas</h2>

            <div class="mt-4">
                <x-input-label value="Username" />
                <x-text-input name="username" class="mt-1 block w-full" required />
            </div>

            <div class="mt-4">
                <x-input-label value="Password" />
                <x-text-input type="password" name="password" class="mt-1 block w-full" required />
            </div>

            <div class="mt-4">
                <x-input-label value="Nama Petugas" />
                <x-text-input name="nama_petugas" class="mt-1 block w-full" required />
            </div>

            <div class="mt-4">
                <x-input-label value="Level" />
                <select name="level" class="mt-1 block w-full border-gray-300 rounded-lg">
                     <option value="admin">Admin</option>
                    <option value="petugas">Petugas</option>
                </select>
            </div>

            <div class="mt-6 flex justify-end gap-2">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'tambah-petugas')">Batal</x-secondary-button>
                <x-primary-button>Simpan</x-primary-button>
            </div>
        </form>
    </x-modal>


    {{-- ========================= --}}
    {{-- MODAL EDIT PETUGAS       --}}
    {{-- ========================= --}}
    @foreach ($petugas as $p)
        <x-modal name="edit-petugas-{{ $p->id_petugas }}">
            <form method="POST" action="{{ route('admin.petugas.update', $p->id_petugas) }}" class="p-6">
                @csrf
                @method('PUT')

                <h2 class="text-lg font-semibold">Edit Petugas</h2>

                <div class="mt-4">
                    <x-input-label value="Username" />
                    <x-text-input name="username" value="{{ $p->username }}" class="mt-1 block w-full" required />
                </div>

                <div class="mt-4">
                    <x-input-label value="Password (kosongkan jika tidak diubah)" />
                    <x-text-input type="password" name="password" class="mt-1 block w-full" />
                </div>

                <div class="mt-4">
                    <x-input-label value="Nama Petugas" />
                    <x-text-input name="nama_petugas" value="{{ $p->nama_petugas }}" class="mt-1 block w-full" required />
                </div>

                <div class="mt-4">
                    <x-input-label value="Level" />
                    <select name="level" class="mt-1 block w-full border-gray-300 rounded-lg">
                        <option value="admin" @selected($p->level == 'admin')>Admin</option>
                        <option value="petugas" @selected($p->level == 'petugas')>Petugas</option>
                    </select>
                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <x-secondary-button
                        x-on:click="$dispatch('close-modal', 'edit-petugas-{{ $p->id_petugas }}')">
                        Batal
                    </x-secondary-button>

                    <x-primary-button>Update</x-primary-button>
                </div>
            </form>
        </x-modal>
    @endforeach

</x-sidebar-layout>
