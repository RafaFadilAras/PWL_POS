<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LevelModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class LevelController extends Controller
{
    public function index() {
        $breadcrumb = (object) [
            'title' => 'Daftar Level',
            'list' => ['Home', 'Level']
        ];
        $page = (object) [
            'title' => 'Daftar Level User'
        ];
        $activeMenu = 'level';
        return view('level.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
         $levels = LevelModel::select('level_id', 'level_kode', 'level_nama');
 
         return DataTables::of($levels)
             ->addIndexColumn()
             ->addColumn('aksi', function ($level) {
                 $btn = '<a href="'.url('/level/' . $level->level_id).'" class="btn btn-info btn-sm">Detail</a> ';
                 $btn .= '<a href="'.url('/level/' . $level->level_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                 $btn .= '<form class="d-inline-block" method="POST" action="'. url('/level/'.$level->level_id).'">'
                     . csrf_field() . method_field('DELETE') .
                     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                 return $btn;
             })
             ->rawColumns(['aksi'])
             ->make(true);
    }

    //Menampilkan halaman form tambah level
    public function create()
    {
         $breadcrumb = (object) [
             'title' => 'Tambah Level',
             'list' => ['Home', 'Level', 'Tambah']
         ];
 
         $page = (object) [
             'title' => 'Tambah Data Level User'
         ];
 
         $activeMenu = 'level';
         return view('level.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function create_ajax() {
        //$level = LevelModel::select('level_id', 'level_nama')->get();

        return view('level.create_ajax');
    }

    //Menyimpan data level baru
    public function store(Request $request)
     {
         $request->validate([
             'level_kode' => 'required|max:10|unique:m_level,level_kode',
             'level_nama' => 'required|max:100'
         ]);
 
         LevelModel::create([
             'level_kode' => $request->level_kode,
             'level_nama' => $request->level_nama
         ]);
 
         return redirect('/level')->with('success', 'Data level berhasil disimpan');
     }
    
    public function store_ajax(Request $request) {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_kode' => 'required|max:10|unique:m_level,level_kode',
                'level_nama' => 'required|string|unique:m_level,level_nama|min:3|max:100'
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
    
            LevelModel::create($request->all());
    
            return response()->json([
                'status' => true,
                'message' => 'Data level berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    // menampilkan detail level user
    public function show($id)
    {
         $breadcrumb = (object) [
             'title' => 'Detail Level',
             'list' => ['Home', 'Level', 'Detail']
         ];
 
         $page = (object) [
             'title' => 'Detail Data Level User'
         ];
 
         $level = LevelModel::find($id);
         $activeMenu = 'level';
         return view('level.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }
    
    // menampilkan halaman form edit level
    public function edit($id)
     {
        $level = LevelModel::find($id);

         $breadcrumb = (object) [
             'title' => 'Edit Level',
             'list' => ['Home', 'Level', 'Edit']
         ];
 
         $page = (object) [
             'title' => 'Edit Data Level User'
         ];
 
         $activeMenu = 'level';
 
         return view('level.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
     }

    // menyimpan perubahan data level
    public function update(Request $request, $id)
     {
         $request->validate([
             'level_kode' => 'required|max:10|unique:m_level,level_kode,'.$id.',level_id',
             'level_nama' => 'required|max:100'
         ]);
 
         LevelModel::find($id)->update([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama,
         ]);
 
         return redirect('/level')->with('success', 'Data level berhasil diubah');
     }

    // menghapus data level
    public function destroy($id)
    {
         $check = LevelModel::find($id);
         if (!$check) {
             return redirect('/level')->with('error', 'Data level tidak ditemukan');
         }

         try{
             LevelModel::destroy($id);
             return redirect('/level')->with('success', 'Data level berhasil dihapus');
         } catch (\Illuminate\Database\QueryException $e) {
             return redirect('/level')->with('error', 'Data level gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
         }
    }
}
