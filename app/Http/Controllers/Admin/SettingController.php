<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Services\Admin\SettingService;
use App\Models\PaymentGateway;

class SettingController extends Controller
{
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function index()
    {
        $settings = $this->settingService->getAllSetting();
        $paymentGateways = $settings->paymentGateways;
        return view('Admin.settings.index',get_defined_vars());
    }
    function ChangeActiveHomePage(Request $request)
    {
        $Setting =  Setting::first();
        $Setting->update([
            'active_home_page' => $request->active_home_page,
        ]);
    }

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
            'api_key_paytabs' => 'required|string',
            'profile_id_paytabs' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:0,1',
        ]);

        $paymentGateway = PaymentGateway::findOrFail($id);

        $paymentGateway->fill($request->except('image', 'status'));
        $paymentGateway->status = $request->input('status');

        if ($request->hasFile('image')) {
            // Delete previous image
            if ($paymentGateway->image) {
                $previousImagePath = public_path($paymentGateway->image);
                if (file_exists($previousImagePath)) {
                    unlink($previousImagePath);
                }
            }

            // Upload and save new image
            $file = $request->file('image');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('dashboard_files/images/payments');
            $file->move($destinationPath, $fileName);
            $paymentGateway->image = 'dashboard_files/images/payments/' . $fileName;
        }

        // Save the payment gateway
        $paymentGateway->save();

        return redirect()->route('Admin.settings.index')->with('success', __('Payment gateway updated successfully.'));
    }
}
