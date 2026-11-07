<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

// ===== Publik: hanya berita dan struktur =====
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/berita', [NewsController::class, 'index'])->name('news.index');
Route::get('/berita/{news}', [NewsController::class, 'show'])->name('news.show');

// Pendaftaran anggota (masuk sebagai "pending", disetujui admin)
Route::get('/daftar', [RegisterController::class, 'create'])->name('daftar');
Route::post('/daftar', [RegisterController::class, 'store'])->name('daftar.store');
Route::get('/daftar/kartu/{member}', [RegisterController::class, 'kartu'])->name('daftar.kartu')->middleware('signed');

// Foto lama yang tersimpan di storage tetap bisa dibuka tanpa "storage:link"
Route::get('/storage/{path}', function (string $path) {
    $file = storage_path('app/public/' . $path);
    abort_unless(!str_contains($path, '..') && is_file($file), 404);

    return response()->file($file);
})->where('path', '.*');

// ===== Login admin (tidak ditautkan di halaman publik) =====
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ===== Admin =====
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('news', AdminNewsController::class)->except('show');
    Route::resource('members', MemberController::class)->except('show');
    Route::post('members/{member}/approve', [MemberController::class, 'approve'])->name('members.approve');
    Route::get('members/{member}/card', [MemberController::class, 'card'])->name('members.card');

    // Halaman bantu: memeriksa semua foto berita dan anggota
    Route::get('cek-foto', function () {
        $baris = [];
        foreach (\App\Models\News::all() as $n) {
            $baris[] = ['Berita', $n->judul, $n->gambar, $n->gambar_url];
        }
        foreach (\App\Models\Member::all() as $m) {
            $baris[] = ['Anggota', $m->nama, $m->foto, $m->foto_url];
        }

        $html = '<h2 style="font-family:sans-serif">Cek Foto</h2><table border="1" cellpadding="6" style="font-family:sans-serif;font-size:14px;border-collapse:collapse">'
              . '<tr><th>Jenis</th><th>Nama</th><th>Path di database</th><th>File ada di disk?</th><th>Pratinjau</th></tr>';
        foreach ($baris as [$jenis, $nama, $path, $url]) {
            $ada = $path && (is_file(public_path($path)) || is_file(storage_path('app/public/' . $path)));
            $html .= '<tr><td>' . e($jenis) . '</td><td>' . e($nama) . '</td><td>' . e($path ?: '(kosong)') . '</td><td>'
                   . ($path ? ($ada ? 'ADA' : 'TIDAK ADA') : '-') . '</td><td>'
                   . ($url ? '<img src="' . e($url) . '" height="60">' : '') . '</td></tr>';
        }

        return response($html . '</table>');
    })->name('cek-foto');
});
