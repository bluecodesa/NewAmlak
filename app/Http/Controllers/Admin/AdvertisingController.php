<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertising;
use App\Models\PartnerSuccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdvertisingController  extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $Ads = Advertising::all();
        return view('Admin.settings.HomePages.PartnerSuccess.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Admin.settings.HomePages.PartnerSuccess.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
            $imageName = uniqid() . '.' . $ext;
            $image->move(public_path('/Admin/PartnerSuccess/Images/'), $imageName);
            $data['image'] = '/Admin/PartnerSuccess/Images/' . $imageName;
        }

        PartnerSuccess::create($data);

        return redirect()->route('Admin.PartnerSuccess.index')
            ->with('success', 'added successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $partnerSuccess = PartnerSuccess::findOrFail($id);
        return view('Admin.settings.HomePages.PartnerSuccess.edit', compact('partnerSuccess'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $partnerSuccess = PartnerSuccess::findOrFail($id);

        $data = $request->only(['name']);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($partnerSuccess->image) {
                $oldImagePath = public_path($partnerSuccess->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Upload new image
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('Admin/PartnerSuccess/Images/'), $imageName);
            $data['image'] = 'Admin/PartnerSuccess/Images/' . $imageName;
        }

        $partnerSuccess->update($data);
        return redirect()->route('Admin.PartnerSuccess.index')->with('success', 'Update successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $partnerSuccess = PartnerSuccess::findOrFail($id);
        if ($partnerSuccess->image) {
            $imagePath = public_path($partnerSuccess->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $partnerSuccess->delete();

        return redirect()->route('Admin.PartnerSuccess.index')->with('success', 'Deleted successfully');

    }
}
