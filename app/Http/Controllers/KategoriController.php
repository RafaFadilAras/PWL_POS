<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Models\KategoriModel;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    public function index() {
        $breadcrumb = (object) [
            'title' => 'Daftar Kategori',
            'list' => ['Home', 'Kategori']
        ];

        $page = (object) [
            'title' => 'Daftar Kategori yang terdaftar dalam sistem',
        ];

        $activeMenu = 'kategori';

        return view('kategori.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
     {
         $kategori = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama');
         
         return DataTables::of($kategori)
             ->addIndexColumn()
             ->addColumn('aksi', function ($kategori) {
                //  $btn = '<a href="'.url('/kategori/' . $kategori->kategori_id).'" class="btn btn-info btn-sm">Detail</a> ';
                //  $btn .= '<a href="'.url('/kategori/' . $kategori->kategori_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                //  $btn .= '<form class="d-inline-block" method="POST" action="'. url('/kategori/'.$kategori->kategori_id).'">'
                //      . csrf_field() . method_field('DELETE') .
                //      '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                $btn = '<button onclick="modalAction(\''.url('/kategori/' . $kategori->kategori_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/kategori/' . $kategori->kategori_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/kategori/' . $kategori->kategori_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
             })
             ->rawColumns(['aksi'])
             ->make(true);
     }
    
    // Menampilkan hakaman form tambah kategori
    public function create()
     {
         $breadcrumb = (object) [
             'title' => 'Tambah Kategori',
             'list' => ['Home', 'Kategori', 'Tambah']
         ];
 
         $page = (object) [
             'title' => 'Tambah Kategori Barang'
         ];
         
         $kategori = KategoriModel::all();
         $activeMenu = 'kategori';
 
         return view('kategori.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
     }

    public function create_ajax() {
        $kategori = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama')->get();

        return view('kategori.create_ajax')
            ->with('kategori', $kategori);
    }
    
    // Menyimpan data kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'kategori_kode' => 'required|max:10|unique:m_kategori,kategori_kode',
            'kategori_nama' => 'required|max:100'
        ]);
 
        KategoriModel::create([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama
        ]);
 
        return redirect('/kategori')->with('success', 'Data kategori berhasil disimpan');
    }

    public function store_ajax(Request $request) {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_kode' => 'required|max:10|unique:m_kategori,kategori_kode',
                'kategori_nama' => 'required|max:100'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            KategoriModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data kategori berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    // Menampilkan detail kategori
    public function show(string $id)
    {
        $kategori = KategoriModel::with('barang')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Kategori',
            'list' => ['Home', 'Kategori', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Kategori'
        ];

        $activeMenu = 'kategori';

        return view('kategori.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman form edit kategori
    public function edit($id)
     {
        $kategori = KategoriModel::find($id);

         $breadcrumb = (object) [
             'title' => 'Edit Kategori',
             'list' => ['Home', 'Kategori', 'Edit']
         ];
 
         $page = (object) [
             'title' => 'Edit Kategori Barang'
         ];
 
         $activeMenu = 'kategori';
         
         return view('kategori.edit', [
             'breadcrumb' => $breadcrumb,
             'page' => $page,
             'kategori' => $kategori,
             'activeMenu' => $activeMenu
         ]);
     }
    
    public function edit_ajax($id) {
        $kategori = KategoriModel::find($id);

        return view('kategori.edit_ajax', ['kategori' => $kategori]);
    }
    
     // Menyimpan perubahan data kategori
     public function update(Request $request, $id)
     {
         $request->validate([
             'kategori_kode' => 'required|max:10|unique:m_kategori,kategori_kode,'.$id.',kategori_id',
             'kategori_nama' => 'required|max:100',
         ]);
 
         KategoriModel::find($id)->update([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama
         ]);
 
         return redirect('/kategori')->with('success', 'Data kategori berhasil diubah');
     }
    
    public function update_ajax(Request $request, $id) {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_kode' => 'required|max:10|unique:m_kategori,kategori_kode,'.$id.',kategori_id',
                'kategori_nama' => 'required|max:100'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $kategori = KategoriModel::find($id);
            if ($kategori) {
                $kategori->update($request->all());

                return response()->json([
                    'status' => true,
                    'message' => 'Data kategori berhasil diubah'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data kategori tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
    
    // Menghapus data kategori
    public function destroy($id)
    {
        $check = KategoriModel::find($id);
        if (!$check) {
            return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan');
        }
 
        try{
            KategoriModel::destroy($id);
            return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/kategori')->with('error', 'Data kategori gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
