<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangModel;
use App\Models\KategoriModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller {
    public function index() {
        $breadcrumb = (object) [
            'title' => 'Daftar Barang',
            'list' => ['Home', 'Barang']
        ];

        $page = (object) [
            'title' => 'Daftar Barang yang terdaftar dalam sistem',
        ];

        $kategori = KategoriModel::all();
        $activeMenu = 'barang';

        return view('barang.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'kategori' => $kategori,
            'activeMenu' => $activeMenu
        ]);
    }

    // Ambil data barang dalam bentuk json untuk datatables
    public function list(Request $request)
     {
         $barang = BarangModel::select('barang_id', 'barang_kode', 'barang_nama', 'kategori_id', 'harga_beli', 'harga_jual')
             ->with('kategori');
 
         if ($request->kategori_id) {
             $barang->where('kategori_id', $request->kategori_id);
         }
 
         return DataTables::of($barang)
             ->addIndexColumn()
             ->addColumn('aksi', function ($barang) {
                 $btn = '<a href="'.url('/barang/' . $barang->barang_id).'" class="btn btn-info btn-sm">Detail</a> ';
                 $btn .= '<a href="'.url('/barang/' . $barang->barang_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                 $btn .= '<form class="d-inline-block" method="POST" action="'. url('/barang/'.$barang->barang_id).'">'
                     . csrf_field() . method_field('DELETE') .
                     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                 return $btn;
             })
             ->rawColumns(['aksi'])
             ->make(true);
     }

    // Menampilkan halaman form tambah user
    public function create()
     {
         $breadcrumb = (object) [
             'title' => 'Tambah Barang',
             'list' => ['Home', 'Barang', 'Tambah']
         ];
 
         $page = (object) [
             'title' => 'Tambah Data Barang'
         ];
 
         $kategori = KategoriModel::all();
 
         $activeMenu = 'barang';
 
        return view('barang.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'kategori' => $kategori,
            'activeMenu' => $activeMenu
        ]);
     }
    
    public function create_ajax() {
        $kategori = KategoriModel::all();

        return view('barang.create_ajax', compact('kategori'));
        
    }
    
    // Menyimpan data barang baru
    public function store(Request $request)
     {
         $request->validate([
             'kategori_id' => 'required',
             'barang_kode' => 'required|unique:m_barang',
             'barang_nama' => 'required',
             'harga_beli' => 'required|numeric',
             'harga_jual' => 'required|numeric',
         ]);
         
        BarangModel::create([
            'kategori_id' => $request->kategori_id,
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual
        ]);

         return redirect('barang')->with('success', 'Barang berhasil ditambahkan');
     }

    public function store_ajax(Request $request) {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_id' => 'required',
                'barang_kode' => 'required|unique:m_barang',
                'barang_nama' => 'required',
                'harga_beli' => 'required|numeric',
                'harga_jual' => 'required|numeric',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            BarangModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data barang berhasil disimpan'
            ]);
        }
        redirect('/');
    }
    
    // Menampilkan detail barang
    public function show(string $id)
     {
        $barang = BarangModel::with('kategori')->find($id);

         $breadcrumb = (object) [
             'title' => 'Detail Barang',
             'list' => ['Home', 'Barang', 'Detail']
         ];
 
         $page = (object) [
             'title' => 'Detail Data Barang'
         ];
 
         $activeMenu = 'barang';
 
         return view('barang.show', [
             'breadcrumb' => $breadcrumb,
             'page' => $page,
             'barang' => $barang,
             'activeMenu' => $activeMenu
         ]);
     }
    
    // Menampilkan halaman form edit barang
    public function edit($id)
    {
        $breadcrumb = (object) [
            'title' => 'Edit Barang',
            'list' => ['Home', 'Barang', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Data Barang'
        ];

        $barang = BarangModel::find($id);
        $kategori = KategoriModel::all();

        $activeMenu = 'barang';

        return view('barang.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,            
            'barang' => $barang,
            'kategori' => $kategori,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan perubahan data barang
    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_id' => 'required',
            'barang_kode' => 'required|unique:m_barang,barang_kode,'.$id.',barang_id',
            'barang_nama' => 'required',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
        ]);

        $barang = BarangModel::find($id);
        $barang->update($request->all());

        return redirect('barang')->with('success', 'Barang berhasil diperbarui');
    }

    // Menghapus data barang
    public function destroy($id)
    {
        $barang = BarangModel::find($id);
        if ($barang) {
            $barang->delete();
            return redirect('barang')->with('success', 'Barang berhasil dihapus');
        }
        return redirect('barang')->with('error', 'Barang tidak ditemukan');
    }
 
}