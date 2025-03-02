<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data= [
            [
                'kategori_id' => 1,
                'kategori_kode' =>'KMM001',
                'kategori_nama' =>'Makanan dan Minuman'
            ],
            [
                'kategori_id' => 2,
                'kategori_kode' =>'KPA002',
                'kategori_nama' =>'Pakaian'
            ],
            [
                'kategori_id' => 3,
                'kategori_kode' =>'KKB003',
                'kategori_nama' =>'Kebutuhan Bayi'
            ],
            [
                'kategori_id' => 4,
                'kategori_kode' =>'KPK004',
                'kategori_nama' =>'Perawatan dan Kecantikan'
            ],
            [
                'kategori_id' => 5,
                'kategori_kode' =>'KPR005',
                'kategori_nama' =>'Perawatan Rumah'
            ],
        ];
        DB::table('m_kategori')->insert($data);
    }
}
