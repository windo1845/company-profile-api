<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\SlidesController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\MenuMasterController;
use App\Http\Controllers\MenuSubController;
use App\Http\Controllers\PagesController;



Route::get('/', function () { return redirect()->route('login');});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('/select-website', [WebsiteController::class, 'select'])->name('website.select');

    // master table user
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::post('/users/store', [UserController::class, 'store'])->name('user.store');
    Route::post('/users/delete', [UserController::class, 'delete'])->name('user.delete');
    Route::post('/users/update', [UserController::class, 'update'])->name('user.update');

    // master table products
    Route::get('/products', [ProductsController::class, 'index'])->name('produk.index');
    Route::post('/products/store', [ProductsController::class, 'store'])->name('produk.store');
    Route::post('/products/delete', [ProductsController::class, 'delete'])->name('produk.delete');
    Route::post('/products/update', [ProductsController::class, 'update'])->name('produk.update');

    // master table news
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::post('/news/store', [NewsController::class, 'store'])->name('news.store');
    Route::post('/news/delete', [NewsController::class, 'delete'])->name('news.delete');
    Route::post('/news/update', [NewsController::class, 'update'])->name('news.update');

    // master table website
    Route::get('/website', [WebsiteController::class, 'index'])->name('website.index');
    Route::post('/website/store', [WebsiteController::class, 'store'])->name('website.store');
    Route::post('/website/delete', [WebsiteController::class, 'delete'])->name('website.delete');
    Route::post('/website/update', [WebsiteController::class, 'update'])->name('website.update');

    // master table slides
    Route::get('/slides', [SlidesController::class, 'index'])->name('slides.index');
    Route::post('/slides/store', [SlidesController::class, 'store'])->name('slides.store');
    Route::post('/slides/delete', [SlidesController::class, 'delete'])->name('slides.delete');
    Route::post('/slides/update', [SlidesController::class, 'update'])->name('slides.update');

    // master table video
    Route::get('/video', [VideoController::class, 'index'])->name('video.index');
    Route::post('/video/store', [VideoController::class, 'store'])->name('video.store');
    Route::post('/video/delete', [VideoController::class, 'delete'])->name('video.delete');
    Route::post('/video/update', [VideoController::class, 'update'])->name('video.update');

    // master table menu master
    Route::get('/menumaster', [MenuMasterController::class, 'index'])->name('menumaster.index');
    Route::post('/menumaster/store', [MenuMasterController::class, 'store'])->name('menumaster.store');
    Route::post('/menumaster/delete', [MenuMasterController::class, 'delete'])->name('menumaster.delete');
    Route::post('/menumaster/update', [MenuMasterController::class, 'update'])->name('menumaster.update');

    // master table sub menu
    Route::get('/submenu', [MenuSubController::class, 'index'])->name('submenu.index');
    Route::post('/submenu/store', [MenuSubController::class, 'store'])->name('submenu.store');
    Route::post('/submenu/delete', [MenuSubController::class, 'delete'])->name('submenu.delete');
    Route::post('/submenu/update', [MenuSubController::class, 'update'])->name('submenu.update');
    
    // master table pages
    Route::get('/pages', [PagesController::class, 'index'])->name('pages.index');
    Route::post('/pages/store', [PagesController::class, 'store'])->name('pages.store');
    Route::post('/pages/delete', [PagesController::class, 'delete'])->name('pages.delete');
    Route::post('/pages/update', [PagesController::class, 'update'])->name('pages.update');
});