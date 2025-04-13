<?php
 
 namespace App\Http\Controllers;
 
 use App\Models\SupplierModel;
 use Illuminate\Http\Request;
 use Yajra\DataTables\Facades\DataTables;
 use Illuminate\Support\Facades\Validator;
 use PhpOffice\PhpSpreadsheet\IOFactory;
 
 class SupplierController extends Controller
 {
     public function index()
     {
 
         $breadcrumb = (object) [
             'title' => 'Daftar Supplier',
             'list' => ['Home', 'Kategori']
         ];
 
         $page = (object) [
             'title' => 'Daftar Supplier yang terdaftar dalam sistem'
         ];
 
         $activeMenu = 'supplier';
         return view('supplier.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
     }
 
     public function list()
     {
         $suppliers = SupplierModel::select('supplier_id', 'supplier_kode', 'supplier_nama', 'supplier_alamat');
 
 
         return DataTables::of($suppliers)
             ->addIndexColumn()
             ->addColumn('aksi', function ($supplier) {
                //  $btn = '<a href="' . url('/supplier/' . $supplier->supplier_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                //  $btn .= '<a href="' . url('/supplier/' . $supplier->supplier_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                //  $btn .= '<form class="d-inline-block" method="POST" action="' . url('/supplier/' . $supplier->supplier_id) . '">';
                //  $btn .= csrf_field() . method_field('DELETE');
                //  $btn .= '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                $btn = '<button onclick="modalAction(\''.url('/supplier/' . $supplier->supplier_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/supplier/' . $supplier->supplier_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/supplier/' . $supplier->supplier_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
             })
             ->rawColumns(['aksi'])
             ->make(true);
     }
 
     public function create()
     {
         $breadcrumb = (object) [
             'title' => 'Tambah Supplier',
             'list' => ['Home', 'Supplier', 'Tambah']
         ];
 
         $page = (object) [
             'title' => 'Tambah supplier baru'
         ];
 
         $activeMenu = 'supplier';
 
         return view('supplier.create', [
             'breadcrumb' => $breadcrumb,
             'page' => $page,
             'activeMenu' => $activeMenu
         ]);
     }

     public function create_ajax() {
        $supplier = SupplierModel::select('supplier_id', 'supplier_kode', 'supplier_nama')->get();

        return view('supplier.create_ajax')
            ->with('supplier', $supplier);
    }
 
     public function store(Request $request)
     {
         $request->validate([
             'supplier_kode' => 'required|string|min:3|unique:m_supplier,supplier_kode',
             'supplier_nama' => 'required|string|max:100',
             'supplier_alamat' => 'required|string|max:100'
         ]);
 
         SupplierModel::create([
             'supplier_kode' => $request->supplier_kode,
             'supplier_nama' => $request->supplier_nama,
             'supplier_alamat' => $request->supplier_alamat
         ]);
 
         return redirect('/supplier')->with('success', 'Data Supplier berhasil ditambahkan');
     }
 
     public function store_ajax(Request $request) {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_kode' => 'required|string|min:3|unique:m_supplier,supplier_kode',
                'supplier_nama' => 'required|string|max:100',
                'supplier_alamat' => 'required|string|max:100'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'false',
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            SupplierModel::create($request->all());

            return response()->json([
                'status' => 'true',
                'message' => 'Data Supplier berhasil disimpan'
            ]);
        }
        redirect('/');
     }
     public function show(string $id)
     {
         $supplier = SupplierModel::find($id);
 
         $breadcrumb = (object) [
             'title' => 'Detail Supplier',
             'list' => ['Home', 'Supplier', 'Detail']
         ];
 
         $page = (object) [
             'title' => 'Detail Supplier'
         ];
 
         $activeMenu = 'supplier';
 
         return view('supplier.show', [
             'breadcrumb' => $breadcrumb,
             'page' => $page,
             'supplier' => $supplier,
             'activeMenu' => $activeMenu
         ]);
     }
 
     public function edit(string $id)
     {
         $supplier = SupplierModel::find($id);
 
         $breadcrumb = (object) [
             'title' => 'Edit Supplier',
             'list' => ['Home', 'Supplier', 'Edit']
         ];
 
         $page = (object) [
             'title' => 'Edit Supplier'
         ];
 
         $activeMenu = 'supplier';
 
         return view('supplier.edit', [
             'breadcrumb' => $breadcrumb,
             'page' => $page,
             'supplier' => $supplier,
             'activeMenu' => $activeMenu
         ]);
     }

    public function edit_ajax(string $id) {
        $supplier = SupplierModel::find($id);

        return view('supplier.edit_ajax', ['supplier' => $supplier]);
    }
 
     public function update(Request $request, string $id)
     {
         $request->validate([
             'supplier_kode' => 'required|string|min:3|unique:m_supplier,supplier_kode,'. $id . ',supplier_id',
             'supplier_nama' => 'required|string|max:100',
             'supplier_alamat' => 'required|string|max:100'
         ]);
 
         SupplierModel::find($id)->update([
             'supplier_kode' => $request->supplier_kode,
             'supplier_nama' => $request->supplier_nama,
             'supplier_alamat' => $request->supplier_alamat
         ]);
 
         return redirect('/supplier')->with('success', 'Data Supplier berhasil diubah');
     }

    public function update_ajax(Request $request, $id) {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_kode' => 'required|string|min:3|unique:m_supplier,supplier_kode,'. $id . ',supplier_id',
                'supplier_nama' => 'required|string|max:100',
                'supplier_alamat' => 'required|string|max:100'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'false',
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $supplier = SupplierModel::find($id);
            if ($supplier) {
                $supplier->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data Supplier berhasil diubah'
                ]);

            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data Supplier tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
 
     public function destroy(string $id)
     {
         $check = SupplierModel::find($id);
         if (!$check) {
             return redirect('/supplier')->with('error', 'Data Supplier tidak ditemukan');
         }
 
         try {
             SupplierModel::destroy($id);
             return redirect('/supplier')->with('success', 'Data Supplier berhasil dihapus');
         } catch (\Illuminate\Database\QueryException $e) {
             return redirect('/supplier')->with('error', 'Data Supplier gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
         }
     }

    public function delete_ajax(Request $request, $id) {
        if($request->ajax() || $request->wantsJson()) {
            $supplier = SupplierModel::find($id);
            if ($supplier) {
                $supplier->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data Supplier berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data Supplier tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
    
    public function confirm_ajax(string $id) {
        $supplier = SupplierModel::find($id);

        return view('supplier.confirm_ajax', ['supplier' => $supplier]);
    }

    public function import()
 {
     return view('supplier.import');
 }
 
 public function import_ajax(Request $request)
 {
     if ($request->ajax() || $request->wantsJson()) {
         $rules = [
             // validasi file harus xls atau xlsx, max 1MB
             'file_supplier' => ['required', 'mimes:xlsx', 'max:1024']
         ];
         $validator = Validator::make($request->all(), $rules);
         if ($validator->fails()) {
             return response()->json([
                 'status' => false,
                 'message' => 'Validasi Gagal',
                 'msgField' => $validator->errors()
             ]);
         }
 
         $file = $request->file('file_supplier');  // ambil file dari request
         $reader = IOFactory::createReader('Xlsx');  // load reader file excel
         $reader->setReadDataOnly(true);             // hanya membaca data
         $spreadsheet = $reader->load($file->getRealPath()); // load file excel
         $sheet = $spreadsheet->getActiveSheet();    // ambil sheet yang aktif
         $data = $sheet->toArray(null, false, true, true);   // ambil data excel
 
         $insert = [];
         if (count($data) > 1) { // jika data lebih dari 1 baris
             foreach ($data as $baris => $value) {
                 if ($baris > 1) { // baris ke 1 adalah header, maka lewati
                     $insert[] = [
                         'supplier_kode' => $value['A'],
                         'supplier_nama' => $value['B'],
                         'supplier_alamat' => $value['C']
                     ];
                 }
             }
 
             if (count($insert) > 0) {
                 // insert data ke database, jika data sudah ada, maka diabaikan
                 SupplierModel::insertOrIgnore($insert);
             }
 
             return response()->json([
                 'status' => true,
                 'message' => 'Data Supplier berhasil diimport'
             ]);
         } else {
             return response()->json([
                 'status' => false,
                 'message' => 'Tidak ada data yang diimport'
             ]);
         }
     }
     return redirect('/');
 }
 
 }