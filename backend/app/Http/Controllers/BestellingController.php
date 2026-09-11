<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Gerecht;
use Illuminate\Contracts\View\View;
use App\Models\Bestelling;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\Hulpvraag;

class BestellingController extends Controller
{
    public function kiesTafel(
        Request $request,
        int $tafelnummer
    ): RedirectResponse {
        abort_unless(
            $tafelnummer >= 1 && $tafelnummer <= 10,
            404
        );

        if ($request->session()->get('tablet.tafelnummer') !== $tafelnummer) {
            $request->session()->put([
                'tablet.tafelnummer' => $tafelnummer,
                'tablet.rondes' => 0,
                'tablet.laatste_bestelling' => null,
            ]);
        }

        return redirect()->route('bestellen.menu');
    }

    public function toonMenu(Request $request): View|RedirectResponse
    {
        if (!$request->session()->has('tablet.tafelnummer')) {
            return redirect()->route('bestellen');
        }

        $gerechtenPerCategorie = Gerecht::query()
            ->orderBy('id')
            ->orderBy('menunummer')
            ->orderBy('menu_toevoeging')
            ->get()
            ->groupBy('soortgerecht');

        return view('pages.bestelmenu', [
            'tafelnummer' => $request->session()->get(
                'tablet.tafelnummer'
            ),
            'gerechtenPerCategorie' => $gerechtenPerCategorie,
        ]);
    }

    public function plaatsBestelling(Request $request): JsonResponse
    {
        $tafelnummer = $request->session()->get('tablet.tafelnummer');
        $rondes = (int) $request->session()->get('tablet.rondes', 0);
        $laatsteBestelling = $request->session()->get(
            'tablet.laatste_bestelling'
        );

        if (!$tafelnummer) {
            return response()->json([
                'message' => 'Kies eerst een tafelnummer.',
            ], 422);
        }

        if ($rondes >= 5) {
            return response()->json([
                'message' => 'Het maximale aantal van vijf rondes is bereikt.',
            ], 422);
        }

        if ($laatsteBestelling) {
            $beschikbaarVanaf = Carbon::parse($laatsteBestelling)
                ->addMinutes(10);

            if (now()->lessThan($beschikbaarVanaf)) {
                $seconden = (int) now()->diffInSeconds($beschikbaarVanaf);

                return response()->json([
                    'message' => 'U kunt over enkele minuten opnieuw bestellen.',
                    'wachten_seconden' => $seconden,
                ], 429);
            }
        }

        $gegevens = $request->validate([
            'gerechten' => ['required', 'array', 'min:1'],
            'gerechten.*.id' => [
                'required',
                'integer',
                'distinct',
                'exists:menu,id',
            ],
            'gerechten.*.aantal' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);

        $bestelling = DB::transaction(function () use (
            $gegevens,
            $tafelnummer
        ) {
            $bestelling = Bestelling::create([
                'besteldatum' => now(),
                'bron' => 'tablet',
                'tafelnummer' => $tafelnummer,
            ]);

            $bestelregels = collect($gegevens['gerechten'])
                ->map(fn ($gerecht) => [
                    'menu_id' => $gerecht['id'],
                    'aantal' => $gerecht['aantal'],
                    'opmerking' => null,
                ])
                ->all();

            $bestelling->bestelregels()->createMany($bestelregels);

            return $bestelling;
        });

        $request->session()->put([
            'tablet.rondes' => $rondes + 1,
            'tablet.laatste_bestelling' => now()->toIso8601String(),
        ]);

        return response()->json([
            'message' => 'Bestelling succesvol geplaatst!',
            'bestelling_id' => $bestelling->id,
            'ronde' => $rondes + 1,
            'resterende_rondes' => 4 - $rondes,
        ], 201);
    }

    public function vraagHulp(Request $request): JsonResponse
    {
        $tafelnummer = $request->session()->get('tablet.tafelnummer');

        if (!$tafelnummer) {
            return response()->json([
                'message' => 'Kies eerst een tafelnummer.',
            ], 422);
        }

        $hulpvraag = Hulpvraag::firstOrCreate(
            [
                'tafelnummer' => $tafelnummer,
                'afgehandeld' => false,
            ],
            [
                'aangemaakt_op' => now(),
            ]
        );

        return response()->json([
            'message' => $hulpvraag->wasRecentlyCreated
                ? 'Een medewerker komt zo naar uw tafel.'
                : 'Uw hulpvraag staat al open.',
        ]);
    }
}