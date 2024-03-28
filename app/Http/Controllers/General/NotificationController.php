<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Subscription;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        return view('General.Notifications.index');
    }
}