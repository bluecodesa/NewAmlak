<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Paytabscom\Laravel_paytabs\Facades\paypage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class PaymentController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct()
    {
        $this->middleware('auth');
    }

    function store(Request $request)
    {
        $fields = [
            "profile_id" => env('paytabs_profile_id', '87757'),
            "tran_type" => "Sale",
            "tran_class" => "ecom",
            "cart_id" => "Bsaray Sample Payment",
            "cart_description" => "Dummy Order 35925502061445345",
            "cart_currency" => "USD",
            "cart_amount" => 46.17,
            "callback" => "https://yourdomain.com/yourcallback",
            "return" => "https://yourdomain.com/yourpage",
            "customer_details" => [
                "name" => "John Smith",
                "email" => "jsmith@gmail.com",
                "street1" => "404, 11th st, void",
                "city" => "dubai",
                "country" => "AE",
                "ip" => "94.204.129.89"
            ],
            "shipping_details" => [
                "name" => "name1 last1",
                "email" => "email1@domain.com",
                "phone" => "971555555555",
                "street1" => "street2",
                "city" => "dubai",
                "state" => "dubai",
                "country" => "AE",
                "zip" => "54321",
                "ip" => "2.2.2.2"
            ],
        ];

        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'authorization' => env('paytabs_server_key', 'SDJNBZH9T9-JDGBLW9GDL-2W2W6TW2N2'),
            'Content-type' => 'application/json'
        ])->post('https://secure-global.paytabs.com/payment/request', $fields);

        return $response->json();
    }

    function query_transaction()
    {
        $fields = [
            "profile_id" => env('paytabs_profile_id'),
            'tran_ref' => 'TST2107500114813' // example
        ];
        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'authorization' => env('paytabs_server_key'),
            'Content-type' => 'application/json'
        ])->post('https://secure-global.paytabs.com/payment/query', $fields);

        return $response->json();
    }
}
