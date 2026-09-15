@extends('layouts.app')

@section('title', 'Contact | De Gouden Draak')

@section('content')
    <section class="contact">
        <div class="contact-information">
            <p class="contact-information__description">
                De Gouden Draak is eenvoudig te vinden, vlak bij het centrum,
                5 minuten lopen achter het centraal station.
            </p>

            <address class="contact-information__address">
                <span>Onderwijsboulevard 215, kamer OG112</span>
                <span>5223 DE 's-Hertogenbosch</span>
            </address>
        </div>

        <div class="contact-map">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2473.432987711052!2d5.284448915590253!3d51.68852110526529!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c6ee8855f3c5d1%3A0x4c4797f27d227e73!2sOnderwijsboulevard%20215%2C%205223%20DE%20&#39;s-Hertogenbosch!5e0!3m2!1sen!2snl!4v1585055473064!5m2!1sen!2snl"
                title="Locatie van De Gouden Draak"
                width="100%"
                height="450"
                loading="lazy"
                allowfullscreen
            ></iframe>
        </div>
    </section>
@endsection