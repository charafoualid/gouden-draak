<?php

namespace App\Http\Controllers\Kassa;

use App\Http\Controllers\Controller;
use App\Models\Gerecht;
use App\Models\Bestelling;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function afrekenen(Request $request): JsonResponse
    {
        $gegevens = $request->validate([
            'gerechten' => ['required', 'array', 'min:1'],
            'gerechten.*.id' => ['required', 'integer', 'distinct', 'exists:menu,id'],
            'gerechten.*.aantal' => ['required', 'integer', 'min:1'],
        ]);

        $bestelling = DB::transaction(function () use ($gegevens) {
            $bestelling = Bestelling::create([
                'besteldatum' => now(),
                'bron' => 'kassa',
                'tafelnummer' => null,
            ]);

            $bestelregels = collect($gegevens['gerechten'])->map(function ($gerecht) {
                return [
                    'menu_id' => $gerecht['id'],
                    'aantal' => $gerecht['aantal'],
                    'opmerking' => null,
                ];
            })->all();

            $bestelling->bestelregels()->createMany($bestelregels);

            return $bestelling;
        });

        return response()->json([
            'message' => 'Verkoop succesvol!',
            'bestelling_id' => $bestelling->id,
        ], 201);
    }
}