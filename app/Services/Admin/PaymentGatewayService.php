<?php

// app\Services\PaymentGatewayService.php

namespace App\Services;

use App\Interfaces\Admin\PaymentGatewayRepositoryInterface;
use App\Repositories\Admin\PaymentGatewayRepository;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;


class PaymentGatewayService implements PaymentGatewayRepositoryInterface
{
    protected $paymentGatewayRepository;

    public function __construct(PaymentGatewayRepository $paymentGatewayRepository)
    {
        $this->paymentGatewayRepository = $paymentGatewayRepository;
    }

    public function editPaymentGatewayForm($id)
    {
        $paymentGateway = $this->paymentGatewayRepository->editPaymentGatewayForm($id);
        return view('Admin.settings.Payments.edit-modal', compact('paymentGateway'));
    }

    public function createPaymentGateway(array $data)
    {

        $request = request();

        $rules =
       [
            'name' => 'required|string',
            'api_key' => 'required|string',
            'profile_id' => 'required|string',
            'client_key' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        validator($data, $rules)->validate();
        $user_id = auth()->id();


        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('dashboard_files/images/payments');
            $file->move($destinationPath, $fileName);
            $data['image'] = 'dashboard_files/images/payments/' . $fileName;
        }
        $data['user_id'] = $user_id;

        $this->paymentGatewayRepository->createPaymentGateway($data);

 }

}
