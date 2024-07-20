<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\YearController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuotaController;
use App\Http\Controllers\UserAdminController;
use App\Http\Controllers\UserStaffController;
use App\Http\Controllers\UserAgencyController;
use App\Http\Controllers\UserMentorController;
use App\Http\Controllers\UserDosenController;
use App\Http\Controllers\UserMahasiswaController;
use App\Http\Controllers\MagangController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\ReportController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('firstpage')->middleware('guest');


// Auth::routes();
Auth::routes([
    'register' => false,
]);
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// routing untuk redirect setelah user login menuju halaman dashboard
Route::get('/home', function(){
    if (Auth::user()->role->name == 'superadmin') {
        return redirect()->route('superadmin.dashboard');
    } elseif (Auth::user()->role->name == 'admin') {
        return redirect()->route('admin.dashboard');
    } else if (Auth::user()->role->name == 'staff') {
        return redirect()->route('staff.dashboard');
    } else if (Auth::user()->role->name == 'agency') {
        return redirect()->route('agency.dashboard');
    } else if (Auth::user()->role->name == 'mentor') {
        return redirect()->route('mentor.dashboard');
    } else if (Auth::user()->role->name == 'dosen') {
        return redirect()->route('dosen.dashboard');
    } else if (Auth::user()->role->name == 'mahasiswa') {
        if (Auth::user()->mahasiswa->status == true) {
            return redirect()->route('mahasiswa.dashboard');
        } else {
            return redirect()->route('mahasiswa.forbidden');
        }
    }
})->middleware('auth');

Route::get('mahasiswa/forbidden',function(){
    return view('layouts.forbidden');
})->name('mahasiswa.forbidden');

$roles = ['superadmin', 'admin', 'staff', 'agency', 'mentor', 'dosen', 'mahasiswa'];
foreach ($roles as $role) {
    Route::prefix($role)->middleware(['auth', "role:$role"])->group(function () use ($role) {
        Route::get('/dashboard', [HomeController::class, 'index'])->name("$role.dashboard");
    });
}
// CRUD Jurusan dan Prsodi
Route::prefix('jurusan')->group(function(){
    Route::get('/',[JurusanController::class,'index'])->name('jurusan.index');
    Route::post('/store',[JurusanController::class,'store'])->name('jurusan.store');
    Route::delete('/delete/{jurusan}',[JurusanController::class,'delete'])->name('jurusan.delete');
});

Route::prefix('jurusan/{jurusan}')->middleware(['auth','role:superadmin,admin'])->group(function(){
    Route::get('/',[ProdiController::class,'index'])->name('prodi.index');
    Route::post('/store',[ProdiController::class,'store'])->name('prodi.store');
    Route::delete('/delete/{prodi}',[ProdiController::class,'delete'])->name('prodi.delete');
});

Route::prefix('year')->group(function(){
    Route::get('/',[YearController::class,'index'])->name('year.index');
    Route::post('/store',[YearController::class,'store'])->name('year.store');
    Route::delete('/delete/{year}',[YearController::class,'delete'])->name('year.delete');

    Route::prefix('{year}')->group(function(){
        Route::get('/',[PeriodController::class,'index'])->name('period.index');
        Route::post('/store',[PeriodController::class,'store'])->name('period.store');
        Route::delete('/delete/{period}',[PeriodController::class,'delete'])->name('period.delete');
    });
});

Route::prefix('scores')->group(function(){
    Route::get('/menu',[ScoreController::class,'menu'])->name('score.menu');
    Route::get('/{prodi}',[ScoreController::class,'index'])->name('score.index');
    Route::post('/store',[ScoreController::class,'store'])->name('score.store');
    Route::delete('/delete/{score}',[ScoreController::class,'delete'])->name('score.delete');
});

// CRUD ACCOUNT

Route::prefix('account')->group(function(){
    Route::prefix('admin')->group(function(){
        Route::get('/',[UserAdminController::class,'index'])->name('user.admin.index');
        Route::post('/store',[UserAdminController::class,'store'])->name('user.admin.store');
        Route::post('/update',[UserAdminController::class,'update'])->name('user.admin.update');
    });
    Route::prefix('staff')->group(function(){
        Route::get('/',[UserStaffController::class,'index'])->name('user.staff.index');
        Route::post('/store',[UserStaffController::class,'store'])->name('user.staff.store');
        Route::post('/update',[UserStaffController::class,'update'])->name('user.staff.update');
    });
    Route::prefix('agency')->group(function(){
        Route::get('/',[UserAgencyController::class,'index'])->name('user.agency.index');
        Route::post('/store',[UserAgencyController::class,'store'])->name('user.agency.store');
        Route::post('/update',[UserAgencyController::class,'update'])->name('user.agency.update');
    });
    Route::prefix('mentor/{agency}')->group(function(){
        Route::get('/',[UserMentorController::class,'index'])->name('user.mentor.index');
        Route::post('/store',[UserMentorController::class,'store'])->name('user.mentor.store');
        Route::post('/update',[UserMentorController::class,'update'])->name('user.mentor.update');
    });
    Route::prefix('dosen')->group(function(){
        Route::get('/',[UserDosenController::class,'index'])->name('user.dosen.index');
        Route::post('/store',[UserDosenController::class,'store'])->name('user.dosen.store');
        Route::post('/update',[UserDosenController::class,'update'])->name('user.dosen.update');
    });
    Route::prefix('/mahasiswa')->group(function(){
        Route::get('/menu',[UserMahasiswaController::class,'menu'])->name('user.mahasiswa.menu');
        Route::get('/{prodi}',[UserMahasiswaController::class,'index'])->name('user.mahasiswa.index');
        Route::post('/store',[UserMahasiswaController::class,'store'])->name('user.mahasiswa.store');
        Route::post('/update',[UserMahasiswaController::class,'update'])->name('user.mahasiswa.update');
        Route::post('/enabled/{id}',[UserMahasiswaController::class,'enabled'])->name('user.mahasiswa.enabled');
        Route::post('/disabled/{id}',[UserMahasiswaController::class,'disabled'])->name('user.mahasiswa.disabled');
    });

    Route::get('/profiles', [ProfileController::class,'index'])->name('user.profile');
});

Route::prefix('quota/{agency}')->group(function(){
    Route::get('/',[QuotaController::class,'index'])->name('quota.index');
    Route::post('/store-update',[QuotaController::class,'store'])->name('quota.store');
});

// Hapus Akun Untuk Semua Role

Route::delete('/users/delete/{id}',[UserController::class,'delete'])->name('user.delete');

// Daftar Magang
Route::middleware(['auth','role:mahasiswa'])->prefix('mahasiswa/magang')->group(function(){
    Route::get('list-mitra',[MagangController::class,'index'])->name('mahasiswa.magang.index');
    Route::post('apply',[MagangController::class,'apply'])->name('mahasiswa.magang.apply');
    Route::get('my-intern',[MagangController::class,'myIntern'])->name('mahasiswa.magang.detail');

    // Creating Logbook
    Route::prefix('logbook')->group(function(){
        Route::get('my-logbook',[LogbookController::class,'index'])->name('mahasiswa.logbook.index');
        Route::post('store',[LogbookController::class,'store'])->name('mahasiswa.logbook.store');
        Route::delete('delete/{id}',[LogbookController::class,'delete'])->name('mahasiswa.logbook.delete');
    });

    Route::prefix('laporan-akhir')->group(function(){
        Route::get('/',[ReportController::class,'index'])->name('mahasiswa.report.index');
        Route::post('/store',[ReportController::class,'store'])->name('mahasiswa.report.store');
        Route::post('/update',[ReportController::class,'update'])->name('mahasiswa.report.update');
        Route::delete('/delete/{id}',[ReportController::class,'delete'])->name('mahasiswa.report.delete');
    });


});






