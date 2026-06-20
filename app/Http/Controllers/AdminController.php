<?php

namespace App\Http\Controllers;

use App\Models\Lahan;
use App\Models\User;

class AdminController extends Controller
{
   public function database()
{
    $users = User::all();
    $lahans = Lahan::with('user')->get();

    return view('admin.database', compact('users', 'lahans'));
}
}