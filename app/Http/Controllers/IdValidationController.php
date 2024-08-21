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

        $idNumber = $request->input('id_number');
        $result = $this->nafathService->validateIdNumber($idNumber);

        // Prepare the message and alert class based on the result
        if ($result['valid']) {
            $message = 'ID Number is valid';
            $alertClass = 'alert-success';
        } else {
            $message = 'ID Number is invalid';
            $alertClass = 'alert-danger';
        }

        // Redirect back with the result message
        return redirect()->route('id-validation')
                         ->with('message', $message)
                         ->with('alert-class', $alertClass);
    }
}
