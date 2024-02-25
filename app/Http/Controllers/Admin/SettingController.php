<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\Admin\SettingRepositoryInterface;
use App\Interfaces\Admin\PaymentGatewayRepositoryInterface;
use App\Models\PaymentGateway;
use App\Repositories\Admin\PaymentGatewayRepository;
use App\Services\Admin\SettingService;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    protected $settingRepo;
    protected $settingService;
    protected $paymentGateway;

    public function __construct(
        SettingRepositoryInterface $settingRepo,
        SettingService $settingService,
        PaymentGatewayRepositoryInterface $paymentGateway
    )
    {
        $this->settingRepo = $settingRepo;
        $this->settingService = $settingService;
        $this->paymentGateway = $paymentGateway;
    }

    public function index()
    {
        $settings = $this->settingRepo->getAllSetting();
        $paymentGateways = $settings->paymentGateways;
        return view('Admin.settings.index',get_defined_vars());
    }

    public function ChangeActiveHomePage(Request $request)
    {
       return $this->settingRepo->ChangeActiveHomePage($request);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show(string $id)
    {
    }

    public function edit(string $id)
    {
    }

    public function update(Request $request, Setting $setting){
        $this->settingService->updateSetting($request, $setting);

    return redirect()->route('Admin.settings.index')->with('success', __('Settings updated successfully.'));
    }


    public function destroy(string $id)
    {
    }

    public function editPaymentGatewayForm($id)
    {
        return $this->paymentGateway->editPaymentGatewayForm($id);
    }




    public function createPaymentGateway(Request $request)
    {
       $this->paymentGateway->createPaymentGateway($request->all());
       return redirect()->route('Admin.settings.index')->with('success', __('Payment gateway updated successfully.'));


    }

    public function updatePaymentGateway(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'api_key' => 'required|string',
            'profile_id' => 'required|string',
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
