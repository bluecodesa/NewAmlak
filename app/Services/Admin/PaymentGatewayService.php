<?php

// app\Services\PaymentGatewayService.php

namespace App\Services;

use App\Interfaces\Admin\PaymentGatewayRepositoryInterface;
use App\Repositories\Admin\PaymentGatewayRepository;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use Illuminate\Support\Facades\Auth;

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
        $user_id = Auth::user()->id;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('dashboard_files/images/payments');
            $file->move($destinationPath, $fileName);
            $data['image'] = 'dashboard_files/images/payments/' . $fileName; // Update the image path
        }

        $data['user_id'] = Auth::user()->user_id;

        return $this->paymentGatewayRepository->createPaymentGateway($data);

    }

    public function updatePaymentGateway($id, array $data)
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

         if ($request->hasFile('image')) {
            // Delete previous image
            if ($data['image']) {
                $previousImagePath = public_path($data['image']);
                if (file_exists($previousImagePath)) {
                    unlink($previousImagePath);
                }
            }

            // Upload and save new image
            $file = $request->file('image');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('dashboard_files/images/payments');
            $file->move($destinationPath, $fileName);
            $data['image'] = 'dashboard_files/images/payments/' . $fileName; // Update the image path
        }

           return  $this->paymentGatewayRepository->updatePaymentGateway($id,$data);

        }
    }


