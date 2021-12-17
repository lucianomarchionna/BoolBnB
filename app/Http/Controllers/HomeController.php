<?php

namespace App\Http\Controllers;

use App\Apartment;
use App\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $services = Service::all();
        // $apartments = Apartment::all();
        // return view('index', compact('apartments', 'services'));
    }

    // public function about(){
    //     return view('about');
    // }
    // public function search(){
    //     return view('discover');
    // }
    public function indexHome(){
        return view('guest.homepage');
    }


}
