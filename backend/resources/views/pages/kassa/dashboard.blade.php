@extends('layouts.kassa')

@section('title', 'GoodPay Kassa')

@section('content')
    <div
        id="kassa-app"
        data-gerechten="{{ $gerechtenPerCategorie->toJson() }}"
        data-opmerkingen="{{ $veelgebruikteOpmerkingen->toJson() }}"
    ></div>
@endsection