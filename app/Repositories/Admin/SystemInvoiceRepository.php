<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\SystemInvoiceRepositoryInterface;
use App\Models\SystemInvoice;

class SystemInvoiceRepository implements SystemInvoiceRepositoryInterface
{
    public function all()
    {
        return SystemInvoice::all();
    }

    public function findByBrokerId($brokerId)
    {
        return SystemInvoice::where('broker_id', $brokerId)->get();
    }

    public function findByOfficeId($officeId)
    {
        return SystemInvoice::where('office_id', $officeId)->get();
    }

    public function find($id)
    {
        return SystemInvoice::find($id);
    }

    public function create(array $data)
    {
        return SystemInvoice::create($data);
    }


}
