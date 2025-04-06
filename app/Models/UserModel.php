<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable; // implementasi class Authenticatable

// class UserModel extends Model
// {
//     use HasFactory;

//     protected $table = 'm_user';
//     protected $primaryKey = 'user_id';

//     protected $fillable = ['level_id', 'username', 'nama', 'password'];

//     public function level(): BelongsTo {
//         return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
//     }
// }

class UserModel extends Authenticatable {
    use HasFactory;

    protected $table = 'm_user';  // Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'user_id';  // Mendefinisikan primary key dari tabel yang digunakan
 
    protected $fillable = [
         'username',
         'password',
         'nama',
         'level_id',
         'created_at',
         'updated_at',
     ];
 
    protected $hidden = [
         'password', // jangan ditampilkan saat select
    ];
 
    protected $casts = [
         'password' => 'hashed', // casting agar password dienkripsi otomatis
    ];

    /** Relasi ke tabel level */
    public function level(): BelongsTo {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    public function getRoleName(){
        return $this->level->level_nama;
    }

    public function hasRole($role){
        return $this->level->level_kode == $role;
    }
}
