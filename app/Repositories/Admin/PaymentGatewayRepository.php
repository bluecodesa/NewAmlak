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

        public function createPaymentGateway(array $data){
            $data['user_id'] = Auth::user()->id;
            return PaymentGateway::create($data);
        }

        public function updatePaymentGateway($id, array $data)
        {
            $payment = PaymentGateway::findOrFail($id);
            $payment->update($data);
            return $payment;
        }
    }
