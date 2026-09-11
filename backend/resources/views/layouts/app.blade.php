<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'The Golden Dragon')</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
@vite([
    'resources/css/kassa.css',
    'resources/js/app.js',
])
<body>
    <header class="site-header">
        <div class="site-brand">
            <img
                class="site-brand__dragon"
                src="{{ asset('images/dragon-small.png') }}"
                alt="Golden Dragon"
            >

            <span class="site-brand__name">De Gouden Draak</span>

            <img
                class="site-brand__dragon"
                src="{{ asset('images/dragon-small-flipped.png') }}"
                alt="Golden Dragon"
            >
        </div>

        <a
            class="announcement"
            href="{{ url('/aanbiedingen') }}"
        >
            <span class="announcement__text">
                Welkom bij De Gouden Draak. Klik op deze tekst om de
                aanbiedingen van deze week te zien!
            </span>
        </a>

        <div class="site-brand">
            <img
                class="site-brand__dragon"
                src="{{ asset('images/dragon-small.png') }}"
                alt="Golden Dragon"
            >

            <span class="site-brand__name">De Gouden Draak</span>

            <img
                class="site-brand__dragon"
                src="{{ asset('images/dragon-small-flipped.png') }}"
                alt="Golden Dragon"
            >
        </div>
    </header>

    <main class="decorative-frame">
        <div
            class="decorative-frame__top"
            aria-hidden="true"
        ></div>

        <div class="decorative-frame__body">
            <section class="restaurant-intro">
                <img
                    class="restaurant-intro__dragon"
                    src="{{ asset('images/dragon-small.png') }}"
                    alt="Golden Dragon"
                >

                <div class="restaurant-intro__center">
                    <p class="restaurant-intro__subtitle">
                        Chinees Indische Specialiteiten
                    </p>

                    <h1 class="restaurant-intro__title">
                        De Gouden Draak
                    </h1>

                    <nav aria-label="Hoofdnavigatie">
                        <ul class="main-navigation">
                            <li>
                                <a href="{{ route('menukaart') }}">Menukaart</a>
                            </li>

                            <li>
                                <a href="{{ route('bestellen') }}">Bestellen</a>
                            </li>

                            <li>
                                <a href="{{ route('nieuws') }}">Nieuws</a>
                            </li>

                            <li>
                                <a href="{{ route('contact') }}">Contact</a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <img
                    class="restaurant-intro__dragon"
                    src="{{ asset('images/dragon-small-flipped.png') }}"
                    alt="Golden Dragon"
                >
            </section>

            <section class="page-content">
                @yield('content')
            </section>

            <a
                class="contact-shortcut"
                href="{{ url('/contact') }}"
            >
                Naar Contact
            </a>
        </div>

        <div
            class="decorative-frame__bottom"
            aria-hidden="true"
        ></div>
    </main>
</body>
</html>