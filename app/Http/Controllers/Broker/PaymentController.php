<?php

namespace App\Http\Controllers\Broker;

use App\Http\Controllers\Controller;
use Paytabscom\Laravel_paytabs\Facades\paypage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function Payment_callBack(Request $request)
    {
        $subscription = Auth::user()->UserBrokerData->UserSubscriptionPending;
        $amount  = Auth::user()->UserBrokerData->UserSubscriptionPending->total;
        $last_record = Auth::user()->UserBrokerData->UserSystemInvoicePending;
        $pay = Paypage::sendPaymentCode('all')
            ->sendTransaction('Auth')
            ->sendCart($last_record['id'] ?? '0' + 1, $amount, 'Add to Walet')
            ->sendCustomerDetails(Auth::user()->name, Auth::user()->email, Auth::user()->phone, 'Makka', 'Makka', 'Makka', 'SA', '1234', \Request::ip())
            ->sendShippingDetails(Auth::user()->name, Auth::user()->email, Auth::user()->phone, 'Makka', 'Makka', 'Makka', 'SA', '1234', \Request::ip())
            ->sendURLs(route('dashboard.callback_payments_package', $amount . '&' . Auth::id()), route('dashboard.callback_payments_package', $amount . '&' . Auth::id()))
            ->sendLanguage('ar')
            ->create_pay_page();
        return $pay;
    }
}
