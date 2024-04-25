<?php

namespace App\Http\Controllers\Admin\Subscribers;

use App\Interfaces\Admin\SystemInvoiceRepositoryInterface;

use App\Services\RegionService;
use App\Services\CityService;
use App\Http\Controllers\Controller;
use App\Models\SubscriptionType;
use App\Services\Admin\SubscriptionTypeService;
use Illuminate\Http\Request;

class SystemInvoiceController extends Controller
{
    protected $systemInvoiceRepository;
    protected $regionService;
    protected $cityService;
    protected $subscriptionTypeService;


    public function __construct(SystemInvoiceRepositoryInterface $systemInvoiceRepository, 
    RegionService $regionService, 
    CityService $cityService,
    SubscriptionTypeService $subscriptionTypeService)
    {
        $this->systemInvoiceRepository = $systemInvoiceRepository;
        $this->regionService = $regionService;
        $this->cityService = $cityService;
        $this->subscriptionTypeService = $subscriptionTypeService;

    }

    public function index()
    {
        $invoices = $this->systemInvoiceRepository->all();
        return view('Admin.subscribers.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        // $subscriptionTypes = SubscriptionType::all();
        $subscriptionTypes = $this->subscriptionTypeService->getSubscriptionTypeAll();
        return view('Admin.subscribers.invoices.create');
    }

    public function store(Request $request)
    {

        $this->systemInvoiceRepository->create($request->all());

        return redirect()->route('Admin.Subscribers.index')
            ->withSuccess(__('added successfully'));
    }

    public function show($id)
    {
        $invoice = $this->systemInvoiceRepository->find($id);
        return view('Admin.subscribers.invoices.show', compact('invoice'));
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
}
