<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penghuni;

class PenghuniController extends Controller
{
    public function index()
    {
        $penghunis = Penghuni::all();
        return view('penghuni.index', compact('penghunis'));
    }

    public function create()
    {
        return view('penghuni.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'no_ktp' => 'required',
            'pekerjaan' => 'required',
            'no_hp' => 'required',
            'kontak_darurat' => 'required',
            'hubungan_kontak_darurat' => 'required',
        ]);

        Penghuni::create($request->all());
        return redirect()->route('penghuni.index');
    }

    public function edit($id)
    {
        $penghuni = Penghuni::findOrFail($id);
        return view('penghuni.edit', compact('penghuni'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'no_ktp' => 'required',
            'pekerjaan' => 'required',
            'no_hp' => 'required',
            'kontak_darurat' => 'required',
            'hubungan_kontak_darurat' => 'required',
        ]);

        $penghuni = Penghuni::findOrFail($id);
        $penghuni->update($request->all());

        return redirect()->route('penghuni.index');
    }

    public function destroy($id)
    {
        $penghuni = Penghuni::findOrFail($id);
        $penghuni->delete();

        return redirect()->route('penghuni.index');
    }
}