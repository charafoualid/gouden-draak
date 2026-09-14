<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class VerkoopoverzichtService
{
    public function maak(
        string $begindatum,
        string $einddatum
    ): array {
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
                $begindatum.' 00:00:00',
                $einddatum.' 23:59:59',
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

        $omzetExclusiefBtw = round(
            $omzetInclusiefBtw / 1.09,
            2
        );

        $btw = round(
            $omzetInclusiefBtw - $omzetExclusiefBtw,
            2
        );

        return [
            'verkoopregels' => $verkoopregels,
            'totalen' => [
                'inclusief_btw' => $omzetInclusiefBtw,
                'btw' => $btw,
                'exclusief_btw' => $omzetExclusiefBtw,
            ],
        ];
    }
}