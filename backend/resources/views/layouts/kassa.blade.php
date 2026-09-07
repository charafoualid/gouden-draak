<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'GoodPay Kassa')</title>

    @vite('resources/css/kassa.css')
</head>
<body>
    <header class="kassa-header">
        <img
            class="kassa-header__logo"
            src="{{ asset('images/goodpay.png') }}"
            alt="GoodPay-logo"
        >

        <nav class="kassa-header__navigation">
            @yield('navigation')
        </nav>
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>