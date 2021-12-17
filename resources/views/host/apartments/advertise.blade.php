@extends('layouts.dashboard')
@section('title', 'Sponsorizza il tuo appartamento')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <div class="container" id="payment_section">
                <h1 class="font-weight-bold">Sponsorizza il tuo appartamento: {{$apartment->title}}</h1>
                <div class="row my-5">
                @foreach ($advertises as $advertise)
                    <div class="col-12 col-md-4">
                        <div class="card text-center border-0 shadow-{{$advertise->name}}">
                            <div class="card-body">
                                <div class="card-title w-100  text-uppercase font-weight-bold fs-24 bg-{{$advertise->name}} p-2 border rounded text-white mb-4">{{$advertise->name}}</div>
                                <div class="card-text card-price mb-2 font-weight-bold">{{$advertise->price}}</div>
                                <div class="card-text mb-4">Metti in risalto per <p class="font-weight-bold fs-20">{{$advertise->duration}} ore</p></div>
                            </div>
                            <div class="card-footer bg-white ">
                                <a href="{{route('host.apartments.advertise.payment', ['id' => $apartment->id, 'advertise_id'=>$advertise->id])}}" class="btn p-2 px-4 btn-{{$advertise->name}} ">Compra ora</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection