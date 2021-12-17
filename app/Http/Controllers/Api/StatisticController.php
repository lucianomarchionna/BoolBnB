<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Statistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Apartment;
use Illuminate\Support\Facades\Auth;
class StatisticController extends Controller
{
    public function store(Request $request){
        $data = $request->all();
        
        $validator = Validator::make($request->all(),[
            'apartment_id' => 'required',
            'data' => 'required|date',
            'visitors' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => $data,
                'errors' => $validator->errors()
            ]);
        }

        $visitorData = Statistic::where('visitors', $data['visitors'])
                                    ->where('apartment_id', $data['apartment_id'])
                                    ->first();

        if(!$visitorData){
            $new_statistic = new Statistic();
            $new_statistic->fill($data);
            $new_statistic->save();
        }
    }

    public function show($id){
        $apartment = Apartment::where('id', $id)->first();


        if($apartment){
            $statistics = Statistic::where('apartment_id', $id)->get();

            // Creo un array di valori per ogni mese
            $january = [];
            $february = [];
            $march = [];
            $april = [];
            $may = [];
            $june = [];
            $july = [];
            $august = [];
            $september = [];
            $october = [];
            $november = [];
            $december = [];

            // Prendo il mese delle statistiche e le pusho nell'array corrispondente
            foreach($statistics as $statistic){
                $clicks = substr($statistic->data, 5,2);

                switch($clicks){
                    case '01':
                        array_push($january, $statistics);
                        break;
                        
                    case '02':
                        array_push($february, $statistics);
                        break;
                        
                    case '03':
                        array_push($march, $statistics);
                        break;
                        
                    case '04':
                        array_push($april, $statistics);
                        break;
                        
                    case '05':
                        array_push($may, $statistics);
                        break;
                        
                    case '06':
                        array_push($june, $statistics);
                        break;
                        
                    case '07':
                        array_push($july, $statistics);
                        break;
                        
                    case '08':
                        array_push($august, $statistics);
                        break;
                        
                    case '09':
                        array_push($september, $statistics);
                        break;
                        
                    case '10':
                        array_push($october, $statistics);
                        break;
                        
                    case '11':
                        array_push($november, $statistics);
                        break;
                        
                    case '12':
                        array_push($december, $statistics);
                        break;
                }
            }

            $maxClicks = max($january, $february, $march, $april, $may, $june, $july, $august, $september, $october, $november, $december);
            return response()->json([
                'success'=>true,
                'results'=>[count($january),count($february),count($march),count($april),count($may),count($june),count($july),count($august),count($september),count($october),count($november),count($december)],
                'statistics'=>$statistics,
                'maxClicks'=>count($maxClicks),
                'apartment'=>$apartment
            ]);


            // return view('host.statistics.show', compact('$january, $february, $march, $april, $may, $june, $july, $august, $september, $october, $november, $december', 'statistics', 'apartment', 'maxClicks'));

        }
        else{
            return redirect()->route('host.apartments.index')->with('statistic_error', 'C\'è stato un errore con il caricamento delle statistiche');
        }
    }
}
