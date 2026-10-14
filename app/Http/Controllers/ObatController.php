<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index()
    {
        $obats = Obat::latest()->get();
        return view('admin.obat.index', compact('obats'));
    }

    public function create()
    {
        return view('admin.obat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kemasan' => 'nullable|string|max:35',
            'harga' => 'required|numeric|min:0',
        ]);

        Obat::create($request->all());

        return redirect()->route('admin.obat.index')
            ->with('success', 'Data obat berhasil ditambahkan.');
    }

    public function edit(Obat $obat)
    {
        return view('admin.obat.edit', compact('obat'));
    }

    public function update(Request $request, Obat $obat)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kemasan' => 'nullable|string|max:35',
            'harga' => 'required|numeric|min:0',
        ]);

        $obat->update($request->all());

        return redirect()->route('admin.obat.index')
            ->with('success', 'Data obat berhasil diperbarui.');
    }

    public function destroy(Obat $obat)
    {
        $obat->delete();

        return redirect()->route('admin.obat.index')
            ->with('success', 'Data obat berhasil dihapus.');
    }
}
