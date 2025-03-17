<?php
 
 namespace App\Http\Controllers;
 
 use Illuminate\Http\Request;
 use App\Models\BarangModel;
 use App\Models\StokModel;
 use Yajra\DataTables\Facades\DataTables;
 
 class StokController extends Controller
 {
     public function index()
     {
         $breadcrumb = (object) [
             'title' => 'Data Stok Barang',
             'list' => ['Home', 'Stok']
         ];
 
         $page = (object) [
             'title' => 'Data Stok Barang'
         ];
 
         $barang = BarangModel::all();
         $activeMenu = 'stok';
 
        return view('stok.index', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'barang' => $barang, 
            'activeMenu' => $activeMenu]);
     }
 
     public function list(Request $request)
     {
         $stok = StokModel::with('barang')->select('stok_id', 'barang_id', 'stok_jumlah', 'stok_tanggal');
 
         return DataTables::of($stok)
             ->addIndexColumn()
             ->addColumn('aksi', function ($stok) {
                 $btn = '<a href="'.url('/stok/' . $stok->stok_id).'" class="btn btn-info btn-sm">Detail</a> ';
                 $btn .= '<a href="'.url('/stok/' . $stok->stok_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                 $btn .= '<form class="d-inline-block" method="POST" action="'. url('/stok/'.$stok->stok_id).'">'
                     . csrf_field() . method_field('DELETE') .
                     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Hapus data ini?\');">Hapus</button></form>';
                 return $btn;
             })
             ->rawColumns(['aksi'])
             ->make(true);
     }
 
     public function create()
     {
         $breadcrumb = (object) [
             'title' => 'Tambah Stok Barang',
             'list' => ['Home', 'Stok', 'Tambah']
         ];
 
         $page = (object) [
             'title' => 'Tambah Stok Barang'
         ];
 
         $barang = BarangModel::all();
         $activeMenu = 'stok';
 
         return view('stok.create', [
             'breadcrumb' => $breadcrumb, 
             'page' => $page, 
             'barang' => $barang, 
             'activeMenu' => $activeMenu    
         ]);
     }
 
     public function store(Request $request)
     {
         $request->validate([
             'barang_id' => 'required',
             'stok_jumlah' => 'required|numeric',
             'stok_tanggal' => 'required|date',
         ]);
 
         StokModel::create([
             'barang_id' => $request->barang_id,
             'stok_jumlah' => $request->stok_jumlah,
             'stok_tanggal' => $request->stok_tanggal,
             'user_id' => 1, 
         ]);
 
         return redirect('/stok')->with('success', 'Data stok berhasil disimpan');
     }
 
     public function show($id)
     {
        $stok = StokModel::with('barang')->find($id);

         $breadcrumb = (object) [
             'title' => 'Detail Stok Barang',
             'list' => ['Home', 'Stok', 'Detail']
         ];
 
         $page = (object) [
             'title' => 'Detail Stok Barang'
         ];
 
         $activeMenu = 'stok';
 
         return view('stok.show', [
             'breadcrumb' => $breadcrumb, 
             'page' => $page, 
             'stok' => $stok, 
             'activeMenu' => $activeMenu
         ]);
     }
 
     public function edit($id)
     {
         
        $stok = StokModel::find($id);
        $barang = BarangModel::all();

         $breadcrumb = (object) [
             'title' => 'Edit Stok Barang',
             'list' => ['Home', 'Stok', 'Edit']
         ];
 
         $page = (object) [
             'title' => 'Edit Stok Barang'
         ];

         $activeMenu = 'stok';
 
         return view('stok.edit', [
             'breadcrumb' => $breadcrumb, 
             'page' => $page, 
             'stok' => $stok, 
             'barang' => $barang, 
             'activeMenu' => $activeMenu
         ]);
     }
 
     public function update(Request $request, $id)
     {
         $request->validate([
             'barang_id' => 'required',
             'stok_jumlah' => 'required|numeric',
             'stok_tanggal' => 'required|date',
         ]);
         
         StokModel::find($id)->update([
             'barang_id' => $request->barang_id,
             'stok_jumlah' => $request->stok_jumlah,
             'stok_tanggal' => $request->stok_tanggal
         ]);
 
         return redirect('/stok')->with('success', 'Data stok berhasil diubah');
     }
 
     public function destroy($id)
     {
         $check = StokModel::find($id);
         if (!$check) {
             return redirect('/stok')->with('error', 'Data stok tidak ditemukan');
         }
 
         try{
             StokModel::destroy($id);
             return redirect('/stok')->with('success', 'Data stok berhasil dihapus');
         } catch (\Illuminate\Database\QueryException $e) {
             return redirect('/stok')->with('error', 'Data stok gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
         }
     }
 }