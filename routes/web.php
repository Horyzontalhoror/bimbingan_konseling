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
use App\Http\Controllers\Auth\guru_bk\RekomendasiController;
use App\Http\Controllers\Auth\guru_bk\JenisPelanggaranController;
use App\Http\Controllers\Auth\guru_bk\AbsensiController;
use App\Http\Controllers\Auth\guru_bk\KonfigurasiKMeansController;

use App\Http\Controllers\Auth\guru_bk\KMeans\KMeansNilaiController;
use App\Http\Controllers\Auth\guru_bk\KMeans\KMeansAbsenController;
use App\Http\Controllers\Auth\guru_bk\KMeans\KMeansPelanggaranController;

use App\Http\Controllers\Auth\Parent\ParentLoginController;
use App\Http\Controllers\Auth\Parent\ParentDashboardController;

use App\Http\Controllers\Auth\Student\StudentLoginController;
use App\Http\Controllers\Auth\Student\StudentDashboardController;

use App\Exports\NilaiExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

// ==============================
// AUTHENTIKASI SISWA
// ==============================
Route::prefix('siswa')->name('student.')->group(function () {
    Route::middleware('guest:student')->group(function () {
        Route::get('/login', [StudentLoginController::class, 'showLoginForm'])->name('login');
    });
    Route::post('/login', [StudentLoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [StudentLoginController::class, 'logout'])->name('logout');

    Route::middleware('auth:student')->group(function () {
        // Route::get('/dashboard', [StudentDashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/konseling', [StudentDashboardController::class, 'konseling'])->name('konseling');
        Route::get('/index', [StudentDashboardController::class, 'index'])->name('index');
        Route::get('/nilai', [StudentDashboardController::class, 'nilai'])->name('nilai');
        Route::get('/surat-panggilan', [StudentDashboardController::class, 'suratPanggilan'])->name('surat.panggilan');
    });
});

// ==============================
// AUTHENTIKASI ORANG TUA
// ==============================
Route::prefix('orangtua')->name('parent.')->group(function () {
    Route::middleware('guest:parent')->group(function () {
        Route::get('/login', [ParentLoginController::class, 'showLoginForm'])->name('login');
    });

    Route::post('/login', [ParentLoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [ParentLoginController::class, 'logout'])->name('logout');

    Route::middleware('auth:parent')->group(function () {
        Route::get('/dashboard', [ParentDashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/index', [ParentDashboardController::class, 'index'])->name('index');
        Route::get('/nilai', [ParentDashboardController::class, 'nilai'])->name('nilai');
        Route::get('/jadwal-konseling', [ParentDashboardController::class, 'jadwalKonseling'])->name('konseling');
        Route::get('/surat-panggilan', [ParentDashboardController::class, 'suratPanggilan'])->name('panggilan');
    });
});

// ==============================
// HALAMAN UTAMA & PROFIL BK
// ==============================
Route::view('/', 'welcome');
Route::view('profile', 'profile')->middleware('auth')->name('profile');

// ==============================
// LOGOUT GURU BK
// ==============================
Route::post('/logout', function () {
    Auth::guard('web')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->middleware('auth:web')->name('logout');

// ==============================
// GURU BK (WEB AUTH)
// ==============================
Route::middleware('auth:web')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resources([
        'students'   => StudentController::class,
        'schedules'  => CounselingScheduleController::class,
        'violations' => ViolationController::class,
        'nilai'      => NilaiController::class,
    ]);

    // Surat Panggilan
    Route::prefix('call-letter')->name('call-letter.')->group(function () {
        Route::get('/', [CallLetterController::class, 'index'])->name('index');
        Route::get('/create', [CallLetterController::class, 'form'])->name('form');
        Route::post('/', [CallLetterController::class, 'generate'])->name('generate');
        Route::get('/print/{student_id}', [CallLetterController::class, 'print'])->name('print');
        Route::post('/save', [CallLetterController::class, 'save'])->name('save');
        Route::get('/{id}', [CallLetterController::class, 'show'])->name('show');
        Route::delete('/{id}', [CallLetterController::class, 'destroy'])->name('destroy');
    });


    // Algoritma
    Route::prefix('algoritma')->name('algoritma.')->group(function () {
        Route::get('/', [AlgoritmaController::class, 'index'])->name('index');
        Route::get('/kmeans', [KMeansController::class, 'index'])->name('kmeans');
        Route::get('/kmeans/{id}/edit', [AlgoritmaController::class, 'edit'])->name('kmeans.edit');
        Route::put('/kmeans/{id}', [AlgoritmaController::class, 'update'])->name('kmeans.update');

        Route::get('/knn', [KNNController::class, 'index'])->name('knn');
        // reser data
        Route::post('/reset-Kategori', [AlgoritmaController::class, 'resetKategori'])->name('reset.kategori');
    });

    // Konfigurasi KMeans
    Route::prefix('konfigurasi')->name('konfigurasi.')->group(function () {
        Route::get('/', [KonfigurasiKMeansController::class, 'index'])->name('index');
        Route::get('/{id}/edit', [KonfigurasiKMeansController::class, 'edit'])->name('edit');
        Route::put('/{id}', [KonfigurasiKMeansController::class, 'update'])->name('update');
        Route::resource('konfigurasi', KonfigurasiKMeansController::class);
    });

    // Proses KMeans per aspek
    Route::post('/kmeans/nilai', [KMeansNilaiController::class, 'cluster'])->name('kmeans.nilai');
    Route::post('/kmeans/absen', [KMeansAbsenController::class, 'cluster'])->name('kmeans.absen');
    Route::post('/kmeans/pelanggaran', [KMeansPelanggaranController::class, 'cluster'])->name('kmeans.pelanggaran');

    // Keputusan akhir KMeans
    Route::post('/kmeans/final', [KMeansController::class, 'keputusanAkhir'])->name('kmeans.final'); // gunakan ini saja
    // Route::post('/kmeans/keputusan-akhir', ...) ← HAPUS jika tidak dipakai di Blade

    // Tampilan
    Route::get('/keputusanAkhir', [KMeansController::class, 'keputusanAkhir'])->name('keputusanAkhir');
    Route::get('/keputusanAkhirKNN', [KNNController::class, 'predict'])->name('keputusanAkhirKNN');
    // Rekomendasi
    Route::get('/rekomendasi', [RekomendasiController::class, 'perbandingan'])->name('rekomendasi.perbandingan');
    Route::get('/rekomendasi/perbandingan', [RekomendasiController::class, 'perbandingan'])->name('rekomendasi.perbandingan');

    // Jenis Pelanggaran
    Route::prefix('jenis-pelanggaran')->name('jenis-pelanggaran.')->group(function () {
        Route::get('/', [JenisPelanggaranController::class, 'index'])->name('index');
        Route::get('/create', [JenisPelanggaranController::class, 'create'])->name('create');
        Route::post('/', [JenisPelanggaranController::class, 'store'])->name('store');
        Route::get('/{jenis}/edit', [JenisPelanggaranController::class, 'edit'])->name('edit');
        Route::put('/{jenis}', [JenisPelanggaranController::class, 'update'])->name('update');
        Route::delete('/{jenis}', [JenisPelanggaranController::class, 'destroy'])->name('destroy');
    });

    // Absensi
    Route::prefix('guru-bk/absensi')->name('absensi.')->group(function () {
        Route::get('/', [AbsensiController::class, 'index'])->name('index');
        Route::get('/create', [AbsensiController::class, 'create'])->name('create');
        Route::post('/', [AbsensiController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [AbsensiController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AbsensiController::class, 'update'])->name('update');
        Route::delete('/{id}', [AbsensiController::class, 'destroy'])->name('destroy');
    });
});

// ==============================
// UTILITAS UMUM
// ==============================
Route::get('/profile/photo/{path}', function ($path) {
    $filePath = 'private/profile-photos/' . $path;
    abort_if(!Storage::exists($filePath), 404);
    return response()->file(storage_path('app/' . $filePath));
})->name('profile.photo');

// ==============================
// EXPORT & CETAK NILAI
// ==============================
Route::get('/export-nilai', fn() => Excel::download(new NilaiExport, 'data-nilai.xlsx'))->name('nilai.export');

Route::get('/print-nilai', function () {
    $siswa = DB::table('nilai')
        ->join('students', 'nilai.nisn', '=', 'students.nisn')
        ->select('nilai.*', 'students.name', 'students.class')
        ->when(request('kategori'), fn($q) => $q->where('nilai.kategori', request('kategori')))
        ->when(request('kelas'), fn($q) => $q->where('students.class', request('kelas')))
        ->when(request('q'), fn($q) => $q->where(function ($query) {
            $query->where('students.name', 'like', '%' . request('q') . '%')
                ->orWhere('nilai.nisn', 'like', '%' . request('q') . '%');
        }))
        ->orderBy('nilai.kategori')
        ->orderByDesc('nilai.rata_rata')
        ->get();

    $pdf = Pdf::loadView('nilai.pdf', compact('siswa'));
    return $pdf->download('data-nilai.pdf');
})->name('nilai.print');

// ==============================
// ROUTE BAWAAN LARAVEL BREEZE
// ==============================
require __DIR__ . '/auth.php';
