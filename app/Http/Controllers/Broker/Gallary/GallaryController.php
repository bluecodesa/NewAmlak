<?php

namespace App\Http\Controllers\Broker\Gallary;
use App\Services\Broker\UnitService;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GallaryController extends Controller
{
    protected $UnitService;

    public function __construct(UnitService $UnitService){
        $this->UnitService = $UnitService;

    }
    public function index()
    {
        //
        $gallrays = $this->UnitService->getAll(auth()->user()->UserBrokerData->id);
        return view('Broker.Gallary.index',get_defined_vars());
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $Unit = $this->UnitService->findById($id);
        return view('Broker.Gallary.show',  get_defined_vars());

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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function showGalleryUnit($broker_name, $id)
    {
        $Unit = $this->UnitService->findById($id);
        return view('Broker.Gallery.show', get_defined_vars());
    }
}
