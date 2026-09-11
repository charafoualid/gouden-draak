@extends('layouts.app')

@section('title', 'Bestellen')

@section('content')
    <section class="table-selection">
        <div class="table-selection__intro">
            <h1>Kies uw tafelnummer</h1>

            <p>
                Selecteer het nummer van uw tafel om te beginnen met bestellen.
            </p>
        </div>

        <div class="table-selection__options">
            @for ($tafelnummer = 1; $tafelnummer <= 10; $tafelnummer++)
                <form
                    action="{{ route('bestellen.tafel', $tafelnummer) }}"
                    method="POST"
                >
                    @csrf

                    <button type="submit">
                        Tafel {{ $tafelnummer }}
                    </button>
                </form>
            @endfor
        </div>
    </section>
@endsection