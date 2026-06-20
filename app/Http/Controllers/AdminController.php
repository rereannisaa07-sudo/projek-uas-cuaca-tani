<?php

namespace App\Http\Controllers;

use App\Models\Lahan;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function database()
    {
        $users = User::all();
        $lahans = Lahan::with('user')->get();

        return view('admin.database', compact('users', 'lahans'));
    }

    public function editUser(User $user)
    {
        return view('admin.edit-user', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|in:admin,user',
        ]);

        $user->update($request->only('name', 'email', 'role'));

        return redirect()->route('admin.database')->with('success', 'User berhasil diupdate.');
    }

    public function destroyUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.database')->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.database')->with('success', 'User berhasil dihapus.');
    }

    public function editLahan(Lahan $lahan)
    {
        return view('admin.edit-lahan', compact('lahan'));
    }

    public function updateLahan(Request $request, Lahan $lahan)
    {
        $request->validate([
            'nama_lahan' => 'required|string|max:255',
            'luas_lahan' => 'required|numeric',
            'komoditas' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'alamat' => 'nullable|string',
        ]);

        $lahan->update($request->all());

        return redirect()->route('admin.database')->with('success', 'Lahan berhasil diupdate.');
    }

    public function destroyLahan(Lahan $lahan)
    {
        $lahan->delete();

        return redirect()->route('admin.database')->with('success', 'Lahan berhasil dihapus.');
    }
}