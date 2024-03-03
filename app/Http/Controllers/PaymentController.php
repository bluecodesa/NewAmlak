<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SystemInvoice;
use Paytabscom\Laravel_paytabs\Facades\paypage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use PDO;

class PaymentController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct()
    {
        $this->middleware('auth');
    }

    function store(Request $request)
    {
        $user =  Auth::user();

        if ($user->UserOfficeData) {
            $Subscription =  $user->UserOfficeData->UserSubscriptionPending;
        } else {
            $Subscription = $user->UserBrokerData->UserSubscriptionPending;
        }

        $amount = $Subscription->total;

        $last_record = SystemInvoice::latest()->first();
        $pay = Paypage::sendPaymentCode('all')
            ->sendTransaction('Auth')
            ->sendCart($last_record['id'] ?? '0' + 1, $amount, 'Add to Walet')
            ->sendCustomerDetails(Auth::user()->name, Auth::user()->email, Auth::user()->phone, 'Makka', 'Makka', 'Makka', 'SA', '1234', \Request::ip())
            ->sendShippingDetails(Auth::user()->name, Auth::user()->email, Auth::user()->phone, 'Makka', 'Makka', 'Makka', 'SA', '1234', \Request::ip())
            ->sendURLs(route('callback_payments_package', $amount . '&' . Auth::id()), route('callback_payments_package', $amount . '&' . Auth::id()))
            ->sendLanguage('ar')
            ->create_pay_page();
        return $pay;
    }

    function create()
    {
    }

    function Payment_callBack($user)
    {
        $user = Auth::user();
        $officeData = $user->UserOfficeData;
        $brokerData = $user->UserBrokerData;

        if ($officeData) {
            $subscription = $officeData->UserSubscriptionPending;
        } else {
            $subscription = $brokerData->UserSubscriptionPending;
        }

        if ($subscription) {
            $subscription->update(['status' => 'active', 'is_start' => 1]);
        }

        $invoice = $officeData ? $brokerData->UserSubscriptionPending : $brokerData->UserSystemInvoicePending;

        if ($invoice) {
            $invoice->update(['status' => 'active']);
        }

        $redirectRoute = $officeData ? 'Office.home' : 'Broker.home';
        $redirectMessage = $officeData ? 'The subscription has been activated successfully' : 'The subscription has been activated successfully';

        return redirect()->route($redirectRoute)->with('success', __($redirectMessage));
    }

    function query_transaction()
    {
    }
}
