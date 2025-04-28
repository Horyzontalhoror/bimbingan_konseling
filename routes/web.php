<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\CallLetterController;
use App\Http\Controllers\ViolationController;
use App\Http\Controllers\CounselingScheduleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\KMeansController;
use App\Exports\NilaiExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\KNNController;


Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


// login
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

//logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

//students
Route::middleware(['auth'])->group(function () {
    Route::resource('students', StudentController::class);
});

//counseling schedule
Route::middleware(['auth'])->group(function () {
    Route::resource('schedules', CounselingScheduleController::class);
});

//validation pelanggaran
Route::middleware(['auth'])->group(function () {
    Route::resource('violations', ViolationController::class);
});

//call letter
Route::middleware(['auth'])->group(function () {
    Route::get('/call-letter', [CallLetterController::class, 'form'])->name('call-letter.form');
    Route::post('/call-letter', [CallLetterController::class, 'generate'])->name('call-letter.generate');
});

//dashboard
Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//kmeans
Route::get('/cluster', [KMeansController::class, 'cluster'])->name('cluster');


//profile photo
Route::get('/profile/photo/{path}', function ($path) {
    $filePath = 'private/profile-photos/' . $path;

    if (!Storage::exists($filePath)) {
        abort(404);
    }

    return response()->file(storage_path('app/' . $filePath));
})->name('profile.photo');

//export nilai excel
Route::get('/export-nilai', function () {
    return Excel::download(new \App\Exports\NilaiExport, 'data-nilai.xlsx');
})->name('nilai.export');


//ceatak pdf
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

//knn controller
Route::get('/predict', [KNNController::class, 'predict'])->name('predict');

Route::get('/test', fn() => view('test'));


require __DIR__.'/auth.php';
