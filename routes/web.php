<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\HutangPiutangController;

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
//route login
Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'process']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// route dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/', [DashboardController::class, 'index'])->middleware('auth');

//route barang
Route::resource('/barang', BarangController::class)->middleware('auth');

//route Hutang & Piutang
Route::get('/hutangpiutang', [HutangPiutangController::class, 'index'])->middleware('auth');

//route management
Route::get('/management', [ManagementController::class, 'index'])->middleware('auth');

//route demo
Route::middleware('auth')->group(function () {
    // Route demo di dalam route auth
    Route::prefix('demo')->group(function () {
        Route::get('/', [DemoController::class, 'index'])->name('demo.index');
        Route::get('/create', [DemoController::class, 'create']);
        Route::post('/', [DemoController::class, 'store'])->name('demo.store');
        Route::get('/detail/{id}', [DemoController::class, 'show'])->name('detail.show');
        Route::get('/{id}/edit', [DemoController::class, 'edit'])->name('demo.edit');
        Route::put('/{id}/edit', [DemoController::class, 'update'])->name('demo.update');
        Route::delete('/{id}', [DemoController::class, 'destroy'])->name('demo.destroy');
    });
});