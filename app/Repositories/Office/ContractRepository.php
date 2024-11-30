<?php

namespace App\Repositories\Office;

use App\Interfaces\Office\ContractRepositoryInterface;
use App\Models\Attachment;
use App\Models\Contract;
use App\Models\ContractAttachment;
use App\Models\Installment;
use App\Models\Renter;
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


    public function getContractByRenterId($id)
    {

        return Contract::where('renter_id', $id)->get();
    }
    public function create($data)
    {

        // dd($data);
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
            'bear_commission' => 'required|string',
            'renter_id' => 'required|exists:renters,id',
            'calendarTypeSelect' => 'required|string|in:gregorian,hijri',
            'gregorian_contract_date' => 'nullable|date',
            'hijri_contract_date' => 'nullable|string',
            'date_concluding_contract' => 'nullable|date',
            'contract_duration' => 'required|integer',
            'duration_unit' => 'required|string',
            'payment_cycle' => 'required|string',
            'auto_renew' => 'required|string',
            // 'name.*' => 'nullable|string',
            'attachment.*' => 'nullable|file',
        ];
        $messages = [
            'project_id.required' => 'The project ID field is required.',
            'bear_commission.required' => 'The bear commission field is required.',
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


        $office_id = auth()->user()->UserOfficeData->id;

        // إنشاء رقم العقد
        $customer_id = auth()->user()->customer_id;

        // استرجاع آخر رقم عقد للمكتب
        $lastContract = Contract::where('office_id', $office_id)
            ->orderBy('id', 'desc')
            ->first();

        if ($lastContract) {
            // تقسيم رقم العقد الأخير وزيادة الجزء الأخير
            $lastContractNumber = $lastContract->contract_number;
            $parts = explode('-', $lastContractNumber);
            $lastPart = (int)$parts[2]; // الجزء الأخير
            $newPart = $lastPart + 1; // زيادة الجزء الأخير
            $contractNumber = "{$parts[0]}-{$parts[1]}-{$newPart}"; // رقم العقد الجديد
        } else {
            // إذا لم يوجد أي عقود، نبدأ من قيمة افتراضية
            $contractNumber = "{$customer_id}-1"; // تخصيص هذا حسب الحاجة
        }


        $contractData = [
            'office_id' => auth()->user()->UserOfficeData->id,
            'project_id' => $data['project_id'] ?? null,
            'property_id' => $data['property_id'] ?? null,
            'unit_id' => $data['unit_id'],
            'owner_id' => $data['owner_id'],
            'employee_id' => $data['employee_id'] ?? null,
            // 'price' => $data['price'],
            'price' => 0, // سنقوم بتحديث السعر لاحقًا
            'type' => $data['type'],
            'service_type_id' => $data['service_type_id'],
            'bear_commission' => $data['bear_commission'],
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
            'contract_number' => $contractNumber, // إضافة رقم العقد



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

        // if (isset($data['name']) && isset($data['attachment'])) {
        //     foreach ($data['name'] as $index => $attachment_name) {
        //         $attachment = Attachment::where('name', $attachment_name)->first();
        //         if (!$attachment) {
        //             $attachment = Attachment::create([
        //                 'name' => $attachment_name,
        //                 'created_by' => Auth::id()
        //             ]);
        //         }

        //         $attachmentFile = $data['attachment'][$index];
        //         $ext = $attachmentFile->getClientOriginalExtension();
        //         $fileName = uniqid() . '.' . $ext;

        //         $attachmentFile->move(public_path('/Offices/Contracts/' . $attachment->name), $fileName);

        //         ContractAttachment::create([
        //             'attachment_id' => $attachment->id,
        //             'contract_id' => $contract->id,
        //             'attachment' => '/Offices/Contracts/' . $attachment->name . '/' . $fileName
        //         ]);
        //     }
        // }


        if (isset($data['attachment'])) {
            foreach ($data['attachment'] as $attachmentFile) {
                // الحصول على الاسم الأصلي للملف
                $originalFileNameWithExt = $attachmentFile->getClientOriginalName();

                // إزالة الامتداد من الاسم الأصلي للملف
                $originalFileName = pathinfo($originalFileNameWithExt, PATHINFO_FILENAME);

                // تحقق مما إذا كان الاسم مسجلاً بالفعل
                $existingAttachment = Attachment::where('name', $originalFileName)->first();

                // إذا لم يكن الاسم مسجلاً، قم بإضافته إلى قاعدة البيانات
                if (!$existingAttachment) {
                    // إنشاء سجل جديد في جدول Attachment
                    $attachment = Attachment::create([
                        'name' => $originalFileName,
                        'created_by' => Auth::id()
                    ]);

                    // الحصول على الامتداد وإنشاء اسم فريد للملف للتخزين
                    $ext = $attachmentFile->getClientOriginalExtension();
                    $fileName = uniqid() . '.' . $ext;

                    // نقل الملف إلى المسار المحدد
                    $attachmentFile->move(public_path('/Offices/Contracts/' . $originalFileName), $fileName);

                    // إنشاء سجل في جدول ContractAttachment وربط الملف بالعقد
                    ContractAttachment::create([
                        'attachment_id' => $attachment->id,
                        'contract_id' => $contract->id,
                        'attachment' => '/Offices/Contracts/' . $originalFileName . '/' . $fileName,
                    ]);
                }
            }
        }


        // $this->createInstallments($contract, $data);
        $totalInstallmentsPrice = $this->createInstallments($contract, $data);

        // تحديث سعر العقد بناءً على مجموع الأقساط
        $contract->update(['price' => $totalInstallmentsPrice]);

        return $contract;
    }

    private function createInstallments(Contract $contract, array $data)
    {
        $numberOfContracts = 1;
        $installments = [];

        // Calculate monthly price based on the contract duration and payment cycle
        $pricePerMonth = $data['price'] / 12;  // Assuming price is annual, so dividing by 12

        // تحديد عدد الأقساط بناءً على مدة العقد ودورة الدفع
        if ($data['duration_unit'] === 'year') {
            if ($data['payment_cycle'] === 'annual') {
                $numberOfContracts = $data['contract_duration'];
                $pricePerContract = $pricePerMonth * 12; // For annual, price is the full year's price
            } else if ($data['payment_cycle'] === 'semi-annual') {
                $numberOfContracts = $data['contract_duration'] * 2;
                $pricePerContract = $pricePerMonth * 6; // For semi-annual, price is 6 months
            } else if ($data['payment_cycle'] === 'quarterly') {
                $numberOfContracts = $data['contract_duration'] * 4;
                $pricePerContract = $pricePerMonth * 3; // For quarterly, price is 3 months
            } else if ($data['payment_cycle'] === 'monthly') {
                $numberOfContracts = $data['contract_duration'] * 12;
                $pricePerContract = $pricePerMonth; // For monthly, price is the monthly price
            }
        } else if ($data['duration_unit'] === 'month') {
            if ($data['payment_cycle'] === 'monthly') {
                $numberOfContracts = $data['contract_duration'];
                $pricePerContract = $pricePerMonth; // For monthly, price is the monthly price
            } else if ($data['payment_cycle'] === 'quarterly') {
                $numberOfContracts = ceil($data['contract_duration'] / 3);
                $pricePerContract = $pricePerMonth * 3; // For quarterly, price is 3 months
            }
        }

        // تحديد تاريخ بداية العقد
        if (!empty($data['gregorian_contract_date'])) {
            $startDate = new \DateTime($data['gregorian_contract_date']);
        } elseif (!empty($data['hijri_contract_date'])) {
            $startDate = new \DateTime($data['hijri_contract_date']);
        } else {
            throw new \InvalidArgumentException('Invalid calendar type provided.');
        }

        // حساب العمولة لكل قسط إذا كانت مطلوبة
        $commissionPerContract = 0;

        if ($data['service_type_id'] == 3) {
            if ($data['collection_type'] === 'once with frist installment') {
                $commissionPerContract = ($data['commissions_rate'] / 100) * $data['price'];
            } else if ($data['collection_type'] === 'divided with all installments') {
                $commissionPerContract = ($data['commissions_rate'] / 100) * $pricePerContract;
            }
        }

        // إنشاء الأقساط
        $totalInstallmentsPrice = 0;

        for ($i = 0; $i < $numberOfContracts; $i++) {
            $endDate = clone $startDate;

            // تحديث تاريخ النهاية بناءً على دورة الدفع
            if ($data['payment_cycle'] === 'monthly') {
                $endDate->modify('+1 month');
            } else if ($data['payment_cycle'] === 'quarterly') {
                $endDate->modify('+3 months');
            } else if ($data['payment_cycle'] === 'semi-annual') {
                $endDate->modify('+6 months');
            } else if ($data['payment_cycle'] === 'annual') {
                $endDate->modify('+1 year');
            }

            // حساب السعر النهائي لكل قسط مع تضمين العمولة إذا كانت مطلوبة
            $finalPrice = $pricePerContract;
            // if ($commissionPerContract !== 0) {
            //     if ($data['collection_type'] === 'once with frist installment') {
            //         if ($i === 0) {
            //             $finalPrice += $commissionPerContract;
            //         }
            //     } else if ($data['collection_type'] === 'divided with all installments') {
            //         $finalPrice += $commissionPerContract;
            //     }
            // }

            if ($commissionPerContract !== 0) {
                if ($data['bear_commission'] === 'owner') {
                    // Deduct commission from the first installment for owners
                    if ($data['collection_type'] === 'once with frist installment') {
                        $finalPrice = $finalPrice + 0; // Deduct commission
                    }
                } else if ($data['bear_commission'] === 'Renter') {
                    // Add commission for renters
                    if ($data['collection_type'] === 'once with frist installment') {
                        $finalPrice += $commissionPerContract; // Add commission to first installment
                    } else if ($data['collection_type'] === 'divided with all installments') {
                        $finalPrice += $commissionPerContract; // Add commission to each installment
                    }
                }
            }

            $installments[] = [
                'contract_id' => $contract->id,
                'price' => $pricePerContract,
                'final_price' => $finalPrice,
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'Installment_number' => $contract->contract_number . '-' . ($i + 1),
                'commission' => ($data['collection_type'] === 'once with frist installment' && $i === 0) ? $commissionPerContract : ($data['collection_type'] === 'divided with all installments' ? $commissionPerContract : 0),
            ];

            // Update start date for next installment
            $startDate = $endDate;
            $totalInstallmentsPrice += $pricePerContract;

        }

        // Save installments to database
        Installment::insert($installments);
        return $totalInstallmentsPrice;

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
