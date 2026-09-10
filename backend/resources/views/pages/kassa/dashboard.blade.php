@extends('layouts.kassa')

@section('title', 'GoodPay Kassa')

@section('content')
    <div class="kassa-login">
        <p>Inloggen gelukt.</p>
        <p>Medewerkernummer: {{ auth()->id() }}</p>
    </div>
@endsection