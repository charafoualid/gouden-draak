<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Kassa\LoginController;
use App\Http\Controllers\Kassa\KassaController;
use App\Http\Controllers\BestellingController;
use App\Http\Controllers\MenukaartController;
use App\Http\Controllers\Kassa\DagrapportController;
use App\Http\Controllers\Kassa\GerechtController;

Route::view('/', 'pages.home')
    ->name('home');

Route::get(
    '/kassa/gerechten',
    [GerechtController::class, 'index']
)->name('kassa.gerechten');

Route::post(
    '/kassa/gerechten',
    [GerechtController::class, 'store']
)->name('kassa.gerechten.store');

Route::patch(
    '/kassa/gerechten/{gerecht}',
    [GerechtController::class, 'update']
)->name('kassa.gerechten.update');

Route::delete(
    '/kassa/gerechten/{gerecht}',
    [GerechtController::class, 'destroy']
)->name('kassa.gerechten.destroy');

Route::view('/nieuws', 'pages.news')
    ->name('nieuws');

Route::view('/menukaart', 'pages.menukaart')
    ->name('menukaart');

Route::view('/contact', 'pages.contact')
    ->name('contact');

Route::view('/aanbiedingen', 'pages.offers')
    ->name('offers');

Route::view('/kassa', 'pages.kassa.login')
    ->name('kassa.login');

Route::post('/kassa/login', [LoginController::class, 'login'])
    ->name('kassa.login.submit');

Route::post('/kassa/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('kassa.logout');

Route::get('/kassa/dashboard', [KassaController::class, 'index'])
    ->middleware('auth')
    ->name('kassa.dashboard');

Route::post('/kassa/afrekenen', [KassaController::class, 'afrekenen'])
    ->middleware('auth')
    ->name('kassa.afrekenen');

Route::view('/kassa/verkoopoverzicht', 'pages.kassa.verkoopoverzicht')
    ->middleware('auth')
    ->name('kassa.verkoopoverzicht');

Route::get(
    '/kassa/verkoopoverzicht/gegevens',
    [KassaController::class, 'verkoopgegevens']
)
    ->middleware('auth')
    ->name('kassa.verkoopoverzicht.gegevens');


Route::view('/bestellen', 'pages.bestellen')
    ->name('bestellen');

Route::post(
    '/bestellen/tafel/{tafelnummer}',
    [BestellingController::class, 'kiesTafel']
)
    ->whereNumber('tafelnummer')
    ->name('bestellen.tafel');

Route::get(
    '/bestellen/menu',
    [BestellingController::class, 'toonMenu']
)->name('bestellen.menu');

Route::post(
    '/bestellen/plaatsen',
    [BestellingController::class, 'plaatsBestelling']
)->name('bestellen.plaatsen');

Route::post(
    '/bestellen/hulp',
    [BestellingController::class, 'vraagHulp']
)->name('bestellen.hulp');

Route::get(
    '/kassa/hulpvragen',
    [KassaController::class, 'hulpvragen']
)
    ->middleware('auth')
    ->name('kassa.hulpvragen');

Route::patch(
    '/kassa/hulpvragen/{hulpvraag}/afmelden',
    [KassaController::class, 'handelHulpvraagAf']
)
    ->middleware('auth')
    ->name('kassa.hulpvragen.afmelden');

Route::get('/menukaart', [MenukaartController::class, 'index'])
    ->name('menukaart');

Route::get('/menukaart/pdf', [MenukaartController::class, 'downloadPdf'])
    ->name('menukaart.pdf');

Route::get(
    '/kassa/dagrapporten',
    [DagrapportController::class, 'index']
)->name('kassa.dagrapporten');

Route::get(
    '/kassa/dagrapporten/{bestandsnaam}',
    [DagrapportController::class, 'download']
)->name('kassa.dagrapporten.download');