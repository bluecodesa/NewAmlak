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

class SettingController extends Controller
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
        return view('Admin.settings.index', get_defined_vars());
    }

    public function ChangeActiveHomePage(Request $request)
    {
        return $this->settingRepo->ChangeActiveHomePage($request);
    }


    public function ChangeActiveGalleryPage(Request $request)
    {
        return $this->settingRepo->ChangeActiveGalleryPage($request);
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

    public function editPaymentGatewayForm($id)
    {
        return $this->paymentGateway->editPaymentGatewayForm($id);
    }


    public function createPaymentGateway(Request $request)
    {
        // فين الفالديشن (amin)
        $this->paymentGateway->createPaymentGateway($request->all());
        return redirect()->route('Admin.settings.index')->with('success', __('Payment gateway updated successfully.'));
    }

    public function updatePaymentGateway(Request $request, $id)
    {
        // فين الفالديشن (amin)
        $this->paymentGateway->updatePaymentGateway($id, $request->all());

        return redirect()->route('Admin.settings.index')->with('success', __('Payment gateway updated successfully.'));
    }

    public function updateTax(Request $request, Setting $setting)
    {

        $this->validate($request, [
            'tax_rate' => 'nullable|numeric|min:1|max:100',
            'trn' => 'nullable|min:1|max:100',
        ]);
        $taxRate = $request->input('tax_rate') / 100;
        $setting->tax_rate = $taxRate;
        $setting->trn = $request->trn;
        $setting->save();

        return redirect()->route('Admin.settings.index')->with('success', __('Settings updated successfully.'));
    }

    function NotificationSetting(Request $request, $id)
    {
        $this->settingService->NotificationToggleSetting($request, $id);
    }

    function UpdateEmailSetting(Request $request)
    {
        $this->settingService->UpdateEmailSetting($request->all());
        return redirect()->route('Admin.settings.index')->with('success', __('Settings updated successfully.'));
    }
    function EditEmailTemplate($id)
    {
        $notification = NotificationSetting::find($id);
        $template = EmailTemplate::where('notification_setting_id', $notification->id)->first();
        return view('Admin.settings.Notification.edit', get_defined_vars());
    }

    function StoreEmailTemplate(Request $request, $id)
    {
        if ($request->is_login == 'on') {
            $is_login = 1;
        } else {
            $is_login = 0;
        }
        EmailTemplate::updateOrCreate(['notification_setting_id' => $id], ['notification_setting_id' => $id, 'content' => $request->content, 'is_login' => $is_login, 'subject' => $request->subject]);
        return redirect()->route('Admin.settings.index')->with('success', __('Settings updated successfully.'));
    }


    function TestSendMail()
    {
        return view('emails.Admin.WelcomeBroker', get_defined_vars());
    }

    function StoreNewNotification(Request $request)
    {

        $notification_name =     str_replace(' ', '_', $request['notification_name']);
        $NotificationSetting =       NotificationSetting::create(['notification_name' => $notification_name]);
        EmailTemplate::create([
            'notification_setting_id' => $NotificationSetting->id,
            'content' => null,
            'is_login' => 1,
            'subject' => $request->notification_name_ar
        ]);
        return redirect()->route('Admin.settings.index')->with('success', __('added successfully'));
    }



    public function createInterestType()
    {
        return view('Admin.settings.InterestType.create');
    }

    public function storeInterestType(Request $request)
    {
        $this->settingService->createInterestType($request->all());

        return redirect()->route('Admin.settings.index')->withSuccess(__('added successfully'));
    }
    public function editInterestType($id)
    {
        $Interest  =   $this->settingService->getInterestTypeById($id);
        return view('Admin.settings.InterestType.edit', get_defined_vars());
    }

    public function updateInterestType(Request $request, $id)
    {
        $this->settingService->updateInterestType($id, $request->all());
        return redirect()->route('Admin.settings.index')
            ->withSuccess(__('Update successfully'));
    }

    public function destroyInterestType($id)
    {
        $this->settingService->deleteInterestType($id);
        return redirect()->route('Admin.settings.index')
            ->withSuccess(__('Deleted successfully'));
    }

    function NotificationsManagement()
    {
        $NotificationSetting = $this->settingRepo->getNotificationSetting();
        $EmailSettingService = $this->EmailSettingService->getAll();
        return view('Admin.settings.Notifications.index', get_defined_vars());
    }

    function UpdateNotificationsManagement()
    {
        $NotificationSetting = $this->settingRepo->getNotificationSetting();
        $EmailSettingService = $this->EmailSettingService->getAll();
        return view('Admin.settings.Notifications.edit', get_defined_vars());
    }

    function AddNotificationsManagement()
    {
        $NotificationSetting = $this->settingRepo->getNotificationSetting();
        $EmailSettingService = $this->EmailSettingService->getAll();
        return view('Admin.settings.Notifications.Add', get_defined_vars());
    }

    function PrivacyPage()
    {
        $setting = Setting::first();
        return view('Admin.settings.HomePages.Privacy', get_defined_vars());
    }

    function UpdatePrivacy(Request $request)
    {
        $request_data =  $request->except(['files']);
        $setting = Setting::first();
        $setting->update($request_data);
        return back()->withSuccess(__('Update successfully'));
    }

    function TermsPage()
    {
        $setting = Setting::first();
        return view('Admin.settings.HomePages.Terms', get_defined_vars());
    }

    function UpdateTerms(Request $request)
    {
        $request_data =  $request->except(['files']);
        $setting = Setting::first();
        $setting->update($request_data);
        return back()->withSuccess(__('Update successfully'));
    }
}
