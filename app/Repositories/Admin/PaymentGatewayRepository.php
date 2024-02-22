<?php


namespace App\Repositories\Admin;
use App\Interfaces\Admin\PaymentGatewayRepositoryInterface;


use App\Models\PaymentGateway;

class PaymentGatewayRepository implements PaymentGatewayRepositoryInterface

{
    public function editPaymentGatewayForm($id)
    {
        return PaymentGateway::findOrFail($id);
    }

    public function createPaymentGateway(Request $request)
    {
        return PaymentGateway::create($request);
    }
}
