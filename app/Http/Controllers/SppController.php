<?php

namespace App\Http\Controllers;
use App\Models\Spp;
use Illuminate\Http\Request;

class SppController extends Controller
{
    public function index()
    {
        $spp = Spp::all();
        return view('admin.spp.index', compact('spp'));
    }

    public function store(Request $request)
{
    $request->validate([
        'tahun' => 'required|numeric|unique:spp,tahun',
        'nominal' => 'required|numeric',
    ]);

    Spp::create($request->only(['tahun', 'nominal']));

    return back()->with('success', 'Data SPP berhasil ditambahkan');
}


    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, Spp $spp)
{
    $request->validate([
        'tahun' => 'required|numeric|unique:spp,tahun,' . $spp->id_spp . ',id_spp',
        'nominal' => 'required|numeric',
    ]);

    $spp->update($request->only(['tahun', 'nominal']));

    return back()->with('success', 'Data SPP berhasil diperbarui');
}


    public function destroy(Spp $spp)
    {
        $spp->delete();
        return back()->with('success','Data SPP berhasil dihapus');
    }
}
