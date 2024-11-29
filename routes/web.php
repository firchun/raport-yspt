a<?php

    use App\Http\Controllers\CustomerController;
    use App\Http\Controllers\KategoriPenilaianController;
    use App\Http\Controllers\PenilaianSantriController;
    use App\Http\Controllers\PointPenilaianController;
    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\SantriController;
    use App\Http\Controllers\TahunAjaranController;
    use App\Http\Controllers\UserController;
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

    // Route::get('/', function () {
    //     return view('welcome');
    // });

    Auth::routes(['register' => false, 'resets' => false]);
    Route::middleware(['auth:web'])->group(function () {
        Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

        //akun managemen
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        //santri managemen
        Route::get('/santri', [SantriController::class, 'index'])->name('santri');
        Route::post('/santri/store',  [SantriController::class, 'store'])->name('santri.store');
        Route::get('/santri/edit/{id}',  [SantriController::class, 'edit'])->name('santri.edit');
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
        // penilaian santri managemen
        Route::get('/penilaian', [PenilaianSantriController::class, 'index'])->name('penilaian');
        Route::post('/penilaian/store', [PenilaianSantriController::class, 'store'])->name('penilaian.store');
        Route::post('/penilaian/store-komentar', [PenilaianSantriController::class, 'storeKomentar'])->name('penilaian.store-komentar');
        Route::get('/penilaian/print', [PenilaianSantriController::class, 'print'])->name('penilaian.print');
        Route::get('/penilaian/report/{id}', [PenilaianSantriController::class, 'report'])->name('penilaian.report');
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
