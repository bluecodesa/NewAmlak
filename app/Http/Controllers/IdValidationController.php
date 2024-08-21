<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NafathService;

class IdValidationController extends Controller
{
    //
    protected $nafathService;

    public function __construct(NafathService $nafathService)
    {
        $this->nafathService = $nafathService;
    }

    // Method to display the validation form
    public function showForm()
    {
        return view('auth.id-validation');
    }

    // Method to handle form submission and validate ID number
    public function validateId(Request $request)
    {
        $request->validate([
            'id_number' => 'required|string',
        ]);

        // Example: Retrieving IAM page URL
        $result = $this->nafathService->retrieveIamPage('ar', $request->input('id_number'));

        // Handle the response and set the message
        if (isset($result['id'])) {
            $message = 'ID Number is valid';
            $alertClass = 'alert-success';
        } else {
            $message = 'ID Number is invalid';
            $alertClass = 'alert-danger';
        }

        return redirect()->route('id-validation')
                         ->with('message', $message)
                         ->with('alert-class', $alertClass);
    }
}
