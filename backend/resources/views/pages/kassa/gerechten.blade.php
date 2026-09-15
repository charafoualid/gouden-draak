@extends('layouts.kassa')

@section('title', 'Gerechten')

@section('content')
    <section class="dish-management">
        <div class="dish-management__toolbar">
            <h1>Gerechten beheren</h1>

            <details>
                <summary>+ Gerecht toevoegen</summary>

                <form
                    method="POST"
                    action="{{ route('kassa.gerechten.store') }}"
                    class="dish-management__form"
                >
                    @csrf

                    <label>
                        Nummer
                        <input
                            type="number"
                            name="menunummer"
                            min="1"
                            required
                        >
                    </label>

                    <label>
                        Toevoeging
                        <input
                            type="text"
                            name="menu_toevoeging"
                            maxlength="10"
                            placeholder="Bijvoorbeeld A"
                        >
                    </label>

                    <label>
                        Naam
                        <input
                            type="text"
                            name="naam"
                            maxlength="255"
                            required
                        >
                    </label>

                    <label>
                        Beschrijving
                        <input
                            type="text"
                            name="beschrijving"
                            maxlength="1000"
                        >
                    </label>

                    <label>
                        Categorie
                        <input
                            type="text"
                            name="soortgerecht"
                            list="categorieen"
                            maxlength="255"
                            required
                        >
                    </label>

                    <label>
                        Prijs
                        <input
                            type="number"
                            name="price"
                            min="0"
                            step="0.01"
                            required
                        >
                    </label>

                    <button type="submit">Opslaan</button>
                </form>
            </details>
        </div>

        <datalist id="categorieen">
            @foreach ($categorieen as $categorie)
                <option value="{{ $categorie }}">
            @endforeach
        </datalist>

        @if ($errors->any())
            <div class="dish-management__error">
                @foreach ($errors->all() as $fout)
                    <p>{{ $fout }}</p>
                @endforeach
            </div>
        @endif

        @if (session('success'))
            <p class="dish-management__success">
                {{ session('success') }}
            </p>
        @endif

        @foreach ($gerechtenPerCategorie as $categorie => $gerechten)
            <section class="dish-management__category">
                <h2>{{ $categorie }}</h2>

                @foreach ($gerechten as $gerecht)
                    <div class="dish-management__item">
    <strong class="dish-management__number">
        {{ $gerecht->menunummer }}{{ $gerecht->menu_toevoeging }}.
    </strong>

    <div class="dish-management__information">
        <strong>{{ $gerecht->naam }}</strong>

        @if ($gerecht->beschrijving)
            <i>({{ $gerecht->beschrijving }})</i>
        @endif
    </div>

    <strong class="dish-management__price">
        € {{ number_format($gerecht->price, 2, ',', '.') }}
    </strong>

    <details class="dish-management__edit">
        <summary>Wijzigen</summary>

        <form
            method="POST"
            action="{{ route(
                'kassa.gerechten.update',
                $gerecht
            ) }}"
            class="dish-management__form"
        >
            @csrf
            @method('PATCH')

            <label>
                Nummer
                <input
                    type="number"
                    name="menunummer"
                    value="{{ $gerecht->menunummer }}"
                    min="1"
                    required
                >
            </label>

            <label>
                Toevoeging
                <input
                    type="text"
                    name="menu_toevoeging"
                    value="{{ $gerecht->menu_toevoeging }}"
                    maxlength="10"
                >
            </label>

            <label>
                Naam
                <input
                    type="text"
                    name="naam"
                    value="{{ $gerecht->naam }}"
                    maxlength="255"
                    required
                >
            </label>

            <label>
                Beschrijving
                <input
                    type="text"
                    name="beschrijving"
                    value="{{ $gerecht->beschrijving }}"
                    maxlength="1000"
                >
            </label>

            <label>
                Categorie
                <input
                    type="text"
                    name="soortgerecht"
                    value="{{ $gerecht->soortgerecht }}"
                    list="categorieen"
                    maxlength="255"
                    required
                >
            </label>

            <label>
                Prijs
                <input
                    type="number"
                    name="price"
                    value="{{ $gerecht->price }}"
                    min="0"
                    step="0.01"
                    required
                >
            </label>

            <button type="submit">Wijzigingen opslaan</button>
        </form>
    </details>

    <form
        method="POST"
        action="{{ route(
            'kassa.gerechten.destroy',
            $gerecht
        ) }}"
        onsubmit="return confirm(
            'Weet u zeker dat u dit gerecht wilt verwijderen?'
        )"
    >
        @csrf
        @method('DELETE')

        <button
            type="submit"
            class="dish-management__delete"
        >
            Verwijderen
        </button>
    </form>
</div>
                @endforeach
            </section>
        @endforeach
    </section>
@endsection