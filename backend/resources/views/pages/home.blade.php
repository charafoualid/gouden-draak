@extends('layouts.app')

@section('title', 'The Golden Dragon')

@section('content')
    <article class="student-offer">
        <p class="student-offer__introduction">
            <span>
                Al jaren is De Gouden Draak een begrip als het gaat om de beste
                afhaalgerechten in 's-Hertogenbosch.
            </span>

            <span>
                Graag trakteren we u op authentieke gerechten uit de Cantonese keuken.
            </span>
        </p>

        <h2 class="student-offer__title">
            Speciale Studentenaanbieding
        </h2>

        <h3 class="student-offer__meal">
            Chinese Rijsttafel (2 personen)
        </h3>

        <p class="student-offer__instruction">
            Maak een keuze uit 3 van onderstaande keuzegerechten:
        </p>

        <div class="student-offer__dishes">
            <ul class="student-offer__dish-column student-offer__dish-column--left">
                <li>Koe Loe Yuk</li>
                <li>Tjap Tjoy</li>
                <li>Babi Pangang</li>
            </ul>

            <ul class="student-offer__dish-column">
                <li>Foe Yong Hai</li>
                <li>Garnalen met Gebakken Knoflook</li>
                <li>Kipfilet in Zwarte Bonen saus</li>
            </ul>
        </div>

        <p class="student-offer__rice">
            Met witte rijst. (Nasi of bami voor meerprijs mogelijk.)
        </p>

        <p class="student-offer__price">
            Prijs: €21,00
        </p>
    </article>
@endsection