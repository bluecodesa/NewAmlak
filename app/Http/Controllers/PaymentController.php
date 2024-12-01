<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\SubscriptionHistory;
use App\Models\SubscriptionSection;
use App\Models\SubscriptionType;
use App\Models\SystemInvoice;
use Carbon\Carbon;
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
        // $this->middleware('auth');
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
        $data =  explode('&', $user);
        Auth::loginUsingId($data[1]);
        $officeData = Auth::user()->UserOfficeData;
        $brokerData = Auth::user()->UserBrokerData;

        if ($officeData) {
            $subscription = $officeData->UserSubscription;
        } else {
            $subscription = $brokerData->UserSubscription;
        }
        $subscriptionType =  $subscription->SubscriptionTypeData;
        $endDate = $subscriptionType->calculateEndDate(Carbon::now())->format('Y-m-d H:i:s');
        $sections = $subscription->SubscriptionTypeData->sections()->get();
        $subscription->SubscriptionSectionData()->delete();
        foreach ($sections as $section_id) {
            SubscriptionSection::create([
                'section_id' => $section_id->id,
                'subscription_id' => $subscription->id,
            ]);
        }
        if ($subscription) {
            $subscription->update(['status' => 'active', 'is_start' => 1, 'start_date' => now()->format('Y-m-d H:i:s'), 'end_date' => $endDate]);
            // $this->updateSubscriptionHistory($subscription);
        }

        $invoice = $officeData ? $brokerData->UserSubscriptionPending : $brokerData->UserSystemInvoicePending;

        if ($invoice) {
            $invoice->update(['status' => 'active']);
        }

        $redirectRoute = $officeData ? 'Office.home' : 'Broker.home';
        $redirectMessage = $officeData ? 'The subscription has been activated successfully' : 'The subscription has been activated successfully';
        Auth::loginUsingId($data[1]);
        return redirect()->route($redirectRoute)->with('success', __($redirectMessage));
    }

    protected function updateSubscriptionHistory($subscription)
    {
        $subscriptionHistory = SubscriptionHistory::where('subscription_id', $subscription->id)->latest()->first();

        if ($subscriptionHistory) {
            $subscriptionHistory->update(['status' => 'active']);
        }
    }

    function UpgradeSubscription(Request $request)
    {
        // return $request;

        $user =  Auth::user();

        if ($user->UserOfficeData) {
            $Subscription =  $user->UserOfficeData->UserSubscription;
        } else {
            $Subscription = $user->UserBrokerData->UserSubscription;
        }

        $SubscriptionType =  SubscriptionType::find($request->subscription_type);

        $amount = $SubscriptionType->price - $SubscriptionType->price * $SubscriptionType->upgrade_rate;

        $last_record = SystemInvoice::latest()->first();

        $pay = Paypage::sendPaymentCode('all')
            ->sendTransaction('Auth')
            ->sendCart($last_record['id'] ?? '0' + 1, $amount, 'Add to Walet')
            ->sendCustomerDetails(Auth::user()->name, Auth::user()->email, Auth::user()->phone, 'Makka', 'Makka', 'Makka', 'SA', '1234', \Request::ip())
            ->sendShippingDetails(Auth::user()->name, Auth::user()->email, Auth::user()->phone, 'Makka', 'Makka', 'Makka', 'SA', '1234', \Request::ip())
            ->sendURLs(route('callback_UpgradeSubscription', $SubscriptionType->id . '&' . Auth::id()), route('callback_UpgradeSubscription', $SubscriptionType->id . '&' . Auth::id()))
            ->sendLanguage('ar')
            ->create_pay_page();
        return $pay;
    }

    function callback_UpgradeSubscription($user)
    {
        $data =  explode('&', $user);
        Auth::loginUsingId($data[1]);

        $officeData = Auth::user()->UserOfficeData;
        $brokerData = Auth::user()->UserBrokerData;
        $SubscriptionType =  SubscriptionType::find($data[0]);

        if ($officeData) {
            $subscription = $officeData->UserSubscription;
        } else {
            $subscription = $brokerData->UserSubscription;
        }


        $endDate = $SubscriptionType->calculateEndDate(Carbon::now())->format('Y-m-d H:i:s');
        $sections = $subscription->SubscriptionTypeData->sections()->get();
        $subscription->SubscriptionSectionData()->delete();
        foreach ($sections as $section_id) {
            SubscriptionSection::create([
                'section_id' => $section_id->id,
                'subscription_id' => $subscription->id,
            ]);
        }
        if ($subscription) {
            $subscription->update(['subscription_type_id' => $SubscriptionType->id, 'status' => 'active', 'is_start' => 1, 'start_date' => now()->format('Y-m-d H:i:s'), 'end_date' => $endDate]);
            // $this->updateSubscriptionHistory($subscription);
            // Check if section 18 exists
            $hasSection18 = $sections->contains('id', 18);

            // Check if a gallery exists
            $hasGallery = Gallery::where('broker_id', $brokerData->id)->exists();

            if ($hasSection18 && !$hasGallery) {
                // Create a new gallery if section 18 exists but there is no gallery
                $galleryName = explode('@', auth()->user()->email)[0];
                $defaultCoverImage = '/Gallery/cover/cover.png';

                Gallery::create([
                    'broker_id' => $brokerData->id,
                    'gallery_name' => $galleryName,
                    'gallery_status' => 1,
                    'gallery_cover' => $defaultCoverImage,
                ]);
            } elseif (!$hasSection18 && $hasGallery) {
                // Delete the gallery if section 18 does not exist but there is a gallery
                Gallery::where('broker_id', $brokerData->id)->delete();
            }
        }
        $amount = $SubscriptionType->price - $SubscriptionType->price * $SubscriptionType->upgrade_rate;
        SystemInvoice::create([
            'broker_id' => $subscription->broker_id,
            'office_id' => $subscription->office_id,
            'subscription_name' => $SubscriptionType->name,
            'amount' => $amount,
            "discount" => $SubscriptionType->upgrade_rate,
            'subscription_type' => ($SubscriptionType->price > 0) ? 'paid' : 'free',
            'period' => $SubscriptionType->period,
            'period_type' => $SubscriptionType->period_type,
            'status' => 'active',
            'invoice_ID' => 'INV_' . uniqid(),
        ]);

        $redirectRoute = $officeData ? 'Office.home' : 'Broker.home';
        $redirectMessage = $officeData ? 'The subscription has been Upgraded successfully' : 'The subscription has been Upgraded successfully';
        Auth::loginUsingId($data[1]);
        return redirect()->route($redirectRoute)->with('success', __($redirectMessage));
    }
}
