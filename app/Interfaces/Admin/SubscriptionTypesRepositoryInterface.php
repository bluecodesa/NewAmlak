<?php

// App/Interfaces/SubscriptionTypesRepositoryInterface.php

namespace App\Interfaces\Admin;

use Illuminate\Http\Request;

interface SubscriptionTypesRepositoryInterface
{
    public function calculateRange($counts);

    public function index($statusFilter, $periodFilter, $priceFilter);

    public function create();

    public function store(Request $request);

    public function edit($id);

    public function update(Request $request, $id);

    public function find($id);

    public function getBy(array $arr);

    public function getAll();

    public function deleteMultiType($array);

    public function deleteType($id);

    public function getSubscriptionTypesByRole($roleName);

}
