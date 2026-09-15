<?php

namespace App\Http\Controllers\Kassa;

use App\Http\Controllers\Controller;
use App\Models\Gerecht;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class GerechtController extends Controller
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

        $categorieen = Gerecht::query()
            ->select('soortgerecht')
            ->distinct()
            ->orderBy('soortgerecht')
            ->pluck('soortgerecht');

        return view('pages.kassa.gerechten', [
            'gerechtenPerCategorie' => $gerechtenPerCategorie,
            'categorieen' => $categorieen,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $gegevens = $this->valideerGerecht($request);

        Gerecht::create([
            ...$gegevens,
            'actief' => true,
        ]);

        return redirect()
            ->route('kassa.gerechten')
            ->with('success', 'Gerecht is toegevoegd.');
    }

    public function update(
        Request $request,
        Gerecht $gerecht
    ): RedirectResponse {
        $gegevens = $this->valideerGerecht(
            $request,
            $gerecht
        );

        $gerecht->update($gegevens);

        return redirect()
            ->route('kassa.gerechten')
            ->with('success', 'Gerecht is gewijzigd.');
    }

    public function destroy(
        Gerecht $gerecht
    ): RedirectResponse {
        $gerecht->update([
            'actief' => false,
        ]);

        return redirect()
            ->route('kassa.gerechten')
            ->with('success', 'Gerecht is verwijderd.');
    }

    private function valideerGerecht(
        Request $request,
        ?Gerecht $huidigGerecht = null
    ): array {
        $request->merge([
            'menu_toevoeging' => $request->filled(
                'menu_toevoeging'
            )
                ? strtoupper($request->input('menu_toevoeging'))
                : null,
        ]);

        $gegevens = $request->validate([
            'menunummer' => [
                'required',
                'integer',
                'min:1',
            ],
            'menu_toevoeging' => [
                'nullable',
                'string',
                'max:10',
            ],
            'naam' => [
                'required',
                'string',
                'max:255',
            ],
            'beschrijving' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'soortgerecht' => [
                'required',
                'string',
                'max:255',
            ],
            'price' => [
                'required',
                'numeric',
                'min:0',
                'decimal:0,2',
            ],
        ]);

        $bestaatAl = Gerecht::query()
            ->where('menunummer', $gegevens['menunummer'])
            ->where(
                'menu_toevoeging',
                $gegevens['menu_toevoeging']
            )
            ->when(
                $huidigGerecht,
                fn ($query) => $query->where(
                    'id',
                    '!=',
                    $huidigGerecht->id
                )
            )
            ->exists();

        if ($bestaatAl) {
            throw ValidationException::withMessages([
                'menunummer' =>
                    'Dit menunummer bestaat al.',
            ]);
        }

        return $gegevens;
    }
}