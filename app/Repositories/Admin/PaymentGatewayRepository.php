<?php

    namespace App\Repositories\Admin;
    use App\Interfaces\Admin\PaymentGatewayRepositoryInterface;
    use Illuminate\Http\Request;



    use App\Models\PaymentGateway;

    class PaymentGatewayRepository implements PaymentGatewayRepositoryInterface

    {
        public function editPaymentGatewayForm($id)
        {
            return PaymentGateway::findOrFail($id);
        }

        public function createPaymentGateway(array $data){
// dd($data);
         return PaymentGateway::create($data);
        }
    }
