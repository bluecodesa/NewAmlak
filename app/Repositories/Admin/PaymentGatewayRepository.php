<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\PaymentGatewayRepositoryInterface;
use App\Models\BankAccount;
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

        if (array_key_exists('image', $data)) {
            $image = $data['image'];


            if ($image) {
                $ext = $data['image']->getClientOriginalExtension();
                $imageName = uniqid() . '.' . $ext;
                $image->move(public_path('/PaymentGateway/'), $imageName);
                $data['image'] = '/PaymentGateway/' . $imageName;
            } else {

                unset($data['image']);
            }
        }
        return PaymentGateway::create($data);
    }



    public function updatePaymentGateway($id, array $data)
    {
          // Check if is_default is set to 1
          if (isset($data['is_default']) && $data['is_default'] == '1') {
            // Check if there is already a default bank account
            $existingDefault = PaymentGateway::where('is_default', '1')->where('id', '!=', $id)->first();
            if ($existingDefault) {
                // Return an error message
                return redirect()->route('Admin.settings.index')->with('sorry', __('لا يمكن إضافة أكثر من حالة رئيسية في بوابات الدفع'));
            }
        }

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


    public function createBankAccount(array $data)
    {
        $data['user_id'] = Auth::user()->id;

        if (array_key_exists('image', $data)) {
            $image = $data['image'];


            if ($image) {
                $ext = $data['image']->getClientOriginalExtension();
                $imageName = uniqid() . '.' . $ext;
                $image->move(public_path('/BankAccounts/'), $imageName);
                $data['image'] = '/BankAccounts/' . $imageName;
            } else {

                unset($data['image']);
            }
        }
        return BankAccount::create($data);
    }



    public function updateBankAccount($id, array $data)
    {
        // Check if is_default is set to 1
        if (isset($data['is_default']) && $data['is_default'] == '1') {
            // Check if there is already a default bank account
            $existingDefault = BankAccount::where('is_default', '1')->where('id', '!=', $id)->first();
            if ($existingDefault) {
                // Return an error message
                return redirect()->route('Admin.settings.index')->with('sorry', __('لا يمكن إضافة أكثر من حالة رئيسية في الحسابات'));
            }
        }

        $payment = BankAccount::findOrFail($id);

        if (isset($data['image'])) {
            $image = $data['image'];

            // Proceed with image upload logic
            $ext = $image->getClientOriginalExtension();
            $imageName = uniqid() . '.' . $ext;
            $image->move(public_path('/BankAccounts/'), $imageName);
            $data['image'] = '/BankAccounts/' . $imageName;
        }

        $payment->update($data);
        return $payment;
    }



}
