@extends('layouts.app')
@section('title', 'Registrati come Host')
    
@section('content_main')
<div id="loginPage">

    <div class="row">
        <div class="col-12">
            <div class="container">
                <div class="card my-3">
                    <div class="card-body">
                        <div class="card-title">
                            <h5 class="font-weight-bold text-center" id="ModalRegister">Registrati</h5>
                        </div>
                        <div class="card-text">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
        
                                <div class="form-group modal-dialog-centered row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nome') }}</label>
        
                                    <div class="col-md-8 modal-dialog-centered flex-column">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
        
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group modal-dialog-centered row">
                                    <label for="surname" class="col-md-4 col-form-label text-md-right">{{ __('Cognome') }}</label>
        
                                    <div class="col-md-8 modal-dialog-centered flex-column">
                                        <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname') }}" required autocomplete="surname" autofocus>
        
                                        @error('surname')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group modal-dialog-centered row">
                                    <label for="date_of_birth" class="col-md-4 col-form-label text-md-right">{{ __('Data di nascita') }}</label>
        
                                    <div class="col-md-8 modal-dialog-centered flex-column">
                                        <input id="date_of_birth" type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth') }}" required autocomplete="date_of_birth" autofocus>
        
                                        @error('date_of_birth')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="form-group modal-dialog-centered row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>
        
                                    <div class="col-md-8 modal-dialog-centered flex-column">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
        
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="form-group modal-dialog-centered row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
        
                                    <div class="col-md-8 modal-dialog-centered flex-column">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
        
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="form-group modal-dialog-centered row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Ripeti Password') }}</label>
        
                                    <div class="col-md-8 modal-dialog-centered flex-column">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>
    
                                <div class="form-group row mb-0">
                                    <div class="col-md-12 d-flex flex-column">
                                        <button type="submit" class="btn-login-register py-2">
                                            {{ __('Registrati') }}
                                        </button>
                                        <a href="/login" class="color-red btn btn-link">Hai già un account? Loggati!</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
    
            </div>
        </div>
    </div>
</div>
   
@endsection
