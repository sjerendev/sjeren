<?php

use App\Http\Controllers\Api\NavigationController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/pages', [PageController::class, 'index']);
Route::get('/navigation', [NavigationController::class, 'index']);
Route::get('/pages/home', [PageController::class, 'home']);
Route::get('/pages/{slug}', [PageController::class, 'show']);
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{slug}', [PostController::class, 'show']);
Route::get('/settings', [App\Http\Controllers\Api\SettingsController::class, 'index']);
