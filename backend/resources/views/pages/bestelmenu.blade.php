@extends('layouts.app')

@section('title', 'Bestellen aan tafel ' . $tafelnummer)

@section('content')
    <div class="tablet-order-intro">
        <h1>Bestellen aan tafel {{ $tafelnummer }}</h1>

        <p>
            Kies rustig uw gerechten en plaats daarna uw bestelling.
        </p>
    </div>
    <div
        id="tablet-bestelling-app"
        data-tafelnummer="{{ $tafelnummer }}"
        data-gerechten="{{ $gerechtenPerCategorie->toJson() }}"
    ></div>
@endsection