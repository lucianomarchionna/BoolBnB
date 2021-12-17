{{-- Creazione appartamenti --}}
@extends('layouts.dashboard')
@section('title', 'Aggiungi appartamento')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <form action="{{ route('host.apartments.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <h1 class="font-weight-bold">Aggiungi un nuovo appartamento</h1>
                    <input type="text" value="{{Auth::user()->id}}" hidden name="user_id">
                    <div class="mt-3 mb-3">
                        <label for="title" class="form-label">Titolo*</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="Aggiungi un titolo" class="@error('title') is-invalid @enderror" value="{{old('title')}}">
                        @error('title')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Tipologia</label>
                        <select name="type" id="type">
                            <option value=""> -- Seleziona -- </option>
                            <option value="appartamento"
                                {{old("type") == "appartamento" ? "selected" : null}}
                            > 
                            Appartamento </option>
                            {{-- da controllare lo spazio lasciato nel value --}}
                            <option value="casa"
                                {{old("type") == "casa" ? "selected" : null}}
                            > Casa intera </option>
                            <option value="stanza"
                                {{old("type") == "stanza" ? "selected" : null}}
                            > Stanza </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descrizione dell'appartamento*</label>
                        <textarea name="description" class="form-control" id="description" placeholder="Aggiungi una descrizione" class="@error('description') is-invalid @enderror">{{old('description')}}</textarea>
                        @error('description')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    {{--L'utente può utilizzare le frecce per sceglire il valore ma anche inserirlo, se lo inserisce controllare che metta solo un numero--}}
                    <div class="d-flex align-items-start flex-wrap pt-3 pb-3"> 
                        <div class="mb-3 mr-4">
                            <label for="mq">Dimensione m<sup>2</sup></label>
                            <input class="text-center" type="number" id="mq" name="mq" min="1" placeholder="Aggiungi la dimensione della struttura in mq" value="{{old('mq')}}">
                        </div>
                        <div class="mb-3 mr-4">
                            <label for="n_rooms">N° di stanze*</label>
                            <input class="text-center" type="number" id="n_rooms" name="n_rooms" min="1" placeholder="Aggiungere numero stanze" class="@error('n_rooms') is-invalid @enderror" value="{{old('n_rooms')}}">
                            @error('n_rooms')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 mr-4">
                            <label for="n_beds">N° di letti*</label>
                            <input class="text-center" type="number" id="n_beds" name="n_beds" min="1" placeholder="Aggiungere numero letti" class="@error('n_beds') is-invalid @enderror" value="{{old('n_beds')}}">
                            @error('n_beds')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 mr-4">
                            <label for="n_baths">N° di bagni*</label>
                            <input class="text-center" type="number" id="n_baths" name="n_baths" min="1" placeholder="Aggiungere numero bagni" class="@error('n_baths') is-invalid @enderror" value="{{old('n_baths')}}">
                            @error('n_baths')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 mr-4">
                            <label for="n_guests">N° di ospiti*</label>
                            <input class="text-center" type="number" id="n_guests" name="n_guests" min="1" placeholder="Aggiungere numero ospiti" class="@error('n_guests') is-invalid @enderror" value="{{old('n_guests')}}">
                            @error('n_guests')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-5">
                        <label>Seleziona i servizi che puoi offrire nella tua struttura</label>
                        <div class="d-flex justify-content-between flex-wrap mt-2">
                            @foreach ($services as $service)
                                <div>
                                    <i class="{{ $service['icon'] }}"></i>
                                    <label for="{{ 'service' . $service['id'] }}" class="form-check-label">{{ $service['name'] }}</label> 
                                    <input type="checkbox" 
                                    {{in_array($service->id, old('services', [])) ? 'checked' : null}}
                                    value="{{ $service['id'] }}" name="services[]" id="{{ 'service' . $service['id'] }}">      
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="d-flex flex-wrap justify-content-between">
                        <div class="mb-3">
                            <label for="pet">Possibilità di portare animali*</label>
                            <input type="text" id="pet" name="pet" class="@error('pet') is-invalid @enderror" value="{{old('pet')}}">
                            @error('pet')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="mb-3">
                            <label for="h_checkin">Orario Checkin*</label>
                            <input type="text" id="h_checkin" name="h_checkin" class="@error('h_checkin') is-invalid @enderror" value="{{old('h_checkin')}}">
                            @error('h_checkin')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="h_checkout">Orario Checkout*</label>
                            <input type="text" id="h_checkout" name="h_checkout" class="@error('h_checkout') is-invalid @enderror" value="{{old('h_checkout')}}">
                            @error('h_checkout')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="price_night">Prezzo per notte</label>
                        <input class="w-25 text-center" type="number" id="price_night" name="price_night" min="1" placeholder="Prezzo per notte" value="{{old('price_night')}}">
                    </div>
                    {{-- Per l'immagine bisogna: modificare il file system, creare un link nella cartella public, inserire l'enctype nel form, utilizzare il metodo Storage::put nel controller --}}
                
                    <div class="mb-3">
                        <label for="image">Inserisci l'immagine di copertina per la tua struttura*</label>
                        <input type="file" id="image" name="image" class="@error('image') is-invalid @enderror">
                        @error('image')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="visibility" class="form-label">Visibilità struttura</label>
                        <select name="visibility" id="visibility">
                            <option value="1"> Rendi visibile </option>
                            <option value="0"> Al momento non voglio renderlo visibile sul sito </option>
                        </select>
                    </div>
            
                    {{-- Inizio autocomplete SearchMap --}}
                    <div class="mb-3">
                        <label for="search-for-coordinates">Indirizzo*</label>
                        <div id="search-field"></div>
                    </div>
                    <div>
                        @error('address')
                            <div class="alert alert-danger pt-1">{{ $message }}</div>
                        @enderror
                        @error('city')
                            <div class="alert alert-danger pt-1">{{ $message }}</div>
                        @enderror
                        @error('street')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <p>I campi contrassegnati con (*) sono richiesti</p>
                    <div class="d-flex mt-2">
                        <a href="{{route('host.apartments.index')}}" class="btn btn-border p-2 mr-3">Torna indietro</a>
                        <button type="submit" class="d-block btn btn-success">Registra l'appartamento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection