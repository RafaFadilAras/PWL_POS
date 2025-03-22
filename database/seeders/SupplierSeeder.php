<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'supplier_id'=> 1,
                'supplier_kode'=> 'SPP001',
                'supplier_nama'=> 'Mayora',
                'supplier_alamat'=> 'Jl. Raya Purwodadi No 1'
            ],
            [
                'supplier_id'=> 2,
                'supplier_kode'=> 'SPP002',
                'supplier_nama'=> 'Bintang Mas',
                'supplier_alamat'=> 'Jl. Soekarno Hatta No 99'
            ],
        ];
        DB::table('m_supplier')->insert($data);
    }
}
