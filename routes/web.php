<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    if(auth()->user()){
        return redirect()->route('home');
    }
    return view('auth.login');
});

Auth::routes();

Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('post', [PostController::class, 'index'])->name('post.index');
Route::get('post/create', [PostController::class, 'create'])->name('post.create');
Route::post('post/store', [PostController::class, 'store'])->name('post.store');
Route::get('post/edit/{post}', [PostController::class, 'edit'])->name('post.edit');
Route::put('post/update/{post}', [PostController::class, 'update'])->name('post.update');
Route::delete('post/destroy/{post}', [PostController::class, 'destroy'])->name('post.destroy');

Route::post('like', [LikeController::class, 'like'])->name('like');
Route::post('disLike', [LikeController::class, 'destroy'])->name('disLike');
