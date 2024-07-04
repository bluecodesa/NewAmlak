<?php

namespace App\Repositories\Office;

use App\Interfaces\Office\ContractRepositoryInterface;
use App\Models\Attachment;
use App\Models\Contract;
use App\Models\ContractAttachment;
use App\Models\Installment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class ContractRepository implements ContractRepositoryInterface
{
    public function getAllByOfficeId($officeId)
    {

        return Contract::where('office_id', $officeId)->get();
    }
    public function getAllByContractId($contractId)
    {

        return Contract::where('office_id', $contractId)->get();
    }


    public function create($data)
    {
        $rules = [
            'project_id' => 'nullable|exists:projects,id',
            'property_id' => 'nullable|exists:properties,id',
            'unit_id' => 'required|exists:units,id',
            'owner_id' => 'required|exists:owners,id',
            'employee_id' => 'nullable|exists:employees,id',
            'price' => 'required|numeric',
            'type' => 'required|string',
            'service_type_id' => 'required|exists:service_types,id',
            'commissions_rate' => 'nullable|numeric',
            'collection_type' => 'nullable|string',
            'renter_id' => 'required|exists:renters,id',
            'calendarTypeSelect' => 'required|string|in:gregorian,hijri',
            'gregorian_contract_date' => 'nullable|date',
            'hijri_contract_date' => 'nullable|string',
            'date_concluding_contract' => 'nullable|date',
            'contract_duration' => 'required|integer',
            'duration_unit' => 'required|string',
            'payment_cycle' => 'required|string',
            'auto_renew' => 'required|string',
            'name.*' => 'nullable|string',
            'attachment.*' => 'nullable|file',
        ];
        $messages = [
            'project_id.required' => 'The project ID field is required.',
            'project_id.exists' => 'The selected project ID is invalid.',
            'property_id.required' => 'The property ID field is required.',
            'property_id.exists' => 'The selected property ID is invalid.',
            'unit_id.required' => 'The unit ID field is required.',
            'unit_id.exists' => 'The selected unit ID is invalid.',
            'owner_id.required' => 'The owner ID field is required.',
            'owner_id.exists' => 'The selected owner ID is invalid.',
            'employee_id.required' => 'The employee ID field is required.',
            'employee_id.exists' => 'The selected employee ID is invalid.',
            'price.required' => 'The price field is required.',
            'price.numeric' => 'The price must be a number.',
            'type.required' => 'The type field is required.',
            'type.string' => 'The type must be a string.',
            'service_type_id.required' => 'The service type ID field is required.',
            'service_type_id.exists' => 'The selected service type ID is invalid.',
            'commissions_rate.numeric' => 'The commissions rate must be a number.',
            'collection_type.string' => 'The collection type must be a string.',
            'renter_id.required' => 'The renter ID field is required.',
            'renter_id.exists' => 'The selected renter ID is invalid.',
            'calendarTypeSelect.required' => 'The calendar type field is required.',
            'calendarTypeSelect.string' => 'The calendar type must be a string.',
            'calendarTypeSelect.in' => 'The calendar type must be either gregorian or hijri.',
            'gregorian_contract_date.date' => 'The Gregorian contract date must be a valid date.',
            'hijri_contract_date.string' => 'The Hijri contract date must be a valid string.',
            'date_concluding_contract.date' => 'The concluding contract date must be a valid date.',
            'contract_duration.required' => 'The contract duration field is required.',
            'contract_duration.integer' => 'The contract duration must be an integer.',
            'duration_unit.required' => 'The duration unit field is required.',
            'duration_unit.string' => 'The duration unit must be a string.',
            'payment_cycle.required' => 'The payment cycle field is required.',
            'payment_cycle.string' => 'The payment cycle must be a string.',
            'auto_renew.required' => 'The auto renew field is required.',
            'auto_renew.string' => 'The auto renew field must be a string.',
            'name.*.string' => 'The name field for attachments must be a string.',
            'attachment.*.file' => 'The attachment must be a file.',
        ];
        validator($data, $rules,$messages)->validate();


        // if (empty($data['employee_id'])) {
        //     $data['employee_id'] = auth()->user()->UserOfficeData->id;
        // }
        $totalcommission = $data['price'] * ($data['commissions_rate'] / 100);


        $contractData = [
            'office_id' => auth()->user()->UserOfficeData->id,
            'project_id' => $data['project_id'] ?? null,
            'property_id' => $data['property_id'] ?? null,
            'unit_id' => $data['unit_id'],
            'owner_id' => $data['owner_id'],
            'employee_id' => $data['employee_id'] ?? null,
            'price' => $data['price'],
            'type' => $data['type'],
            'service_type_id' => $data['service_type_id'],
            'commissions_rate' => $data['commissions_rate'],
            'total_commission' => $totalcommission, // Add commission total here
            'collection_type' => $data['collection_type'] ?? null,
            'renter_id' => $data['renter_id'],
            'contract_duration' => $data['contract_duration'],
            'duration_unit' => $data['duration_unit'],
            'payment_cycle' => $data['payment_cycle'],
            'auto_renew' => $data['auto_renew'],
            'date_concluding_contract' => $data['date_concluding_contract'],
            'calendarTypeSelect' => $data['calendarTypeSelect'],


        ];
        if ($data['gregorian_contract_date']) {
            $startDate = Carbon::parse($data['gregorian_contract_date']);
            $contractData['start_contract_date'] = $startDate;
        } elseif ($data['hijri_contract_date']) {
            $startDate = Carbon::parse($data['hijri_contract_date']);
            $contractData['start_contract_date'] = $startDate;
        }
        switch ($data['duration_unit']) {
            case 'month':
                $endDate = $startDate->copy()->addMonths($data['contract_duration']);
                break;
            case 'year':
                $endDate = $startDate->copy()->addYears($data['contract_duration']);
                break;
            default:
                return back()->withErrors(['duration_unit' => 'Invalid duration unit provided.']);
        }

        $contractData['end_contract_date'] = $endDate;

        $contract = Contract::create($contractData);

        if (isset($data['name']) && isset($data['attachment'])) {
            foreach ($data['name'] as $index => $attachment_name) {
                $attachment = Attachment::where('name', $attachment_name)->first();
                if (!$attachment) {
                    $attachment = Attachment::create([
                        'name' => $attachment_name,
                        'created_by' => Auth::id()
                    ]);
                }

                $attachmentFile = $data['attachment'][$index];
                $ext = $attachmentFile->getClientOriginalExtension();
                $fileName = uniqid() . '.' . $ext;

                $attachmentFile->move(public_path('/Offices/Contracts/' . $attachment->name), $fileName);

                ContractAttachment::create([
                    'attachment_id' => $attachment->id,
                    'contract_id' => $contract->id,
                    'attachment' => '/Offices/Contracts/' . $attachment->name . '/' . $fileName
                ]);
            }
        }

        $customer_id = auth()->user()->customer_id;
        $contractNumber = $customer_id .'-'. $contract->id;

        $contract->update(['contract_number' => $contractNumber]);

        $this->createInstallments($contract, $data);

        return $contract;
    }

    private function createInstallments(Contract $contract, array $data)
    {
        $numberOfContracts = 1;
        $installments = [];

        if ($data['duration_unit'] === 'year' && $data['payment_cycle'] === 'annual') {
            $numberOfContracts = $data['contract_duration'];
        } else if ($data['duration_unit'] === 'month' && $data['payment_cycle'] === 'monthly') {
            $numberOfContracts = $data['contract_duration'];
        } else if ($data['duration_unit'] === 'year' && $data['payment_cycle'] === 'monthly') {
            $numberOfContracts = $data['contract_duration'] * 12;
        }

        // $startDate = new \DateTime($data['contract_date']);
        if ($data['gregorian_contract_date']) {
            $startDate = new \DateTime($data['gregorian_contract_date']);
        } elseif ($data['hijri_contract_date']) {
            $hijriDate = $data['hijri_contract_date'];
            $startDate = new \DateTime($hijriDate);
        } else {
            throw new \InvalidArgumentException('Invalid calendar type provided.');
        }
        $pricePerContract = $data['price'] / $numberOfContracts;
        $commissionPerContract = 0;

        if ($data['service_type_id'] == 3) {
            if ($data['collection_type'] == 'once with frist installment') {
                $commissionPerContract = ($data['commissions_rate'] / 100) * $data['price'];
            } else if ($data['collection_type'] == 'divided with all installments') {
                $commissionPerContract = ($data['commissions_rate'] / 100) * ($data['price'] / $numberOfContracts);
            }
        }

        for ($i = 0; $i < $numberOfContracts; $i++) {
            $endDate = clone $startDate;
            if ($data['duration_unit'] === 'month') {
                $endDate->modify('+1 month');
            } else if ($data['duration_unit'] === 'year') {
                $endDate->modify('+1 year');
            }
            $price = $pricePerContract;

            $finalPrice = $pricePerContract;
            if ($commissionPerContract !== 0) {
                if ($data['collection_type'] === 'once with frist installment') {
                    if ($i === 0) {
                        $finalPrice += $commissionPerContract;
                    }
                } else if ($data['collection_type'] === 'divided with all installments') {
                    $finalPrice += $commissionPerContract;
                }
            }

            $installments[] = [
                'contract_id' => $contract->id,
                'price' => $price,
                'final_price' => $finalPrice,
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'Installment_number' => $contract->contract_number . '-' . ($i + 1),
                'commission' => ($data['collection_type'] === 'once with frist installment' && $i === 0) ? $commissionPerContract : ($data['collection_type'] === 'divided with all installments' ? $commissionPerContract  : 0),


            ];

            $startDate = clone $endDate;
        }

        Installment::insert($installments);
    }

    function getContractById($id)
    {
        return Contract::find($id);
    }

    public function updateContract($id, $data)
    {
        $Contract = Contract::findOrFail($id);
        $Contract->update($data);
        return $Contract;
    }

    public function deleteContract($id)
    {
        return Contract::findOrFail($id)->delete();
    }
}
