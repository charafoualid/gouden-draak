<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Kassa\LoginController;

Route::view('/', 'pages.home')
    ->name('home');

Route::view('/menukaart', 'pages.menukaart')
    ->name('menukaart');

Route::view('/nieuws', 'pages.news')
    ->name('nieuws');

Route::view('/contact', 'pages.contact')
    ->name('contact');

Route::view('/aanbiedingen', 'pages.offers')
    ->name('offers');

Route::view('/kassa', 'pages.kassa.login')
    ->name('kassa.login');

Route::post('/kassa/login', [LoginController::class, 'login'])
    ->name('kassa.login');

Route::view('/kassa/dashboard', 'pages.kassa.dashboard')
    ->middleware('auth')
    ->name('kassa.dashboard');