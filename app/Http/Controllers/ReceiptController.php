<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Models\SubscriptionSection;
use App\Models\User;
use App\Notifications\Admin\ReceiptStatusUpdatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

class ReceiptController extends Controller
{
    //

    public function storeReceipt(Request $request){
        // Validate the request
        $request->validate([
            'receipt' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048', // Validate file types and size
        ]);

    // Initialize the data array with receipt_id and status


    $Last_receipt_id = Receipt::where('receipt_id', '!=', null)->latest()->value('receipt_id');
    $delimiter = '-';
    $new_receipt_id = !$Last_receipt_id ? '00001' : str_pad((int)explode($delimiter, $Last_receipt_id)[1] + 1, 5, '0', STR_PAD_LEFT);



    $data = [
        'receipt_id' => 'REC-' . $new_receipt_id,
        'status' => 'Under review', // Default status
        'comment' => $request->input('comment') ?? null,
    ];

    if (auth()->check()) {
        $user = auth()->user();

        if ($user->is_office) {
            $data['office_id'] = $user->UserOfficeData->id;
        } elseif ($user->is_broker) {
            $data['broker_id'] = $user->UserBrokerData->id;
        } elseif ($user->is_owner) {
            $data['owner_id'] = $user->UserOwnerData->id;
        }
    }


    if ($request->hasFile('receipt')) {
        $receipt = $request->file('receipt');
        $ext = $receipt->getClientOriginalExtension();
        $receiptName = uniqid() . '.' . $ext;
        $receipt->move(public_path('/Admin/Receipt/'), $receiptName);
        $data['receipt'] = '/Admin/Receipt/' . $receiptName;
    }


    $receipt = Receipt::create($data);

    if ($receipt) {
        return redirect()->back()->with('success', __('Receipt uploaded successfully!'));
    } else {
        return redirect()->back()->with('error', __('Failed to upload receipt. Please try again.'));
    }
    }

    public function indexReceipt(){
        $receipts = Receipt::paginate(20);
        return view('Admin.subscribers.receipts.index' , get_defined_vars());
    }

    public function showReceipt($id){
        $receipt = Receipt::findOrFail($id);
        return view('Admin.subscribers.receipts.show' , get_defined_vars());
    }


    public function updateStatus(Request $request, $id)
    {
        $receipt = Receipt::findOrFail($id);

        if ($receipt->status === 'accepted' || $receipt->status === 'rejected') {
            return redirect()->back()->with('error', __('This receipt has already been processed.'));
        }

        $newStatus = $request->input('status');
        $receipt->update(['status' => $newStatus]);

        if ($newStatus === 'accepted') {
            $userId = $this->getUserIdFromReceipt($receipt);
            if ($userId) {
                $this->activateSubscription($userId);
            }
        }
        $this->notifyRelatedUser($receipt, $newStatus);

        return redirect()->back()->with('success', __('Receipt status updated successfully.'));
    }
    protected function notifyRelatedUser($receipt, $newStatus)
    {
        $user = null;

        if ($receipt->OfficeData && $receipt->OfficeData->UserData) {
            $user = $receipt->OfficeData->UserData;
        } elseif ($receipt->BrokerData && $receipt->BrokerData->UserData) {
            $user = $receipt->BrokerData->UserData;
        } elseif ($receipt->OwnerData && $receipt->OwnerData->UserData) {
            $user = $receipt->OwnerData->UserData;
        }

        // Send notification if a user is found
        if ($user) {
            // $user->notify(new ReceiptStatusUpdatedNotification($receipt, $newStatus));
            Notification::send($user, new ReceiptStatusUpdatedNotification($receipt, $newStatus));

        }
    }
    protected function getUserIdFromReceipt($receipt)
    {
        if ($receipt->OfficeData && $receipt->OfficeData->UserData) {
            return $receipt->OfficeData->UserData->id;
        }

        if ($receipt->BrokerData && $receipt->BrokerData->UserData) {
            return $receipt->BrokerData->UserData->id;
        }

        if ($receipt->OwnerData && $receipt->OwnerData->UserData) {
            return $receipt->OwnerData->UserData->id;
        }

        return null; // Return null if no user ID is found
    }

    protected function activateSubscription($userId)
{
    // Auth::loginUsingId($userId);

    // Fetch user data for office or broker
    $user = User::find($userId);

    // $user = Auth::user();
    if (!$user) {
        return;
    }
    $officeData = $user->UserOfficeData;
    $brokerData = $user->UserBrokerData;

    // Determine which subscription to use
    $subscription = $officeData ? $officeData->UserSubscription : $brokerData->UserSubscription;

    if ($subscription) {
        $subscriptionType = $subscription->SubscriptionTypeData;
        $endDate = $subscriptionType->calculateEndDate(now())->format('Y-m-d H:i:s');

        // Get subscription sections
        $sections = $subscriptionType->sections()->get();

        // Delete old sections and add new ones
        $subscription->SubscriptionSectionData()->delete();
        foreach ($sections as $section) {
            SubscriptionSection::create([
                'section_id' => $section->id,
                'subscription_id' => $subscription->id,
            ]);
        }

        // Update subscription status to active
        $subscription->update([
            'status' => 'active',
            'is_start' => 1,
            'start_date' => now()->format('Y-m-d H:i:s'),
            'end_date' => $endDate
        ]);
    }

    // Update invoice status if available
    $invoice = $this->getPendingInvoice($officeData, $brokerData);
    if ($invoice) {
        $invoice->update(['status' => 'active']);
    }

    // Redirect user based on their role
    $redirectRoute = $officeData ? 'Office.home' : 'Broker.home';
    $redirectMessage = __('The subscription has been activated successfully');
    return redirect()->route($redirectRoute)->with('success', $redirectMessage);
}

// Helper function to get the pending invoice
private function getPendingInvoice($officeData, $brokerData)
{
    if ($officeData && $officeData->UserSubscriptionPending) {
        return $officeData->UserSubscriptionPending;
    } elseif ($brokerData && $brokerData->UserSubscriptionPending) {
        return $brokerData->UserSubscriptionPending;
    } elseif ($officeData && $officeData->UserSystemInvoicePending) {
        return $officeData->UserSystemInvoicePending;
    } elseif ($brokerData && $brokerData->UserSystemInvoicePending) {
        return $brokerData->UserSystemInvoicePending;
    }
    return null;
}


public function addComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        $receipt = Receipt::findOrFail($id);

        $receipt->update([
            'comment' => $request->input('comment'),
        ]);

        return redirect()->back()->with('success', __('Comment added successfully.'));
    }

}
