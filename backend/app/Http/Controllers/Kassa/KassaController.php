<?php

namespace App\Http\Controllers\Kassa;

use App\Http\Controllers\Controller;
use App\Models\Gerecht;
use Illuminate\View\View;

class KassaController extends Controller
{
    public function index(): View
    {
        $gerechtenPerCategorie = Gerecht::query()
            ->orderBy('id')
            ->orderBy('menunummer')
            ->orderBy('menu_toevoeging')
            ->get()
            ->groupBy('soortgerecht');

        return view('pages.kassa.dashboard', [
            'gerechtenPerCategorie' => $gerechtenPerCategorie,
        ]);
    }
}