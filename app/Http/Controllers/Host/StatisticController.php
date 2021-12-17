<?php

namespace App\Http\Controllers\Host;
use App\Apartment;
use App\Statistic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StatisticController extends Controller
{
    public function statistics($id)
    {
        // if(!$apartment) {
        //     abort(404);
        // }elseif(Auth::user()->id !== $apartment->user_id){
        //     return redirect()->back();
        // }
        
        $user_id = Auth::user()->id;
        
        $statistics = DB::table('apartments')
        ->select(DB::raw('count(apartment_id) as apartment_count'), 'apartment_id', 'users.id')
        ->join('users','users.id', '=', 'apartments.user_id')
        ->join('statistics', 'apartments.id','=', 'statistics.apartment_id')
        ->where('user_id', '=', $user_id)
        ->where('apartment_id', '=', $id)
        ->groupBy('statistics.apartment_id')
        ->get()
        ;
        
        /*
        $statistics = DB::table('statistics')
        ->select(DB::raw('count(apartment_id) as apartment_count'), 'apartment_id')
        ->where('apartment_id', '=', $id)
        ->groupBy('apartment_id')
        ->get()
        ;
        dd($statistics);
        */

        // $stat_apartment = [];
        // foreach ($statistics as $statistic) {
        //     array_push($stat_apartment,$statistic);
        // }
       
        
        return view('host.apartments.statistics', compact('statistics'));
    }
    
    public function show($id){

        $apartment = Apartment::where('id', $id)->first();
        if(!$apartment) {
            abort(404);
        }elseif(Auth::user()->id !== $apartment->user_id){
            return redirect()->back();
        }
        return view('host.apartments.statistics.show', compact('apartment'));
    }
}
