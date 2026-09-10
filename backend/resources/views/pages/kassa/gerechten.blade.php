@extends('layouts.kassa')

@section('title', 'Gerechten | GoodPay Kassa')

@section('content')
    <section class="kassa-menu-page">
        <img
            class="kassa-menu-page__image"
            src="{{ asset('menukaarten/restaurant-menukaart-1-2.jpg') }}"
            alt="Menukaart pagina 1"
        >

        <img
            class="kassa-menu-page__image"
            src="{{ asset('menukaarten/restaurant-menukaart-1.jpg') }}"
            alt="Menukaart pagina 2"
        >
    </section>
@endsection