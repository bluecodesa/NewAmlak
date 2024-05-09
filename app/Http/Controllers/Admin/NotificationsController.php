<?php

namespace App\Http\Controllers\Admin;

use App\Email\Admin\WelcomeBroker;
use App\Http\Controllers\Controller;
use App\Interfaces\Admin\SettingRepositoryInterface;
use App\Interfaces\Admin\PaymentGatewayRepositoryInterface;
use App\Models\EmailTemplate;
use App\Models\InterestType;
use App\Models\InterestTypeTranslation;
use App\Models\NotificationSetting;
use App\Services\Admin\SettingService;
use App\Services\Admin\EmailSettingService;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class NotificationsController extends Controller
{
    protected $settingRepo;
    protected $settingService;
    protected $paymentGateway;
    protected $EmailSettingService;
    public function __construct(
        SettingRepositoryInterface $settingRepo,
        SettingService $settingService,
        EmailSettingService $EmailSettingService,
        PaymentGatewayRepositoryInterface $paymentGateway
    ) {
        $this->middleware(['role_or_permission:update-PlatformSettings'])->only(['update']);
        $this->middleware(['role_or_permission:update-payment-gateway'])->only(['editPaymentGatewayForm']);
        $this->middleware(['role_or_permission:update-Billing'])->only(['updateTax']);
        $this->middleware(['role_or_permission:update-DomainSettings'])->only(['ChangeActiveHomePage']);

        //Interest Type
        $this->middleware(['role_or_permission:create-interest-request-status'])->only(['createInterestType', 'storeInterestType']);
        $this->middleware(['role_or_permission:update-interest-request-status'])->only(['editInterestType', 'updateInterestType']);
        $this->middleware(['role_or_permission:delete-interest-request-status'])->only(['destroyInterestType']);
        $this->middleware(['role_or_permission:update-notify-content'])->only(['EditEmailTemplate']);

        $this->settingRepo = $settingRepo;
        $this->settingService = $settingService;
        $this->paymentGateway = $paymentGateway;
        $this->EmailSettingService = $EmailSettingService;
    }

    public function index()
    {
        $settings = $this->settingRepo->getAllSetting();
        $EmailSettingService = $this->EmailSettingService->getAll();
        $NotificationSetting = $this->settingRepo->getNotificationSetting();
        $paymentGateways = $settings->paymentGateways;
        $interests = $this->settingService->getAllInterestTypes();

        return view('Admin.settings.Notifications.index', get_defined_vars());
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

    public function update(Request $request, Setting $setting)
    {

        $this->settingService->updateSetting($request, $setting);

        return redirect()->route('Admin.settings.index')->with('success', __('Settings updated successfully.'));
    }


    public function destroy(string $id)
    {
    }
}