<?php

namespace App\Http\Controllers;

use App\Models\Lahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LahanController extends Controller
{
    public function index()
    {
        $lahans = Lahan::where('user_id', Auth::id())->get();
        return view('lahan.index', compact('lahans'));
    }

    public function create()
    {
        return view('lahan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lahan'     => 'required|string|max:255',
            'luas_lahan'     => 'required|numeric',
            'komoditas'      => 'required|string|max:255',
            'komoditas_lain' => 'nullable|string|max:255',
            'kota'           => 'required|string|max:255',
            'alamat'         => 'nullable|string',
        ]);

        $komoditas = $request->komoditas;
        if ($komoditas === 'lainnya' && $request->filled('komoditas_lain')) {
            $komoditas = $request->komoditas_lain;
        }

        Lahan::create([
            'user_id'    => Auth::id(),
            'nama_lahan' => $request->nama_lahan,
            'luas_lahan' => $request->luas_lahan,
            'komoditas'  => $komoditas,
            'kota'       => $request->kota,
            'alamat'     => $request->alamat,
        ]);

        return redirect()->route('lahan.index')->with('success', 'Lahan berhasil ditambahkan!');
    }

    public function edit(Lahan $lahan)
    {
        return view('lahan.edit', compact('lahan'));
    }

    public function update(Request $request, Lahan $lahan)
    {
        $request->validate([
            'nama_lahan' => 'required|string|max:255',
            'luas_lahan' => 'required|numeric',
            'komoditas'  => 'required|string|max:255',
            'kota'       => 'required|string|max:255',
            'alamat'     => 'nullable|string',
        ]);

        $lahan->update($request->only(['nama_lahan', 'luas_lahan', 'komoditas', 'kota', 'alamat']));

        return redirect()->route('lahan.index')->with('success', 'Lahan berhasil diupdate!');
    }

    public function destroy(Lahan $lahan)
    {
        $lahan->delete();
        return redirect()->route('lahan.index')->with('success', 'Lahan berhasil dihapus!');
    }
}