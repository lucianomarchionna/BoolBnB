{{-- Pagina dettaglio appartamento (host) --}}
@extends('layouts.dashboard')
@section('title', 'Info appartamento')
    
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1 class="font-weight-bold">INFO APPARTAMENTO: {{$apartment->title}}</h1>
            <div class="col-md-12 p-0 mt-4">
                <p class="fs-20 font-weight-bold text-capitalize">Titolo: {{$apartment->title}}</p>
                <p class="fs-15 d-flex flex-column">Immagine di copertina: <img class="host-apartments-img my-2" src="{{ asset('storage/' . $apartment->image)}}" alt="Image inserted"></p>
                <p class="fs-15">ID: {{$apartment->id}}</p>
                <p class="fs-15 text-capitalize">Tipologia: {{$apartment->type}}</p>
                <p class="fs-15 text-capitalize">Descrizione: {{$apartment->description}}</p>
                <p class="fs-15">Mq: {{$apartment->mq}}</p>
                <p class="fs-15">N° di letti: {{$apartment->n_beds}}</p>
                <p class="fs-15">N° di stanze: {{$apartment->n_rooms}}</p>
                <p class="fs-15">N° di ospiti: {{$apartment->n_guests}}</p>
                <p class="fs-15 text-capitalize">Servizi:
                @foreach($apartment->services as $service)
                    @if ($loop->last)
                        {{($service->name)}}.
                    @else
                        {{($service->name)}},
                    @endif
                @endforeach
                </p>
                <p class="fs-15 text-capitalize">Animali: {{$apartment->pet}}</p>
                <p class="fs-15 text-capitalize">Orario checkin: {{$apartment->h_checkin}}</p>
                <p class="fs-15 text-capitalize">Orario checkout: {{$apartment->h_checkout}}</p>
                <p class="fs-15">Prezzo per notte: {{$apartment->price_night}}</p>
                <p class="fs-15 text-capitalize">Città: {{$apartment->city}}</p>
                <p class="fs-15 text-capitalize">Via: {{$apartment->street}}</p>
                <p class="fs-15 mb-4">N° civico: {{$apartment->house_number}}</p>
                <a href="{{route('host.apartments.index')}}" class="btn btn-login-register p-2">Torna indietro</a>
            </div>
        </div>
    </div>
</div>
@endsection