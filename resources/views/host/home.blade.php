{{-- Pagina utente che fa accesso --}}
@extends('layouts.dashboard')
@section('title', 'Home')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1 class="mb-5 font-weight-bold">BoolBnb Dashboard</h1>
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            {{-- access confirm --}}
            <div class="card mb-3">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    {{ __('Accesso effettuato. Inizia a gestire i tuoi appartamenti dalla barra laterale') }}
                </div>
            </div>
            {{-- <div class="d-flex flex-row col-md-12 justify-content-around p-0">
                <div class="card col-xl-6 p-0 mx-1 mb-3">
                    <div class="card-header">{{ __('Appartamenti') }}</div>
                    <div class="card-body">
                        {{ __('anteprima di un appartamento o slideshow degli appartamenti') }}
                    </div>
                </div>
                <div class="card col-xl-6 p-0 mr-1 mb-3">
                    <div class="card-header">{{ __('Statistiche') }}</div>
                    <div class="card-body">
                        {{ __('da vedere poi con chartjs') }}
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header">{{ __('Altro') }}</div>
                <div class="card-body">
                    {{ __('booooooooooooooooooooooooooooooh') }}
                </div>
            </div> --}}
        </div>
    </div>
</div>
@endsection
