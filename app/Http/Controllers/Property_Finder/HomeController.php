<?php

namespace App\Http\Controllers\Property_Finder;

use App\Http\Controllers\Controller;





class HomeController extends Controller
{
    public function index(){

        return view('Home.Property-Finder.index',  get_defined_vars());
    }


}
