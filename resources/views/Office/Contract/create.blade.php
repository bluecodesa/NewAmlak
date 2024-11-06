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
                            placeholder="{{ __('Automatic Selected') }}">

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
                                <i class="tf-icons ti ti-message-dots ti-xs me-1"></i> @lang('Attachments')
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">
                            <form action="{{ route('Office.Contract.store') }}" method="POST" class="row" enctype="multipart/form-data">
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
                                        <option  selected value="">@lang('Choose')</option>
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->id }}">
                                                {{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3 col-12">
                                    <label class="form-label">@lang('property') <span class="required-color"></span></label>
                                    <select class="form-select" name="property_id" id="propertySelect">
                                        <option  selected value="">@lang('Choose')</option>
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
                                            <option value="{{ $unit->id }}" data-service-type-id="{{ $unit->service_type_id }}">{{ $unit->number_unit }}</option>
                                            @endforeach
                                        </select>
                                        <span class="required-color" id="unitStatus"></span>
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
                                <input type="hidden" name="owner_id" id="hiddenOwnerId" />

                                <div class="col-md-4 mb-3">
                                    <label for="price" class="form-label">@lang('yearly rental price') <span
                                            class="required-color">*</span></label>
                                    <div class="input-group">
                                        <input type="number" name="price" id="unitSalary" class="form-control" placeholder="@lang('yearly rental price')"
                                            aria-label="@lang('yearly rental price')" aria-describedby="button-addon2" required>
                                        <button class="btn btn-outline-primary waves-effect" type="button"
                                            id="button-addon2">@lang('SAR')</button>
                                    </div>
                                </div>

                                <!-- Contract Type -->
                                <div class="col-md-4 mb-3 col-12">
                                    <label class="form-label">@lang('Contract Type') <span
                                            class="required-color">*</span></label>
                                    <select class="form-select" name="type" id="type" required>
                                        {{-- <option disabled selected value="">@lang('Contract Type')</option> --}}
                                        @foreach (['rent'] as $type)
                                            <option value="{{ $type }}">
                                                {{ __($type) }}</option>
                                        @endforeach
                                    </select>
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
                                    <label class="form-label">@lang('Date of concluding the contract') <span class="required-color">*</span></label>
                                    <input class="form-control"  type="date" value="{{ now()->format('Y-m-d H:i') }}" name="date_concluding_contract" />
                                </div>
                                    <div class="col-md-4 mb-3 col-12" id="gregorianDate" style="display: none;">
                                        <label class="form-label">@lang('Contract start date (Gregorian)') <span class="required-color">*</span></label>
                                        <input class="form-control"  type="date" name="gregorian_contract_date" />
                                    </div>
                                    <div class="col-md-4 mb-3 col-12" id="hijriDate2" style="display: none;">
                                        <label class="form-label">@lang('Date of concluding the contract') <span class="required-color">*</span></label>
                                        <input class="form-control"  type="text"  id="txtHijriDate" value="{{ now()->format('Y-m-d H:i') }}" name="date_concluding_contract" placeholder="@lang('Hijri Date')" />
                                    </div>
                                    <div class="col-md-4 mb-3 col-12" id="hijriDate" style="display: none;">
                                        <label class="form-label">@lang('Contract start date (Higri)') <span class="required-color">*</span></label>
                                        <input class="form-control"  id="txtHijriDate2" type="text" name="hijri_contract_date" placeholder="@lang('Hijri Date')" />
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
                                                <!-- Options will be dynamically updated based on selection -->
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

                                           <div class="col-12 col-md-4 mb-3">
                                    <label class="col-md-6 form-label">@lang('Employee Name') <span
                                            class="required-color"></span>
                                    </label>
                                    <div class="input-group">
                                        <select class="form-select"
                                            aria-label="Example select with button addon" name="employee_id">
                                            <option disabled selected value="{{ auth()->user()->UserOfficeData->id }}">@lang('Employee Name')</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}">
                                                    {{ $employee->UserData->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
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
                                <input type="hidden" name="service_type_id" id="hiddenServiceTypeId" />


                                <div id="propertyManagementFields" class="row" style="display: none;">

                                    <!-- Commissions Rate -->
                                    <div class="col-md-4 mb-3 col-12">
                                        <label class="form-label">@lang('Commissions Rate') <span
                                                class="required-color">*</span></label>
                                            <div class="input-group">
                                                <input type="number" name="commissions_rate" step="0.01" class="form-control"
                                                placeholder="@lang('Commissions Rate')">
                                                <button class="btn btn-outline-primary waves-effect" type="button"
                                                    id="button-addon2">@lang('%')</button>
                                            </div>
                                    </div>

                                    <!-- Collection Type -->
                                    <div class="col-md-4 mb-3 col-12">
                                        <label class="form-label">@lang('Collection Type') <span
                                                class="required-color">*</span></label>
                                        <select class="form-select" required name="collection_type" id="type" >
                                            @foreach (['once with frist installment', 'divided with all installments'] as $type)
                                                <option value="{{ $type }}">
                                                    {{ __($type) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>



                                <div style="text-align: left;">
                                    <button type="button" class="btn btn-primary me-1 next-tab" data-next="#navs-justified-profile">
                                        {{ __('Next') }}
                                    </button>
                                </div>

                                </div>
                                <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
                                    <div class="col-md-4 mb-3 col-12">
                                        <button type="button" id="calculateButton" class="btn btn-primary me-1"
                                            role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-profile"
                                            aria-controls="navs-justified-profile">
                                            @lang('Calculate Installments')
                                        </button>
                                    </div>
                                    <div id="contractDetails" style="display: none;">
                                        <!-- Contract details will be dynamically added here -->
                                    </div>
                                    <div style="text-align: left;">
                                        <button type="button" class="btn btn-primary me-1 next-tab" data-next="#navs-justified-messages">
                                            {{ __('Next') }}
                                        </button>
                                    </div>


                                </div>
                                <div class="tab-pane fade" id="navs-justified-messages" role="tabpanel">
                                    <div class="col-12 mb-3">
                                        <label class="form-label">@lang('Attachments')</label>
                                        <div id="features" class="row">
                                            <!-- حقل المرفق الأول -->
                                            <div class="mb-3 col-4">
                                                <input type="text" name="name[]" class="form-control search" placeholder="@lang('Field name')" />
                                            </div>
                                            <div class="mb-3 col-4">
                                                <input class="form-control" type="file" name="attachment[]" accept="image/*,application/pdf" />
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-primary w-100" onclick="addFeatures()">
                                                    <i class="ti ti-plus me-0 me-sm-1 ti-xs"></i>
                                                    <span class="d-none d-sm-inline-block">@lang('Add Attachment')</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="text-align: left;">
                                        <button type="submit" class="btn btn-primary me-1">{{ __('Save') }}</button>
                                    </div>
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
                        populateDropdown('unitSelect', data.units, 'id', 'number_unit');

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
                dropdown.innerHTML = ' <option  selected value="">@lang('Choose')</option>';
                items.forEach(item => {
                    var option = document.createElement('option');
                    option.value = item[valueField];
                    option.textContent = item[textField];
                    dropdown.appendChild(option);
                });
            }


            function fetchAllPropertiesAndUnits() {
            fetch(`/get-all-properties-and-units`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    populateDropdown('propertySelect', data.properties, 'id', 'name');
                    populateDropdown('unitSelect', data.units, 'id', 'number_unit');
                })
                .catch(error => {
                    console.error('Error fetching all properties and units:', error);
                    alert('An error occurred while fetching all properties and units. Please try again.');
                });
        }

        function fetchAllUnits() {
            fetch(`/get-all-units`)
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
                    console.error('Error fetching all units:', error);
                    alert('An error occurred while fetching all units. Please try again.');
                });
        }

            function clearDropdowns() {
            fetchAllPropertiesAndUnits();
        }

        function clearUnitDropdown() {
            fetchAllUnits();
        }


    </script>
    <script>
        function addFeatures() {
            const featuresContainer = document.getElementById('features');
            const newRow = document.createElement('div');
            newRow.classList.add('row', 'mb-3');

            newRow.innerHTML = `
                <div class="mb-3 col-4">
                    <input type="text" name="name[]" class="form-control search" placeholder="@lang('Field name')" />
                </div>
                <div class="mb-3 col-4">
                    <input class="form-control" type="file" name="attachment[]" accept="image/*,application/pdf" />
                </div>
                <div class="col-4">
                    <button type="button" class="btn btn-danger w-100" onclick="removeFeature(this)">
                        @lang('Remove')
                    </button>
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
            // Handle payment cycle options based on selected duration unit
            $('select[name="duration_unit"]').change(function() {
                var durationUnit = $(this).val();
                var paymentCycleSelect = $('select[name="payment_cycle"]');
                paymentCycleSelect.empty(); // Clear existing options

                var options = {
                    'annual': '@lang('annual')',
                    'semi-annual': '@lang('semi-annual')',
                    'quarterly': '@lang('quarterly')',
                    'monthly': '@lang('monthly')'
                };

                var filteredOptions = ['monthly', 'quarterly', 'semi-annual', 'annual'];
                if (durationUnit === 'month') {
                    filteredOptions = ['monthly', 'quarterly'];
                }

                filteredOptions.forEach(function(option) {
                    paymentCycleSelect.append('<option value="' + option + '">' + options[option] + '</option>');
                });
            });

            $('select[name="duration_unit"]').trigger('change');

            // Handle the calculation button click event
            $('#calculateButton').on('click', function() {
                var formData = {
                    price: parseFloat($('input[name="price"]').val()), // Convert price to float
                    contract_type: $('select[name="contract_type"]').val(),
                    contract_duration: parseInt($('input[name="contract_duration"]').val()), // Convert duration to integer
                    duration_unit: $('select[name="duration_unit"]').val(),
                    payment_cycle: $('select[name="payment_cycle"]').val(),
                    service_type_id: parseInt($('select[name="service_type_id"]').val()), // Convert service type to integer
                    commissions_rate: parseFloat($('input[name="commissions_rate"]').val()), // Convert commissions rate to float
                    collection_type: $('select[name="collection_type"]').val(),
                };

                // Calculate monthly rental price from annual price
                var monthlyRate = formData.price / 12;

                // Calculate the number of contracts/installments based on duration
                var numberOfContracts = 1;
                if (formData.duration_unit === 'year') {
                    if (formData.payment_cycle === 'annual') {
                        numberOfContracts = formData.contract_duration;
                    } else if (formData.payment_cycle === 'semi-annual') {
                        numberOfContracts = formData.contract_duration * 2;
                    } else if (formData.payment_cycle === 'quarterly') {
                        numberOfContracts = formData.contract_duration * 4;
                    } else if (formData.payment_cycle === 'monthly') {
                        numberOfContracts = formData.contract_duration * 12;
                    }
                } else if (formData.duration_unit === 'month') {
                    if (formData.payment_cycle === 'monthly') {
                        numberOfContracts = formData.contract_duration;
                    } else if (formData.payment_cycle === 'quarterly') {
                        numberOfContracts = Math.ceil(formData.contract_duration / 3);
                    }
                }

                // Calculate commission per contract
                var commissionPerContract = 0;
                if (formData.service_type_id === 3) {
                    if (formData.collection_type === 'once with frist installment') {
                        commissionPerContract = (formData.commissions_rate / 100) * formData.price;
                    } else if (formData.collection_type === 'divided with all installments') {
                        commissionPerContract = (formData.commissions_rate / 100) * (formData.price / numberOfContracts);
                    }
                }

                // Initialize array to store installment details
                var contracts = [];
                var startDate = new Date();

                // Generate each installment based on payment cycle
                for (var i = 0; i < numberOfContracts; i++) {
                    var pricePerContract = 0;

                    // Calculate price per contract based on the payment cycle
                    if (formData.payment_cycle === 'annual') {
                        pricePerContract = monthlyRate * 12;
                    } else if (formData.payment_cycle === 'semi-annual') {
                        pricePerContract = monthlyRate * 6;
                    } else if (formData.payment_cycle === 'quarterly') {
                        pricePerContract = monthlyRate * 3;
                    } else if (formData.payment_cycle === 'monthly') {
                        pricePerContract = monthlyRate;
                    }

                    // Add commission if applicable
                    var finalPrice = pricePerContract;
                    if (commissionPerContract !== 0) {
                        if (formData.collection_type === 'once with frist installment' && i === 0) {
                            finalPrice += commissionPerContract;
                        } else if (formData.collection_type === 'divided with all installments') {
                            finalPrice += commissionPerContract;
                        }
                    }

                    // Set installment start and end dates based on payment cycle
                    var installmentEndDate = new Date(startDate);
                    if (formData.payment_cycle === 'annual') {
                        installmentEndDate.setFullYear(installmentEndDate.getFullYear() + 1);
                    } else if (formData.payment_cycle === 'semi-annual') {
                        installmentEndDate.setMonth(installmentEndDate.getMonth() + 6);
                    } else if (formData.payment_cycle === 'quarterly') {
                        installmentEndDate.setMonth(installmentEndDate.getMonth() + 3);
                    } else if (formData.payment_cycle === 'monthly') {
                        installmentEndDate.setMonth(installmentEndDate.getMonth() + 1);
                    }

                    // Add installment to contracts array
                    contracts.push({
                        contractNumber: i + 1,
                        startDate: startDate.toLocaleDateString('en-US'),
                        endDate: installmentEndDate.toLocaleDateString('en-US'),
                        price: finalPrice.toFixed(2)
                    });

                    // Set start date for next installment
                    startDate = new Date(installmentEndDate);
                }

                // Display the calculated contracts
                var contractsHTML = '<h4>@lang('Number of Installments'): ' + numberOfContracts + '</h4><div class="row">';
                contracts.forEach(function(contract) {
                    contractsHTML += `
                        <div class="col-md-12">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="form-label">@lang('Installment'):</label>
                                            <input type="text" class="form-control" value="${contract.contractNumber}" disabled>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">@lang('Start Date'):</label>
                                            <input type="text" class="form-control" value="${contract.startDate}" disabled>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">@lang('End Date'):</label>
                                            <input type="text" class="form-control" value="${contract.endDate}" disabled>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">@lang('Price'):</label>
                                            <input type="text" class="form-control" value="${contract.price}" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                });

                contractsHTML += '</div>';
                $('#contractDetails').html(contractsHTML).show();
            });
        });
    </script>


    <script>
        $(document).ready(function() {

        $('#unitSelect').on('change', function() {
            var unitId = $(this).val();
            var serviceTypeId = $('#unitSelect option:selected').data('service-type-id');

            if (serviceTypeId) {
                $('#serviceTypeSelect').val(serviceTypeId);
                $('#serviceTypeSelect').prop('disabled', true);
            } else {
                $('#serviceTypeSelect').val('');
                $('#serviceTypeSelect').prop('disabled', false);
            }

            if (serviceTypeId == 3) {
                $('#propertyManagementFields').show();
            } else {
                $('#propertyManagementFields').hide();
            }

            $('#hiddenServiceTypeId').val(serviceTypeId);

        });

        $('#unitSelect').trigger('change');

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
        $(document).ready(function() {
            $('#unitSelect').on('change', function() {
                var unitId = $(this).val();
                if (unitId) {
                    fetchUnitDetails(unitId);
                } else {
                    resetUnitDetails();
                }
            });

            function fetchUnitDetails(unitId) {
                $.ajax({
                    url: '/get-unit-details/' + unitId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#OwnersDiv').val(data.owner_id);
                        $('#OwnersDiv').prop('disabled', true);
                        var yearlySalary = data.unit_rental_price.yearly;
                        $('#unitSalary').val(yearlySalary);

                        $('#hiddenOwnerId').val(data.owner_id);

                        $('#serviceTypeSelect').val(data.service_type_id);
                        $('#serviceTypeSelect').prop('disabled', true);

                        $('#hiddenServiceTypeId').val(data.service_type_id);
                        if (data.service_type_id == 3) {
                        $('#propertyManagementFields').show();
                    } else {
                        $('#propertyManagementFields').hide();
                    }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching unit details:', error);
                    }
                });
            }

            function resetUnitDetails() {
                $('#OwnersDiv').val('');
                $('#OwnersDiv').prop('disabled', false);

                $('#unitSalary').val('');

                $('#hiddenOwnerId').val('');

                $('#serviceTypeSelect').val('');
                $('#serviceTypeSelect').prop('disabled', false);

                $('#hiddenServiceTypeId').val('');
                $('#propertyManagementFields').hide();

            }

            $('#unitSelect').trigger('change');
        });


    </script>

    <script>
        document.querySelectorAll('.next-tab').forEach(button => {
            button.addEventListener('click', function() {
                const nextTab = this.getAttribute('data-next');
                const nextTabButton = document.querySelector(`[data-bs-target="${nextTab}"]`);
                nextTabButton.click();
            });
        });
    </script>
    <script>
        document.getElementById('unitSelect').addEventListener('change', function() {
            var unitId = this.value;
            var unitStatusSpan = document.getElementById('unitStatus');
            var messages = @json(__('This unit is rented. Start date:'));
            var undefinedMessage = @json(__('null')); // ترجمة "غير محدد"
            if (unitId) {
                fetch(`/units/${unitId}/status`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'rented') {
                            // unitStatusSpan.innerHTML = `${messages} ${data.start_date}`;
                            var startDate = data.start_date ? data.start_date : undefinedMessage;
                            unitStatusSpan.innerHTML = `${messages} ${startDate}`;
                        } else {
                            unitStatusSpan.innerHTML = '';
                        }
                    })
                    .catch(error => console.error('Error fetching unit status:', error));
            } else {
                unitStatusSpan.innerHTML = '';
            }
        });
    </script>

@endpush

@endsection
