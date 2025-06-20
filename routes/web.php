<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\KategoriPenilaianController;
use App\Http\Controllers\KategoriPenilaianQuranController;
use App\Http\Controllers\PencapaianQuranController;
use App\Http\Controllers\PengasuhController;
use App\Http\Controllers\PenilaianQuranController;
use App\Http\Controllers\PenilaianSantriController;
use App\Http\Controllers\PointPenilaianController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\UserController;
use App\Models\Santri;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/raport-santri/{code}', function ($code) {
    $santri = Santri::where('code', $code)->first();
    $data = [
        'title' => $santri ? 'Laporan Santri  : ' . $santri->nama : 'Data Tidak Ditemukan',
        'santri' => $santri,
    ];
    return view('welcome', $data);
});

Auth::routes(['register' => false, 'resets' => false]);
Route::middleware(['auth:web'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    // create user pengasuh
    Route::post('/admin/create-user-from-pengasuh', [UserController::class, 'createFromPengasuh']);
    Route::post('/admin/reset-user-password', [UserController::class, 'resetPassword']);

    //akun managemen
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //santri managemen
    Route::get('/santri', [SantriController::class, 'index'])->name('santri');
    Route::get('/santri/create', [SantriController::class, 'create'])->name('santri.create');
    Route::post('/santri/store',  [SantriController::class, 'store'])->name('santri.store');
    Route::get('/santri/edit/{id}',  [SantriController::class, 'edit'])->name('santri.edit');
    Route::get('/santri/edit-view/{id}',  [SantriController::class, 'editView'])->name('santri.edit-view');
    Route::delete('/santri/delete/{id}',  [SantriController::class, 'destroy'])->name('santri.delete');
    Route::get('/santri-datatable', [SantriController::class, 'getSantriDataTable']);
    //tahun ajaran managemen
    Route::get('/tahun', [TahunAjaranController::class, 'index'])->name('tahun');
    Route::post('/tahun/store',  [TahunAjaranController::class, 'store'])->name('tahun.store');
    Route::get('/tahun/edit/{id}',  [TahunAjaranController::class, 'edit'])->name('tahun.edit');
    Route::delete('/tahun/delete/{id}',  [TahunAjaranController::class, 'destroy'])->name('tahun.delete');
    Route::get('/tahun-datatable', [TahunAjaranController::class, 'getTahunAjaranDataTable']);
    //kategori managemen
    Route::get('/kategori', [KategoriPenilaianController::class, 'index'])->name('kategori');
    Route::post('/kategori/store',  [KategoriPenilaianController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/edit/{id}',  [KategoriPenilaianController::class, 'edit'])->name('kategori.edit');
    Route::delete('/kategori/delete/{id}',  [KategoriPenilaianController::class, 'destroy'])->name('kategori.delete');
    Route::get('/kategori-datatable', [KategoriPenilaianController::class, 'getKategoriDataTable']);
    //kategori managemen
    Route::get('/kategori-quran', [KategoriPenilaianQuranController::class, 'index'])->name('kategori-quran');
    Route::post('/kategori-quran/store',  [KategoriPenilaianQuranController::class, 'store'])->name('kategori-quran.store');
    Route::get('/kategori-quran/edit/{id}',  [KategoriPenilaianQuranController::class, 'edit'])->name('kategori-quran.edit');
    Route::delete('/kategori-quran/delete/{id}',  [KategoriPenilaianQuranController::class, 'destroy'])->name('kategori-quran.delete');
    Route::get('/kategori-quran-datatable', [KategoriPenilaianQuranController::class, 'getKategoriDataTable']);
    //pengasuh managemen
    Route::get('/pengasuh', [PengasuhController::class, 'index'])->name('pengasuh');
    Route::post('/pengasuh/store',  [PengasuhController::class, 'store'])->name('pengasuh.store');
    Route::get('/pengasuh/edit/{id}',  [PengasuhController::class, 'edit'])->name('pengasuh.edit');
    Route::delete('/pengasuh/delete/{id}',  [PengasuhController::class, 'destroy'])->name('pengasuh.delete');
    Route::get('/pengasuh-datatable', [PengasuhController::class, 'getPengasuhDataTable']);
    // penilaian quran santri managemen
    Route::get('/penilaian-quran', [PenilaianQuranController::class, 'index'])->name('penilaian-quran');
    Route::get('/penilaian-quran/report/{id}', [PenilaianQuranController::class, 'report'])->name('penilaian-quran.report');
    Route::post('/penilaian-quran/store', [PenilaianQuranController::class, 'store'])->name('penilaian-quran.store');
    Route::post('/pencapaian-quran/store', [PenilaianQuranController::class, 'storePencapaian'])->name('pencapaian-quran.store');
    Route::post('/penilaian-quran/store-komentar', [PenilaianQuranController::class, 'storeKomentar'])->name('penilaian-quran.store-komentar');
    Route::get('penilaian-quran/get-komentar/{id}/{id_santri}', [PenilaianQuranController::class, 'getKomentar']);
    Route::get('/penilaian-quran/print', [PenilaianQuranController::class, 'print'])->name('penilaian-quran.print');
    // penilaian santri managemen
    Route::get('/penilaian', [PenilaianSantriController::class, 'index'])->name('penilaian');
    Route::post('/penilaian/store', [PenilaianSantriController::class, 'store'])->name('penilaian.store');
    Route::post('/penilaian/store-komentar', [PenilaianSantriController::class, 'storeKomentar'])->name('penilaian.store-komentar');
    Route::get('/penilaian/print', [PenilaianSantriController::class, 'print'])->name('penilaian.print');
    Route::get('/penilaian/report/{id}', [PenilaianSantriController::class, 'report'])->name('penilaian.report');
    Route::get('penilaian/get-komentar/{id}/{id_santri}', [PenilaianSantriController::class, 'getKomentar']);
    Route::put('penilaian/update-komentar', [PenilaianSantriController::class, 'updateKomentar']);

    Route::get('penilaian/get/{id}', [PenilaianSantriController::class, 'getPenilaian']);
    Route::put('penilaian/update', [PenilaianSantriController::class, 'updatePenilaian']);
    //point penilaian managemen
    Route::get('/point', [PointPenilaianController::class, 'index'])->name('point');
    Route::post('/point/store',  [PointPenilaianController::class, 'store'])->name('point.store');
    Route::get('/point/edit/{id}',  [PointPenilaianController::class, 'edit'])->name('point.edit');
    Route::delete('/point/delete/{id}',  [PointPenilaianController::class, 'destroy'])->name('point.delete');
    Route::get('/point-datatable', [PointPenilaianController::class, 'getPointDataTable']);
});
Route::middleware(['auth:web', 'role:Admin'])->group(function () {
    //user managemen
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::post('/users/store',  [UserController::class, 'store'])->name('users.store');
    Route::get('/users/edit/{id}',  [UserController::class, 'edit'])->name('users.edit');
    Route::delete('/users/delete/{id}',  [UserController::class, 'destroy'])->name('users.delete');
    Route::get('/users-datatable', [UserController::class, 'getUsersDataTable']);
});