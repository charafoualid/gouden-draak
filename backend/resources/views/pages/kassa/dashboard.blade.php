@extends('layouts.kassa')

@section('title', 'GoodPay Kassa')

@section('content')
    <section class="cash-desk">
        <div class="cash-desk__left">
            <div class="cash-desk__menu">
                @foreach ($gerechtenPerCategorie as $soortgerecht => $gerechten)
                    <h2 class="cash-desk__heading">
                        {{ $soortgerecht }}
                    </h2>

                    <table class="cash-desk__menu-table">
                        <tbody>
                            @foreach ($gerechten as $gerecht)
                                <tr>
                                    <td>
                                        {{ $gerecht->menunummer }}{{ $gerecht->menu_toevoeging }}.
                                    </td>

                                    <td>
                                        {{ $gerecht->naam }}

                                        @if (! empty($gerecht->beschrijving))
                                            <i>({{ $gerecht->beschrijving }})</i>
                                        @endif
                                    </td>

                                    <td>
                                        € {{ number_format((float) $gerecht->price, 2, ',', ' ') }}
                                    </td>

                                    <td>
                                        <button type="button">
                                            Toevoegen
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>
        </div>

        <div class="cash-desk__right">
            <div class="cash-desk__order-container">
                <div class="cash-desk__order">
                    <h2 class="cash-desk__heading cash-desk__order-heading">
                        Bestelling
                    </h2>

                    <table class="cash-desk__order-table">
                        <tbody>
                            {{-- Bestelregels komen hier later via Vue --}}
                        </tbody>
                    </table>
                </div>

                <div class="cash-desk__total">
                    <table class="cash-desk__total-table">
                        <tbody>
                            <tr>
                                <td></td>

                                <td>Totaal:</td>

                                <td>€ 0,00</td>

                                <td class="cash-desk__actions">
                                    <button type="button">Afrekenen</button>
                                    <button type="button">Verwijderen</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection