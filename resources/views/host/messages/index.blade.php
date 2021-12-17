@extends('layouts.dashboard')
@section('title', 'Messaggi')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if (session('deleted-message'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{session('deleted-message')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            
            @if (!empty($user_messages))
            <h2 class="font-weight-bold">Hai ricevuto i seguenti messaggi:</h2>
            <div class="messages-list d-flex flex-column-reverse">
                @foreach ($user_messages as $user_message)
                    <div class="card my-2">
                        <div class="card-body">
                            <div class="card-title">{{$user_message->fullname}}</div>
                            <div class="card-subtitle">{{$user_message->apartment_title}}</div>
                        </div>
                        <div class="card-body d-flex justify-content-between">
                            <a href="{{route('host.show-message', $user_message->id)}}" class="btn btn-primary d-flex align-items-center h-75">Leggi</a>
                            <form action="{{route('host.delete-message', $user_message->id)}}" method="post">
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
                @endforeach
            </div>
            @else
                <h2 class="font-weight-bold">Nessun Messaggio Ricevuto</h2>
            @endif
        </div>
    </div>
</div>

        
@endsection