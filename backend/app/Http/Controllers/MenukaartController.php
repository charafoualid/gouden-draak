<?php

namespace App\Http\Controllers;

use App\Models\Gerecht;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\Response;

class MenukaartController extends Controller
{
    public function index(): View
    {
        $gerechtenPerCategorie = Gerecht::query()
            ->where('actief', true)
            ->orderBy('id')
            ->orderBy('menunummer')
            ->orderBy('menu_toevoeging')
            ->get()
            ->groupBy('soortgerecht');

        return view('pages.menukaart', [
            'gerechtenPerCategorie' => $gerechtenPerCategorie,
        ]);
    }

    public function downloadPdf(): Response
    {
        $gerechtenPerCategorie = Gerecht::query()
            ->where('actief', true)
            ->orderBy('id')
            ->orderBy('menunummer')
            ->orderBy('menu_toevoeging')
            ->get()
            ->groupBy('soortgerecht');

        $pdf = Pdf::loadView('pdf.menukaart', [
            'gerechtenPerCategorie' => $gerechtenPerCategorie,
        ]);

        return $pdf->download('menukaart-de-gouden-draak.pdf');
    }
}