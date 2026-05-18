<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminUserController extends Controller
{
    // Kullanıcıları Listele
    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    // Hesabı Dondur / Aktifleştir
    public function toggleFreeze($id)
    {
        $user = User::findOrFail($id);
        $user->is_frozen = !$user->is_frozen;
        $user->save();

        $status = $user->is_frozen ? 'donduruldu' : 'tekrar aktifleştirildi';
        return redirect()->back()->with('success', $user->name . ' adlı kullanıcının hesabı ' . $status . '.');
    }

    // Kullanıcıyı Tamamen Sil
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $userName = $user->name;
        $user->delete();

        return redirect()->back()->with('success', $userName . ' adlı kullanıcı sistemden tamamen silindi.');
    }
}