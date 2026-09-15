<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class DagverkoopExport implements FromArray
{
    public function __construct(
        private readonly array $overzicht,
        private readonly string $datum
    ) {
    }

    public function array(): array
    {
        $regels = [
            ['Dagrapport verkoop'],
            ['Datum', $this->datum],
            [],
            [
                'Bestelling',
                'Besteldatum',
                'Gerecht',
                'Prijs',
                'Aantal',
                'Subtotaal',
            ],
        ];

        foreach ($this->overzicht['verkoopregels'] as $regel) {
            $regels[] = [
                $regel->bestelling_id,
                $regel->besteldatum,
                $regel->naam,
                (float) $regel->prijs,
                $regel->aantal,
                (float) $regel->subtotaal,
            ];
        }

        $totalen = $this->overzicht['totalen'];

        $regels[] = [];
        $regels[] = [
            'Omzet inclusief btw',
            $totalen['inclusief_btw'],
        ];
        $regels[] = ['Btw (9%)', $totalen['btw']];
        $regels[] = [
            'Omzet exclusief btw',
            $totalen['exclusief_btw'],
        ];

        return $regels;
    }
}