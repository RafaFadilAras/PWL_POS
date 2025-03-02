<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index() {
        // $data = [
        //         'kategori_kode'=>'SNK',
        //         'kategori_nama'=> 'Snack/Makanan RIngan',
        //         'created_at'=> now()
        //     ];
        //     DB::table('m_kategori')->insert($data);
        //     return 'Insert data baru berhasil';

        $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->update(['kategori_nama' => 'Camilan']);
        return 'Update data berhasil. Jumlah data yang diupdate: '. $row. 'baris';
    }
}
