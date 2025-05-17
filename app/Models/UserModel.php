<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Tymon\JWTAuth\Contracts\JWTSubject;// implementasi class Authenticatable
use Illuminate\Database\Eloquent\Casts\Attribute;

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

class UserModel extends Authenticatable implements JWTSubject {

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }
    use HasFactory;

    protected $table = 'm_user';  // Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'user_id';  // Mendefinisikan primary key dari tabel yang digunakan
 
    protected $fillable = [
         'username',
         'password',
         'nama',
         'level_id',
         'created_at',
         'image'
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

    protected function image(): Attribute {
        return Attribute::make(
            get: fn($image) => url('/storage/posts' . $image),
        );
    }

    public function getRoleName(){
        return $this->level->level_nama;
    }

    public function hasRole($role){
        return $this->level->level_kode == $role;
    }

    public function getRole(){
        return $this->level->level_kode;
    }
}
