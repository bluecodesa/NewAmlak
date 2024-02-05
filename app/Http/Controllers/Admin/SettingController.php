<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;


class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index()
     {
         $settings = Setting::first(); // Assuming only one row in the settings table
         $paymentGateways = PaymentGateway::all();
        //  $titleArabic = $settings->translate('ar')->title;
        // $titleEnglish = $settings->translate('en')->title;
        //  // dd($paymentGateway);
         return view('Admin.settings.index', get_defined_vars());
     }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
{
    $request->validate([
        'ar.title' => 'required|string',
        'en.title' => 'required|string',
        'facebook' => 'nullable|url',
        'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'color' => 'nullable|string',
    ]);

    foreach (config('translatable.locales') as $locale) {
        $setting->translateOrNew($locale)->title = $request->input("$locale.title");
    }

    $setting->facebook = $request->input('url');

    if ($request->hasFile('icon')) {
        $iconPath = $request->file('icon')->store('logos', 'public');
        $setting->icon = $iconPath;
    }

    $setting->color = $request->input('color');

    $setting->save();

    return redirect()->route('Admin.settings.index')->with('success', __('Settings updated successfully.'));
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function editPaymentGatewayForm($id)
    {
        $paymentGateway = PaymentGateway::find($id);

        return view('Admin.settings.index', compact('paymentGateway'));
    }

    public function updatePaymentGatewayStatus(Request $request, $id)
{
    $paymentGateway = PaymentGateway::findOrFail($id);
    $paymentGateway->status = $request->input('status');
    $paymentGateway->save();

    return redirect()->route('Admin.settings.index')->with('success', __('Payment gateway status updated successfully.'));
}



public function createPaymentGateway(Request $request)
{

    $request->validate([
        'name' => 'required|string',
        'api_key' => 'required|string',
        'profile_id' => 'required|string',
        'client_key' => 'required|string',
    ]);


      $user = auth()->user();

    $paymentGateway = new PaymentGateway();
    $paymentGateway->name = $request->input('name');
    $paymentGateway->api_key_paytabs = $request->input('api_key');
    $paymentGateway->profile_id_paytabs = $request->input('profile_id');
    $paymentGateway->client_key = $request->input('client_key');
    $paymentGateway->status = 1;


    $paymentGateway->user()->associate($user);

    $paymentGateway->save();

    return redirect()->route('Admin.settings.index')->with('success', __('Payment gateway created successfully.'));
}


}
