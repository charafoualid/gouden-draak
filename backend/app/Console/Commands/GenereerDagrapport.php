<?php

namespace App\Console\Commands;

use App\Exports\DagverkoopExport;
use App\Services\VerkoopoverzichtService;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class GenereerDagrapport extends Command
{
    protected $signature = 'verkoop:dagrapport
                            {datum? : Datum in formaat JJJJ-MM-DD}';

    protected $description = 'Genereert het dagelijkse verkooprapport';

    public function handle(
        VerkoopoverzichtService $verkoopoverzicht
    ): int {
        $datum = $this->argument('datum')
            ?? now()->subDay()->toDateString();

        $overzicht = $verkoopoverzicht->maak(
            $datum,
            $datum
        );

        $bestandsnaam =
            "verkooprapporten/verkoop-{$datum}.xlsx";

        Excel::store(
            new DagverkoopExport($overzicht, $datum),
            $bestandsnaam,
            'local'
        );

        $this->info(
            "Dagrapport voor {$datum} is gegenereerd."
        );

        return self::SUCCESS;
    }
}