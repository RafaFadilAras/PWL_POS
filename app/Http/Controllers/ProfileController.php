<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Profil Saya',
            'list' => ['Home', 'Profil']
        ];

        $page = (object)[
            'title' => 'Pengaturan Profil Pengguna'
        ];

        $activeMenu = 'profile';
        $user = Auth::user();

        return view('profile.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'user' => $user,
            'activeMenu' => $activeMenu
        ]);
    }

    public function updateFoto(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        if ($user->foto && Storage::disk('public')->exists($user->foto)) {
            Storage::disk('public')->delete($user->foto);
        }


        $foto = $request->file('foto');
        $fotoName = 'profile_' . $user->user_id . '_' . Str::random(10) . '.' . $foto->getClientOriginalExtension();
        $fotoPath = $foto->storeAs('fotos', $fotoName, 'public');


        UserModel::where('user_id', $user->user_id)->update(['foto' => $fotoPath]);

        return redirect('/profile')->with('success', 'Foto profil berhasil diperbarui');
    }


    public function removeFoto()
    {
        $user = Auth::user();

        if ($user->foto && Storage::disk('public')->exists($user->foto)) {
            Storage::disk('public')->delete($user->foto);
        }


        UserModel::where('user_id', $user->user_id)->update(['foto' => null]);

        return redirect('/profile')->with('success', 'Foto profil berhasil dihapus');
    }
}
