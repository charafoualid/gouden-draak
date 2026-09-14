<?php

namespace App\Http\Controllers;

use App\Models\Gerecht;
use Illuminate\View\View;

class MenukaartController extends Controller
{
    public function index(): View
    {
        $gerechtenPerCategorie = Gerecht::query()
            ->orderBy('id')
            ->orderBy('menunummer')
            ->orderBy('menu_toevoeging')
            ->get()
            ->groupBy('soortgerecht');

        return view('pages.menukaart', [
            'gerechtenPerCategorie' => $gerechtenPerCategorie,
        ]);
    }
}