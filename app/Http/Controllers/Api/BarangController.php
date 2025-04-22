<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangModel;

class BarangController extends Controller
{
    public function index()
     {
         return BarangModel::all();
     }
 
     public function store(Request $request)
     {
         $barang = BarangModel::create($request->all());
         return response()->json($barang, 201);
     }
 
     public function show(BarangModel $barang)
     {
        //  return BarangModel::find($barang);
        return response()->json($barang);
     }
 
/*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Update the specified barang in the database.
     *
     * @param \Illuminate\Http\Request $request The request object containing data to update the barang.
     * @param \App\Models\BarangModel $barang The barang model to be updated.
     * @return \App\Models\BarangModel The updated barang model.
     */

/*******  1c96172a-c663-45f7-be22-d1ebc3d57102  *******/
     public function update(Request $request, BarangModel $barang)
     {
         $barang->update($request->all());
         return $barang;
     }
 
     public function destroy(BarangModel $barang)
     {
         $barang->delete();
         return response()->json([
             'success' => true,
             'message' => 'Data berhasil dihapus'
         ]);
     }
}
