<?php

namespace App\Http\Controllers\Kassa;

use App\Http\Controllers\Controller;
use App\Models\Gerecht;
use App\Models\Bestelling;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Hulpvraag;
use Illuminate\Http\RedirectResponse;
use App\Models\Bestelregel;

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
        
        $veelgebruikteOpmerkingen = Bestelregel::query()
            ->whereNotNull('opmerking')
            ->where('opmerking', '!=', '')
            ->select('opmerking')
            ->selectRaw('COUNT(*) as aantal')
            ->groupBy('opmerking')
            ->orderByDesc('aantal')
            ->limit(10)
            ->pluck('opmerking');

        return view('pages.kassa.dashboard', [
            'gerechtenPerCategorie' => $gerechtenPerCategorie,
            'veelgebruikteOpmerkingen' => $veelgebruikteOpmerkingen,

        ]);
    }

    public function afrekenen(Request $request): JsonResponse
    {
        $gegevens = $request->validate([
            'gerechten' => ['required', 'array', 'min:1'],
            'gerechten.*.id' => ['required', 'integer', 'distinct', 'exists:menu,id'],
            'gerechten.*.aantal' => ['required', 'integer', 'min:1'],
            'gerechten.*.opmerking' => [
                'nullable',
                'string',
                'max:255',
            ],
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
                    'opmerking' => $gerecht['opmerking'] ?? null,
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

    public function verkoopgegevens(Request $request): JsonResponse
    {
        $gegevens = $request->validate([
            'begindatum' => ['required', 'date'],
            'einddatum' => [
                'required',
                'date',
                'after_or_equal:begindatum',
            ],
        ]);

        $verkoopregels = DB::table('bestellingen as bestelling')
            ->join(
                'bestelregels as bestelregel',
                'bestelregel.bestelling_id',
                '=',
                'bestelling.id'
            )
            ->join(
                'menu as gerecht',
                'gerecht.id',
                '=',
                'bestelregel.menu_id'
            )
            ->whereBetween('bestelling.besteldatum', [
                $gegevens['begindatum'].' 00:00:00',
                $gegevens['einddatum'].' 23:59:59',
            ])
            ->select([
                'bestelling.id as bestelling_id',
                'bestelling.besteldatum',
                'gerecht.id as menu_id',
                'gerecht.naam',
                'gerecht.price as prijs',
                'bestelregel.aantal',
                DB::raw(
                    '(gerecht.price * bestelregel.aantal) as subtotaal'
                ),
            ])
            ->orderBy('bestelling.besteldatum')
            ->orderBy('bestelling.id')
            ->get();

        $omzetInclusiefBtw = round(
            $verkoopregels->sum(
                fn ($regel) => (float) $regel->subtotaal
            ),
            2
        );

        $omzetExclusiefBtw = round($omzetInclusiefBtw / 1.09, 2);
        $btw = round($omzetInclusiefBtw - $omzetExclusiefBtw, 2);

        return response()->json([
            'verkoopregels' => $verkoopregels,
            'totalen' => [
                'inclusief_btw' => $omzetInclusiefBtw,
                'btw' => $btw,
                'exclusief_btw' => $omzetExclusiefBtw,
            ],
        ]);
    }

    public function hulpvragen(): View
    {
        $hulpvragen = Hulpvraag::query()
            ->where('afgehandeld', false)
            ->orderBy('aangemaakt_op')
            ->get();

        return view('pages.kassa.hulpvragen', [
            'hulpvragen' => $hulpvragen,
        ]);
    }

    public function handelHulpvraagAf(
        Hulpvraag $hulpvraag
    ): RedirectResponse {
        $hulpvraag->update([
            'afgehandeld' => true,
        ]);

        return redirect()
            ->route('kassa.hulpvragen')
            ->with('success', 'Hulpvraag is afgemeld.');
    }

}