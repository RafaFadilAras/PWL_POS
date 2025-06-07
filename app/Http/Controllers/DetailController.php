<?php

namespace App\Http\Controllers;

use App\Models\DetailModel;
use App\Models\PenjualanModel;
use App\Models\BarangModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DetailController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Detail Penjualan',
            'list' => ['Home', 'Detail Penjualan']
        ];

        $page = (object)[
            'title' => 'Daftar Detail Penjualan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'detail';
        $penjualan = PenjualanModel::all();
        $barang = BarangModel::all();

        return view('detail.index', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'penjualan' => $penjualan, 
            'barang' => $barang, 
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        $details = DetailModel::select('detail_id', 'penjualan_id', 'barang_id', 'harga', 'jumlah')
            ->with(['penjualan', 'barang']);

        if ($request->penjualan_id) {
            $details->where('penjualan_id', $request->penjualan_id);
        }

        if ($request->barang_id) {
            $details->where('barang_id', $request->barang_id);
        }

        return DataTables::of($details)
            ->addIndexColumn()
            ->addColumn('total', function ($detail) {
                return $detail->harga * $detail->jumlah;
            })
            ->addColumn('aksi', function ($detail) {
                $btn = '<a href="' . url('/detail/' . $detail->detail_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/detail/' . $detail->detail_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/detail/' . $detail->detail_id) . '">';
                $btn .= csrf_field() . method_field('DELETE');
                $btn .= '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Detail Penjualan',
            'list' => ['Home', 'Detail Penjualan', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah detail penjualan baru'
        ];

        $penjualan = PenjualanModel::all();
        $barang = BarangModel::all();
        $activeMenu = 'detail';

        return view('detail.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'penjualan' => $penjualan,
            'barang' => $barang,
            'activeMenu' => $activeMenu
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'penjualan_id' => 'required|integer|exists:t_penjualan,penjualan_id',
            'barang_id' => 'required|integer|exists:m_barang,barang_id',
            'harga' => 'required|numeric|min:0',
            'jumlah' => 'required|integer|min:1'
        ]);

        DetailModel::create([
            'penjualan_id' => $request->penjualan_id,
            'barang_id' => $request->barang_id,
            'harga' => $request->harga,
            'jumlah' => $request->jumlah
        ]);

        return redirect('/detail')->with('success', 'Data detail penjualan berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $detail = DetailModel::with(['penjualan', 'barang'])->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Penjualan',
            'list' => ['Home', 'Detail Penjualan', 'Detail']
        ];

        $page = (object) [
            'title' => 'Informasi detail penjualan'
        ];

        $activeMenu = 'detail';

        return view('detail.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'detail' => $detail,
            'activeMenu' => $activeMenu
        ]);
    }

    public function edit(string $id)
    {
        $detail = DetailModel::find($id);
        $penjualan = PenjualanModel::all();
        $barang = BarangModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Detail Penjualan',
            'list' => ['Home', 'Detail Penjualan', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit detail penjualan'
        ];

        $activeMenu = 'detail';

        return view('detail.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'detail' => $detail,
            'penjualan' => $penjualan,
            'barang' => $barang,
            'activeMenu' => $activeMenu
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'penjualan_id' => 'required|integer|exists:t_penjualan,penjualan_id',
            'barang_id' => 'required|integer|exists:m_barang,barang_id',
            'harga' => 'required|numeric|min:0',
            'jumlah' => 'required|integer|min:1'
        ]);

        DetailModel::find($id)->update([
            'penjualan_id' => $request->penjualan_id,
            'barang_id' => $request->barang_id,
            'harga' => $request->harga,
            'jumlah' => $request->jumlah
        ]);

        return redirect('/detail')->with('success', 'Data detail penjualan berhasil diubah');
    }

    public function destroy(string $id)
    {
        $check = DetailModel::find($id);
        if (!$check) {
            return redirect('/detail')->with('error', 'Data detail penjualan tidak ditemukan');
        }

        try {
            DetailModel::destroy($id);
            return redirect('/detail')->with('success', 'Data detail penjualan berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/detail')->with('error', 'Data detail penjualan gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}