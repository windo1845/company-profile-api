<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContentApiController;

Route::get('/products', [ContentApiController::class, 'products']);
Route::get('/news', [ContentApiController::class, 'news']);
Route::get('/slides', [ContentApiController::class, 'slides']);
Route::get('/video', [ContentApiController::class, 'video']);

Route::get('/menumaster', [ContentApiController::class, 'menumaster']);
Route::get('/submenu', [ContentApiController::class, 'submenu']);
Route::get('/pages', [ContentApiController::class, 'pages']);