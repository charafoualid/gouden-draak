@extends('layouts.kassa')

@section('title', 'Hulpvragen')

@section('content')
    <section class="help-requests">
        <h1>Openstaande hulpvragen</h1>

        @if (session('success'))
            <p class="help-requests__success">
                {{ session('success') }}
            </p>
        @endif

        @if ($hulpvragen->isEmpty())
            <p class="help-requests__empty">
                Er zijn geen openstaande hulpvragen.
            </p>
        @else
            <table class="help-requests__table">
                <thead>
                    <tr>
                        <th>Tafelnummer</th>
                        <th>Aangemaakt op</th>
                        <th>Actie</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($hulpvragen as $hulpvraag)
                        <tr>
                            <td>
                                Tafel {{ $hulpvraag->tafelnummer }}
                            </td>

                            <td>
                                {{ $hulpvraag->aangemaakt_op->format('d-m-Y H:i') }}
                            </td>

                            <td>
                                <form
                                    action="{{ route(
                                        'kassa.hulpvragen.afmelden',
                                        $hulpvraag
                                    ) }}"
                                    method="POST"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit">
                                        Afmelden
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </section>
@endsection