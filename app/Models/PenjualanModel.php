<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanModel extends Model
{
    use HasFactory;

    protected $table = 't_penjualan'; // Nama tabel di database
    protected $primaryKey = 'penjualan_id'; // Primary key dari tabel
    protected $fillable = [ // Kolom-kolom yang bisa diisi
        'user_id',
        'pembeli',
        'penjualan_kode',
        'penjualan_tanggal',
    ];

      public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }

}