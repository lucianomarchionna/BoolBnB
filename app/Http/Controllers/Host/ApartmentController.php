<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Apartment;
use App\Statistic;
use App\Service;
use App\Advertise;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $apartments = Apartment::where('user_id', $user_id)->get();
        $advertises = Advertise::all();
        
        $houses = DB::table('advertises')
        ->join('advertise_apartment', 'advertise_apartment.advertise_id', '=', 'advertises.id')
        ->join('apartments', 'advertise_apartment.apartment_id', 'apartments.id')
        ->where('apartments.user_id', '=', $user_id)
        ->get();


        $adv_houses = [];
        foreach($houses as $house){
            if(Carbon::now()->toDateTimeString() < $house->end_date){
                $adv_houses[] = $house;
            }
        }

        return view('host.apartments.index', compact('apartments', 'advertises', 'adv_houses'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $services = Service::all();
        return view('host.apartments.create', compact('services'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Creo apiURL per ricevere info TomTom
        $apiUrl = 'https://api.tomtom.com/search/2/geocode/' . $request->address . '.JSON?key=6pyK2YdKNiLrHrARYvnllho6iAdjMPex';

        // Prendo la risposta in formato JSON
        $responseJson = Http::get($apiUrl)->json();

        // Setto a Null le variabili per l'indirizzo
        $city = NULL;
        $street = NULL;
        $house_number = NULL;

        $lat = NULL;
        $long = NULL;

        // Prendo gli address dalla risposta
        $responseAddress = $responseJson['results'][0]['address'];
        if(isset($responseAddress['municipality'])){
            $city = $responseAddress['municipality'];
        }
        if(isset($responseAddress['streetName'])){
            $street = $responseAddress['streetName'];
        }
        if(isset($responseAddress['streetNumber'])){
            $house_number = $responseAddress['streetNumber'];
        }else{
            $house_number = 1;
        }

        // Prendo la posizione lat e long dalla risposta position
        $responsePosition = $responseJson['results'][0]['position'];
        if(isset($responsePosition['lat'])){
            $lat = $responsePosition['lat'];
        }
        if(isset($responsePosition['lon'])){
            $long = $responsePosition['lon'];
        }

        $validationData = [
            'city' => $city,
            'street' => $street,
            'house_number' => $house_number,
        ];

        // prepare validatio rules package
        $validationRules = [
            'city' => 'required|max:255',
            'street' => 'required|max:255',
            'house_number' => 'required|max:20',
        ];

        // call validator method
        $validator = Validator::make($validationData, $validationRules);

        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $request->validate([
            //Required
            "title" => "required|max:255",
            "description" => "required",
            "n_rooms" => "required|numeric",
            "n_beds" => "required|numeric",
            "n_baths" => "required|numeric",
            "n_guests" => "required|numeric",
            "pet" => "required",
            "h_checkin" => "required",
            "h_checkout" => "required",
            "image" => "required|image",
            // "city" => "required",
            // "street" => "required",
            //"services" => "exists:services,id",

            //da modificare lat e long con tomtom
            // "lat" => "required|numeric",
            // "long" => "required|numeric",
            // "house_number" => "required",
            //Nullable
            "type" => "nullable",
            "mq" => "nullable|numeric",
            "price_night" => "nullable|numeric"
        ]);
    
        $form_data_apartment = $request->all();
        $form_data_apartment['city']=$city;
        $form_data_apartment['street']=$street;
        $form_data_apartment['house_number']=$house_number;
        $form_data_apartment['lat']=$lat;
        $form_data_apartment['long']=$long;

        //Verifico se l'immagine è stata caricata
        if(array_key_exists('image', $form_data_apartment)){
            $img_path = Storage::put('apartment_image', $form_data_apartment['image']);
            $form_data_apartment['image'] = $img_path;
        }
        $new_apartment = new Apartment();
        $new_apartment->fill($form_data_apartment);

        //Creazione slug
        $slug = Str::slug($new_apartment->title, '-');
        $slug_apartment = Apartment::where('slug', $slug)->first();
        //il ciclo inizia se lo slug è gia presente
        $i= 1;
        while($slug_apartment) {
            $slug = $slug . '-' . $i;
            $slug_apartment = Apartment::where('slug', $slug)->first();
            $i++;
        }
        $new_apartment->slug = $slug;
        //Fino a qui creo solo l'appartamento con tutti i valori delle colonne ma senza assegnargli l'id
  
        $new_apartment->save();
        //Faccio qui l'attach perchè dopo il salvataggio l'appartamento avrà l'id assegnato a cui dobbiamo collegare gli id dei servizi 
        
        //$new_apartment->services()->attach($form_data_apartment['services']);
 
        
        if(array_key_exists('services', $form_data_apartment)) {
            $new_apartment->services()->attach($form_data_apartment['services']);
        } else {
            $new_apartment->services()->attach([]);
        }
        
        return redirect()->route('host.apartments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  Apartment $apartment
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        if(!$apartment) {
            abort(404);
        }elseif(Auth::user()->id !== $apartment->user_id){
            return redirect()->back();
        }
        return view('host.apartments.show', compact('apartment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Apartment $apartment
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
        if(!$apartment) {
            abort(404);
        }elseif(Auth::user()->id !== $apartment->user_id){
            return redirect()->back();
        }
        $services = Service::all();
        return view('host.apartments.edit', compact('apartment','services'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Apartment $apartment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apartment $apartment)
    {
         // Creo apiURL per ricevere info TomTom
         if($request->address){
            $apiUrl = 'https://api.tomtom.com/search/2/geocode/' . $request->address . '.JSON?key=6pyK2YdKNiLrHrARYvnllho6iAdjMPex';
            $responseJson = Http::get($apiUrl)->json();
            $responseAddress = $responseJson['results'][0]['address'];
            if(isset($responseAddress['municipality'])){
                $city = $responseAddress['municipality'];
                $apartment->city = $city;
            }
            if(isset($responseAddress['streetName'])){
                $street = $responseAddress['streetName'];
                $apartment->street = $street;
    
            }
            if(isset($responseAddress['streetNumber'])){
                $house_number = $responseAddress['streetNumber'];
                $apartment->house_number = $house_number;
    
            }else{
                $house_number = 1;
            }
            $responsePosition = $responseJson['results'][0]['position'];
            if(isset($responsePosition['lat'])){
             $lat = $responsePosition['lat'];
             $apartment->lat =  $lat;
            }
            if(isset($responsePosition['lon'])){
             $long = $responsePosition['lon'];
             $apartment->long = $long;
            }
         }

        $request->validate([
            //Required
            "title" => "required|max:255",
            "description" => "required",
            "n_rooms" => "required|numeric",
            "n_beds" => "required|numeric",
            "n_baths" => "required|numeric",
            "n_guests" => "required|numeric",
            "pet" => "required",
            "h_checkin" => "required",
            "h_checkout" => "required",

            //Nullable
            "type" => "nullable",
            "mq" => "nullable|numeric",
            "price_night" => "nullable|numeric"
        ]);

        $form_data_apartment = $request->all();

        if(array_key_exists('image', $form_data_apartment)){
            Storage::delete($apartment->image);
            $img_path = Storage::put('apartment_image', $form_data_apartment['image']);
            $form_data_apartment['image'] = $img_path;
        }
        
        if($form_data_apartment != $apartment->title) {
            //Creazione slug
            $slug = Str::slug($form_data_apartment['title'], '-');
            $slug_apartment = Apartment::where('slug', $slug)->first();
            //il ciclo inizia se lo slug è gia presente
            $i= 1;
            while($slug_apartment) {
                $slug = $slug . '-' . $i;
                $slug_apartment = Apartment::where('slug', $slug)->first();
                $i++;
            }
            
            //Dobbiamo inviare il nuovo slug, quindi bisogna sovracrivere la proprietà slug
            
            $form_data_apartment['slug'] = $slug;
        }

        if(isset($responseJson)){
            $form_data_apartment['city'] = $city;
            $form_data_apartment['street'] = $street;
            $form_data_apartment['house_number'] = $house_number;
            $responsePosition = $responseJson['results'][0]['position'];
            $form_data_apartment['lat'] = $lat;
            $form_data_apartment['long'] = $long;
        } else {
            $form_data_apartment['city'] =  $apartment->city;
            $form_data_apartment['street'] = $apartment->street;
            $form_data_apartment['house_number'] = $apartment->house_number;
            $form_data_apartment['lat'] = $apartment->lat;
            $form_data_apartment['lon'] = $apartment->long;
        }
        
        //Per inviare i dati utilizzo il metodo update
        $apartment->update($form_data_apartment);
        
       
        if(array_key_exists('services', $form_data_apartment)) {
            $apartment->services()->sync($form_data_apartment['services']);
        } else {
            $apartment->services()->sync([]);
        }
       
        return redirect()->route('host.apartments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Apartment $apartment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {
        $apartment->delete();
        return redirect()->route('host.apartments.index');
    }

    public function sponsor($id){
        $apartment = Apartment::where('id', $id)->first();
        if(!$apartment) {
            abort(404);
        }elseif(Auth::user()->id !== $apartment->user_id){
            return redirect()->back();
        }
        $advertises = Advertise::all();
        return view('host.apartments.advertise', compact('advertises', 'apartment'));
    }
}
