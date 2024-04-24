<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\SystemInvoiceRepositoryInterface;
use App\Models\SystemInvoice;
use Illuminate\Support\Facades\DB;

class SystemInvoiceRepository implements SystemInvoiceRepositoryInterface
{
    public function all()
    {
        $duplicates = SystemInvoice::select('created_at', 'broker_id', DB::raw('COUNT(*) as count'))
            ->groupBy(['created_at', 'broker_id'])
            ->havingRaw('count > 1')
            ->get();

        foreach ($duplicates as $duplicate) {
            $duplicateRecords = SystemInvoice::where('created_at', $duplicate->created_at)
                ->where('broker_id', $duplicate->broker_id)
                ->get();

            // Keep one record and delete the rest
            $duplicateRecords->slice(1)->each->delete();
        }

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
