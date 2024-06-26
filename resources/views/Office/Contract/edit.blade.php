@extends('Admin.layouts.app')
@section('title', __('Edit'))
@section('content')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-6">
                <h4>
                    <a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                    <a href="{{ route('Office.Contract.index') }}" class="text-muted fw-light">@lang('Contracts')</a> /
                    @lang('Edit')
                </h4>
            </div>
        </div>

        <div class="col-xl-12">
            <div class="nav-align-top nav-tabs-shadow mb-4">
                <div class="row">
                    <div class="col-md-3 col-12 mb-3">
                        <label class="form-label">
                            {{ __('Contract Number') }} <span class="required-color"></span></label>
                        <input disabled type="text" required id="modalRoleName" name="number_unit" class="form-control"
                               placeholder="{{ $contract->contract_number }}">
                    </div>
                    <div class="col-md-3 col-12 mb-3">
                        <label class="form-label">
                            {{ __('status') }} <span class="required-color"></span></label>
                        @if($contract->status == 'draft')
                            <input disabled type="text" required id="modalRoleName" name="number_unit" class="form-control"
                                   placeholder="{{ __('draft') }}">
                        @elseif ($contract->status == 'Certified')
                            <input disabled type="text" required id="modalRoleName" name="number_unit" class="form-control"
                                   placeholder="{{ __('Certified') }}">
                        @else
                        <input disabled type="text" required id="modalRoleName" name="number_unit" class="form-control"
                        placeholder="{{ __('Relay') }}">
                        @endif
                    </div>
                    <div class="col-md-4 col-12 mb-3">
                        @if($contract->status == 'draft')
                        <button class="btn btn-secondary" id="certifyButton" data-contract-id="{{ $contract->id }}">@lang('Certify')</button>
                        <button class="btn btn-secondary" id="deportationButton" data-contract-id="{{ $contract->id }}">@lang('Deportation')</button>
                        <button class="btn btn-danger" id="restoreButton" data-contract-id="{{ $contract->id }}">@lang('استعادة')</button>
                        @elseif ($contract->status == 'Certified')
                        <button class="btn btn-secondary" id="deportationButton" data-contract-id="{{ $contract->id }}">@lang('Deportation')</button>
                        <button class="btn btn-danger" id="restoreButton" data-contract-id="{{ $contract->id }}">@lang('استعادة')</button>
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
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">
                        <form method="POST" class='row' action="{{ route('Office.Contract.update', $contract->id) }}">
                            @csrf
                            @method('PUT')
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="col-md-4 mb-3 col-12">
                                <label class="form-label">@lang('Project') <span class="required-color"></span></label>
                                <select class="form-select" name="project_id" id="projectSelect">
                                    <option disabled selected value="">@lang('Project')</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}" {{ $contract->project_id == $project->id ? 'selected' : '' }}>
                                            {{ $project->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3 col-12">
                                <label class="form-label">@lang('property') <span class="required-color"></span></label>
                                <select class="form-select" name="property_id" id="propertySelect">
                                    <option disabled selected value="">@lang('property')</option>
                                    @foreach ($properties as $property)
                                        <option value="{{ $property->id }}" {{ $contract->property_id == $property->id ? 'selected' : '' }}>
                                            {{ $property->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3 col-12">
                                <label class="form-label">@lang('Unit') <span class="required-color">*</span></label>
                                <select class="form-select" name="unit_id" id="unitSelect" required>
                                    <option disabled selected value="">@lang('Unit')</option>
                                    @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}" {{ $contract->unit_id == $unit->id ? 'selected' : '' }} data-service-type-id="{{ $unit->service_type_id }}">{{ $unit->number_unit }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="col-md-6 form-label">@lang('owner name') <span
                                        class="required-color">*</span>
                                </label>
                                <div class="input-group">
                                    <select class="form-select" id="OwnersDiv"
                                            aria-label="Example select with button addon" name="owner_id" required>
                                        <option disabled selected value="">@lang('owner name')</option>
                                        @foreach ($owners as $owner)
                                            <option value="{{ $owner->id }}" {{ $contract->owner_id == $owner->id ? 'selected' : '' }}>
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
                                    <select class="form-select"
                                            aria-label="Example select with button addon" name="employee_id">
                                        <option disabled selected value="">@lang('Employee Name')</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}" {{ $contract->employee_id == $employee->id ? 'selected' : '' }}>
                                                {{  $employee->UserData->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="price" class="form-label">@lang('price') <span
                                        class="required-color">*</span></label>
                                <div class="input-group">
                                    <input id="price" type="number" class="form-control @error('price')
                                     is-invalid @enderror" name="price" value="{{ old('price', $contract->price) }}" required>
                                    <button class="btn btn-outline-primary waves-effect" type="button"
                                            id="button-addon2">@lang('SAR')</button>
                                </div>
                            </div>

                            <!-- Contract Type -->
                            <div class="col-md-4 mb-3 col-12">
                                <label class="form-label">@lang('Contract Type') <span
                                        class="required-color">*</span></label>
                                <select class="form-select" name="type" id="type" required>
                                    <option disabled selected value="">@lang('Contract Type')</option>
                                    @foreach (['rent', 'sale'] as $type)
                                    <option  value="{{ $type }}" {{  $contract->type == $type ? 'selected' : '' }}>
                                            {{ __($type) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3 col-12">
                                <label class="form-label">@lang('offered service') <span
                                        class="required-color">*</span></label>
                                <select class="form-select" name="service_type_id" id="serviceTypeSelect" required>
                                    <option disabled selected value="">@lang('offered service')</option>
                                    @foreach ($servicesTypes as $service)
                                    <option value="{{ $service->id }}" {{ $contract->service_type_id == $service->id ? 'selected' : '' }}>
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
                                    <input type="number" name="commissions_rate" class="form-control" value="{{ $contract->commissions_rate }}"
                                        placeholder="@lang('Commissions Rate')">
                                </div>

                                <!-- Collection Type -->
                                <div class="col-md-4 mb-3 col-12">
                                    <label class="form-label">@lang('Collection Type') <span
                                            class="required-color"></span></label>
                                    <select class="form-select" name="collection_type" id="type" >
                                        <option disabled selected value="">@lang('Collection Type')</option>
                                        @foreach (['once', 'divided'] as $type)
                                        <option value="{{ $type }}" {{ $contract->collection_type == $type ? 'selected' : '' }}>
                                            {{ __($type) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Renters -->
                            <div class="col-md-4 mb-3 col-12">
                                <label class="form-label">@lang('Renter') <span
                                        class="required-color">*</span></label>
                                <select class="form-select" id="RenterDiv"
                                    aria-label="Example select with button addon" name="renter_id" required>
                                    <option disabled selected value="">@lang('Renter name')</option>
                                    @foreach ($renters as $renter)
                                    <option value="{{ $renter->id }}" {{ $contract->renter_id == $renter->id ? 'selected' : '' }}>
                                        {{ $renter->UserData->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <!-- Calendar Type -->
                            <div class="col-md-4 mb-3 col-12">
                                <label class="form-label">@lang('Calendar Type') <span class="required-color">*</span></label>
                                <select class="form-select" id="calendarTypeSelect" name="calendarTypeSelect" required>
                                    <option disabled selected value="">@lang('Calendar Type')</option>
                                    <option value="gregorian" {{ $contract->calendarTypeSelect == 'gregorian' ? 'selected' : '' }}>@lang('Gregorian')</option>
                                    <option value="hijri" {{  $contract->calendarTypeSelect == 'hijri' ? 'selected' : '' }}>@lang('Hijri')</option>
                                </select>
                            </div>
                            
       
                            <!-- Contract Date -->
                  
                                <div class="col-md-4 mb-3 col-12" id="gregorianDate2" style="{{ $contract->calendarTypeSelect == 'gregorian' ? '' : 'display: none;' }}">
                                    <label class="form-label">@lang('تاريخ ابرام العقد') <span class="required-color"></span></label>
                                    <input class="form-control" type="date" name="date_concluding_contract" value="{{ old('date_concluding_contract', $contract->date_concluding_contract ?? '') }}" />
                                </div>
                                <div class="col-md-4 mb-3 col-12" id="gregorianDate" style="{{ $contract->calendarTypeSelect == 'gregorian' ? '' : 'display: none;' }}">
                                    <label class="form-label">@lang('تاريخ بدأ العقد (ميلادي)') <span class="required-color"></span></label>
                                    <input class="form-control" type="date" name="gregorian_contract_date" value="{{ old('start_contract_date', $contract->start_contract_date ?? '') }}"/>
                                </div>
                                <div class="col-md-4 mb-3 col-12" id="hijriDate2" style="{{ $contract->calendarTypeSelect == 'hijri' ? '' : 'display: none;' }}">
                                    <label class="form-label">@lang('تاريخ ابرام العقد') <span class="required-color"></span></label>
                                    <input class="form-control" type="text" id="txtHijriDate" name="date_concluding_contract" value="{{ old('date_concluding_contract', $contract->date_concluding_contract ?? '') }}" />
                                </div>
                                <div class="col-md-4 mb-3 col-12" id="hijriDate" style="{{ $contract->calendarTypeSelect == 'hijri' ? '' : 'display: none;' }}">
                                    <label class="form-label">@lang('تاريخ بدأ العقد (هجري)') <span class="required-color"></span></label>
                                    <input class="form-control" id="txtHijriDate2" type="text" name="hijri_contract_date" value="{{ old('start_contract_date', $contract->start_contract_date ?? '') }}" />
                                </div>



                            <!-- Duration of the Contract -->
                            <div class="col-md-4 mb-3 col-12">
                                <label class="form-label">@lang('Duration of the Contract') <span
                                        class="required-color">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="contract_duration" value="{{ $contract->contract_duration }}"
                                        placeholder="@lang('Duration')" required>
                                    <select class="form-select" name="duration_unit" required>
                                        <option value="month" {{ $contract->duration_unit == 'month' ? 'selected' : '' }}>@lang('month')</option>
                                        <option value="year" {{  $contract->duration_unit == 'year' ? 'selected' : '' }}>@lang('year')</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Payment Cycle -->
                            <div class="col-md-4 mb-3 col-12">
                                <label class="form-label">@lang('Payment Cycle') <span
                                        class="required-color">*</span></label>
                                <select class="form-select" name="payment_cycle" required>
                                    <option disabled selected value="">@lang('Payment Cycle')</option>
                                    @foreach (['annual', 'semi-annual', 'quarterly', 'monthly'] as $cycle)
                                    <option value="{{ $cycle }}" {{ $contract->payment_cycle == $cycle ? 'selected' : '' }}>
                                        {{ __($cycle) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3 col-12">
                                <label class="form-label">@lang('التجديد التلقائي') <span
                                        class="required-color">*</span></label>
                                <select class="form-select" name="auto_renew" id="auto_renew" required>
                                    @foreach (['not_renewed', 'renewed'] as $type)
                                    <option value="{{ $type }}" {{ $contract->auto_renew == $type ? 'selected' : '' }}>

                                            {{ __($type) }}</option>
                                    @endforeach
                                </select>
                            </div>
                         
                    </div>

                    <!-- Installments Tab -->
                    <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
                        <div class="col-md-4 mb-3 col-12">
                            <button type="button" id="calculateButton" class="btn btn-primary me-1"
                                role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-profile"
                                aria-controls="navs-justified-profile">
                                @lang('Calculate')
                            </button>
                        </div>
                        <div id="contractDetails" style="display: none;">
                            <!-- Contract details will be dynamically added here -->
                        </div>
                        <div class="col-12 mb-3" id="installmentsTable">
                            <div class="card">
                                <h5 class="card-header"> @lang('Installments') </h5>
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>@lang('Installment Number')</th>
                                                <th>@lang('Amount')</th>
                                                <th>@lang('status')</th>
                                                <th>@lang('Start Date')</th>
                                                <th>@lang('End Date')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($contract->installments as $installment)
                                                <tr>
                                                    <td>{{ $installment->id }}</td>
                                                    <td>{{ $installment->price }}</td>
                                                    <td>{{ __($installment->status) }}</td>
                                                    <td>{{ $installment->start_date }}</td>
                                                    <td>{{ $installment->end_date }}</td>
                                                   
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attachments Tab -->
                    <div class="tab-pane fade" id="navs-justified-messages" role="tabpanel">
                     
                        <div class="col-12 mb-3">
                            <label class="form-label">@lang('Additional details')</label>
                            <button type="button" class="btn btn-outline-primary btn-sm"
                                onclick="addFeature()">@lang('Add details')</button>
                            @foreach ($contract->ContractAttachmentData  as $attachment)
                                <div class="row p-1">
                                    <div class="col">
                                        <input type="text" name="name[]" class="form-control search"
                                            placeholder="@lang('Field name')"
                                            value="{{ $attachment->AttachmentData->name }}" />
                                    </div>
                                    <div class="col">
                                        <input type="file" name="attachment[]" class="form-control" accept="image/*,application/pdf" />
                                        @if($attachment->attachment)
                                        <a href="{{ Storage::url($attachment->attachment) }}" target="_blank" class="btn btn-primary">Download File</a>
                                    
                                    @endif
                                    </div>
                           
                                    <div class="col">
                                        <button type="button"
                                            class="btn btn-outline-danger w-100 remove-feature">@lang('Remove')</button>
                                    </div>
                                </div>
                            @endforeach

                            <div id="features" class="row p-2">

                            </div>
                        </div>
                    </div>
              
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary me-1">

                                {{ __('save') }}
                            </button>

                        </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>

        <div class="content-backdrop fade"></div>
    </div>



    @push('scripts')

    <script>
        document.getElementById('projectSelect').addEventListener('change', function() {
            var projectId = this.value;
            if (projectId) {
                fetchPropertiesAndUnits(projectId);
            } else {
                clearDropdowns();
            }
        });

        document.getElementById('propertySelect').addEventListener('change', function() {
            var propertyId = this.value;
            if (propertyId) {
                fetchUnitsByProperty(propertyId);
            } else {
                clearUnitDropdown();
            }
        });

        function fetchPropertiesAndUnits(projectId) {
            fetch(`/get-project-details/${projectId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    populateDropdown('propertySelect', data.properties, 'id', 'name');
                    clearUnitDropdown(); // Clear units dropdown when properties change
                })
                .catch(error => {
                    console.error('Error fetching project details:', error);
                    alert('An error occurred while fetching project details. Please try again.');
                });
        }

        function fetchUnitsByProperty(propertyId) {
            fetch(`/get-units-by-property/${propertyId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    populateDropdown('unitSelect', data.units, 'id', 'number_unit');
                })
                .catch(error => {
                    console.error('Error fetching units:', error);
                    alert('An error occurred while fetching units. Please try again.');
                });
        }

        function populateDropdown(dropdownId, items, valueField, textField) {
            var dropdown = document.getElementById(dropdownId);
            dropdown.innerHTML = '<option disabled selected value="">@lang('Choose')</option>';
            items.forEach(item => {
                var option = document.createElement('option');
                option.value = item[valueField];
                option.textContent = item[textField];
                dropdown.appendChild(option);
            });
        }

        function clearDropdowns() {
            document.getElementById('propertySelect').innerHTML = '<option disabled selected value="">@lang('Property')</option>';
            clearUnitDropdown();
        }

        function clearUnitDropdown() {
            document.getElementById('unitSelect').innerHTML = '<option disabled selected value="">@lang('Unit')</option>';
        }


        function addFeature() {
            const featuresContainer = document.getElementById('features');
            const newRow = document.createElement('div');
            newRow.classList.add('row', 'mb-3'); // Add any additional classes that your grid system requires

            // Use the exact same class names and structure as your existing rows
            newRow.innerHTML = `
<div class="col">
<input type="text" required name="name[]" class="form-control search" placeholder="@lang('Field name')" value="" />
</div>
<div class="col">
<input type="file" required name="attachment[]" class="form-control" placeholder="@lang('value')" value="" />
</div>
<div class="col mr-2">
<button type="button" class="btn btn-danger w-100" onclick="removeFeature(this)">@lang('Remove')</button>
</div>
`;

            featuresContainer.appendChild(newRow);
        }

        function removeFeature(button) {
            const rowToRemove = button.parentNode.parentNode;
            rowToRemove.remove();
        }



    </script>

        <script>
            $('#txtHijriDate').calendarsPicker({
                calendar: $.calendars.instance('islamic', 'Ar'),
                // monthsToShow: [1, 2],
                // showOtherMonths: true,
                // onSelect: function(date) {
                //     alert('You picked ' + date[0].formatDate());
                // }
            });
            $('#txtHijriDate2').calendarsPicker({
                calendar: $.calendars.instance('islamic', 'Ar'),
                // monthsToShow: [1, 2],
                // showOtherMonths: true,
                // onSelect: function(date) {
                //     alert('You picked ' + date[0].formatDate());
                // }
            });

            function updateFullPhone(input) {
                input.value = input.value.replace(/[^0-9]/g, '').slice(0, 9);
                var key_phone = $('#key_phone').val();
                var fullPhone = key_phone + input.value;
                document.getElementById('full_phone').value = fullPhone;
            }
            $(document).ready(function() {
                $('.dropdown-item').on('click', function() {
                    var key = $(this).data('key');
                    var phone = $('#phone').val();
                    $('#key_phone').val(key);
                    $('#full_phone').val(key + phone);
                    $(this).closest('.input-group').find('.btn.dropdown-toggle').text(key);
                });
            });

            $('#Region_id').on('change', function() {
                var selectedOption = $(this).find(':selected');
                var url = selectedOption.data('url');
                $.ajax({
                    type: "get",
                    url: url,
                    beforeSend: function() {
                        $('#CityDiv').fadeOut('fast');
                    },
                    success: function(data) {
                        $('#CityDiv').fadeOut('fast', function() {
                            $(this).empty().append(data);
                            $(this).fadeIn('fast');
                        });
                    },
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                $('#serviceTypeSelect').on('change', function() {
                    var selectedValue = $(this).val();
                    if (selectedValue == 3) {
                        $('#propertyManagementFields').show();
                    } else {
                        $('#propertyManagementFields').hide();
                    }
                });

                $('#calendarTypeSelect').on('change', function() {
                    var selectedValue = $(this).val();
                    if (selectedValue === 'gregorian') {
                        $('#gregorianDate').show();
                        $('#gregorianDate2').show();
                        $('#hijriDate').hide();
                        $('#hijriDate2').hide();
                    } else if (selectedValue === 'hijri') {
                        $('#gregorianDate').hide();
                        $('#gregorianDate2').hide();
                        $('#hijriDate').show();
                        $('#hijriDate2').show();
                    } else {
                        $('#gregorianDate').hide();
                        $('#gregorianDate2').hide();
                        $('#hijriDate').hide();
                        $('#hijriDate2').hide();
                    }
                });

            });
        </script>

        <script>
            $(document).ready(function() {
                // Event listener for the Calculate button
                $('#calculateButton').on('click', function() {
                    // Gather all relevant data from the form
                    var formData = {
                        price: parseFloat($('input[name="price"]').val()), // Convert price to float
                        contract_type: $('select[name="contract_type"]').val(),
                        contract_date_gregorian: null,
                        contract_date_hijri: null,
                        contract_duration: parseInt($('input[name="contract_duration"]')
                            .val()), // Convert duration to integer
                        duration_unit: $('select[name="duration_unit"]').val(),
                        payment_cycle: $('select[name="payment_cycle"]').val(),
                        service_type_id: parseInt($('select[name="service_type_id"]')
                            .val()), // Convert service type to integer
                        commissions_rate: parseFloat($('input[name="commissions_rate"]')
                            .val()), // Convert commissions rate to float
                        collection_type: $('select[name="collection_type"]').val(),
                    };

                    if ($('#calendarTypeSelect').val() === 'gregorian') {
                        formData.contract_date_gregorian = new Date($('input[name="gregorian_contract_date"]').val());
                        // Set contract_date_hijri to null when using Gregorian calendar
                        formData.contract_date_hijri = null;
                        var startDate = formData.contract_date_gregorian;

                    } else if ($('#calendarTypeSelect').val() === 'hijri') {
                        formData.contract_date_hijri = new Date($('input[name="hijri_contract_date"]').val());
                        formData.contract_date_gregorian = null;
                        var startDate = formData.contract_date_hijri;


                    }

                    var numberOfContracts = 1; // Default to 1 contract
                    var contracts = [];

                    // Calculate number of sub-contracts based on duration and payment cycle
                    if (formData.duration_unit === 'year' && formData.payment_cycle === 'annual') {
                        numberOfContracts = formData.contract_duration; // One contract per year
                    } else if (formData.duration_unit === 'month' && formData.payment_cycle === 'monthly') {
                        numberOfContracts = formData.contract_duration; // One contract per month
                    } else if (formData.duration_unit === 'year' && formData.payment_cycle === 'monthly') {
                        numberOfContracts = formData.contract_duration * 12; // Convert years to months
                    }

                    // Calculate start and end dates for each contract
                    var endDate = new Date(startDate);

                    // Calculate commissions based on service type and collection type
                    var commissionPerContract = 0;
                    if (formData.service_type_id ==
                        3) { // Assuming serviceTypeSelect = 3 means additional fields are relevant
                        if (formData.collection_type == 'once') {
                            // Calculate commission once-off
                            commissionPerContract = (formData.commissions_rate / 100) * formData
                                .price; // Commission for the first contract
                        } else if (formData.collection_type == 'divided') {
                            // Calculate commission divided
                            commissionPerContract = (formData.commissions_rate / 100) * (formData.price /
                                numberOfContracts); // Equal commission for each contract
                        }
                    }


                    // Loop to calculate contracts
                    for (var i = 0; i < numberOfContracts; i++) {
                        // Calculate end date based on contract duration unit (month or year)
                        if (formData.duration_unit === 'month') {
                            endDate.setMonth(startDate.getMonth() + 1); // End date is one month from start date
                        } else if (formData.duration_unit === 'year') {
                            endDate.setFullYear(startDate.getFullYear() +
                                1); // End date is one year from start date
                        }

                        // Calculate price for each contract
                        var pricePerContract = formData.price / numberOfContracts;

                        // Adjust price for commission if applicable
                        var finalPrice = pricePerContract;
                        if (commissionPerContract !== 0) {
                            if (formData.collection_type === 'once') {
                                // Add commission only for the first installment
                                if (i === 0) {
                                    finalPrice += commissionPerContract;
                                }
                            } else if (formData.collection_type === 'divided') {
                                // Add equal commission for each installment
                                finalPrice += commissionPerContract;
                            }
                        }

                        // Prepare contract object with details
                        var contract = {
                            contractNumber: i + 1,
                            startDate: startDate.toLocaleDateString('en-US'),
                            endDate: endDate.toLocaleDateString('en-US'),
                            price: finalPrice.toFixed(2), // Display price with two decimal places
                        };

                        // Add contract object to contracts array
                        contracts.push(contract);

                        // Update startDate for next contract (increment by 1 month or 1 year)
                        if (formData.duration_unit === 'month') {
                            startDate.setMonth(startDate.getMonth() + 1);
                        } else if (formData.duration_unit === 'year') {
                            startDate.setFullYear(startDate.getFullYear() + 1);
                        }
                    }

                    // Create HTML for displaying contract details
                    var contractsHTML = '<h4>@lang('Number of Installments'): ' + numberOfContracts + '</h4>';
                    contractsHTML += '<div class="row">';

                    contracts.forEach(function(contract) {
                        contractsHTML += '<div class="col-md-12">';
                        contractsHTML += '<div class="card mb-3">';
                        contractsHTML += '<div class="card-body">';

                        contractsHTML += '<h5 class="card-title">@lang('Installment') ' + contract
                            .contractNumber + '</h5>';

                        contractsHTML += '<div class="row">';
                        contractsHTML += '<div class="col-md-4">';
                        contractsHTML += '<label class="form-label">@lang('Start Date'):</label>';
                        contractsHTML += '<input type="text" class="form-control" value="' + contract
                            .startDate + '" disabled>';
                        contractsHTML += '</div>';
                        contractsHTML += '<div class="col-md-4">';
                        contractsHTML += '<label class="form-label">@lang('End Date'):</label>';
                        contractsHTML += '<input type="text" class="form-control" value="' + contract
                            .endDate + '" disabled>';
                        contractsHTML += '</div>';

                        contractsHTML += '<div class="col-md-4">';
                        contractsHTML += '<label class="form-label">@lang('Price'):</label>';
                        contractsHTML += '<input type="text" class="form-control" value="' + contract
                            .price + '" disabled>';
                        contractsHTML += '</div>';
                        contractsHTML += '</div>';

                        // contractsHTML += '<div class="row">';
                        // contractsHTML += '<div class="col-md-4">';
                        // contractsHTML += '<label class="form-label">@lang('Price'):</label>';
                        // contractsHTML += '<input type="text" class="form-control" value="' + contract.price + '" disabled>';
                        // contractsHTML += '</div>';
                        // contractsHTML += '</div>';

                        contractsHTML += '</div>'; // end card-body
                        contractsHTML += '</div>'; // end card
                        contractsHTML += '</div>'; // end col-md-6
                    });

                    contractsHTML += '</div>'; // end row

                    // Display contract details on the page
                    $('#contractDetails').html(contractsHTML);


                    // Optionally, you can hide or show this section based on your needs
                    $('#contractDetails').html(contractsHTML).show();
                    $('#installmentsTable').hide();
                });
            });
        </script>


<script>
   $(document).ready(function() {

// Function to handle unit selection
$('#unitSelect').on('change', function() {
    var unitId = $(this).val();
    var serviceTypeId = $('#unitSelect option:selected').data('service-type-id');
    
    // Set service type and disable select
    if (serviceTypeId) {
        $('#serviceTypeSelect').val(serviceTypeId);
        $('#serviceTypeSelect').prop('disabled', true); // Disable the select field
    } else {
        $('#serviceTypeSelect').val('');
        $('#serviceTypeSelect').prop('disabled', false); // Enable the select field
    }

    // Show property management fields if service type is 3
    if (serviceTypeId == 3) {
        $('#propertyManagementFields').show();
    } else {
        $('#propertyManagementFields').hide();
    }

    // Optionally, update hidden input for service_type_id
    $('#hiddenServiceTypeId').val(serviceTypeId); // Update hidden input value

});

// Trigger change event on page load
$('#unitSelect').trigger('change');

// Function to handle service type change
$('#serviceTypeSelect').on('change', function() {
    var selectedValue = $(this).val();
    if (selectedValue == 3) {
        $('#propertyManagementFields').show();
    } else {
        $('#propertyManagementFields').hide();
    }
});

});

    </script>

    <script>
        //action buttons 

    $(document).ready(function() {
        $('#certifyButton').click(function() {
            var contractId = $(this).data('contract-id');
            $.ajax({
                url: '{{ route('contracts.certify', ['contract' => ':id']) }}'.replace(':id', contractId),
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if(response.success) {
                        location.reload();
                    } else {
                        alert('Failed to certify contract.');
                    }
                },
                error: function() {
                    alert('An error occurred. Please try again.');
                }
            });
        });
    });


    $(document).ready(function() {
        $('#deportationButton').click(function() {
            var contractId = $(this).data('contract-id');
            $.ajax({
                url: '{{ route('contracts.deportation', ['contract' => ':id']) }}'.replace(':id', contractId),
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if(response.success) {
                        window.location.href = '{{ route('Office.Contract.index') }}';
                    } else {
                        alert('Failed to deportation contract.');
                    }
                },
                error: function() {
                    alert('An error occurred. Please try again.');
                }
            });
        });
    });



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

    </script>

    @endpush

@endsection
