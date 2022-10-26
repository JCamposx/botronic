<?php

use App\Http\Controllers\BotController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BotmanController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('', fn () => view('welcome'));

Auth::routes();

Route::get('home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'admin'])
    ->resource('users', UserController::class)
    ->except(['create', 'store', 'show']);

Route::middleware('auth')->group(function () {
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::resource('profile', ProfileController::class)
        ->except(['create', 'store', 'show', 'edit', 'destroy']);
    });

Route::middleware('auth')->resource('bots', BotController::class);

Route::match(['get', 'post'], 'botman', [BotmanController::class, "handle"]);
