<?php

namespace App\Http\Controllers;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{

    public function index()
    {
        $kelas = Kelas::all();
        return view('admin.kelas.index', compact('kelas'));
    }

    public function create()
    {
        return view('admin.kelas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|max:10',
            'kompetensi_keahlian' => 'required|max:50',
        ]);

        Kelas::create($request->all());
        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil ditambahkan');
    }

    public function edit(Kelas $kelas)
    {
        $kelas = Kelas::findOrFail($id);
        return view('admin.kelas.edit', compact('kelas'));
    }

    public function update(Request $request, Kelas $id_kelas)
    {
        $request->validate([
            'nama_kelas' => 'required|max:10',
            'kompetensi_keahlian' => 'required|max:50',
        ]);

        $id_kelas->update($request->only(['nama_kelas','kompetensi_keahlian']));
        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil diupdate');
    }

    public function destroy(Kelas $id_kelas)
    {
        $id_kelas->delete();
        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dihapus');
    }
}
