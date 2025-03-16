<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() {
        $breadcrumb = (object) [
            'title' => 'User',
            'list' => [ 'Home', 'User']
        ];

        $page = (object) [
            'title' => 'Daftar User yang terdaftar dalam sistem',
        ];

        $activeMenu = 'user';

        return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }    
    
    public function list(Request $request) 
     { 
         $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
             ->with('level');
     
         return Datatables::of($users)
             // Menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
             ->addIndexColumn()
             ->addColumn('aksi', function ($user) { // Menambahkan kolom aksi
                 $btn  = '<a href="' . url('/user/' . $user->user_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                 $btn .= '<a href="' . url('/user/' . $user->user_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                 $btn .= '<form class="d-inline-block" method="POST" action="' . url('/user/' . $user->user_id) . '">'
                     . csrf_field() . method_field('DELETE') .
                     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">
                         Hapus
                     </button>
                 </form>';
     
                 return $btn;
             })
             ->rawColumns(['aksi']) // Memberitahu bahwa kolom aksi mengandung HTML
             ->make(true);
     }
}