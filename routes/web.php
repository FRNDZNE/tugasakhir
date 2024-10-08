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
use App\Http\Controllers\AsistensiController;
use App\Http\Controllers\SeleksiController;
use App\Http\Controllers\DospemController;
use App\Http\Controllers\BimbinganController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\ScoreValueController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;


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
    } else if (Auth::user()->role->name == 'admin') {
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
Route::get('mahasiswa/forbidden',function(){
    return view('layouts.forbidden');
})->name('mahasiswa.forbidden');
$roles = ['superadmin', 'admin', 'staff', 'agency', 'mentor', 'dosen', 'mahasiswa'];
foreach ($roles as $role) {
    Route::prefix($role)->middleware(['auth', "role:$role"])->group(function () use ($role) {
        // Route::get('/dashboard', [HomeController::class, '$role'])->name("$role.dashboard");
        Route::get('dashboard', function() use ($role){
            $controller = app(HomeController::class);
            $method = $role;
            return $controller->$method();
        })->name("$role.dashboard");
        Route::get('/notification',[NotificationController::class,'index'])->name("notification.$role");
        Route::get('/profile',[ProfileController::class,'index'])->name("profile.$role");
        Route::post('/profile/update',[ProfileController::class,'update'])->name("update.$role");
    });
}

// Read Notifikasi
Route::get('mark-read-all',[NotificationController::class,'markAsRead'])->name('markAll');
Route::get('mark-read-by-id/{id}',[NotificationController::class,'markAsReadById'])->name('markId');
// CRUD Jurusan dan Prsodi
Route::prefix('jurusan')->middleware(['auth','role:superadmin'])->group(function(){
    Route::get('/',[JurusanController::class,'index'])->name('jurusan.index');
    Route::post('/store',[JurusanController::class,'store'])->name('jurusan.store');
    Route::delete('/delete/{jurusan}',[JurusanController::class,'delete'])->name('jurusan.delete');
});
Route::prefix('jurusan/{jurusan}')->middleware(['auth','role:superadmin,admin'])->group(function(){
    Route::get('/',[ProdiController::class,'index'])->name('prodi.index');
    Route::post('/store',[ProdiController::class,'store'])->name('prodi.store');
    Route::delete('/delete/{prodi}',[ProdiController::class,'delete'])->name('prodi.delete');
});
Route::prefix('year')->middleware(['auth','role:superadmin,admin,staff'])->group(function(){
    Route::get('/',[YearController::class,'index'])->name('year.index');
    Route::post('/store',[YearController::class,'store'])->name('year.store');
    Route::delete('/delete/{year}',[YearController::class,'delete'])->name('year.delete');

    Route::prefix('{year}')->group(function(){
        Route::get('/',[PeriodController::class,'index'])->name('period.index');
        Route::post('/store',[PeriodController::class,'store'])->name('period.store');
        Route::delete('/delete/{period}',[PeriodController::class,'delete'])->name('period.delete');
    });
});
Route::prefix('scores')->middleware(['auth','role:superadmin,admin,staff'])->group(function(){
    Route::get('/menu',[ScoreController::class,'menu'])->name('score.menu');
    Route::get('/{prodi}',[ScoreController::class,'index'])->name('score.index');
    Route::post('/store',[ScoreController::class,'store'])->name('score.store');
    Route::delete('/delete/{score}',[ScoreController::class,'delete'])->name('score.delete');
});
// CRUD ACCOUNT
Route::prefix('account')->group(function(){
    Route::prefix('admin')->middleware(['auth','role:superadmin'])->group(function(){
        Route::get('/',[UserAdminController::class,'index'])->name('user.admin.index');
        Route::post('/store',[UserAdminController::class,'store'])->name('user.admin.store');
        Route::post('/update',[UserAdminController::class,'update'])->name('user.admin.update');
        Route::post('import',[UserAdminController::class,'import'])->name('user.admin.import');
    });
    Route::prefix('staff')->middleware(['auth','role:superadmin,admin'])->group(function(){
        Route::get('/',[UserStaffController::class,'index'])->name('user.staff.index');
        Route::post('/store',[UserStaffController::class,'store'])->name('user.staff.store');
        Route::post('/update',[UserStaffController::class,'update'])->name('user.staff.update');
        Route::post('/import',[UserStaffController::class,'import'])->name('user.staff.import');

    });
    Route::prefix('agency')->middleware(['auth','role:superadmin,admin'])->group(function(){
        Route::get('/',[UserAgencyController::class,'index'])->name('user.agency.index');
        Route::post('/store',[UserAgencyController::class,'store'])->name('user.agency.store');
        Route::post('/update',[UserAgencyController::class,'update'])->name('user.agency.update');
        Route::post('import',[UserAgencyController::class,'import'])->name('user.agency.import');
    });
    Route::prefix('mentor/{agency}')->middleware(['auth','role:superadmin,admin,agency'])->group(function(){
        Route::get('/',[UserMentorController::class,'index'])->name('user.mentor.index');
        Route::post('/store',[UserMentorController::class,'store'])->name('user.mentor.store');
        Route::post('/update',[UserMentorController::class,'update'])->name('user.mentor.update');
        Route::post('/import/{id}',[UserMentorController::class,'import'])->name('user.mentor.import');
    });
    Route::prefix('dosen')->group(function(){
        Route::get('/',[UserDosenController::class,'index'])->name('user.dosen.index');
        Route::post('/store',[UserDosenController::class,'store'])->name('user.dosen.store');
        Route::post('/update',[UserDosenController::class,'update'])->name('user.dosen.update');
        Route::post('/import',[UserDosenController::class,'import'])->name('user.dosen.import');
    });
    Route::prefix('/mahasiswa')->group(function(){
        Route::get('/menu',[UserMahasiswaController::class,'menu'])->name('user.mahasiswa.menu');
        Route::get('/{prodi}',[UserMahasiswaController::class,'index'])->name('user.mahasiswa.index');
        Route::post('/store',[UserMahasiswaController::class,'store'])->name('user.mahasiswa.store');
        Route::post('/update',[UserMahasiswaController::class,'update'])->name('user.mahasiswa.update');
        Route::post('/enabled/{id}',[UserMahasiswaController::class,'enabled'])->name('user.mahasiswa.enabled');
        Route::post('/disabled/{id}',[UserMahasiswaController::class,'disabled'])->name('user.mahasiswa.disabled');
        Route::post('/import',[UserMahasiswaController::class,'import'])->name('user.mahasiswa.import');
    });
    // Hapus Akun Untuk Semua Role
    Route::delete('/users/delete/{id}',[UserController::class,'delete'])->name('user.delete');

});
Route::prefix('quota/{agency}')->group(function(){
    Route::get('/',[QuotaController::class,'index'])->name('quota.index');
    Route::post('/store-update',[QuotaController::class,'store'])->name('quota.store');
});
// Route Mahasiswa
Route::middleware(['auth','role:mahasiswa','access:active'])->prefix('mahasiswa/magang')->group(function(){
    Route::get('list-mitra',[MagangController::class,'index'])->name('mahasiswa.magang.index');
    Route::post('apply',[MagangController::class,'apply'])->name('mahasiswa.magang.apply');
    Route::post('cancel',[MagangController::class,'cancel'])->name('mahasiswa.magang.cancel');
    Route::get('my-intern',[MagangController::class,'myIntern'])->name('mahasiswa.magang.detail');
    Route::get('nilai-akhir',[MagangController::class,'score_value'])->name('mahasiswa.magang.nilai');
    // Creating Logbook
    Route::prefix('logbook')->group(function(){
        Route::get('/',[LogbookController::class,'index'])->name('mahasiswa.logbook.index');
        Route::post('store',[LogbookController::class,'store'])->name('mahasiswa.logbook.store');
        Route::delete('delete/{logbook}',[LogbookController::class,'delete'])->name('mahasiswa.logbook.delete');

        Route::prefix('image/{logbook}')->group(function(){
            Route::get('/',[LogbookController::class,'index_image'])->name('logbook.image.index');
            Route::post('/store',[LogbookController::class,'store_image'])->name('logbook.image.store');
            Route::post('/update',[LogbookController::class,'update_image'])->name('logbook.image.update');
            Route::delete('/delete/{image}',[LogbookController::class,'delete_image'])->name('logbook.image.delete');
        });
    });
    // Asistensi
    Route::prefix('assistance')->group(function(){
        Route::get('/',[AsistensiController::class,'index'])->name('mahasiswa.asistensi.index');
        Route::post('store',[AsistensiController::class,'store'])->name('mahasiswa.asistensi.store');
        Route::delete('delete/{id}',[AsistensiController::class,'delete'])->name('mahasiswa.asistensi.delete');
    });
    // Absensi
    Route::prefix('absensi')->group(function(){
        Route::get('/',[AbsensiController::class,'index'])->name('mahasiswa.absensi.index');
        Route::post('/store',[AbsensiController::class,'store'])->name('mahasiswa.absensi.store');
    });
    // Final Submission
    Route::prefix('laporan-akhir')->group(function(){
        Route::get('/',[ReportController::class,'index'])->name('mahasiswa.report.index');
        Route::post('/store',[ReportController::class,'store'])->name('mahasiswa.report.store');
        Route::post('/update',[ReportController::class,'update'])->name('mahasiswa.report.update');
        // Route::delete('/delete/{id}',[ReportController::class,'delete'])->name('mahasiswa.report.delete');
    });
    Route::get('/history',[MagangController::class,'history'])->name('mahasiswa.history');
});
// Route Agency dan mentor
Route::prefix('mitra')->middleware(['auth','role:agency,mentor'])->group(function(){
    Route::prefix('magang')->group(function(){
        // Profile Mahasiswa
        Route::prefix('profile-mahasiswa/{intern}')->group(function(){
            Route::get('/',[SeleksiController::class,'profile'])->name('agency.profile.mahasiswa');
            Route::get('/absensi',[AbsensiController::class,'absen_mahasiswa'])->name('agency.absensi.mahasiswa');
            Route::post('/absensi/store',[AbsensiController::class,'absen_store'])->name('agency.absensi.store');
            Route::get('/logbook',[LogbookController::class,'index_mahasiswa'])->name('agency.logbook.mahasiswa');
            Route::get('/logbook/{log}',[LogbookController::class,'index_image_mahasiswa'])->name('agency.logimage.mahasiswa');
            Route::get('/report',[ReportController::class,'report'])->name('agency.report.mahasiswa');
            Route::get('/score',[ScoreValueController::class,'index'])->name('agency.score.mahasiswa');
            Route::post('/score/store',[ScoreValueController::class,'store'])->name('agency.score.store');
        });
        Route::get('/',[SeleksiController::class,'index_year'])->name('agency.select.year');
        Route::get('/{year}',[SeleksiController::class,'index_period'])->name('agency.select.period');
        Route::prefix('{year}/{period}')->group(function(){
            Route::get('/',[SeleksiController::class,'index'])->name('agency.select.intern');
            Route::middleware('role:agency')->group(function(){
                Route::post('/proses',[SeleksiController::class,'proses'])->name('agency.proses');
                Route::post('/terima',[SeleksiController::class,'terima'])->name('agency.terima');
                Route::post('/tolak',[SeleksiController::class,'tolak'])->name('agency.tolak');
                Route::post('/restore',[SeleksiController::class,'restore'])->name('agency.restore');
                Route::post('/mentor',[SeleksiController::class,'mentor'])->name('agency.mentor');
            });
        });

    });

});
// Route Staff Prodi
Route::prefix('staff')->middleware(['auth','role:staff'])->group(function(){
    Route::prefix('magang')->group(function(){
        Route::get('/',[DospemController::class,'index_year'])->name('staff.select.year');
        Route::get('/{year}',[DospemController::class,'index_period'])->name('staff.select.period');
        Route::prefix('{year}/{period}')->group(function(){
            Route::get('/',[DospemController::class,'index'])->name('staff.select.intern');
            Route::post('/pilih-dospem',[DospemController::class,'store_dospem'])->name('staff.select.dospem');
        });
    });
});
// Route Dosen
Route::prefix('dosen')->middleware(['auth','role:dosen'])->group(function(){
    Route::prefix('bimbingan')->group(function(){
        Route::prefix('mahasiswa')->group(function(){
            Route::prefix('{intern}')->group(function(){
                Route::get('/',[BimbinganController::class,'detail'])->name('dosen.bimbingan.detail');
                Route::get('/asistensi',[AsistensiController::class,'asistensi'])->name('dosen.bimbingan.asistensi');
                Route::post('/asistensi/confirmed',[AsistensiController::class,'confirmed'])->name('dosen.asistensi.confirmed');
                Route::post('/asistensi/unconfirmed',[AsistensiController::class,'unconfirmed'])->name('dosen.asistensi.unconfirmed');
                Route::get('/absensi',[AbsensiController::class,'absen_mahasiswa'])->name('dosen.bimbingan.absensi');
                Route::get('/logbook',[LogbookController::class,'index_mahasiswa'])->name('dosen.bimbingan.logbook');
                Route::get('/logbook/{log}',[LogbookController::class,'index_image_mahasiswa'])->name('dosen.bimbingan.logimage');
                Route::get('/report',[ReportController::class,'report'])->name('dosen.bimbingan.report');
                Route::get('/score',[ScoreValueController::class,'index'])->name('dosen.bimbingan.score');
            });
        });
        Route::get('/',[BimbinganController::class,'index_year'])->name('dosen.bimbingan.year');
        Route::get('/{year}',[BimbinganController::class,'index_period'])->name('dosen.bimbingan.period');
        Route::get('{year}/{period}',[BimbinganController::class,'index'])->name('dosen.bimbingan.intern');
        // Route Detail Mahasiswa Bimbingan
    });
});







