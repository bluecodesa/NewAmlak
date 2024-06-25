@extends('Admin.layouts.app')
@section('title', __('Add New Contract'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 ">

                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Office.Contract.index') }}" class="text-muted fw-light">@lang('Contracts')
                        </a> /
                        @lang('Add New Contract')
                    </h4>
                </div>
            </div>

            <div class="col-xl-12">
                <div class="nav-align-top nav-tabs-shadow mb-4">
                    <div class="col-md-3 col-12 mb-3">
                        <label class="form-label">
                            {{ __('Contract Number') }} <span class="required-color"></span></label>
                        <input disabled type="text" required id="modalRoleName" name="number_unit" class="form-control"
                            placeholder="{{ __('يحدد أليا') }}">

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
                            <form action="{{ route('Office.Contract.store') }}" method="POST" class="row"
                                enctype="multipart/form-data">
                                @csrf
                                @method('post')
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
                                            <option value="{{ $project->id }}">
                                                {{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3 col-12">
                                    <label class="form-label">@lang('property') <span class="required-color"></span></label>
                                    <select class="form-select" name="property_id" id="propertySelect">
                                        <option disabled selected value="">@lang('property')</option>
                                        @foreach ($properties as $property)
                                        <option value="{{ $property->id }}">{{ $property->name }}</option>

                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3 col-12">
                                        <label class="form-label">@lang('Unit') <span class="required-color">*</span></label>
                                        <select class="form-select" name="unit_id" id="unitSelect" required>
                                            <option disabled selected value="">@lang('Unit')</option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}">{{ $unit->number_unit }}</option>
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
                                                <option value="{{ $owner->id }}">
                                                    {{ $owner->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <label class="col-md-6 form-label">@lang('Employee Name') <span
                                            class="required-color">*</span>
                                    </label>
                                    <div class="input-group">
                                        <select class="form-select"
                                            aria-label="Example select with button addon" name="employee_id" required>
                                            <option disabled selected value="">@lang('Employee Name')</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}">
                                                    {{ $employee->UserData->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="price" class="form-label">@lang('price') <span
                                            class="required-color">*</span></label>
                                    <div class="input-group">
                                        <input type="number" name="price" class="form-control" placeholder="@lang('price')"
                                            aria-label="@lang('price')" aria-describedby="button-addon2" required>
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
                                            <option value="{{ $type }}">
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
                                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div id="propertyManagementFields" class="row" style="display: none;">

                                    <!-- Commissions Rate -->
                                    <div class="col-md-4 mb-3 col-12">
                                        <label class="form-label">@lang('Commissions Rate') <span
                                                class="required-color"></span></label>
                                        <input type="number" name="commissions_rate" class="form-control"
                                            placeholder="@lang('Commissions Rate')">
                                    </div>

                                    <!-- Collection Type -->
                                    <div class="col-md-4 mb-3 col-12">
                                        <label class="form-label">@lang('Collection Type') <span
                                                class="required-color"></span></label>
                                        <select class="form-select" name="collection_type" id="type" >
                                            <option disabled selected value="">@lang('Collection Type')</option>
                                            @foreach (['once', 'divided'] as $type)
                                                <option value="{{ $type }}">
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
                                            <option value="{{ $renter->id }}">
                                                {{ $renter->UserData->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            
                                <!-- Calendar Type -->
                                <div class="col-md-4 mb-3 col-12">
                                    <label class="form-label">@lang('Calendar Type') <span
                                            class="required-color">*</span></label>
                                    <select class="form-select" id="calendarTypeSelect" name="calendarTypeSelect" required>
                                        <option disabled selected value="">@lang('Calendar Type')</option>
                                        <option value="gregorian">@lang('Gregorian')</option>
                                        <option value="hijri">@lang('Hijri')</option>
                                    </select>
                                </div>

                                <!-- Contract Date -->
                      
                                    <div class="col-md-4 mb-3 col-12" id="gregorianDate2" style="display: none;">
                                        <label class="form-label">@lang('تاريخ ابرام العقد') <span class="required-color"></span></label>
                                        <input class="form-control" type="date" name="date_concluding_contract" />
                                    </div>
                                    <div class="col-md-4 mb-3 col-12" id="gregorianDate" style="display: none;">
                                        <label class="form-label">@lang('تاريخ بدأ العقد (ميلادي)') <span class="required-color"></span></label>
                                        <input class="form-control" type="date" name="gregorian_contract_date" />
                                    </div>
                                    <div class="col-md-4 mb-3 col-12" id="hijriDate2" style="display: none;">
                                        <label class="form-label">@lang('تاريخ ابرام العقد') <span class="required-color"></span></label>
                                        <input class="form-control" type="text" id="txtHijriDate" name="date_concluding_contract" placeholder="@lang('Hijri Date')" />
                                    </div>
                                    <div class="col-md-4 mb-3 col-12" id="hijriDate" style="display: none;">
                                        <label class="form-label">@lang('تاريخ بدأ العقد (هجري)') <span class="required-color"></span></label>
                                        <input class="form-control" id="txtHijriDate" type="text" name="hijri_contract_date" placeholder="@lang('Hijri Date')" />
                                    </div>



                                <!-- Duration of the Contract -->
                                <div class="col-md-4 mb-3 col-12">
                                    <label class="form-label">@lang('Duration of the Contract') <span
                                            class="required-color">*</span></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="contract_duration"
                                            placeholder="@lang('Duration')" required>
                                        <select class="form-select" name="duration_unit" required>
                                            <option value="month">@lang('month')</option>
                                            <option value="year">@lang('year')</option>
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
                                            <option value="{{ $cycle }}">{{ __($cycle) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3 col-12">
                                    <label class="form-label">@lang('التجديد التلقائي') <span
                                            class="required-color">*</span></label>
                                    <select class="form-select" name="auto_renew" id="auto_renew" required>
                                        @foreach (['not_renewed', 'renewed'] as $type)
                                            <option value="{{ $type }}">
                                                {{ __($type) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                             

                        </div>
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

                        </div>
                        <div class="tab-pane fade" id="navs-justified-messages" role="tabpanel">
                            <div class="col-12 mb-3">
                                <label class="form-label">@lang('Attachments')</label>
                                <div id="features" class="row">
                                    <div class="mb-3 col-4">
                                        <input type="text" name="name[]" class="form-control search"
                                            placeholder="@lang('Field name')" value="{{ old('name*') }}" />

                                    </div>
                                    <div class="mb-3 col-4">
                                        <input class="form-control" type="file" name="attachment[]" 
                                            id="projectMasterplan" accept="image/*,application/pdf">
                                    </div>
                                    <div class="col">
                                        <button type="button" class="btn btn-primary w-100"
                                            onclick="addFeature()"><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                                                class="d-none d-sm-inline-block">@lang('Add Attachment')</span></button>
                                    </div>
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
    newRow.classList.add('row', 'mb-3');

    newRow.innerHTML = `
        <div class="mb-3 col-4">
            <input type="text" name="name[]" class="form-control search" placeholder="@lang('Field name')" value="" />
        </div>
        <div class="mb-3 col-4">
            <input type="file" name="attachment[]" class="form-control" placeholder="@lang('value')" />
        </div>
        <div class="col-4">
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
                        contract_date_gregorian: new Date($('input[name="gregorian_contract_date"]')
                            .val()), // Convert to Date object
                        contract_date_hijri: new Date($('input[name="hijri_contract_date"]')
                            .val()), // Convert to Date object
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

                    // Initialize variables for contract details
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
                    var startDate = formData.contract_date_gregorian;
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
                    $('#contractDetails').show();
                });
            });
        </script>
    @endpush

@endsection
