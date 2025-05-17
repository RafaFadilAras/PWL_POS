<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangModel;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index()
    {
        $barang = BarangModel::all();

        return response()->json([
            'success' => true,
            'data' => $barang
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori_id' => 'required|exists:m_kategori,kategori_id',
            'barang_kode' => 'required|unique:m_barang,barang_kode',
            'barang_nama' => 'required',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->all();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->store('public/posts');
            $data['image'] = $image->hashName();
        }

        $barang = BarangModel::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Data barang berhasil dibuat',
            'data' => $barang
        ], 201);
    }

    public function show($id)
    {
        //  return BarangModel::find($barang);
        $barang = BarangModel::with('kategori')->find($id);

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Data barang tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $barang
        ]);
    }

    public function update(Request $request, $id)
    {
        $barang = BarangModel::find($id);

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Data barang tidak ditemukan'
            ], 404);
        }


        $validator = Validator::make($request->all(), [
            'kategori_id' => 'nullable|exists:m_kategori,kategori_id',
            'barang_kode' => 'nullable|unique:m_barang,barang_kode,' . $id . ',barang_id',
            'barang_nama' => 'nullable',
            'harga_beli' => 'nullable|numeric',
            'harga_jual' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $data = $request->all();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->store('public/posts');
            $data['image'] = $image->hashName();
        }

        $barang->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Data barang berhasil diperbarui',
            'data' => $barang
        ]);
    }

    public function destroy($id)
    {
        $barang = BarangModel::find($id);

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Data barang tidak ditemukan'
            ], 404);
        }

        $barang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data barang berhasil dihapus'
        ]);
    }
}
