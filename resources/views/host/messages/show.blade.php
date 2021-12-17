@extends('layouts.dashboard')
@section('title', 'Messaggio di ' . $message->fullname)
    
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>Nome utente: {{$message->fullname}}</h2>
                    </div>
                    <div class="card-subtitle">
                        <h4>Email mittente: {{$message->email}}</h4>
                    </div>
                    <div class="card-subtitle">
                        <h4>Richiesta informazioni per: {{$message->apartment_title}}</h4>
                    </div>
                    <div class="card-text">
                        <h5>Corpo del messaggio:</h5>
                        <p>{{$message->message}}</p>
                    </div>
                    <div class="card-footer bg-white d-flex justify-content-between align-items-center p-0">
                        <a href="mailto:{{$message->email}}?subject={{$message->apartment_title . ' '}}BoolBnB" class="btn btn-primary h-75">Rispondi via email</a>
                        <form action="{{route('host.delete-message', $message->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                                <button class="btn" type="submit" class="my-trash-icon">
                                    <div class="my-icons">
                                        <img src="{{asset('images/icons/trash.png')}}" alt="" class="w-75">
                                    </div>
                                </button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection