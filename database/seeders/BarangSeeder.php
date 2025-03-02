<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data= [
            [
                'barang_id'=> 1,
                'kategori_id'=> 1,
                'barang_kode' =>'BMM001',
                'barang_nama' => 'Susu Kotak 250ml',
                'harga_beli' => 4500,
                'harga_jual' => 5000,
            ],
            [
                'barang_id'=> 2,
                'kategori_id'=> 1,
                'barang_kode' =>'BMM002',
                'barang_nama' => 'Snack Bar',
                'harga_beli' => 6500,
                'harga_jual' => 7000,
            ],
            [
                'barang_id'=> 3,
                'kategori_id'=> 2,
                'barang_kode' =>'BPA001',
                'barang_nama' => 'Kemeja Hitam Pria',
                'harga_beli' => 110000,
                'harga_jual' => 115000,
            ],
            [
                'barang_id'=> 4,
                'kategori_id'=> 2,
                'barang_kode' =>'BPA002',
                'barang_nama' => 'Kemeja Putih Wanita',
                'harga_beli' => 120000,
                'harga_jual' => 125000,
            ],
            [
                'barang_id'=> 5,
                'kategori_id'=> 3,
                'barang_kode' =>'BKB001',
                'barang_nama' => 'Popok Bayi',
                'harga_beli' => 50000,
                'harga_jual' => 55000,
            ],
            [
                'barang_id'=> 6,
                'kategori_id'=> 3,
                'barang_kode' =>'BKB002',
                'barang_nama' => 'Bedak Bayi',
                'harga_beli' => 20000,
                'harga_jual' => 25000,
            ],
            [
                'barang_id'=> 7,
                'kategori_id'=> 4,
                'barang_kode' =>'BPK001',
                'barang_nama' => 'Sunscreen spf50',
                'harga_beli' => 65000,
                'harga_jual' => 70000,
            ],
            [
                'barang_id'=> 8,
                'kategori_id'=> 4,
                'barang_kode' =>'BPK002',
                'barang_nama' => 'Cushion Matte',
                'harga_beli' => 135000,
                'harga_jual' => 140000,
            ],
            [
                'barang_id'=> 9,
                'kategori_id'=> 5,
                'barang_kode' =>'BPR001',
                'barang_nama' => 'Pembersih Kaca',
                'harga_beli' => 40000,
                'harga_jual' => 45000,
            ],
            [
                'barang_id'=> 10,
                'kategori_id'=> 5,
                'barang_kode' =>'BPR002',
                'barang_nama' => 'Kanebo',
                'harga_beli' => 8000,
                'harga_jual' => 12000,
            ],
        ];
        DB::table('m_barang')->insert($data);
    }
}
