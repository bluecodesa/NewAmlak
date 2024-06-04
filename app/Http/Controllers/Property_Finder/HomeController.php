<?php

namespace App\Http\Controllers\Property_Finder;

use App\Http\Controllers\Controller;
use App\Models\User;

class HomeController extends Controller
{
    public function index(){

        $finder =auth()->user();
        return view('Home.Property-Finder.index',  get_defined_vars());
    }


}
