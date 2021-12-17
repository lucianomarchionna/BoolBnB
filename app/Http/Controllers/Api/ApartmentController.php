<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Apartment;
use App\Service;
use App\Message;
use Illuminate\Support\Carbon;
class ApartmentController extends Controller
{
    public function searchApartment(Request $request){

        // Funzione per calcolare la distanza tra due punti sulla terra
        function distanceCalculation($point1_lat, $point1_long, $point2_lat, $point2_long, $decimals = 2) {
            // Calculate the distance in degrees
            $degrees = rad2deg(acos((sin(deg2rad($point1_lat))*sin(deg2rad($point2_lat))) + (cos(deg2rad($point1_lat))*cos(deg2rad($point2_lat))*cos(deg2rad($point1_long-$point2_long)))));
    
            // Convert the distance in degrees to km
            $distance = $degrees * 111.13384; // 1 degree = 111.13384 km, based on the average diameter of the Earth (12,735 km)
            return round($distance, $decimals);
        };

        // Mi salvo la query in una variabile
        $resQuery = $request->query();
        $ids = explode(',', $request->services);

        // Creo il primo filtro in base a ciò che mi viene passato dalla query. Se non mi viene passato nessun valore lo inizializzo io con 0
        $filteredApartments = Apartment::where('visibility', 1)
        ->where('n_rooms', '>=', $resQuery['n_rooms'] ?? 0)
        ->where('n_beds', '>=', $resQuery['n_beds'] ?? 0)
        ->where('n_guests', '>=', $resQuery['n_guests'] ?? 0)
        ->get();


        if(!empty($request->services)){
            $filteredApartments = Apartment::whereHas('services', function($q) use($ids){
                $q->whereIn('service_id', $ids);
            })->get();
        }

        // Salvo la distanza passata dal range input
        $rangeDistance = $request->distance;

        // Salvo la lat e long della città cercata dall'utente e se non c'è imposto quella di una città (in questo caso Torino)
        $lat = $request->lat;
        $long = $request->long;

        // Controllo tramite un foreach che i singoli appartamenti che si sono salvati dal primo filtro risultino nel raggio della distanza che ha inserito l'utente
        $filteredApartmentsByDistance = [];
        foreach($filteredApartments as $apartment){
            $distancePoints = distanceCalculation($lat, $long, $apartment->lat, $apartment->long, 2);
            if($distancePoints < $rangeDistance || ($lat === null && $long === null)){
                $filteredApartmentsByDistance[] = $apartment;
            }
        };



        $services = Service::all();


        return response()->json([
            'success' => true,
            "results" => $filteredApartmentsByDistance,
            'services' => $services
        ]);
    }

    public function show($slug){
        $apartment = Apartment::where('slug', $slug)->with(['services'])->first();

        return response()->json([
            'success'=>true,
            'results'=>$apartment
        ]);
    }

    public function sendMessage(Request $request){
        $request->validate([
            'apartment_id'=>'required',
            'apartment_title'=>'required',
            'fullname'=>'required',
            'email'=>'required',
            'message'=>'required',
        ]);
        $apartment_id = $request->apartment_id;
        $message_data = $request->all();
        $new_message = new Message();
        $new_message->fill($message_data);
        $new_message->save();

        return response()->json([
            'success' => true
        ]);
    }

    public function sendCity(Request $request){
        $data = $request->all();
        return response()->json([
            'success'=>true,
            'results'=>$data
        ]);
    }

    public function sponsored(){
        $apartments = Apartment::whereHas('advertises', function($q){
            $today = Carbon::now()->toDateTimeString();
            $q->where('end_date', '>', $today);
        })->get();

        return response()->json([
            'success'=>true,
            'results'=>$apartments
        ]);
    }
}
