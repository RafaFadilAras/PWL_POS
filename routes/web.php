<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make somethi   ng great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/level', [LevelController::class, 'index']);
// Route::get('/kategori', [KategoriController::class, 'index']);
// Route::get('/user',[UserController::class, 'index']);

// Route::get('/user/tambah', [UserController::class, 'tambah']);
// Route::post('/user/simpan', [UserController::class, 'tambah_simpan']);
// Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
// Route::put('/user/ubah/{id}', [UserController::class, 'ubah_simpan']);
// Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);

// Route::get('/', [WelcomeController::class, 'index']);

Route::get('user/register', [UserController::class, 'createRegistrasi'])->name('register');
Route::post('user/storeRegister', [UserController::class, 'storeRegistrasi'])->name('storeRegister');

Route::get('/', [WelcomeController::class, 'index']);

// Route::group(['prefix' => 'user'], function () {
//     Route::get('/', [UserController::class, 'index']);           // menampilkan halaman awal user
//     Route::post('/list', [UserController::class, 'list']);       // menampilkan data user dalam bentuk json untuk datatables
//     Route::get('/create', [UserController::class, 'create']);    // menampilkan halaman form tambah user
//     Route::post('/', [UserController::class, 'store']);          // menyimpan data user baru
//     Route::get('/create_ajax', [UserController::class, 'create_ajax']); // Menampilkan halaman form tambah user Ajax
//     Route::post('ajax', [UserController::class, 'store_ajax']); // Menyimpan data user baru Ajax
//     Route::get('/{id}', [UserController::class, 'show']);        // menampilkan detail user
//     Route::get('/{id}/edit', [UserController::class, 'edit']);   // menampilkan halaman form edit user
//     Route::put('/{id}', [UserController::class, 'update']);      // menyimpan perubahan data user
//     Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); // menampilkan halaman form edit user ajax
//     Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); // menyimpan perubahan data user
//     Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete user Ajax
//     Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // Untuk menghapus data user
//     Route::delete('/{id}', [UserController::class, 'destroy']);  // menghapus data user
// });

Route::group(['prefix' => 'level'], function () {
    Route::get('/', [LevelController::class, 'index']);
    Route::post('/list', [LevelController::class, 'list']);
    Route::get('/create', [LevelController::class, 'create']);
    Route::post('/', [LevelController::class, 'store']);
    Route::get('/create_ajax', [LevelController::class, 'create_ajax']);
    Route::post('/ajax', [LevelController::class, 'store_ajax']);
    Route::get('/{id}', [LevelController::class, 'show']);
    Route::get('/{id}/edit', [LevelController::class, 'edit']);
    Route::put('/{id}', [LevelController::class, 'update']);
    Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);
    Route::delete('/{id}', [LevelController::class, 'destroy']);
});

Route::group(['prefix' => 'kategori'], function () {
    Route::get('/', [KategoriController::class, 'index']);
    Route::get('/create', [KategoriController::class, 'create']);
    Route::post('/', [KategoriController::class, 'store']);
    Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);
    Route::post('/ajax', [KategoriController::class, 'store_ajax']);
    Route::get('/{id}', [KategoriController::class, 'show']);
    Route::get('/{id}/edit', [KategoriController::class, 'edit']);
    Route::put('/{id}', [KategoriController::class, 'update']);
    Route::delete('/{id}', [KategoriController::class, 'destroy']);
    Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);
    Route::post('/list', [KategoriController::class, 'list']);
});

Route::group(['prefix' => 'barang'], function () {
    Route::get('/', [BarangController::class, 'index']);
    Route::post('/list', [BarangController::class, 'list']);
    Route::get('/create', [BarangController::class, 'create']);
    Route::post('/', [BarangController::class, 'store']);
    Route::get('/create_ajax', [BarangController::class, 'create_ajax']);
    Route::post('/ajax', [BarangController::class, 'store_ajax']);
    Route::get('/{id}', [BarangController::class, 'show']);
    Route::get('/{id}/edit', [BarangController::class, 'edit']);
    Route::put('/{id}', [BarangController::class, 'update']);
    Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']);
    Route::delete('/{id}', [BarangController::class, 'destroy']);
});

Route::group(['prefix' => 'stok'], function () {
    Route::get('/', [StokController::class, 'index']);
    Route::get('/create', [StokController::class, 'create']);
    Route::post('/', [StokController::class, 'store']);
    Route::get('/{id}', [StokController::class, 'show']);
    Route::get('/{id}/edit', [StokController::class, 'edit']);
    Route::put('/{id}', [StokController::class, 'update']);
    Route::delete('/{id}', [StokController::class, 'destroy']);
    Route::post('/list', [StokController::class, 'list']);
});

Route::group(['prefix' => 'supplier'], function () {
    Route::get('/', [SupplierController::class, 'index']);
    Route::post('/list', [SupplierController::class, 'list']);
    Route::get('/create', [SupplierController::class, 'create']);
    Route::post('/', [SupplierController::class, 'store']);
    Route::get('/create_ajax', [SupplierController::class, 'create_ajax']);
    Route::post('/ajax', [SupplierController::class, 'store_ajax']);
    Route::get('/{id}', [SupplierController::class, 'show']);
    Route::get('/{id}/edit', [SupplierController::class, 'edit']);
    Route::put('/{id}', [SupplierController::class, 'update']);
    Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']);
    Route::delete('/{id}', [SupplierController::class, 'destroy']);
});

Route::pattern('id', '[0-9]+');

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [WelcomeController::class, 'index']);

    Route::group(['prefix' => 'user'], function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::post('/list', [UserController::class, 'list'])->name('user.list');
        Route::get('/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/', [UserController::class, 'store'])->name('user.store');
        Route::get('/create_ajax', [UserController::class, 'create_ajax'])->name('user.create_ajax');
        Route::post('/ajax', [UserController::class, 'store_ajax'])->name('user.store_ajax');
        Route::get('/{id}', [UserController::class, 'show'])->name('user.show');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('user.update');
        Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax'])->name('user.show_ajax');
        Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax'])->name('user.edit_ajax');
        Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax'])->name('user.update_ajax');
        Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax'])->name('user.confirm_ajax');
        Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax'])->name('user.delete_ajax');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::get('/import', [UserController::class, 'import'])->name('user.import');
        Route::post('/import_ajax', [UserController::class, 'import_ajax'])->name('user.import_ajax');
        Route::get('/export_excel', [UserController::class, 'export_excel'])->name('user.export_excel');
        Route::get('/export_pdf', [UserController::class, 'export_pdf'])->name('user.export_pdf');
    });

    Route::middleware(['authorize:ADM'])->group(function () {
        Route::group(['prefix' => 'level'], function () {
            Route::get('/', [LevelController::class, 'index'])->name('level.index');
            Route::post('/list', [LevelController::class, 'list'])->name('level.list');
            Route::get('/create', [LevelController::class, 'create'])->name('level.create');
            Route::post('/', [LevelController::class, 'store'])->name('level.store');
            Route::get('/create_ajax', [LevelController::class, 'create_ajax'])->name('level.create_ajax');
            Route::post('/ajax', [LevelController::class, 'store_ajax'])->name('level.store_ajax');
            Route::get('/{id}', [LevelController::class, 'show'])->name('level.show');
            Route::get('/{id}/edit', [LevelController::class, 'edit'])->name('level.edit');
            Route::put('/{id}', [LevelController::class, 'update'])->name('level.update');
            Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax'])->name('level.edit_ajax');
            Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax'])->name('level.update_ajax');
            Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax'])->name('level.confirm_ajax');
            Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax'])->name('level.delete_ajax');
            Route::delete('/{id}', [LevelController::class, 'destroy'])->name('level.destroy');
            Route::get('/import', [LevelController::class, 'import'])->name('level.import');
            Route::post('/import_ajax', [LevelController::class, 'import_ajax'])->name('level.import_ajax');
            Route::get('/export_excel', [LevelController::class, 'export_excel'])->name('level.export_excel');  
            Route::get('/export_pdf', [LevelController::class, 'export_pdf'])->name('level.export_pdf');
        });
    });

    Route::middleware(['authorize:ADM,MNG'])->group(function () {
        Route::group(['prefix' => 'barang'], function () {
            Route::get('/', [BarangController::class, 'index'])->name('barang.index');
            Route::post('/list', [BarangController::class, 'list'])->name('barang.list');
            Route::get('/create', [BarangController::class, 'create'])->name('barang.create');
            Route::post('/', [BarangController::class, 'store'])->name('barang.store');
            Route::get('/create_ajax', [BarangController::class, 'create_ajax'])->name('barang.create_ajax');
            Route::post('/ajax', [BarangController::class, 'store_ajax'])->name('barang.store_ajax');
            Route::get('/{id}', [BarangController::class, 'show'])->name('barang.show');
            Route::get('/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
            Route::put('/{id}', [BarangController::class, 'update'])->name('barang.update');
            Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax'])->name('barang.edit_ajax');
            Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax'])->name('barang.update_ajax');
            Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax'])->name('barang.confirm_ajax');
            Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax'])->name('barang.delete_ajax');
            Route::delete('/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
            Route::get('/import', [BarangController::class, 'import'])->name('barang.import');
            Route::post('/import_ajax', [BarangController::class, 'import_ajax'])->name('barang.import_ajax');
            Route::get('/export_excel', [BarangController::class, 'export_excel'])->name('barang.export_excel');
            Route::get('/export_excel', [BarangController::class, 'export_excel'])->name('barang.export_excel');
            Route::get('/export_pdf', [BarangController::class, 'export_pdf'])->name('barang.export_pdf');
        });
    });

    Route::middleware(['authorize:ADM,STF'])->group(function(){
        Route::group(['prefix' => 'kategori'], function () {
            Route::get('/', [KategoriController::class, 'index'])->name('kategori.index');
            Route::post('/list', [KategoriController::class, 'list'])->name('kategori.list');
            Route::get('/{id}',[KategoriController::class, 'show'])->name('kategori.show');
            Route::get('/create', [KategoriController::class, 'create'])->name('kategori.create');
            Route::post('/', [KategoriController::class, 'store'])->name('kategori.store');
            Route::get('/create_ajax', [KategoriController::class, 'create_ajax'])->name('kategori.create_ajax');
            Route::post('/ajax', [KategoriController::class, 'store_ajax'])->name('kategori.store_ajax');
            Route::get('/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
            Route::put('/{id}', [KategoriController::class, 'update'])->name('kategori.update');
            Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax'])->name('kategori.edit_ajax');
            Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax'])->name('kategori.update_ajax');
            Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax'])->name('kategori.confirm_ajax');
            Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax'])->name('kategori.delete_ajax');
            Route::delete('/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
            Route::get('/import', [KategoriController::class, 'import'])->name('kategori.import');
            Route::post('/import_ajax', [KategoriController::class, 'import_ajax'])->name('kategori.import_ajax');
            Route::get('/export_excel', [KategoriController::class, 'export_excel'])->name('kategori.export_excel');
            Route::get('/export_pdf', [KategoriController::class, 'export_pdf'])->name('kategori.export_pdf');
        });
    });

    Route::middleware(['authorize:MNG,STF,ADM'])->group(function(){
        Route::group(['prefix' => 'supplier'], function () {
            Route::get('/', [SupplierController::class, 'index'])->name('supplier.index');
            Route::post('/list', [SupplierController::class, 'list'])->name('supplier.list');
            Route::get('/create', [SupplierController::class, 'create'])->name('supplier.create');
            Route::post('/', [SupplierController::class, 'store'])->name('supplier.store');
            Route::get('/create_ajax', [SupplierController::class, 'create_ajax'])->name('supplier.create_ajax');
            Route::post('/ajax', [SupplierController::class, 'store_ajax'])->name('supplier.store_ajax');
            Route::get('/{id}', [SupplierController::class, 'show'])->name('supplier.show');
            Route::get('/{id}/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
            Route::put('/{id}', [SupplierController::class, 'update'])->name('supplier.update');
            Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax'])->name('supplier.edit_ajax');
            Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax'])->name('supplier.update_ajax');
            Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax'])->name('supplier.confirm_ajax');
            Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax'])->name('supplier.delete_ajax');
            Route::delete('/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
            Route::get('/import', [SupplierController::class, 'import'])->name('supplier.import');
            Route::post('/import_ajax', [SupplierController::class, 'import_ajax'])->name('supplier.import_ajax');
            Route::get('/export_excel', [SupplierController::class, 'export_excel'])->name('supplier.export_excel');
            Route::get('/export_pdf', [SupplierController::class, 'export_pdf'])->name('supplier.export_pdf');
        });
    });

    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
        Route::put('update', [ProfileController::class, 'updateFoto'])->name('profile.update');
        Route::delete('remove_foto', [ProfileController::class, 'removeFoto'])->name('profile.remove_foto');

    });
});
