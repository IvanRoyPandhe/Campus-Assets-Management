<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
});

Route::middleware('auth')->group(function () {
    // Routes accessible by both admin and student
    Route::get('/dashboard', function () {
        return redirect()->route('assets.index');
    })->name('dashboard');
    
    // Asset routes
    Route::controller(AssetController::class)->group(function () {
        Route::get('/assets', 'index')->name('assets.index');
        Route::get('/assets/create', 'create')->name('assets.create');
        Route::post('/assets', 'store')->name('assets.store');
        Route::get('/assets/{asset}', 'show')->name('assets.show');
        Route::get('/assets/{asset}/edit', 'edit')->name('assets.edit');
        Route::put('/assets/{asset}', 'update')->name('assets.update');
        Route::delete('/assets/{asset}', 'destroy')->name('assets.destroy');
    });
    
    // Location routes
    Route::controller(LocationController::class)->group(function () {
        Route::get('/locations', 'index')->name('locations.index');
        Route::get('/locations/create', 'create')->name('locations.create');
        Route::post('/locations', 'store')->name('locations.store');
        Route::get('/locations/{location}', 'show')->name('locations.show');
        Route::get('/locations/{location}/edit', 'edit')->name('locations.edit');
        Route::put('/locations/{location}', 'update')->name('locations.update');
        Route::delete('/locations/{location}', 'destroy')->name('locations.destroy');
    });
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';