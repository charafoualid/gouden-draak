<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'GoodPay Kassa')</title>

    @vite([
        'resources/css/kassa.css',
        'resources/js/app.js',
    ])
</head>
<body>
    <header class="kassa-header">
        <img
            class="kassa-header__logo"
            src="{{ asset('images/goodpay.png') }}"
            alt="GoodPay-logo"
        >

        <nav class="kassa-header__navigation" aria-label="Kassanavigatie">
            @auth
                <a
                    class="kassa-menu-button"
                    href="{{ route('kassa.dashboard') }}"
                >
                    Kassa
                </a>

                <a
                    class="kassa-menu-button"
                    href="{{ route('kassa.gerechten') }}"
                >
                    Gerechten
                </a>

                <a class="kassa-menu-button" href="{{ route('kassa.verkoopoverzicht') }}">
                    Verkoop Overzicht
                </a>

                <form
                    class="kassa-logout-form"
                    action="{{ route('kassa.logout') }}"
                    method="POST"
                >
                    @csrf

                    <button class="kassa-menu-button" type="submit">
                        Log Uit
                    </button>
                </form>
            @endauth
        </nav>
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>