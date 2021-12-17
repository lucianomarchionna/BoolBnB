<?php

namespace App\Http\Controllers\Host;

use App\Advertise;
use App\Apartment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Braintree\Gateway;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class SponsorController extends Controller
{
    public function index(Request $request, $id){
        
        $apartment = Apartment::where('id', $id)->first();
        if(!$apartment) {
            abort(404);
        }elseif(Auth::user()->id !== $apartment->user_id){
            return redirect()->back();
        }

        $advertise = Advertise::find($request->advertise_id);
        $gateway = new Gateway([
            'environment' => 'sandbox',
            'merchantId' => '4nbx6f3smbzz8cmn',
            'publicKey' => 'ymj3gt8z5r5yyqdf',
            'privateKey' => '83a7e90f1b3a5a5450811fb15828c539'
        ]);

        $clientToken = $gateway->clientToken()->generate();
        return view('host.apartments.payment', compact('clientToken', 'apartment', 'advertise'));
    }

    public function checkout(Request $request, $id){
        $gateway = new Gateway([
            'environment' => 'sandbox',
            'merchantId' => '4nbx6f3smbzz8cmn',
            'publicKey' => 'ymj3gt8z5r5yyqdf',
            'privateKey' => '83a7e90f1b3a5a5450811fb15828c539'
        ]);

        // Salvo l'appartamento da sponsorizzare e l'advertise
        $apartment = Apartment::where('id', $id)->first();
        if(!$apartment) {
            abort(404);
        }elseif(Auth::user()->id !== $apartment->user_id){
            return redirect()->back();
        }
        $advertise = Advertise::find($request->advertise_id);

        // Prendo l'autorizzazione di pagamento nonce (è un token)
        $nonceFromClient = $request->payment_method_nonce;
        // Creo transazione
        $result = $gateway->transaction()->sale([
            'amount' => $advertise->price,
            'paymentMethodNonce' => $nonceFromClient,
            'customer' =>[
                'firstName' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'options'=>[
                'submitForSettlement' => true
            ]
        ]);

        // $amount = $result->transaction->amount;

        $adv_house = DB::table('apartments')->join('advertise_apartment', 'apartments.id', '=', 'advertise_apartment.apartment_id')
                        ->where('apartments.id', $apartment->id)
                        ->whereDate('end_date', '>', Carbon::now()->toDateString())
                        ->get();
        
        if(count($adv_house)>0){
            return redirect()->route('host.apartments.advertise', $apartment->id)->with('error', 'L\'appartamento ha già una sponsorizzazione in corso');
        }                                  

        if($result->success){
            $startDate = Carbon::now()->toDateTimeString();
            $endDate = Carbon::now()->add($advertise->duration, 'hours')->toDateTimeString();


            $apartment->advertises()->attach($advertise->id, [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => true,
                'transaction_id' => $result->transaction->id,
            ]);

            return redirect()->route('host.apartments.index')->with('sponsored', 'Hai correttamente sponsorizzato l\'appartamento!');
        }else{
            return redirect()->route('host.apartments.advertise', $apartment->id)->with('error', 'C\'è stato un errore durante il processo di sponsorizzazione');
        }
    }
}
