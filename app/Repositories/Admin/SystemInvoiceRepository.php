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

    public function find($id)
    {
        return SystemInvoice::find($id);
    }

    public function create(array $data)
    {
        return SystemInvoice::create($data);
    }

   
}
