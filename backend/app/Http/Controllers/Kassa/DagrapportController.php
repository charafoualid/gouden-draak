<?php

namespace App\Http\Controllers\Kassa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
//use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DagrapportController extends Controller
{
    public function index(): View
    {
        $rapporten = collect(
            Storage::disk('local')->files('verkooprapporten')
        )
            ->filter(
                fn (string $bestand) =>
                    str_ends_with($bestand, '.xlsx')
            )
            ->sortDesc()
            ->map(fn (string $bestand) => [
                'bestandsnaam' => basename($bestand),
                'datum' => str_replace(
                    ['verkoop-', '.xlsx'],
                    '',
                    basename($bestand)
                ),
            ])
            ->values();

        return view('pages.kassa.dagrapporten', [
            'rapporten' => $rapporten,
        ]);
    }

    public function download(
        string $bestandsnaam
    ): BinaryFileResponse {
        abort_unless(
            preg_match(
                '/^verkoop-\d{4}-\d{2}-\d{2}\.xlsx$/',
                $bestandsnaam
            ),
            404
        );

        $bestand = 'verkooprapporten/'.$bestandsnaam;

        abort_unless(
            Storage::disk('local')->exists($bestand),
            404
        );

        return response()->download(
            Storage::disk('local')->path($bestand)
        );
    }
}