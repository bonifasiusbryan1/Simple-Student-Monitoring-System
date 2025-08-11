<?php

use App\Http\Controllers\GeneralController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\DosenWaliController;
use App\Http\Controllers\IRSController;
use App\Http\Controllers\KHSController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\PKLController;
use App\Http\Controllers\SkripsiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/', [LoginController::class, 'login']);
});

Route::get('/home', function(){
    return redirect('/dashboard');
});

Route::middleware(['auth'])->group(function () {
    //gantipassword
    Route::get('/gantipassword', [UserController::class, 'gantipassword']);
    Route::post('/gantipassword', [UserController::class, 'savepassword']);

    //dashboard
    Route::get('/dashboard', [GeneralController::class, 'dashboard']);

    Route::get('/dashboard/mahasiswa', [MahasiswaController::class, 'dashboard'])->middleware('userAkses:mahasiswa');

    Route::get('/dashboard/dosenwali', [DosenWaliController::class, 'dashboard'])->middleware('userAkses:dosenwali');
    
    Route::get('/dashboard/departemen', [DepartemenController::class, 'dashboard'])->middleware('userAkses:departemen');
    
    Route::get('/dashboard/operator', [OperatorController::class, 'dashboard'])->middleware('userAkses:operator');

    //profile
    Route::get('/profile', [GeneralController::class, 'profile']);
    
    Route::get('/profile/mahasiswa', [MahasiswaController::class, 'profile'])->middleware('userAkses:mahasiswa');

    Route::get('/profile/mahasiswa/{nim}', [OperatorController::class, 'op_profile'])->middleware('userAkses:operator');

    Route::get('/profile/dosenwali', [DosenWaliController::class, 'profile'])->middleware('userAkses:dosenwali');
    
    Route::get('/profile/departemen', [DepartemenController::class, 'profile'])->middleware('userAkses:departemen');
    
    Route::get('/profile/operator', [OperatorController::class, 'profile'])->middleware('userAkses:operator');

    //editprofile
    Route::get('/editprofile', [GeneralController::class, 'editprofile']);
    
    Route::get('/editprofile/mahasiswa', [MahasiswaController::class, 'editprofile'])->middleware('userAkses:mahasiswa');

    Route::get('/editprofile/mahasiswa/{nim}', [OperatorController::class, 'op_editprofile'])->middleware('userAkses:operator');

    Route::get('/editprofile/dosenwali', [DosenWaliController::class, 'editprofile'])->middleware('userAkses:dosenwali');
    
    Route::get('/editprofile/departemen', [DepartemenController::class, 'editprofile'])->middleware('userAkses:departemen');
    
    Route::get('/editprofile/operator', [OperatorController::class, 'editprofile'])->middleware('userAkses:operator');

    Route::post('/editprofile/mahasiswa', [MahasiswaController::class, 'saveprofile'])->middleware('userAkses:mahasiswa');

    Route::post('/editprofile/mahasiswa/{nim}', [OperatorController::class, 'op_saveprofile'])->middleware('userAkses:operator');

    Route::post('/editprofile/dosenwali', [DosenWaliController::class, 'saveprofile'])->middleware('userAkses:dosenwali');
    
    Route::post('/editprofile/departemen', [DepartemenController::class, 'saveprofile'])->middleware('userAkses:departemen');
    
    Route::post('/editprofile/operator', [OperatorController::class, 'saveprofile'])->middleware('userAkses:operator');

    //irs
    Route::get('/irs', [GeneralController::class, 'irs']);
    
    Route::get('/irs/mahasiswa', [MahasiswaController::class, 'editirs'])->middleware('userAkses:mahasiswa');

    Route::post('/irs/mahasiswa', [MahasiswaController::class, 'saveirs'])->middleware('userAkses:mahasiswa');

    Route::get('/verifikasi/irs', [IRSController::class, 'irs'])->middleware('userAkses:dosenwali,operator');

    //khs
    Route::get('/khs', [GeneralController::class, 'khs']);
    
    Route::get('/khs/mahasiswa', [MahasiswaController::class, 'editkhs'])->middleware('userAkses:mahasiswa');

    Route::post('/khs/mahasiswa', [MahasiswaController::class, 'savekhs'])->middleware('userAkses:mahasiswa');

    Route::get('/verifikasi/khs', [KHSController::class, 'khs'])->middleware('userAkses:dosenwali,operator');

    //pkl
    Route::get('/pkl', [GeneralController::class, 'pkl']);
    
    Route::get('/pkl/mahasiswa', [MahasiswaController::class, 'editpkl'])->middleware('userAkses:mahasiswa');

    Route::post('/pkl/mahasiswa', [MahasiswaController::class, 'savepkl'])->middleware('userAkses:mahasiswa');

    Route::get('/verifikasi/pkl', [PKLController::class, 'pkl'])->middleware('userAkses:dosenwali,operator');

    //skripsi
    Route::get('/skripsi', [GeneralController::class, 'skripsi']);
    
    Route::get('/skripsi/mahasiswa', [MahasiswaController::class, 'editskripsi'])->middleware('userAkses:mahasiswa');

    Route::post('/skripsi/mahasiswa', [MahasiswaController::class, 'saveskripsi'])->middleware('userAkses:mahasiswa');

    Route::get('/verifikasi/skripsi', [SkripsiController::class, 'skripsi'])->middleware('userAkses:dosenwali,operator');

    //generate akun
    Route::get('/generate/akunmahasiswa', [OperatorController::class, 'generateakun'])->middleware('userAkses:operator');

    Route::post('/generate/akunmahasiswa/satuakun', [OperatorController::class, 'generatesatuakun'])->middleware('userAkses:operator');

    Route::post('/generate/akunmahasiswa/semuaakun', [OperatorController::class, 'generatesemuaakun'])->middleware('userAkses:operator');

    //entry progres studi
    Route::get('/entry/progresstudi', [OperatorController::class, 'entryprogresstudi'])->middleware('userAkses:operator');

    Route::get('/entry/irs/{nim}', [OperatorController::class, 'entryirs'])->middleware('userAkses:operator');

    Route::post('/entry/irs/{nim}', [OperatorController::class, 'entrysaveirs'])->middleware('userAkses:operator');
    
    Route::get('/entry/khs/{nim}', [OperatorController::class, 'entrykhs'])->middleware('userAkses:operator');

    Route::post('/entry/khs/{nim}', [OperatorController::class, 'entrysavekhs'])->middleware('userAkses:operator');

    Route::get('/entry/pkl/{nim}', [OperatorController::class, 'entrypkl'])->middleware('userAkses:operator');

    Route::post('/entry/pkl/{nim}', [OperatorController::class, 'entrysavepkl'])->middleware('userAkses:operator');

    Route::get('/entry/skripsi/{nim}', [OperatorController::class, 'entryskripsi'])->middleware('userAkses:operator');

    Route::post('/entry/skripsi/{nim}', [OperatorController::class, 'entrysaveskripsi'])->middleware('userAkses:operator');

    //verifikasi
        //irs
    Route::get('/verifikasi/irs/{nim}/{semester}', [IRSController::class, 'verifikasiirs'])->middleware('userAkses:dosenwali,operator');

    Route::get('/batalverifikasi/irs/{nim}/{semester}', [IRSController::class, 'batalverifikasiirs'])->middleware('userAkses:dosenwali,operator');

    Route::post('/verifikasi/irs/{nim}', [IRSController::class, 'verifikasisaveirs'])->middleware('userAkses:dosenwali,operator');
    
    Route::get('/verifikasi/edit/irs/{nim}/{semester}', [IRSController::class, 'verifikasieditirs'])->middleware('userAkses:dosenwali,operator');

        //khs
    Route::get('/verifikasi/khs/{nim}/{semester}', [KHSController::class, 'verifikasikhs'])->middleware('userAkses:dosenwali,operator');

    Route::get('/batalverifikasi/khs/{nim}/{semester}', [KHSController::class, 'batalverifikasikhs'])->middleware('userAkses:dosenwali,operator');

    Route::post('/verifikasi/khs/{nim}', [KHSController::class, 'verifikasisavekhs'])->middleware('userAkses:dosenwali,operator');
    
    Route::get('/verifikasi/edit/khs/{nim}/{semester}', [KHSController::class, 'verifikasieditkhs'])->middleware('userAkses:dosenwali,operator');

        //pkl
    Route::get('/verifikasi/pkl/{nim}', [PKLController::class, 'verifikasipkl'])->middleware('userAkses:dosenwali,operator');

    Route::get('/batalverifikasi/pkl/{nim}', [PKLController::class, 'batalverifikasipkl'])->middleware('userAkses:dosenwali,operator');

    Route::post('/verifikasi/pkl/{nim}', [PKLController::class, 'verifikasisavepkl'])->middleware('userAkses:dosenwali,operator');
    
    Route::get('/verifikasi/edit/pkl/{nim}', [PKLController::class, 'verifikasieditpkl'])->middleware('userAkses:dosenwali,operator');

        //skripsi
    Route::get('/verifikasi/skripsi/{nim}', [SkripsiController::class, 'verifikasiskripsi'])->middleware('userAkses:dosenwali,operator');

    Route::get('/batalverifikasi/skripsi/{nim}', [SkripsiController::class, 'batalverifikasiskripsi'])->middleware('userAkses:dosenwali,operator');

    Route::post('/verifikasi/skripsi/{nim}', [SkripsiController::class, 'verifikasisaveskripsi'])->middleware('userAkses:dosenwali,operator');
    
    Route::get('/verifikasi/edit/skripsi/{nim}', [SkripsiController::class, 'verifikasieditskripsi'])->middleware('userAkses:dosenwali,operator');

    //progres studi
    Route::get('/progresstudi', [GeneralController::class, 'progresstudi'])->middleware('userAkses:dosenwali,departemen,operator');

    //export file
    Route::get('/exportexcel/mhs', [OperatorController::class, 'exportExcel']);

    Route::get('/export/fileirs/{nim}/{semester}', [IRSController::class, 'exportIRS']);

    Route::get('/export/filekhs/{nim}/{semester}', [KHSController::class, 'exportKHS']);

    Route::get('/export/filepkl/{nim}', [PKLController::class, 'exportPKL']);

    Route::get('/export/fileskripsi/{nim}', [SkripsiController::class, 'exportSkripsi']);

    //logout
    Route::get('/logout', [LoginController::class, 'logout']);

    //reset password
    Route::get('/reset/akunmahasiswa/{nim}', [OperatorController::class, 'resetPassword'])->middleware('userAkses:operator');

    //Hapus Akun
    Route::get('/hapus/akunmahasiswa/{nim}', [OperatorController::class, 'deleteAkun'])->middleware('userAkses:operator');

    //Pencarian
    Route::get('/cari/akunmahasiswa', [OperatorController::class, 'carimahasiswa'])->middleware('userAkses:operator');

    Route::get('/verifikasi/cari/{page}', [GeneralController::class, 'carimahasiswa'])->middleware('userAkses:dosenwali,operator');

    Route::get('/progresstudi/cari/{page}', [GeneralController::class, 'carimahasiswa'])->middleware('userAkses:dosenwali,departemen,operator');

    Route::get('/rekap/cari/{page}', [GeneralController::class, 'carimahasiswa'])->middleware('userAkses:dosenwali,departemen,operator');

    //rekap
    Route::get('/rekap/mahasiswa', [GeneralController::class, 'rekapmhs'])->middleware('userAkses:dosenwali,departemen,operator');

    Route::get('/rekap/mahasiswa/pkl', [GeneralController::class, 'rekappkl'])->middleware('userAkses:dosenwali,departemen,operator');

    Route::get('/rekap/mahasiswa/skripsi', [GeneralController::class, 'rekapskripsi'])->middleware('userAkses:dosenwali,departemen,operator');

    Route::get('/rekap/mahasiswa/status', [GeneralController::class, 'rekapstatus'])->middleware('userAkses:dosenwali,departemen,operator');

    Route::get('/cetak/rekap/pkl', [GeneralController::class, 'exportPDFRekapPKL'])->middleware('userAkses:dosenwali,departemen,operator');

    Route::get('/cetak/rekap/skripsi', [GeneralController::class, 'exportPDFRekapSkripsi'])->middleware('userAkses:dosenwali,departemen,operator');

    Route::get('/cetak/rekap/status', [GeneralController::class, 'exportPDFRekapStatus'])->middleware('userAkses:dosenwali,departemen,operator');

    Route::get('/cetak/rekap/mahasiswa/{angkatan}/{status}', [GeneralController::class, 'exportPDFRekapMahasiswa'])->middleware('userAkses:dosenwali,departemen,operator');

    //list
    Route::get('/list/pkl/{angkatan}/belum', [GeneralController::class, 'listbelumpkl'])->middleware('userAkses:dosenwali,departemen,operator');

    Route::get('/list/pkl/{angkatan}/sudah', [GeneralController::class, 'listsudahpkl'])->middleware('userAkses:dosenwali,departemen,operator');

    Route::get('/list/skripsi/{angkatan}/belum', [GeneralController::class, 'listbelumskripsi'])->middleware('userAkses:dosenwali,departemen,operator');

    Route::get('/list/skripsi/{angkatan}/sudah', [GeneralController::class, 'listsudahskripsi'])->middleware('userAkses:dosenwali,departemen,operator');
    
    Route::get('/list/status/{angkatan}/{listStatus}', [GeneralController::class, 'liststatus'])->middleware('userAkses:dosenwali,departemen,operator');

    Route::get('/cetak/list/pkl/{angkatan}/{listStatus}', [GeneralController::class, 'exportPDFListPKL'])->middleware('userAkses:dosenwali,departemen,operator');

    Route::get('/cetak/list/skripsi/{angkatan}/{listStatus}', [GeneralController::class, 'exportPDFListSkripsi'])->middleware('userAkses:dosenwali,departemen,operator');

    Route::get('/cetak/list/status/{angkatan}/{listStatus}', [GeneralController::class, 'exportPDFListStatus'])->middleware('userAkses:dosenwali,departemen,operator');

});
