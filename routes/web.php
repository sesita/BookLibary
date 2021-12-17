<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookController;

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

// ჩვეულებრივი იუზერის როუტები
Route::get('/', function () {
    return redirect('home');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/author/{slug}', [AuthorController::class, 'index'])->name('author');

// ადმინის როუტები 

Route::group(['prefix' => 'admin', 'middleware' => 'web', 'admin'], function () {

    Route::get('/home', [HomeController::class, 'adminHome'])->name('admin.home')->middleware('admin');
    // წიგნის დამატება
    Route::get('/add-book', [BookController::class, 'formAdd'])->name('admin.book.formAdd')->middleware('admin');
    Route::post('/createBook', [BookController::class, 'addBook'])->name('admin.book.create')->middleware('admin');
    // წიგნის რედაქტირება
    Route::get('/edit-book/{id}', [BookController::class, 'formEdit'])->name('admin.book.formEdit')->middleware('admin');
    Route::patch('/editBook/{id}', [BookController::class, 'editBook'])->name('admin.book.edit')->middleware('admin');
    // წიგნის წაშლა
    Route::delete('/deleteBook/{id}', [BookController::class, 'deleteBook'])->name('admin.book.delete')->middleware('admin');
    // ავტორი
    Route::get('/author/{slug}', [AuthorController::class, 'adminAuthor'])->name('admin.author')->middleware('admin');
    // ავტორის რედაქტირება
    Route::get('/edit-author/{id}', [AuthorController::class, 'formEdit'])->name('admin.author.formEdit')->middleware('admin');
    Route::patch('/editAuthor/{id}', [AuthorController::class, 'editAuthor'])->name('admin.author.edit')->middleware('admin');
    // ავტორის წაშლა
    Route::delete('/deleteAuthor/{id}', [AuthorController::class, 'deleteAuthor'])->name('admin.author.delete')->middleware('admin');
});

Auth::routes();