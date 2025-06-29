<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Auth\guru_bk\StudentController;
use App\Http\Controllers\Auth\guru_bk\CounselingScheduleController;
use App\Http\Controllers\Auth\guru_bk\KMeansController;
use App\Http\Controllers\Auth\guru_bk\KNNController;
use App\Http\Controllers\Auth\guru_bk\DashboardController;
use App\Http\Controllers\Auth\guru_bk\CallLetterController;
use App\Http\Controllers\Auth\guru_bk\ViolationController;
use App\Http\Controllers\Auth\guru_bk\NilaiController;
use App\Http\Controllers\Auth\guru_bk\AlgoritmaController;
use App\Http\Controllers\Auth\Parent\ParentLoginController;
use App\Http\Controllers\Auth\Student\StudentLoginController;
use App\Http\Controllers\Auth\guru_bk\RekomendasiController;

use App\Exports\NilaiExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

// =====================
// AUTH SISWA
// =====================
Route::prefix('siswa')->name('student.')->group(function () {
    Route::get('/login', [StudentLoginController::class, 'showLoginForm'])->middleware('guest:student')->name('login');
    Route::post('/login', [StudentLoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [StudentLoginController::class, 'logout'])->name('logout');

    Route::middleware('auth:student')->group(function () {
        Route::get('/dashboard', fn() => view('siswa.dashboard'))->name('dashboard');
    });
});

// =====================
// AUTH ORANG TUA
// =====================
Route::prefix('orangtua')->name('parent.')->group(function () {
    Route::get('/login', [ParentLoginController::class, 'showLoginForm'])->middleware('guest:parent')->name('login');
    Route::post('/login', [ParentLoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [ParentLoginController::class, 'logout'])->name('logout');

    Route::middleware('auth:parent')->group(function () {
        Route::get('/dashboard', fn() => view('orangtua.dashboard'))->name('dashboard');
    });
});

// =====================
// HALAMAN AWAL
// =====================
Route::view('/', 'welcome');

// =====================
// PROFIL & LOGOUT BK
// =====================
Route::view('profile', 'profile')->middleware(['auth'])->name('profile');

Route::post('/logout', function () {
    Auth::guard('web')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->middleware('auth:web')->name('logout');

// =====================
// GURU BK
// =====================
Route::middleware(['auth:web'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('students', StudentController::class);
    Route::resource('schedules', CounselingScheduleController::class);
    Route::resource('violations', ViolationController::class);
    Route::resource('nilai', NilaiController::class);

    Route::get('/call-letter', [CallLetterController::class, 'index'])->name('call-letter.index');
    Route::get('/call-letter/create', [CallLetterController::class, 'form'])->name('call-letter.form');
    Route::post('/call-letter', [CallLetterController::class, 'generate'])->name('call-letter.generate');
    Route::get('/call-letter/print/{student_id}', [CallLetterController::class, 'print'])->name('call-letter.print');

    Route::get('/cluster', [KMeansController::class, 'cluster'])->name('cluster');
    Route::get('/predict', [KNNController::class, 'predict'])->name('predict');

    // Halaman untuk melihat hasil algoritma K-Means dan KNN
    Route::get('/algoritma', [AlgoritmaController::class, 'index'])->name('algoritma.index');
    Route::get('/algoritma/kmeans/{id}/edit', [AlgoritmaController::class, 'edit'])->name('algoritma.kmeans.edit');
    Route::put('/algoritma/kmeans/{id}', [AlgoritmaController::class, 'update'])->name('algoritma.kmeans.update');
    Route::post('/algoritma/reset-knn', [AlgoritmaController::class, 'resetKategoriDanPrediksi'])->name('algoritma.reset.knn');

    Route::get('/algoritma/kmeans', [KMeansController::class, 'index'])->name('algoritma.kmeans');
    Route::get('/algoritma/knn', [KNNController::class, 'index'])->name('algoritma.knn');

    // Rekomendasi siswa
    Route::get('/rekomendasi', [RekomendasiController::class, 'perbandingan'])->name('rekomendasi.perbandingan');

});

// =====================
// UTILITAS UMUM
// =====================
Route::get('/profile/photo/{path}', function ($path) {
    $filePath = 'private/profile-photos/' . $path;
    if (!Storage::exists($filePath)) {
        abort(404);
    }
    return response()->file(storage_path('app/' . $filePath));
})->name('profile.photo');

// =====================
// EXPORT & PRINT NILAI
// =====================
Route::get('/export-nilai', function () {
    return Excel::download(new NilaiExport, 'data-nilai.xlsx');
})->name('nilai.export');

Route::get('/print-nilai', function () {
    $siswa = DB::table('nilai')
        ->join('students', 'nilai.nisn', '=', 'students.nisn')
        ->select('nilai.*', 'students.name', 'students.class')
        ->when(request('kategori'), fn($q) => $q->where('nilai.kategori', request('kategori')))
        ->when(request('kelas'), fn($q) => $q->where('students.class', request('kelas')))
        ->when(request('q'), function ($q) {
            $search = request('q');
            $q->where(function ($query) use ($search) {
                $query->where('students.name', 'like', "%{$search}%")
                      ->orWhere('nilai.nisn', 'like', "%{$search}%");
            });
        })
        ->orderBy('nilai.kategori')
        ->orderByDesc('nilai.rata_rata')
        ->get();

    $pdf = Pdf::loadView('nilai.pdf', compact('siswa'));
    return $pdf->download('data-nilai.pdf');
})->name('nilai.print');

// Route auth default Laravel Breeze
require __DIR__.'/auth.php';
