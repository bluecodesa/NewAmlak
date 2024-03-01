<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\SubscriptionType;
use Illuminate\Http\Request;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use App\Services\PaymentPendingService;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $paymentPendingService;

    public function __construct(PaymentPendingService $paymentPendingService)
    {
        $this->middleware('auth');
        $this->paymentPendingService = $paymentPendingService;

    }

    public function index(Request $request)
    {
        $data = $this->paymentPendingService->UserPendingPayment();
        return view('home',   get_defined_vars());
    }

    public function GetCitiesByRegion($id)
    {
        $cities = City::where('region_id', $id)->get();
        return view('Admin.settings.Region.inc._city', get_defined_vars());
    }
}
