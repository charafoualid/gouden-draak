@extends('layouts.app')

@section('title', 'Menukaart | De Gouden Draak')

@section('content')
    <section
        class="menu-pages"
        aria-label="Menukaart van De Gouden Draak"
    >
        <img
            class="menu-pages__image"
            src="{{ asset('menukaarten/restaurant-menukaart-1-2.jpg') }}"
            alt="Menukaart van De Gouden Draak, eerste pagina"
        >

        <img
            class="menu-pages__image"
            src="{{ asset('menukaarten/restaurant-menukaart-1.jpg') }}"
            alt="Menukaart van De Gouden Draak, tweede pagina"
        >
    </section>
@endsection