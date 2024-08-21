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

    public function showForm()
    {
        return view('auth.id-validation');
    }

    public function validateId(Request $request)
{
    $request->validate([
        'id_number' => 'required|string',
    ]);

    $idNumber = $request->input('id_number');
    $result = $this->nafathService->validateIdNumber($idNumber);

    if ($result['valid']) {
        return response()->json([
            'valid' => true,
            'message' => 'ID Number is valid',
        ]);
    } else {
        return response()->json([
            'valid' => false,
            'message' => 'ID Number is invalid',
        ]);
    }
}


    // public function validateId(Request $request)
    // {
    //     $request->validate([
    //         'id_number' => 'required|string',
    //     ]);

    //     $idNumber = $request->input('id_number');
    //     $result = $this->nafathService->validateIdNumber($idNumber);
    //     if ($result['valid']) {
    //         $message = 'ID Number is valid';
    //         $alertClass = 'alert-success';
    //     } else {
    //         $message = 'ID Number is invalid';
    //         $alertClass = 'alert-danger';
    //     }

    //     return redirect()->route('id-validation')
    //                      ->with('message', $message)
    //                      ->with('alert-class', $alertClass);
    // }
}
