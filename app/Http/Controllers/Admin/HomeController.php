<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use App\Models\Subscription;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $pendingPayment = false;
        return view('home', get_defined_vars());
    }

    function ContactUs()
    {
        $messages = ContactUs::latest('created_at')->get();
        return view('Admin.supports.ContactUs.index', get_defined_vars());
    }
}
