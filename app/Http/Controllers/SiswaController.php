<?php

namespace App\Http\Controllers;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Spp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $request)
{
    $filterKelas = $request->kelas;
    $filterNama  = $request->nama;

    $query = Siswa::with(['kelas','spp']);

    if ($filterKelas) {
        $query->where('id_kelas', $filterKelas);
    }

    if ($filterNama) {
        $query->where('nama', 'LIKE', '%' . $filterNama . '%');
    }

    $siswa = $query->get();

    return view('admin.siswa.index', [
        'siswa'       => $siswa,
        'kelas'       => Kelas::all(),
        'spp'         => Spp::all(),
        'filterKelas' => $filterKelas,
        'filterNama'  => $filterNama,
    ]);
}


    public function create()
    {
        $siswa =  Siswa::with(['kelas', 'spp'])->get();
        $kelas = Kelas::all();
        $spp = Spp::all();
        return view('admin.siswa.index', compact('kelas', 'spp', 'siswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required|string|max:10|unique:siswa,nisn',
            'nis' => 'required|string|max:8',
            'nama' => 'required|string|max:35',
            'username' => 'required|string|unique:siswa,username',
            'password' => 'required|min:5',
            'id_kelas' => 'required',
            'no_telp' => 'required',
            'id_spp' => 'required',
        ]);

        Siswa::create([
            'nisn' => $request->nisn,
            'nis' => $request->nis,
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'id_kelas' => $request->id_kelas,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'id_spp' => $request->id_spp,
        ]);
        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil ditambahkan');
    }

    public function edit(string $id)
    {
         $siswa = Siswa::findOrfail($id);
         $kelas = Kelas::all();
         $spp = Spp::all();
         return view('admin.siswa.edit', compact('siswa', 'kelas', 'spp'));
    }

    public function update(Request $request, string $id)
    {
       $siswa = Siswa::findOrFail($id);
       $request->validate([
            'nis' => 'required|string|max:8',
            'nama' => 'required|string|max:35',
            'username' => 'required|string|unique:siswa,username,' . $id . ',nisn',
            'id_kelas' => 'required',
            'no_telp' => 'required',
            'id_spp' => 'required',
        ]);

        $siswa->update([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'username' => $request->username,
            'id_kelas' => $request->id_kelas,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'id_spp' => $request->id_spp,
        ]);

        if ($request->password) {
            $siswa->update([
                'password' =>Hash::make($request->password)
            ]);
        }
        return redirect()->route('admin.siswa.index')->with('succes', 'Data Siswa Behasil di Edit');
    }

    public function destroy(string $nisn)
    {
        $siswa = Siswa::findOrfail($nisn);
        $siswa->delete();
        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil dihapus!');
    }
}
