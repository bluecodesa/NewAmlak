<?php

// app\Services\PaymentGatewayService.php

namespace App\Services;

use App\Interfaces\Admin\PaymentGatewayRepositoryInterface;
use App\Repositories\Admin\PaymentGatewayRepository;
use Illuminate\Http\Request;

class PaymentGatewayService implements PaymentGatewayRepositoryInterface
{
    protected $paymentGatewayRepository;

    public function __construct(PaymentGatewayRepository $paymentGatewayRepository)
    {
        $this->paymentGatewayRepository = $paymentGatewayRepository;
    }

    public function editPaymentGatewayForm($id)
    {
        $paymentGateway = $this->paymentGatewayRepository->find($id);
        return view('Admin.settings.Payments.edit-modal', compact('paymentGateway'));
    }

    public function createPaymentGateway(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'api_key' => 'required|string',
            'profile_id' => 'required|string',
            'client_key' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->input('name'),
            'api_key_paytabs' => $request->input('api_key'),
            'profile_id_paytabs' => $request->input('profile_id'),
            'client_key' => $request->input('client_key'),
            'user_id' => auth()->id(),
        ];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('dashboard_files/images/payments');
            $file->move($destinationPath, $fileName);
            $data['image'] = 'dashboard_files/images/payments/' . $fileName;
        }

        $this->paymentGatewayRepository->create($data);

        return redirect()->route('Admin.settings.index')->with('success', __('Payment gateway created successfully.'));
    }
}
