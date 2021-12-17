{{-- Lista con appartamenti dell'host autenticato --}}
@extends('layouts.dashboard')
@section('title', 'I tuoi appartamenti')
    
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if (session('sponsored'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('sponsored') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            @if (count($apartments) < 1)
                <h2 class="font-weight-bold">Non hai registrato nessun appartamento</h2>
                <a href="{{route('host.apartments.create')}}" class="btn btn-danger">Inizia ad ospitare</a>
            @else
            @if (count($adv_houses)>0)
            <h3>Appartamenti sponsorizzati attivi:</h3>
            <ol>
            @foreach ($adv_houses as $house)
            <div class="row border rounded my-4 align-items-center">
                <h5 class="col-12 col-md-6">{{$house->title}}</h5>
                <div class="col-12 col-md-6 text-right d-flex flex-column justify-content-center">
                    <span>Promozione valida fino al:</span>
                    <p>{{$house->end_date}}</p>
                </div>
            </div>
            @endforeach
            </ol>
            @endif
            <h2 class="font-weight-bold">I miei appartamenti:</h2>
            <ol>
            @foreach ($apartments as $apartment)
                <div class="border rounded row my-4 apartment-row align-items-center py-3">
                    <div class="col-12 col-md-6">
                        <div class="row col-12">
                            <h4>{{$apartment->title}}</h4>
                        </div>
                        <div class="row col-12 align-items-center edit-delete">
                            <a href="{{ route('host.apartments.edit', $apartment['id'])}}" class="">Modifica</a>
                            <form class="d-inline confirm-delete-post" method="POST" action="{{ route('host.apartments.destroy', $apartment['id']) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-link text-danger" type="submit">Elimina</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 details-statistic text-right">
                        <a href="{{ route('host.apartments.show', $apartment['id'])}}" class="btn btn-success">Dettagli</a>
                        <a href="{{ route('host.statistic', $apartment->id)}}" class="btn btn-dark">Statistiche</a>
                        <a href="{{ route('host.apartments.advertise', $apartment['id'])}}" class="btn btn-primary">Sponsorizza</a>
                    </div>
                </div>
            @endforeach
            </ol>        
            @endif
        </div>
    </div>
</div>
@endsection