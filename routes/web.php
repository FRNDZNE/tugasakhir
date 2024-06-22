<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;


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

    Route::prefix('account')->group(function(){
        
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




