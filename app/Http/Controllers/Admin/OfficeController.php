<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Office;
use App\Models\SubscriptionType;
use App\Http\Requests\OfficeRequest;
use App\Services\OfficeService;
use App\Http\Traits\ResponseController;
use App\Models\City;
use Illuminate\Support\Facades\Auth;

// class OfficeController extends Controller
// {
//     use ResponseController;

//     private $officeService;

//     public function __construct(OfficeService $officeService)
//     {
//         $this->officeService = $officeService;
//     }

//     public function create()
//     {
//         $subscriptionTypes = SubscriptionType::all();
//         $cities = City::all(); 
//         return view('admin.auth.register', compact('subscriptionTypes', 'cities'));



//     }

//     public function store(OfficeRequest $request)
//     {
      
//         $request->merge(['user_id' => Auth::id()]);

      
//         $office = $this->officeService->registerOffice($request->all());

//         return $this->successResponse('Office registered successfully.', $office, 201);
//     }
// }
