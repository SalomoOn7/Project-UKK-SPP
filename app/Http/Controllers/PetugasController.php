<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Petugas;
use Illuminate\Support\Facades\Hash;
class PetugasController extends Controller
{
    public function index()
    {
        $petugas = Petugas::all();
        return view('admin.petugas.index', compact('petugas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:petugas',
            'nama_petugas' => 'required',
            'level' => 'required',
            'password' => 'required|min:4'
        ]);

        Petugas::create([
            'username' => $request->username,
            'nama_petugas' => $request->nama_petugas,
            'level' => $request->level,
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Petugas berhasil ditambahkan');
    }

    public function update(Request $request, Petugas $petuga)
    {
        $request->validate([
            'username' => 'required',
            'nama_petugas' => 'required',
            'level' => 'required',
        ]);

        $data = $request->only(['username','nama_petugas','level']);

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $petuga->update($data);

        return back()->with('success', 'Petugas berhasil diupdate');
    }

    public function destroy(Petugas $petuga)
    {
        $petuga->delete();
        return back()->with('success', 'Petugas berhasil dihapus');
    }
}
