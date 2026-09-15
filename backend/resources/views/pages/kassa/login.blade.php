@extends('layouts.kassa')

@section('title', 'GoodPay Kassa')

@section('content')
    <div class="kassa-login">
        <form action="{{ route('kassa.login.submit') }}" method="POST">
            @csrf

            <label class="visually-hidden" for="employeeNr">
                Medewerker Nummer
            </label>

            <input
                id="employeeNr"
                type="number"
                name="employeeNr"
                value="{{ old('employeeNr') }}"
                placeholder="Medewerker Nummer"
                min="1"
                autocomplete="username"
                required
                autofocus
            ><br>

            <label class="visually-hidden" for="password">
                Wachtwoord
            </label>

            <input
                id="password"
                type="password"
                name="password"
                placeholder="Wachtwoord"
                autocomplete="current-password"
                required
            ><br>

            <input type="submit" value="inloggen"><br>
        </form>
    </div>

    @if ($errors->any())
        <div class="error-message">
            {{ $errors->first() }}
        </div>
    @endif
@endsection