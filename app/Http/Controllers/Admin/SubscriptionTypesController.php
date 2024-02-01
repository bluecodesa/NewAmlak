<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Interfaces\SubscriptionTypesRepositoryInterface;
use App\Http\Requests\SubscriptionTypeRequest;
use App\Models\SubscriptionType;
use Illuminate\Http\Request;

class SubscriptionTypesController extends Controller
{
    private $subtypeRepo;

    public function __construct(SubscriptionTypesRepositoryInterface $subtypeRepo)
    {
        $this->subtypeRepo = $subtypeRepo;
    }

    // ... other methods

    public function index()
    {
        $status_filter = request()->input('status_filter') ?? 'all';
        $period_filter = request()->input('period_filter') ?? 'all';
        $price_filter = request()->input('price_filter') ?? 'all';

        return $this->subtypeRepo->index($status_filter, $period_filter, $price_filter);
    }

    public function create()
    {
        return $this->subtypeRepo->create();
    }


    // ...

    public function store(SubscriptionTypeRequest $request)
    {
        return $this->subtypeRepo->store($request);
    }

    public function edit($id)
    {
        return $this->subtypeRepo->edit($id);
    }



    // ...

    public function update(Request $request, $id)
    {
        return $this->subtypeRepo->update($request, $id);
    }

    public function deleteMultiType($array)
    {
        return $this->subtypeRepo->deleteMultiType($array);
    }

    public function destroy($id)
    {
        SubscriptionType::where(['id' => $id])->update(['is_deleted' => 1]);
        return redirect()->route('Admin.SubscriptionTypes.index')
            ->withSuccess(__('Deleted successfully'));
    }
}