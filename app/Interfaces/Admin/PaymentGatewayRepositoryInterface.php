<?php


namespace App\Interfaces\Admin;

use Illuminate\Http\Request;
use App\Models\PaymentGateway;

interface PaymentGatewayRepositoryInterface
{
    public function editPaymentGatewayForm($id);
    public function createPaymentGateway(array  $data);
}
