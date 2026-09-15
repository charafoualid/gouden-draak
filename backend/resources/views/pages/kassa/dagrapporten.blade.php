@extends('layouts.kassa')

@section('title', 'Dagrapporten')

@section('content')
    <section class="daily-reports">
        <h1>Dagrapporten</h1>

        @if ($rapporten->isEmpty())
            <p>Er zijn nog geen dagrapporten gegenereerd.</p>
        @else
            <table class="daily-reports__table">
                <thead>
                    <tr>
                        <th>Rapportdatum</th>
                        <th>Bestandsnaam</th>
                        <th>Downloaden</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($rapporten as $rapport)
                        <tr>
                            <td>{{ $rapport['datum'] }}</td>

                            <td>
                                {{ $rapport['bestandsnaam'] }}
                            </td>

                            <td>
                                <a href="{{ route(
                                    'kassa.dagrapporten.download',
                                    $rapport['bestandsnaam']
                                ) }}">
                                    Downloaden
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </section>
@endsection