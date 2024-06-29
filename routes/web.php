<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\YearController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\UserController;




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
        return redirect()->route('mahasiswa.dashboard');
    }
})->middleware('auth');

Route::prefix('superadmin')->middleware(['auth','role:superadmin'])->group(function(){
    Route::get('/dashboard',[HomeController::class, 'index'])->name('superadmin.dashboard');

    // CRUD untuk Jurusan dan Prodi
    Route::prefix('jurusan')->group(function(){
        Route::get('/',[JurusanController::class,'index'])->name('superadmin.jurusan.index');
        Route::post('/store',[JurusanController::class,'store'])->name('superadmin.jurusan.store');
        Route::post('/update',[JurusanController::class,'update'])->name('superadmin.jurusan.update');
        Route::delete('/delete/{jurusan}',[JurusanController::class,'delete'])->name('superadmin.jurusan.delete');

        Route::prefix('{jurusan}')->group(function(){
            Route::get('/',[ProdiController::class,'index'])->name('superadmin.prodi.index');
            Route::post('/store',[ProdiController::class,'store'])->name('superadmin.prodi.store');
            Route::post('/update',[ProdiController::class,'update'])->name('superadmin.prodi.update');
            Route::delete('/delete/{prodi}',[ProdiController::class,'delete'])->name('superadmin.prodi.delete');
        });
    });

    // CRUD untuk Tahun dan Periode Magang
    Route::prefix('year')->group(function(){
        Route::get('/',[YearController::class,'index'])->name('superadmin.year.index');
        Route::post('/store',[YearController::class,'store'])->name('superadmin.year.store');
        Route::post('/update',[YearController::class,'update'])->name('superadmin.year.update');
        Route::delete('/delete/{year}',[YearController::class,'delete'])->name('superadmin.year.delete');

        Route::prefix('{year}')->group(function(){
            Route::get('/',[PeriodController::class,'index'])->name('superadmin.period.index');
            Route::post('/store',[PeriodController::class,'store'])->name('superadmin.period.store');
            Route::post('/update',[PeriodController::class,'update'])->name('superadmin.period.update');
            Route::delete('/delete/{period}',[PeriodController::class,'delete'])->name('superadmin.period.delete');
        });
    });

    // CRUD untuk Penilaian
    Route::prefix('scores')->group(function(){
        Route::get('/',[ScoreController::class,'index'])->name('superadmin.score.index');
        Route::post('/store',[ScoreController::class,'store'])->name('superadmin.score.store');
        Route::post('/update',[ScoreController::class,'update'])->name('superadmin.score.update');
        Route::delete('/delete/{score}',[ScoreController::class,'delete'])->name('superadmin.score.delete');

    });

    Route::prefix('account')->group(function(){
        Route::prefix('admin')->group(function(){
            Route::get('/',[UserController::class,'index_admin'])->name('superadmin.user.admin.index');
            Route::post('/store',[UserController::class,'store_admin'])->name('superadmin.user.admin.store');
            Route::post('/update',[UserController::class,'update_admin'])->name('superadmin.user.admin.update');
            Route::delete('/delete/{id}',[UserController::class,'delete'])->name('superadmin.user.admin.delete');
        });
        Route::prefix('staff')->group(function(){
            Route::get('/',[UserController::class,'index_staff'])->name('superadmin.user.staff.index');
            Route::post('/store',[UserController::class,'store_staff'])->name('superadmin.user.staff.store');
            Route::post('/update',[UserController::class,'update_staff'])->name('superadmin.user.staff.update');
            Route::delete('/delete/{id}',[UserController::class,'delete'])->name('superadmin.user.staff.delete');
        });
        Route::prefix('agency')->group(function(){
            Route::get('/',[UserController::class,'index_agency'])->name('superadmin.user.agency.index');
            Route::post('/store',[UserController::class,'store_agency'])->name('superadmin.user.agency.store');
            Route::post('/update',[UserController::class,'update_agency'])->name('superadmin.user.agency.update');
            Route::delete('/delete/{id}',[UserController::class,'delete'])->name('superadmin.user.agency.delete');
        });
        Route::prefix('mentor')->group(function(){
                Route::get('/',[UserController::class,'index_mentor'])->name('superadmin.user.mentor.index');
                Route::post('/store',[UserController::class,'store_mentor'])->name('superadmin.user.mentor.store');
                Route::post('/update',[UserController::class,'update_mentor'])->name('superadmin.user.mentor.update');
                Route::delete('/delete/{id}',[UserController::class,'delete'])->name('superadmin.user.mentor.delete');
            });
        Route::prefix('dosen')->group(function(){
            Route::get('/',[UserController::class,'index_dosen'])->name('superadmin.user.dosen.index');
            Route::post('/store',[UserController::class,'store_dosen'])->name('superadmin.user.dosen.store');
            Route::post('/update',[UserController::class,'update_dosen'])->name('superadmin.user.dosen.update');
            Route::delete('/delete/{id}',[UserController::class,'delete'])->name('superadmin.user.dosen.delete');
        });
        Route::prefix('mahasiswa')->group(function(){
            Route::get('/',[UserController::class,'index_mahasiswa'])->name('superadmin.user.mahasiswa.index');
            Route::post('/store',[UserController::class,'store_mahasiswa'])->name('superadmin.user.mahasiswa.store');
            Route::post('/update',[UserController::class,'update_mahasiswa'])->name('superadmin.user.mahasiswa.update');
            Route::delete('/delete/{id}',[UserController::class,'delete'])->name('superadmin.user.mahasiswa.delete');
        });
    });
});

Route::prefix('admin')->middleware(['auth','role:admin'])->group(function(){
    Route::get('/dashboard',[HomeController::class, 'index'])->name('admin.dashboard');
});

Route::prefix('staff')->middleware(['auth','role:staff'])->group(function(){
    Route::get('/dashboard',[HomeController::class, 'index'])->name('staff.dashboard');
});

Route::prefix('agency')->middleware(['auth','role:agency'])->group(function(){
    Route::get('/dashboard',[HomeController::class, 'index'])->name('agency.dashboard');
});

Route::prefix('mentor')->middleware(['auth','role:mentor'])->group(function(){
    Route::get('/dashboard',[HomeController::class, 'index'])->name('mentor.dashboard');
});

Route::prefix('dosen')->middleware(['auth','role:dosen'])->group(function(){
    Route::get('/dashboard',[HomeController::class, 'index'])->name('dosen.dashboard');
});

Route::prefix('mahasiswa')->middleware(['auth','role:mahasiswa'])->group(function(){
    Route::get('/dashboard',[HomeController::class, 'index'])->name('mahasiswa.dashboard');
});




