<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
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
    if(Auth::check()){ return view('dashboard'); }
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::put('tickets/updatestatus/{ticket}', [TicketController::class, 'updatestatus'])->name('tickets.updatestatus')->middleware(['auth', 'verified']);
Route::post('tickets/storereply/{ticket}', [TicketController::class, 'storereply'])->name('tickets.storereply')->middleware(['auth', 'verified']);
Route::resource('tickets', TicketController::class)->except('show')->middleware(['auth', 'verified']);
Route::resource('tasks', TaskController::class)->middleware(['auth', 'verified']);
Route::resource('options', OptionController::class)->except('show', 'destroy')->middleware(['auth', 'verified']);
Route::resource('setting', SettingController::class)->except('index' ,'show', 'create', 'store', 'destroy')->middleware(['auth', 'verified']);
Route::resource('user', UserController::class)->except('show', 'create', 'store', 'destroy')->middleware(['auth', 'verified']);


require __DIR__.'/auth.php';
