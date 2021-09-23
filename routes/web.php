<?php

use App\Http\Livewire\Home;
use App\Http\Livewire\Logout;
use App\Http\Livewire\Register;
use App\Http\Livewire\TestBase;
use App\Models\Comment;
use App\Http\Livewire\Login;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;

//use RealRashid\SweetAlert\Facades\Alert;

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
    return view('livewire.home');
//    return view('layouts.base');
})->middleware('auth_livewire');

Route::get('home', [Home::class, 'render'])->name('home')->middleware('auth_livewire');
Route::group(['middleware' => 'guest'], function () {
    Route::get('loginw', [Login::class, 'render'])->name('loginw');
    Route::get('registerw', [Register::class, 'render'])->name('registerw');
});
//Route::get('logoutw', [Logout::class, 'render'])->name('logoutw');

//Route::get('comment', function () {
//    $comments = Comment::all();
////    dd($comments);
//    return view('livewire.base-comments', compact('comments'));
//})
Route::get('welcome', function () {
    $comments = [];     //Comment::all();
    return view('welcome', compact('comments'));
})->name('welcome');

Route::get('test', function () {
    return view('livewire.test-base');
});
Route::get('test2', [TestBase::class, 'render']);
Route::any('upload1', [TestBase::class, 'uploadFile1'])->name('upload1');
Route::put('upload2', [TestBase::class, 'uploadFile2'])->name('upload2');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
