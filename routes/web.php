<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PeriodedaftarController;
use App\Http\Controllers\PeriodenilaiController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\MkfakController;
use App\Http\Controllers\MkunivController;
use App\Http\Controllers\TahunajaranController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MksemesterController;
use App\Http\Controllers\DosenmkController;
use App\Http\Controllers\DaftarmbkmController;
use App\Http\Controllers\UtsmengajarController;
use App\Http\Controllers\UtsmagangController;
use App\Http\Controllers\ProgrammerdekaController;
use App\Http\Controllers\EurekaController;
use App\Http\Controllers\UtsprenershipController;
use App\Http\Controllers\AsistensiController;
use App\Http\Controllers\KategorimbkmController;
use App\Http\Controllers\ProgrammbkmController;

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
Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route Users
Route::resource('users',UsersController::class);
Route::get('users/matakuliah/{id}', [UsersController::class, 'matakuliah'])->name('users.matakuliah');
Route::get('dosen-search-prodi', [UsersController::class,'selectDosenProdi']);
Route::get('dosen-search-fakultas', [UsersController::class,'selectDosenFakultas']);
Route::get('dosen-search-universitas', [UsersController::class,'selectDosen']);
// Route::get('users/index', [UsersController::class, 'index'])->name('users.index');

//Route MahasiswaController
Route::resource('mahasiswa',MahasiswaController::class);
// Route::get('mahasiswa/index', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
// Route::get('mahasiswa/getdata', [MahasiswaController::class, 'getData'])->name('mahasiswa.getdata');

//Route Tahun Ajaran
Route::resource('tahunajaran',TahunajaranController ::class);
Route::post('delete-tahunajaran', [TahunajaranController  ::class,'destroy']);
// Route::get('tahunajaran/pendaftaran/{id}', [TahunajaranController::class, 'pendaftaran'])->name('tahunajaran.pendaftaran');
// Route::get('tahunajaran/krs/{id}', [TahunajaranController::class, 'krs'])->name('tahunajaran.krs');
// Route::get('tahunajaran/penilaian/{id}', [TahunajaranController::class, 'penilaian'])->name('tahunajaran.penilaian');
Route::get('tahunajaran/periode/{id}', [TahunajaranController::class, 'periode'])->name('tahunajaran.periode');
Route::put('tahunajaran/update_periode/{id}', [TahunajaranController::class, 'update_periode'])->name('tahunajaran.update_periode');

//Route Kelas
Route::resource('kelas',KelasController ::class);
Route::post('delete-kelas', [KelasController  ::class,'destroy']);
Route::get('kelas-search', [KelasController::class,'selectKelas']);

//Route Periode Pendaftaran
Route::resource('pendaftaran',PeriodedaftarController::class);
Route::post('delete-pendaftaran', [PeriodedaftarController::class,'destroy']);

//Route Periode Penilaian
Route::resource('penilaian',PeriodenilaiController::class);
Route::post('delete-penilaian', [PeriodenilaiController::class,'destroy']);

//Route Mata Kuliah Semester
Route::resource('mksemester',MksemesterController::class);
Route::post('delete-mksemester', [MksemesterController::class,'destroy']);

//Route Fakultas
Route::resource('fakultas',FakultasController::class);
Route::post('delete-fakultas', [FakultasController::class,'destroy']);
Route::get('fakultas-autocomplete-search', [FakultasController::class,'selectSearch']);
Route::get('fakultas-search', [FakultasController::class,'selectFakultas']);

//Route Prodi
Route::resource('prodi',ProdiController::class);
Route::post('delete-prodi', [ProdiController::class,'destroy']);
Route::get('prodi-autocomplete-search', [ProdiController::class,'selectSearch']);
Route::get('prodi-search', [ProdiController::class,'selectProdi']);

//Route MatakuliahController
Route::resource('matakuliah',MatakuliahController::class);
Route::resource('mkfak',MkfakController::class);
Route::resource('mkuniv',MkunivController::class);
Route::post('delete-mk', [MatakuliahController::class,'destroy']);
Route::get('mk-search', [MatakuliahController::class,'selectMk']);

//Route Dosen Mata Kuliah
Route::resource('dosenmk',DosenmkController::class);
Route::get('dosenmk/{users_id}/{tahunajarans_id}', [DosenmkController::class, 'matakuliah']);
Route::get('dosenmk/tambah/{users_id}/{tahunajarans_id}', [DosenmkController::class, 'tambah']);
Route::get('dosenmk/edit/{users_id}/{tahunajarans_id}/{id}', [DosenmkController::class, 'edit']);
Route::get('dosenmk/hapus/{users_id}/{tahunajarans_id}/{id}', [DosenmkController::class, 'hapus']);

//Route Daftar Program MBKM
Route::resource('daftarmbkm',DaftarmbkmController::class);
Route::post('delete-daftarmbkm', [DaftarmbkmController::class,'destroy']);
Route::get('daftarmbkm/kirim/{id}', [DaftarmbkmController::class, 'kirim'])->name('daftarmbkm.kirim');

//Route Daftar MBKM UTS Mengajar
Route::resource('utsmengajar',UtsmengajarController::class);
Route::post('delete-uts-mengajar', [UtsmengajarController::class,'destroy']);
Route::get('utsmengajar/kirim/{id}', [UtsmengajarController::class, 'kirim'])->name('utsmengajar.kirim');

//Route Daftar MBKM UTS Magang
Route::resource('utsmagang',UtsmagangController::class);
Route::post('delete-uts-magang', [UtsmagangController::class,'destroy']);
Route::get('utsmagang/kirim/{id}', [UtsmagangController::class, 'kirim'])->name('utsmagang.kirim');

//Route Daftar MBKM Program Merdeka
Route::resource('programmerdeka',ProgrammerdekaController::class);
Route::post('delete-programmerdeka', [ProgrammerdekaController::class,'destroy']);
Route::get('programmerdeka/kirim/{id}', [ProgrammerdekaController::class, 'kirim'])->name('programmerdeka.kirim');

//Route Daftar MBKM Program Eureka
Route::resource('eureka',EurekaController::class);
Route::post('delete-eureka', [EurekaController::class,'destroy']);
Route::get('eureka/kirim/{id}', [EurekaController::class, 'kirim'])->name('eureka.kirim');

//Route Daftar MBKM UTS Prenership
Route::resource('utsprenership',UtsprenershipController::class);
Route::post('delete-utsprenership', [UtsprenershipController::class,'destroy']);
Route::get('utsprenership/kirim/{id}', [UtsprenershipController::class, 'kirim'])->name('utsprenership.kirim');

//Route Daftar MBKM Asistensi Mengajar dikampus
Route::resource('asistensi',AsistensiController::class);
Route::post('delete-asistensi', [AsistensiController::class,'destroy']);
Route::get('asistensi/kirim/{id}', [AsistensiController::class, 'kirim'])->name('asistensi.kirim');

//Route Kategoti MBKM
Route::resource('kategorimbkm',KategorimbkmController::class);
Route::post('delete-kategorimbkm', [KategorimbkmController::class,'destroy']);
Route::get('kategorimbkm-search', [KategorimbkmController::class,'selectKategorimbkm']);

//Route Program MBKM
Route::resource('programmbkm',ProgrammbkmController::class);
Route::post('delete-programmbkm', [ProgrammbkmController::class,'destroy']);
Route::get('programmbkm-autocomplete-search', [ProgrammbkmController::class,'selectSearch']);
Route::get('programmbkm-search', [ProgrammbkmController::class,'selectProgrammbkm']);
