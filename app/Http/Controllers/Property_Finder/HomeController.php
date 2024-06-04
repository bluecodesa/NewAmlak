<?php

namespace App\Http\Controllers\Property_Finder;

use App\Http\Controllers\Controller;
use App\Models\FavoriteUnit;
use App\Models\Unit;
use App\Models\User;

class HomeController extends Controller
{
    public function index(){

        $finder =auth()->user();
        $favorites = FavoriteUnit::where('finder_id', $finder->id)->get();
        $units = Unit::with('Unitfavorites')
            ->whereIn('id', $favorites->pluck('unit_id'))
            ->get();
        return view('Home.Property-Finder.index',  get_defined_vars());
        // $broker = Broker::where('user_id', $finder->ow)->first();
    }
    public function create(){

    }
    // public function store(Request $request){

    // }
    public function show($id){

    }


}
