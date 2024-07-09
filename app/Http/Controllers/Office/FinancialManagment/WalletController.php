<?php

namespace App\Http\Controllers\Office\FinancialManagment;

use App\Http\Controllers\Controller;
use App\Services\Admin\WalletTypeService;
use Illuminate\Http\Request;
use App\Services\CityService;
use App\Services\Office\WalletService;
use App\Services\RegionService;

class WalletController extends Controller
{

    protected $WalletService;
    protected $WalletTypeService;

    protected $regionService;
    protected $cityService;

    public function __construct(WalletService $WalletService,WalletTypeService $WalletTypeService , RegionService $regionService, CityService $cityService)
    {
        $this->WalletService = $WalletService;
        $this->WalletTypeService = $WalletTypeService;
        $this->regionService = $regionService;
        $this->cityService = $cityService;
    }

    public function index()
    {
        $wallets = $this->WalletService->getAllByOfficeId(auth()->user()->UserOfficeData->id);
        return view('Office.FinancialManagment.Wallet.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        $walletTypes = $this->WalletTypeService->getAll();
        return view('Office.FinancialManagment.Wallet.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $this->WalletService->createWallet($request->all());
        return redirect()->route('Office.Wallet.index')->with('success', __('added successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $Owner =  $this->WalletService->getById($id);
        $Regions = $this->regionService->getAllRegions();
        $cities = $this->cityService->getAllCities();
        return view('Office.FinancialManagment.Wallet.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $this->WalletService->updateWallet($id, $request->all());
        return redirect()->route('Office.Wallet.index')->with('success', __('Update successfully'));
    }

    public function destroy(string $id)
    {
        $this->WalletService->deleteWallet($id);
        return redirect()->route('Office.Wallet.index')->with('success', __('Deleted successfully'));
    }
}
