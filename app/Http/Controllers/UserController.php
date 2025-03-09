<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {

        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager_tiga',
        //     'nama' => 'Manager 3',
        //     'password' => Hash::make('12345')   
        // ];
        // UserModel::create($data);

        // $user = UserModel::all();
        // return view('user', ['data' => $user]);

        // $user = UserModel::where('level_id', 1)->first();
        // return  view('user', ['data' => $user]);

        // $user = userModel::findor(20, ['username','nama'], function(){
        //     abort(404);
        // });

        // $user = UserModel::findOrFail(1);

        // $user = UserModel::where('username', 'manager9')->firstOrFail();

        // $user = UserModel::where('level_id', 2)->count();
        //dd($user);

        //         $user = UserModel::firstOrCreate(
        // [
        //                 'username' => 'manager22',
        //                 'nama' => 'Manager Dua Dua',
        //                 'password' => Hash::make('12345'),
        //                 'level_id' => 2
        //             ],
        //          );
        // $user = UserModel::firstOrNew(
        //     [
        //         'username' => 'manager33',
        //         'nama' => 'Manager Tiga Tiga',
        //         'password' => Hash::make('12345'),
        //         'level_id' => 2
        //     ],
        // );
        // $user->save();
        // return  view('user', ['data' => $user]);

        // $user = UserModel::create([
        //     'username' => 'manager12',
        //     'nama' => 'Manager12',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 2,
        // ]);

        // $user->username = 'manager13';

        // $user->isDirty();
        // $user->isDirty('username');
        // $user->isDirty('nama');
        // $user->isDirty(['nama', 'username']);

        // $user->isClean();
        // $user->isClean('username');
        // $user->isClean('nama');
        // $user->isClean(['nama', 'username']);

        //$user->save();

        //  $user->isDirty();
        //  $user->isClean();
        //  dd($user->isDirty());

        // $user->wasChanged();
        // $user->wasChanged('username');
        // $user->wasChanged(['username', 'level_id']);
        // $user->wasChanged('nama'); 
        // dd($user->wasChanged(['nama', 'username']));

        $user = UserModel::all();
        return view('user', ['data' => $user]);
    }

    public function tambah()
    {
        return view('user_tambah');
    }

    public function tambah_simpan()
    {
        UserModel::create([
            'username' => request('username'),
            'nama' => request('nama'),
            'password' => Hash::make(request('password')),
            'level_id' => request('level_id')
        ]);
        return redirect('user');
    }

    public function ubah($id) {
        $user = UserModel::find($id);
        return view('user_ubah', ['data' => $user]);
    }
}
