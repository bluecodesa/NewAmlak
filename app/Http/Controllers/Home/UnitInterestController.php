<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Models\UnitInterest;
use Illuminate\Http\Request;

class UnitInterestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the authenticated user's ID
        $userId = auth()->user()->UserBrokerData->user_id;
        $unitInterests = UnitInterest::with('unit', 'user')
            ->where('user_id', $userId)
            ->get();

        return view('Broker.Gallary.unit-interest',get_defined_vars());
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'unit_id' => 'nullable|exists:units,id',
            'user_id' => 'required|exists:users,id',
        ]);


        $requestData = $request->all();
        $requestData['status'] = 'new order';

        UnitInterest::create($requestData);

        return redirect()->back()->with('success', 'Unit Interest created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $unitInterest = UnitInterest::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'id' => 'required|exists:unit_interests,id',
            'status' => 'required',
        ]);


        // Find the unit interest by ID
        $unitInterest = UnitInterest::findOrFail($request->id);

        // Update the status
        $unitInterest->update(['status' => $request->status]);

        // Optionally, you can return a response or redirect
        return redirect()->back()->with('success', 'Status updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
