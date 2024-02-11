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
         $settings = Setting::first();
         $paymentGateways = PaymentGateway::all();
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

        if ($setting->icon) {
            $previousIconPath = public_path($setting->icon);
            if (file_exists($previousIconPath)) {
                unlink($previousIconPath);
            }
        }


        $file = $request->file('icon');
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path('logos');
        $file->move($destinationPath, $fileName);
        $setting->icon = 'logos/' . $fileName;
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
        return view('Admin.settings.Payments.edit-modal', get_defined_vars());
    }




    public function createPaymentGateway(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'api_key' => 'required|string',
            'profile_id' => 'required|string',
            'client_key' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user_id = auth()->id();

        $paymentGateway = new PaymentGateway();
        $paymentGateway->name = $request->input('name');
        $paymentGateway->api_key_paytabs = $request->input('api_key');
        $paymentGateway->profile_id_paytabs = $request->input('profile_id');
        $paymentGateway->client_key = $request->input('client_key');
        $paymentGateway->status = 1; // Set default status to 1 (enabled)

        // Handle file upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('dashboard_files/images/payments');
            $file->move($destinationPath, $fileName);
            $paymentGateway->image = 'dashboard_files/images/payments/' . $fileName;
        }

        $paymentGateway->user_id = $user_id;

        $paymentGateway->save();

        return redirect()->route('Admin.settings.index')->with('success', __('Payment gateway created successfully.'));
    }




    public function updatePaymentGateway(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'api_key' => 'required|string',
            'profile_id' => 'required|string',
            'client_key' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image file
            'status' => 'required|in:0,1', // Validate status field
        ]);

        $paymentGateway = PaymentGateway::findOrFail($id);

        // Update fields
        $paymentGateway->fill($request->except('image')); // Fill all fields except image
        $paymentGateway->status = $request->input('status'); // Update status separately

        // Handle file upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('dashboard_files/images/payments');
            $file->move($destinationPath, $fileName);
            $paymentGateway->image = 'dashboard_files/images/payments/' . $fileName;
        }

        $paymentGateway->save();

        return redirect()->route('Admin.settings.index')->with('success', __('Payment gateway updated successfully.'));
    }






}
