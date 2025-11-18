<x-sidebar-layout>

    <div class="p-6">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-semibold">Manajemen Siswa</h1>
            <x-primary-button x-data=""
                x-on:click="$dispatch('open-modal', 'modal-create-siswa')">
                + Tambah Siswa
            </x-primary-button>
        </div>

        {{-- TABLE --}}
        <div class="bg-white shadow rounded-lg p-4">
            <table class="w-full text-sm">
                <thead class="border-b font-semibold">
                    <tr class="text-left">
                        <th class="p-2">NISN</th>
                        <th class="p-2">NIS</th>
                        <th class="p-2">Nama</th>
                        <th class="p-2">Kelas</th>
                        <th class="p-2">SPP</th>
                        <th class="p-2">No Telp</th>
                        <th class="p-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($siswa as $s)
                    <tr class="border-b">
                        <td class="p-2">{{ $s->nisn }}</td>
                        <td class="p-2">{{ $s->nis }}</td>
                        <td class="p-2">{{ $s->nama }}</td>
                        <td class="p-2">{{ $s->kelas->nama_kelas ?? '-' }}</td>
                        <td class="p-2">Rp {{ number_format($s->spp->nominal ?? 0, 0, ',', '.') }}</td>
                        <td class="p-2">{{ $s->no_telp }}</td>
                        
                        <td class="px-4 py-2 gap-2 text-center">
                            <div class="flex justify-center gap-2">
                            {{-- Edit Button --}}
                            <x-secondary-button
                                x-data=""
                                x-on:click="$dispatch('open-modal', 'modal-edit-{{ $s->nisn }}')">
                                Edit
                            </x-secondary-button>

                            {{-- Delete --}}
                            <form action="{{ route('admin.siswa.destroy', $s->nisn) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus siswa ini?')">
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
    </div>

    {{-- MODAL CREATE --}}
    <x-modal name="modal-create-siswa">
        <form method="POST" action="{{ route('admin.siswa.store') }}" class="p-6 space-y-4">
            @csrf
            <h2 class="text-lg font-semibold mb-3">Tambah Siswa</h2>

            <x-input-label :value="'NISN'"/>
            <x-text-input name="nisn" class="w-full" required/>

            <x-input-label :value="'NIS'"/>
            <x-text-input name="nis" class="w-full" required/>

            <x-input-label :value="'Nama'"/>
            <x-text-input name="nama" class="w-full" required/>

            <x-input-label :value="'Username'"/>
            <x-text-input name="username" class="w-full" required/>

            <x-input-label :value="'Password'"/>
            <x-text-input type="password" name="password" class="w-full" required/>

            <x-input-label :value="'Kelas'"/>
            <select name="id_kelas" class="w-full border rounded p-2" required>
                @foreach ($kelas as $k)
                <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                @endforeach
            </select>

            <x-input-label :value="'SPP'"/>
            <select name="id_spp" class="w-full border rounded p-2" required>
                @foreach ($spp as $sp)
                <option value="{{ $sp->id_spp }}">{{ $sp->tahun }} - Rp{{ number_format($sp->nominal) }}</option>
                @endforeach
            </select>

            <x-input-label :value="'Alamat'"/>
            <textarea name="alamat" class="w-full border rounded p-2"></textarea>

            <x-input-label :value="'No Telp'"/>
            <x-text-input name="no_telp" class="w-full" required/>

            <div class="flex justify-end mt-4">
                <x-primary-button>Tambah</x-primary-button>
            </div>
        </form>
    </x-modal>

    {{-- MODAL EDIT --}}
    @foreach ($siswa as $s)
    <x-modal name="modal-edit-{{ $s->nisn }}">
        <form method="POST" action="{{ route('admin.siswa.update', $s->nisn) }}" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <h2 class="text-lg font-semibold mb-3">Edit Data Siswa</h2>

            <x-input-label :value="'NISN (tidak bisa diubah)'"/>
            <x-text-input type="text" class="w-full" value="{{ $s->nisn }}" disabled/>

            <x-input-label :value="'NIS'"/>
            <x-text-input name="nis" class="w-full" value="{{ $s->nis }}"/>

            <x-input-label :value="'Nama'"/>
            <x-text-input name="nama" class="w-full" value="{{ $s->nama }}"/>

            <x-input-label :value="'Username'"/>
            <x-text-input name="username" class="w-full" value="{{ $s->username }}"/>

            <x-input-label :value="'Password (kosongkan jika tidak diubah)'"/>
            <x-text-input type="password" name="password" class="w-full"/>

            <x-input-label :value="'Kelas'"/>
            <select name="id_kelas" class="w-full border rounded p-2">
                @foreach ($kelas as $k)
                <option value="{{ $k->id_kelas }}" {{ $s->id_kelas == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                @endforeach
            </select>

            <x-input-label :value="'SPP'"/>
            <select name="id_spp" class="w-full border rounded p-2">
                @foreach ($spp as $sp)
                <option value="{{ $sp->id_spp }}" {{ $s->id_spp == $sp->id_spp ? 'selected' : '' }}>
                    {{ $sp->tahun }} - Rp{{ number_format($sp->nominal) }}
                </option>
                @endforeach
            </select>

            <x-input-label :value="'Alamat'"/>
            <textarea name="alamat" class="w-full border rounded p-2">{{ $s->alamat }}</textarea>

            <x-input-label :value="'No Telp'"/>
            <x-text-input name="no_telp" class="w-full" value="{{ $s->no_telp }}"/>

            <div class="flex justify-end mt-4">
                <x-primary-button>Simpan</x-primary-button>
            </div>
        </form>
    </x-modal>
    @endforeach

</x-sidebar-layout>
