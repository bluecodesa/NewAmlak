<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\PaymentGatewayRepositoryInterface;
use Illuminate\Http\Request;



use App\Models\PaymentGateway;
use Illuminate\Support\Facades\Auth;

class PaymentGatewayRepository implements PaymentGatewayRepositoryInterface

{
    public function editPaymentGatewayForm($id)
    {
        return PaymentGateway::findOrFail($id);
    }

    public function createPaymentGateway(array $data)
    {
        $data['user_id'] = Auth::user()->id;
        $image = $data['image'];
        if ($image) {
            $ext = $data['image']->getClientOriginalExtension();
            $imageName = uniqid() . '.' . $ext;
            $image->move(public_path('/PaymentGateway/'), $imageName);
            $data['image'] = '/PaymentGateway/' . $imageName;
        }
        return PaymentGateway::create($data);
    }

    public function updatePaymentGateway($id, array $data)
    {
        $payment = PaymentGateway::findOrFail($id);
        if (isset($data['image'])) {
            $image = $data['image'];

            // Proceed with image upload logic
            $ext = $image->getClientOriginalExtension();
            $imageName = uniqid() . '.' . $ext;
            $image->move(public_path('/PaymentGateway/'), $imageName);
            $data['image'] = '/PaymentGateway/' . $imageName;
        }
        $payment->update($data);
        return $payment;
    }
}
