<?php

namespace App\Interfaces\Admin;

use App\Models\SystemInvoice;

interface SystemInvoiceRepositoryInterface
{
    public function all();

    public function find($id);

    public function create(array $data);
    public function findByBrokerId(int $brokerId);
    public function findByOfficeId(int $officeId);

}
