@extends('Admin.layouts.app')
@section('title', __('Show'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6">
                    <h4>
                        <a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Office.Contract.index') }}" class="text-muted fw-light">@lang('Contracts')</a> /
                        @lang('Show')
                    </h4>
                </div>
            </div>

            <div class="col-xl-12">

                <div class="nav-align-top nav-tabs-shadow mb-4">
                    <div class="row">
                        <div class="col-md-2 col-12 mb-3">
                            <label class="form-label">
                                {{ __('Contract Number') }} <span class="required-color"></span></label>
                            <input disabled type="text" required id="modalRoleName" name="number_unit"
                                class="form-control" placeholder="{{ $contract->contract_number }}">
                        </div>
                        <div class="col-md-2 col-12 mb-3">
                            <label class="form-label">
                                {{ __('status') }} <span class="required-color"></span></label>
                            @if ($contract->status == 'draft')
                                <input disabled type="text" required id="modalRoleName" name="number_unit"
                                    class="form-control" placeholder="{{ __('draft') }}">
                            @elseif ($contract->status == 'Approved')
                                <input disabled type="text" required id="modalRoleName" name="number_unit"
                                    class="form-control" placeholder="{{ __('Approved') }}">
                            @else
                                <input disabled type="text" required id="modalRoleName" name="number_unit"
                                    class="form-control" placeholder="{{ __('Executed') }}">
                            @endif
                        </div>
                        <div class="col-md-2 col-12 mb-3">
                            <label class="form-label">
                                {{ __('Contract validity') }} <span class="required-color"></span></label>
                            <input disabled type="text" required id="modalRoleName" name="number_unit"
                                class="form-control" placeholder="{{ __($contract->contract_validity) }}">
                        </div>
                        <div class="col-md-4 col-12 mb-3">
                            @if($contract->status == 'draft')
                            <button class="btn btn-secondary" id="certifyButton" onclick="handleCertify('{{ $contract->id }}')" data-contract-id="{{ $contract->id }}">@lang('Approve')</button>
                            <button class="btn btn-primary" id="deportationButton" onclick="handleDeportation('{{ $contract->id }}')" data-contract-id="{{ $contract->id }}">@lang('Execute')</button>
                            @if (Auth::user()->hasPermission('edit-contract') && $contract->status != 'Executed')
                            <a class="btn btn-info"
                                href="{{ route('Office.Contract.edit', $contract->id) }}">@lang('Edit')</a>
                            @endif
                            @elseif ($contract->status == 'Approved')
                            <button class="btn btn-primary" id="deportationButton" onclick="handleDeportation('{{ $contract->id }}')" data-contract-id="{{ $contract->id }}">@lang('Execute')</button>
                            @if (Auth::user()->hasPermission('edit-contract') && $contract->status != 'Executed')
                            <a class="btn btn-info"
                                href="{{ route('Office.Contract.edit', $contract->id) }}">@lang('Edit')</a>
                            @endif
                            @endif
                        </div>
                     
                    </div>

                    <ul class="nav nav-tabs nav-fill" role="tablist">
                        <li class="nav-item">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-justified-home" aria-controls="navs-justified-home"
                                aria-selected="true">
                                <i class="tf-icons ti ti-home ti-xs me-1"></i> @lang('Base Settings')
                                <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1"></span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-justified-profile" aria-controls="navs-justified-profile"
                                aria-selected="false">
                                <i class="tf-icons ti ti-user ti-xs me-1"></i> @lang('Installments')
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-justified-messages" aria-controls="navs-justified-messages"
                                aria-selected="false">
                                <i class="tf-icons ti ti-message-dots ti-xs me-1"></i> مرفقات
                            </button>
                        </li>
                        @if($contract->status == "Executed")
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-justified-payments" aria-controls="navs-justified-payments"
                                aria-selected="false">
                                <i class="tf-icons ti ti-message-dots ti-xs me-1"></i> @lang('Receipts')
                            </button>
                        </li>
                        @endif
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">
                            <div class="row">


                                <div class="col-md-4 mb-3 col-12">
                                    <label class="form-label">@lang('Project') <span class="required-color"></span></label>
                                    <select disabled class="form-select" name="project_id" id="projectSelect">
                                        <option disabled selected value="">@lang('Project')</option>
                                        @foreach ($projects as $project)
                                            <option disabled value="{{ $project->id }}"
                                                {{ $contract->project_id == $project->id ? 'selected' : '' }}>
                                                {{ $project->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3 col-12">
                                    <label class="form-label">@lang('property') <span class="required-color"></span></label>
                                    <select disabled class="form-select" name="property_id" id="propertySelect">
                                        <option disabled selected value="">@lang('property')</option>
                                        @foreach ($properties as $property)
                                            <option disabled value="{{ $property->id }}"
                                                {{ $contract->property_id == $property->id ? 'selected' : '' }}>
                                                {{ $property->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3 col-12">
                                    <label class="form-label">@lang('Unit') <span
                                            class="required-color">*</span></label>
                                    <select disabled class="form-select" name="unit_id" id="unitSelect" required>
                                        <option disabled selected value="">@lang('Unit')</option>
                                        @foreach ($units as $unit)
                                            <option disabled value="{{ $unit->id }}"
                                                {{ $contract->unit_id == $unit->id ? 'selected' : '' }}
                                                data-service-type-id="{{ $unit->service_type_id }}">
                                                {{ $unit->number_unit }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <label class="col-md-6 form-label">@lang('owner name') <span
                                            class="required-color">*</span>
                                    </label>
                                    <div class="input-group">
                                        <select disabled class="form-select" id="OwnersDiv"
                                            aria-label="Example select with button addon" name="owner_id" required>
                                            <option disabled selected value="">@lang('owner name')</option>
                                            @foreach ($owners as $owner)
                                                <option disabled value="{{ $owner->id }}"
                                                    {{ $contract->owner_id == $owner->id ? 'selected' : '' }}>
                                                    {{ $owner->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <label class="col-md-6 form-label">@lang('Employee Name') <span
                                            class="required-color"></span>
                                    </label>
                                    <div class="input-group">
                                        <select disabled class="form-select" aria-label="Example select with button addon"
                                            name="employee_id">
                                            <option disabled selected value="">@lang('Employee Name')</option>
                                            @foreach ($employees as $employee)
                                                <option disabled value="{{ $employee->id }}"
                                                    {{ $contract->employee_id == $employee->id ? 'selected' : '' }}>
                                                    {{ $employee->UserData->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="price" class="form-label">@lang('price') <span
                                            class="required-color">*</span></label>
                                    <div class="input-group">
                                        <input id="price" disabled type="number"
                                            class="form-control @error('price')
                                     is-invalid @enderror"
                                            name="price" value="{{ old('price', $contract->price) }}" required>
                                        <button class="btn btn-outline-primary waves-effect" type="button"
                                            id="button-addon2">@lang('SAR')</button>
                                    </div>
                                </div>

                                <!-- Contract Type -->
                                <div class="col-md-4 mb-3 col-12">
                                    <label class="form-label">@lang('Contract Type') <span
                                            class="required-color">*</span></label>
                                    <select disabled class="form-select" name="type" id="type" required>
                                        <option disabled selected value="">@lang('Contract Type')</option>
                                        @foreach (['rent', 'sale'] as $type)
                                            <option disabled value="{{ $type }}"
                                                {{ $contract->type == $type ? 'selected' : '' }}>
                                                {{ __($type) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3 col-12">
                                    <label class="form-label">@lang('offered service') <span
                                            class="required-color">*</span></label>
                                    <select disabled class="form-select" name="service_type_id" id="serviceTypeSelect"
                                        required>
                                        <option disabled selected value="">@lang('offered service')</option>
                                        @foreach ($servicesTypes as $service)
                                            <option disabled value="{{ $service->id }}"
                                                {{ $contract->service_type_id == $service->id ? 'selected' : '' }}>
                                                {{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" name="service_type_id" id="hiddenServiceTypeId" />
                                <div id="propertyManagementFields" class="row" style="display: none;">

                                    <!-- Commissions Rate -->
                                    <div class="col-md-4 mb-3 col-12">
                                        <label class="form-label">@lang('Commissions Rate') <span
                                                class="required-color"></span></label>
                                        <input disabled type="number" name="commissions_rate" class="form-control"
                                            value="{{ $contract->commissions_rate }}" placeholder="@lang('Commissions Rate')">
                                    </div>

                                    <!-- Collection Type -->
                                    <div class="col-md-4 mb-3 col-12">
                                        <label class="form-label">@lang('Collection Type') <span
                                                class="required-color"></span></label>
                                        <select disabled class="form-select" name="collection_type" id="type">
                                            <option disabled selected value="">@lang('Collection Type')</option>
                                            @foreach (['once', 'divided'] as $type)
                                                <option disabled value="{{ $type }}"
                                                    {{ $contract->collection_type == $type ? 'selected' : '' }}>
                                                    {{ __($type) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Renters -->
                                <div class="col-md-4 mb-3 col-12">
                                    <label class="form-label">@lang('Renter') <span
                                            class="required-color">*</span></label>
                                    <select disabled class="form-select" id="RenterDiv"
                                        aria-label="Example select with button addon" name="renter_id" required>
                                        <option disabled selected value="">@lang('Renter name')</option>
                                        @foreach ($renters as $renter)
                                            <option disabled value="{{ $renter->id }}"
                                                {{ $contract->renter_id == $renter->id ? 'selected' : '' }}>
                                                {{ $renter->UserData->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Calendar Type -->
                                <div class="col-md-4 mb-3 col-12">
                                    <label class="form-label">@lang('Calendar Type') <span
                                            class="required-color">*</span></label>
                                    <select disabled class="form-select" id="calendarTypeSelect"
                                        name="calendarTypeSelect" required>
                                        <option disabled selected value="">@lang('Calendar Type')</option>
                                        <option disabled value="gregorian"
                                            {{ $contract->calendarTypeSelect == 'gregorian' ? 'selected' : '' }}>
                                            @lang('Gregorian')</option>
                                        <option disabled value="hijri"
                                            {{ $contract->calendarTypeSelect == 'hijri' ? 'selected' : '' }}>
                                            @lang('Hijri')
                                        </option>
                                    </select>
                                </div>


                                <!-- Contract Date -->

                                <div class="col-md-4 mb-3 col-12" id="gregorianDate2"
                                    style="{{ $contract->calendarTypeSelect == 'gregorian' ? '' : 'display: none;' }}">
                                    <label class="form-label">@lang('تاريخ ابرام العقد') <span
                                            class="required-color"></span></label>
                                    <input disabled class="form-control" type="date" name="date_concluding_contract"
                                        value="{{ old('date_concluding_contract', $contract->date_concluding_contract ?? '') }}" />
                                </div>
                                <div class="col-md-4 mb-3 col-12" id="gregorianDate"
                                    style="{{ $contract->calendarTypeSelect == 'gregorian' ? '' : 'display: none;' }}">
                                    <label class="form-label">@lang('تاريخ بدأ العقد (ميلادي)') <span
                                            class="required-color"></span></label>
                                    <input disabled class="form-control" type="date" name="gregorian_contract_date"
                                        value="{{ old('start_contract_date', $contract->start_contract_date ?? '') }}" />
                                </div>
                                <div class="col-md-4 mb-3 col-12" id="hijriDate2"
                                    style="{{ $contract->calendarTypeSelect == 'hijri' ? '' : 'display: none;' }}">
                                    <label class="form-label">@lang('تاريخ ابرام العقد') <span
                                            class="required-color"></span></label>
                                    <input disabled class="form-control" type="text" id="txtHijriDate"
                                        name="date_concluding_contract"
                                        value="{{ old('date_concluding_contract', $contract->date_concluding_contract ?? '') }}" />
                                </div>
                                <div class="col-md-4 mb-3 col-12" id="hijriDate"
                                    style="{{ $contract->calendarTypeSelect == 'hijri' ? '' : 'display: none;' }}">
                                    <label class="form-label">@lang('تاريخ بدأ العقد (هجري)') <span
                                            class="required-color"></span></label>
                                    <input disabled class="form-control" id="txtHijriDate2" type="text"
                                        name="hijri_contract_date"
                                        value="{{ old('start_contract_date', $contract->start_contract_date ?? '') }}" />
                                </div>



                                <!-- Duration of the Contract -->
                                <div class="col-md-4 mb-3 col-12">
                                    <label class="form-label">@lang('Duration of the Contract') <span
                                            class="required-color">*</span></label>
                                    <div class="input-group">
                                        <input disabled type="number" class="form-control" name="contract_duration"
                                            value="{{ $contract->contract_duration }}" placeholder="@lang('Duration')"
                                            required>
                                        <select disabled class="form-select" name="duration_unit" required>
                                            <option disabled value="month"
                                                {{ $contract->duration_unit == 'month' ? 'selected' : '' }}>
                                                @lang('month')
                                            </option>
                                            <option disabled value="year"
                                                {{ $contract->duration_unit == 'year' ? 'selected' : '' }}>
                                                @lang('year')
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Payment Cycle -->
                                <div class="col-md-4 mb-3 col-12">
                                    <label class="form-label">@lang('Payment Cycle') <span
                                            class="required-color">*</span></label>
                                    <select disabled class="form-select" name="payment_cycle" required>
                                        <option disabled selected value="">@lang('Payment Cycle')</option>
                                        @foreach (['annual', 'semi-annual', 'quarterly', 'monthly'] as $cycle)
                                            <option disabled value="{{ $cycle }}"
                                                {{ $contract->payment_cycle == $cycle ? 'selected' : '' }}>
                                                {{ __($cycle) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3 col-12">
                                    <label class="form-label">@lang('التجديد التلقائي') <span
                                            class="required-color">*</span></label>
                                    <select disabled class="form-select" name="auto_renew" id="auto_renew" required>
                                        @foreach (['not_renewed', 'renewed'] as $type)
                                            <option disabled value="{{ $type }}"
                                                {{ $contract->auto_renew == $type ? 'selected' : '' }}>

                                                {{ __($type) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Installments Tab -->
                        <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">


                            <!-- Installments table -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">@lang('Installments')</h5>
                                </div>
                                <div class="card-datatable table-responsive">
                                    <div id="DataTables_Table_0_wrapper"
                                        class="dataTables_wrapper dt-bootstrap5 no-footer">
                                        <div class="card-header border-top rounded-0 py-2">
                                            <div class="row">
                                                <div class="col-6">

                                                    <div class="me-5 ms-n2 pe-5">
                                                        <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                                            <label>
                                                                <input id="SearchInput" class="form-control"
                                                                    placeholder="@lang('search...')"
                                                                    aria-controls="DataTables_Table_0"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">

                                                    <div
                                                        class="d-flex justify-content-start justify-content-md-end align-items-baseline">
                                                        <div
                                                            class="dt-action-buttons d-flex flex-column align-items-start align-items-md-center justify-content-sm-center mb-3 mb-md-0 pt-0 gap-4 gap-sm-0 flex-sm-row">
                                                            <div class="dt-buttons btn-group flex-wrap d-flex">
                                                                <div class="btn-group">
                                                                    <button onclick="exportToExcel()"
                                                                        class="btn btn-success buttons-collection  btn-label-secondary me-3 waves-effect waves-light"
                                                                        tabindex="0" aria-controls="DataTables_Table_0"
                                                                        type="button" aria-haspopup="dialog"
                                                                        aria-expanded="false"><span>
                                                                            <i
                                                                                class="ti ti-download me-1 ti-xs"></i>Export</span></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="table-responsive text-nowrap">
                                            <table class="table" id="table">
                                                <thead class="table-dark">
                                                    <tr>

                                                        <th>@lang('Installment Number')</th>
                                                        <th>@lang('price')</th>
                                                        <th>@lang('status')</th>
                                                        <th>@lang('Contract Start Date')</th>
                                                        <th>@lang('Contract End Date')</th>
                                                        {{-- <th>@lang('Action')</th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody class="table-border-bottom-0">
                                                    @forelse ($contract->installments as $index => $installment)
                                                        <tr>

                                                            <td>{{ $installment->Installment_number }}</td>
                                                            <td>{{ $installment->price }}</td>
                                                            <td>{{ __($installment->status) }}</td>
                                                            <td>{{ $installment->start_date }}</td>
                                                            <td>{{ $installment->end_date }}</td>
                                                            {{-- <td>

                                                                <div class="dropdown">
                                                                    <button type="button"
                                                                        class="btn p-0 dropdown-toggle hide-arrow"
                                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <i class="ti ti-dots-vertical"></i>
                                                                    </button>
                                                                    <div class="dropdown-menu" style="">
                                                                        @if (Auth::user()->hasPermission('read-unit'))
                                                                            <a class="dropdown-item"
                                                                                href="{{ route('Broker.Unit.show', $contract->id) }}"
                                                                                class="btn btn-outline-warning btn-sm waves-effect waves-light">@lang('تحصيل')</a>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </td> --}}
                                                        </tr>
                                                    @empty
                                                        <td colspan="6">
                                                            <div class="alert alert-danger d-flex align-items-center"
                                                                role="alert">
                                                                <span class="alert-icon text-danger me-2">
                                                                    <i class="ti ti-ban ti-xs"></i>
                                                                </span>
                                                                @lang('No Data Found!')
                                                            </div>
                                                        </td>
                                                    @endforelse


                                                </tbody>
                                            </table>
                                        </div>


                                    </div>
                                </div>
                            </div>
                            <!-- /Installments table -->

                        </div>

                        <!-- Attachments Tab -->
                        <div class="tab-pane fade" id="navs-justified-messages" role="tabpanel">


                            <div class="col-12 mb-3" id="installmentsTable">
                                <div class="card">
                                    <h5 class="card-header"> @lang('Attachments') </h5>
                                    <div class="table-responsive text-nowrap">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>@lang('#')</th>
                                                    <th>@lang('Name')</th>
                                                    <th>@lang('Attachments')</th>
                                                    <th>@lang('Show')</th>


                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($contract->ContractAttachmentData as $attachment)
                                                    <tr>
                                                        <td></td>
                                                        <td>{{ $attachment->AttachmentData->name }}</td>
                                                        <td>{{ $attachment->attachment }}</td>
                                                        @if ($attachment->attachment)
                                                            <td>

                                                                <a href="{{ $attachment->attachment }}"
                                                                    id="button-addon2" class="btn btn-primary">Download
                                                                    File</a>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @empty
                                                <td colspan="4">
                                                    <div class="alert alert-danger d-flex align-items-center"
                                                        role="alert">
                                                        <span class="alert-icon text-danger me-2">
                                                            <i class="ti ti-ban ti-xs"></i>
                                                        </span>
                                                        @lang('No Data Found!')
                                                    </div>
                                                </td>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="tab-pane fade" id="navs-justified-payments" role="tabpanel">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                                            class="d-none d-sm-inline-block">@lang('إصدار سند')</span></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#basicModal">@lang('إصدار سند قبض')</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('Office.Property.create') }}">@lang('إصدار سند صرف')</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">@lang('Installments')</h5>
                                </div>
                                <div class="card-datatable table-responsive">
                                    <div id="DataTables_Table_0_wrapper"
                                        class="dataTables_wrapper dt-bootstrap5 no-footer">
                                        <div class="card-header border-top rounded-0 py-2">
                                            <div class="row">
                                                <div class="col-6">

                                                    <div class="me-5 ms-n2 pe-5">
                                                        <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                                            <label>
                                                                <input id="SearchInput" class="form-control"
                                                                    placeholder="@lang('search...')"
                                                                    aria-controls="DataTables_Table_0"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">

                                                    <div
                                                        class="d-flex justify-content-start justify-content-md-end align-items-baseline">
                                                        <div
                                                            class="dt-action-buttons d-flex flex-column align-items-start align-items-md-center justify-content-sm-center mb-3 mb-md-0 pt-0 gap-4 gap-sm-0 flex-sm-row">
                                                            <div class="dt-buttons btn-group flex-wrap d-flex">
                                                                <div class="btn-group">
                                                                    <button onclick="exportToExcel()"
                                                                        class="btn btn-success buttons-collection  btn-label-secondary me-3 waves-effect waves-light"
                                                                        tabindex="0" aria-controls="DataTables_Table_0"
                                                                        type="button" aria-haspopup="dialog"
                                                                        aria-expanded="false"><span>
                                                                            <i
                                                                                class="ti ti-download me-1 ti-xs"></i>Export</span></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="table-responsive text-nowrap">
                                            <table class="table" id="table">
                                                <thead class="table-dark">
                                                    <tr>

                                                        <th>@lang('Installment Number')</th>
                                                        <th>@lang('Amount')</th>
                                                        <th>@lang('type')</th>
                                                        <th>@lang('Start Date')</th>
                                                        <th>@lang('End Date')</th>
                                                        <th>@lang('Action')</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-border-bottom-0">
                                                    @forelse ($contract->ReceiptData as $index => $receipt)
                                                        <tr>

                                                            <td>{{ $receipt->voucher_number }}</td>
                                                            <td>{{ $receipt->total_price }}</td>
                                                            <td>{{ __($receipt->type) }}</td>
                                                            <td>{{ $receipt->release_date }}</td>
                                                            <td>{{ $receipt->payment_date }}</td>
                                                            <td>

                                                                <div class="dropdown">
                                                                    <button type="button"
                                                                        class="btn p-0 dropdown-toggle hide-arrow"
                                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <i class="ti ti-dots-vertical"></i>
                                                                    </button>
                                                                    <div class="dropdown-menu" style="">
                                                                        @if (Auth::user()->hasPermission('read-unit'))
                                                                            <a class="dropdown-item receipt-link" href="#" data-bs-toggle="modal"
                                                                            data-bs-target="#receiptModal" data-id="{{ $receipt->id }}">@lang('Show')</a>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <td colspan="6">
                                                            <div class="alert alert-danger d-flex align-items-center"
                                                                role="alert">
                                                                <span class="alert-icon text-danger me-2">
                                                                    <i class="ti ti-ban ti-xs"></i>
                                                                </span>
                                                                @lang('No Data Found!')
                                                            </div>
                                                        </td>
                                                    @endforelse


                                                </tbody>
                                            </table>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="content-backdrop fade"></div>
    </div>
    @include('Office.Contract.ReceiptBills.inc.create_receipt_bill')
    @include('Office.Contract.ReceiptBills.inc.receipt_modal')


    @push('scripts')

    <script>
        //action buttons

        // $('#certifyButton').click(function() {
        //     var contractId = $(this).data('contract-id');
        //     $.ajax({
        //         url: '{{ route('contracts.certify', ['contract' => ':id']) }}'.replace(':id', contractId),
        //         method: 'POST',
        //         data: {
        //             _token: '{{ csrf_token() }}'
        //         },
        //         success: function(response) {
        //             if(response.success) {
        //                 location.reload();
        //             } else {
        //                 alert('Failed to certify contract.');
        //             }
        //         },
        //         error: function() {
        //             alert('An error occurred. Please try again.');
        //         }
        //     });
        // });

        function certifyContract(contractId) {
        $.ajax({
            url: '{{ route('contracts.certify', ['contract' => ':id']) }}'.replace(':id', contractId),
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    toastr.error('Failed to certify contract.');
                }
            },
            error: function() {
                toastr.error('An error occurred. Please try again.');
            }
        });
    }

    function deportContract(contractId) {
        $.ajax({
            url: '{{ route('contracts.deportation', ['contract' => ':id']) }}'.replace(':id', contractId),
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                    // window.location.href = '{{ route('Office.Contract.index') }}';
                } else {
                    toastr.error('Failed to deportation contract.');
                }
            },
            error: function() {
                toastr.error('An error occurred. Please try again.');
            }
        });
    }


    // $(document).ready(function() {
    //     $('#deportationButton').click(function() {
    //         var contractId = $(this).data('contract-id');
    //         $.ajax({
    //             url: '{{ route('contracts.deportation', ['contract' => ':id']) }}'.replace(':id', contractId),
    //             method: 'POST',
    //             data: {
    //                 _token: '{{ csrf_token() }}'
    //             },
    //             success: function(response) {
    //                 if(response.success) {
    //                     window.location.href = '{{ route('Office.Contract.index') }}';
    //                 } else {
    //                     alert('Failed to deportation contract.');
    //                 }
    //             },
    //             error: function() {
    //                 alert('An error occurred. Please try again.');
    //             }
    //         });
    //     });
    // });



    $(document).ready(function() {
        $('#restoreButton').click(function() {
            var contractId = $(this).data('contract-id');
                $.ajax({
                    url: '{{ route('contracts.destroy', ['contract' => ':id']) }}'.replace(':id', contractId),
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if(response.success) {
                            window.location.href = '{{ route('Office.Contract.create') }}';
                        } else {
                            alert('Failed to delete contract.');
                        }
                    },
                    error: function() {
                        alert('An error occurred. Please try again.');
                    }
                });

        });
    });

    function handleDeportation(id) {
        Swal.fire({
            title: "@lang('Are you sure')",
            text: "@lang('You cannot revert this action!')",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: "@lang('Yes, Deport it!')",
            cancelButtonText: "@lang('Cancel')",
            customClass: {
                confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                cancelButton: 'btn btn-label-secondary waves-effect waves-light'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.isConfirmed) {
                // Perform the deportation action via AJAX
                deportContract(id);
            }
        });
    }


    </script>

@endpush
@endsection
