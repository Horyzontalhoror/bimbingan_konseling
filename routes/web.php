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


use App\Exports\NilaiExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

// Halaman awal
Route::view('/', 'welcome');

// Dashboard default Laravel Breeze
Route::view('dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');

// Profil user
Route::view('profile', 'profile')->middleware(['auth'])->name('profile');

// Logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');


// Route yang membutuhkan login
Route::middleware(['auth'])->group(function () {
    // Dashboard khusus guru BK
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Data siswa
    Route::resource('students', StudentController::class);

    // Jadwal konseling
    Route::resource('schedules', CounselingScheduleController::class);

    // Data pelanggaran
    Route::resource('violations', ViolationController::class);

    // Surat panggilan
    Route::get('/call-letter', [CallLetterController::class, 'index'])->name('call-letter.index');
    Route::get('/call-letter/create', [CallLetterController::class, 'form'])->name('call-letter.form');
    Route::post('/call-letter', [CallLetterController::class, 'generate'])->name('call-letter.generate');
    Route::get('/call-letter/print/{student_id}', [CallLetterController::class, 'print'])->name('call-letter.print');

    // Clustering KMeans
    Route::get('/cluster', [KMeansController::class, 'cluster'])->name('cluster');

    // Prediksi KNN
    Route::get('/predict', [KNNController::class, 'predict'])->name('predict');

    // Data nilai
    Route::resource('nilai', NilaiController::class)->only(['index']);
    Route::resource('nilai', NilaiController::class);
});

// Gambar profil (disimpan di folder privat)
Route::get('/profile/photo/{path}', function ($path) {
    $filePath = 'private/profile-photos/' . $path;
    if (!Storage::exists($filePath)) {
        abort(404);
    }
    return response()->file(storage_path('app/' . $filePath));
})->name('profile.photo');

// Export data nilai ke Excel
Route::get('/export-nilai', function () {
    return Excel::download(new NilaiExport, 'data-nilai.xlsx');
})->name('nilai.export');

// Cetak PDF data nilai
Route::get('/print-nilai', function () {
    $siswa = DB::table('nilai')
        ->when(request('kategori'), fn($q) => $q->where('kategori', request('kategori')))
        ->when(request('kelas'), fn($q) => $q->where('class', request('kelas')))
        ->when(request('q'), function ($q) {
            $q->where(function ($query) {
                $search = request('q');
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('nisn', 'like', "%{$search}%");
            });
        })
        ->orderBy('kategori')
        ->orderByDesc('rata_rata')
        ->get();

    $pdf = Pdf::loadView('nilai.pdf', compact('siswa'));
    return $pdf->download('data-nilai.pdf');
})->name('nilai.print');

// Route auth default Laravel Breeze
require __DIR__.'/auth.php';
