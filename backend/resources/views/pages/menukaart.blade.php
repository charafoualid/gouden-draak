@extends('layouts.app')

@section('title', 'Menukaart')

@section('content')
    <div
        id="menukaart-app"
        data-gerechten="{{ $gerechtenPerCategorie->toJson() }}"
    ></div>
@endsection