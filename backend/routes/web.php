<?php

use Illuminate\Support\Facades\Route;

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

