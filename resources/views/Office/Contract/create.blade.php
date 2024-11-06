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
                                            <div class="mb-3 col-4">
                                                <input type="text" name="name[]" class="form-control search" placeholder="@lang('Field name')" />
                                            </div>
                                            <div class="mb-3 col-4">
                                                <input class="form-control" type="file" name="attachment[]" accept="image/*,application/pdf" />
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-primary w-100" onclick="addFeature()">
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
        function addFeature() {
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
                contract_date_gregorian: null,
                contract_date_hijri: null,
                contract_duration: parseInt($('input[name="contract_duration"]').val()), // Convert duration to integer
                duration_unit: $('select[name="duration_unit"]').val(),
                payment_cycle: $('select[name="payment_cycle"]').val(),
                service_type_id: parseInt($('select[name="service_type_id"]').val()), // Convert service type to integer
                commissions_rate: parseFloat($('input[name="commissions_rate"]').val()), // Convert commissions rate to float
                collection_type: $('select[name="collection_type"]').val(),
            };

            // Handle Gregorian or Hijri date
            var startDate;
            if ($('#calendarTypeSelect').val() === 'gregorian') {
                formData.contract_date_gregorian = new Date($('input[name="gregorian_contract_date"]').val());
                startDate = formData.contract_date_gregorian;
            } else if ($('#calendarTypeSelect').val() === 'hijri') {
                formData.contract_date_hijri = new Date($('input[name="hijri_contract_date"]').val());
                startDate = formData.contract_date_hijri;
            }

            // Calculate the number of contracts/installments
            var numberOfContracts = 1;

            // Handle yearly duration
            if (formData.duration_unit === 'year') {
                if (formData.payment_cycle === 'annual') {
                    numberOfContracts = formData.contract_duration; // One contract per year
                } else if (formData.payment_cycle === 'semi-annual') {
                    numberOfContracts = formData.contract_duration * 2; // Two contracts per year (semi-annual)
                } else if (formData.payment_cycle === 'quarterly') {
                    numberOfContracts = formData.contract_duration * 4; // Four contracts per year (quarterly)
                } else if (formData.payment_cycle === 'monthly') {
                    numberOfContracts = formData.contract_duration * 12; // Twelve contracts per year (monthly)
                }
            }
            // Handle monthly duration
            else if (formData.duration_unit === 'month') {
                if (formData.payment_cycle === 'monthly') {
                    numberOfContracts = formData.contract_duration; // One contract per month
                } else if (formData.payment_cycle === 'quarterly') {
                    numberOfContracts = Math.ceil(formData.contract_duration / 3); // One contract every 3 months (quarterly)
                }
            }

            // Calculate commission per contract
            var commissionPerContract = 0;
            if (formData.service_type_id == 3) {
                if (formData.collection_type == 'once with frist installment') {
                    commissionPerContract = (formData.commissions_rate / 100) * formData.price;
                } else if (formData.collection_type == 'divided with all installments') {
                    commissionPerContract = (formData.commissions_rate / 100) * (formData.price / numberOfContracts);
                }
            }
            // var priceOfmanth
            // priceOfmanth * numofmonth  // 18 //12 //13   == total price     /  
            var contracts = [];
            for (var i = 0; i < numberOfContracts; i++) {
                var pricePerContract = formData.price / numberOfContracts;
                var finalPrice = pricePerContract;
                var installmentStartDate = new Date(startDate);
                var installmentEndDate = new Date(startDate);

                // Adjust the end date based on the payment cycle and duration unit
                if (formData.payment_cycle === 'annual') {
                    installmentEndDate.setFullYear(installmentEndDate.getFullYear() + 1);
                } else if (formData.payment_cycle === 'semi-annual') {
                    installmentEndDate.setMonth(installmentEndDate.getMonth() + 6);
                } else if (formData.payment_cycle === 'quarterly') {
                    installmentEndDate.setMonth(installmentEndDate.getMonth() + 3);
                } else if (formData.payment_cycle === 'monthly') {
                    installmentEndDate.setMonth(installmentEndDate.getMonth() + 1);
                }

                if (commissionPerContract !== 0) {
                    if (formData.collection_type === 'once with frist installment' && i === 0) {
                        finalPrice += commissionPerContract;

                    } else if (formData.collection_type === 'divided with all installments') {
                        finalPrice += commissionPerContract;
                    }
                }

                var contract = {
                    contractNumber: i + 1,
                    startDate: installmentStartDate.toLocaleDateString('en-US'),
                    endDate: installmentEndDate.toLocaleDateString('en-US'),
                    price: finalPrice.toFixed(2),
                };

                contracts.push(contract);

                // Update the start date for the next iteration
                startDate = new Date(installmentEndDate);
            }

            // Display the calculated contracts
            var contractsHTML = '<h4>@lang('Number of Installments'): ' + numberOfContracts + '</h4>';
            contractsHTML += '<div class="row">';

            contracts.forEach(function(contract) {
                contractsHTML += '<div class="col-md-12">';
                contractsHTML += '<div class="card mb-3">';
                contractsHTML += '<div class="card-body">';

                contractsHTML += '<div class="row">';
                contractsHTML += '<div class="col-md-2">';
                contractsHTML += '<label class="form-label">@lang('Installment'):</label>';
                contractsHTML += '<input type="text" class="form-control" value="' + contract.contractNumber + '" disabled>';
                contractsHTML += '</div>';
                contractsHTML += '<div class="col-md-3">';
                contractsHTML += '<label class="form-label">@lang('Start Date'):</label>';
                contractsHTML += '<input type="text" required class="form-control" value="' + contract.startDate + '" disabled>';
                contractsHTML += '</div>';
                contractsHTML += '<div class="col-md-3">';
                contractsHTML += '<label class="form-label">@lang('End Date'):</label>';
                contractsHTML += '<input type="text" required class="form-control" value="' + contract.endDate + '" disabled>';
                contractsHTML += '</div>';
                contractsHTML += '<div class="col-md-3">';
                contractsHTML += '<label class="form-label">@lang('Price'):</label>';
                contractsHTML += '<input type="text" required class="form-control" value="' + contract.price + '" disabled>';
                contractsHTML += '</div>';
                contractsHTML += '</div>';

                contractsHTML += '</div>'; // end card-body
                contractsHTML += '</div>'; // end card
                contractsHTML += '</div>'; // end col-md-12
            });

            contractsHTML += '</div>'; // end row

            // Display contract details on the page
            $('#contractDetails').html(contractsHTML);
            $('#contractDetails').show();
        });
    });
</script>


{{-- <script>
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
                contract_date_gregorian: null,
                contract_date_hijri: null,
                contract_duration: parseInt($('input[name="contract_duration"]').val()), // Convert duration to integer
                duration_unit: $('select[name="duration_unit"]').val(),
                payment_cycle: $('select[name="payment_cycle"]').val(),
                service_type_id: parseInt($('select[name="service_type_id"]').val()), // Convert service type to integer
                commissions_rate: parseFloat($('input[name="commissions_rate"]').val()), // Convert commissions rate to float
                collection_type: $('select[name="collection_type"]').val(),
            };


              // Handle Gregorian or Hijri date
              var startDate;
            if ($('#calendarTypeSelect').val() === 'gregorian') {
                formData.contract_date_gregorian = new Date($('input[name="gregorian_contract_date"]').val());
                startDate = formData.contract_date_gregorian;
            } else if ($('#calendarTypeSelect').val() === 'hijri') {
                formData.contract_date_hijri = new Date($('input[name="hijri_contract_date"]').val());
                startDate = formData.contract_date_hijri;
            }

            // Calculate the number of contracts/installments
            var numberOfContracts = 1;

            // Handle yearly duration
            if (formData.duration_unit === 'year') {
                if (formData.payment_cycle === 'annual') {
                    numberOfContracts = formData.contract_duration; // One contract per year
                } else if (formData.payment_cycle === 'semi-annual') {
                    numberOfContracts = formData.contract_duration * 2; // Two contracts per year (semi-annual)
                } else if (formData.payment_cycle === 'quarterly') {
                    numberOfContracts = formData.contract_duration * 4; // Four contracts per year (quarterly)
                } else if (formData.payment_cycle === 'monthly') {
                    numberOfContracts = formData.contract_duration * 12; // Twelve contracts per year (monthly)
                }
            }
            // Handle monthly duration
            else if (formData.duration_unit === 'month') {
                if (formData.payment_cycle === 'monthly') {
                    numberOfContracts = formData.contract_duration; // One contract per month
                } else if (formData.payment_cycle === 'quarterly') {
                    numberOfContracts = Math.ceil(formData.contract_duration / 3); // One contract every 3 months (quarterly)
                }
            }

            // حساب قيمة القسط الأساسي بدون عمولة
            var installmentBaseAmount = formData.price / formData.contract_duration;

            // حساب إجمالي العمولة (2% مثلاً من السعر الكلي)
            var totalCommission = (formData.commissions_rate / 100) * formData.price;
            var commissionPerInstallment = 0;

            // حساب العمولة حسب نوع التجميع
            if (formData.collection_type === 'once with frist installment') {
                // إذا كان جمع العمولة في أول قسط فقط
                commissionPerInstallment = totalCommission;
            } else if (formData.collection_type === 'divided with all installments') {
                // إذا كان توزيع العمولة على جميع الأقساط
                commissionPerInstallment = totalCommission / formData.contract_duration;
            }

            // حساب تفاصيل الأقساط
            var installments = [];
        // حساب تواريخ الأقساط
            for (var i = 0; i < formData.contract_duration; i++) {
                var finalAmount = installmentBaseAmount;
                var installmentStartDate = new Date(startDate);
                var installmentEndDate = new Date(startDate);

                // Adjust the end date based on the payment cycle and duration unit
                if (formData.payment_cycle === 'annual') {
                    installmentEndDate.setFullYear(installmentEndDate.getFullYear() + 1);
                } else if (formData.payment_cycle === 'semi-annual') {
                    installmentEndDate.setMonth(installmentEndDate.getMonth() + 6);
                } else if (formData.payment_cycle === 'quarterly') {
                    installmentEndDate.setMonth(installmentEndDate.getMonth() + 3);
                } else if (formData.payment_cycle === 'monthly') {
                    installmentEndDate.setMonth(installmentEndDate.getMonth() + 1);
                }

                // إضافة العمولة إلى أول قسط فقط
                if (formData.collection_type === 'once with frist installment' && i === 0) {
                    finalAmount += commissionPerInstallment;
                } else if (formData.collection_type === 'divided with all installments') {
                    finalAmount += commissionPerInstallment;
                }

                var installment = {
                    installmentNumber: i + 1,
                    startDate: installmentStartDate.toLocaleDateString('en-US'),
                    endDate: installmentEndDate.toLocaleDateString('en-US'),
                    amount: finalAmount.toFixed(2),
                };

                installments.push(installment);

                // تحديث startDate للتالي ليكون هو endDate من الأقساط السابقة
                startDate = new Date(installmentEndDate);
            }


            // عرض تفاصيل الأقساط على الصفحة
            var installmentsHTML = '<h4>@lang('Number of Installments'): ' + formData.contract_duration + '</h4>';
            installmentsHTML += '<div class="row">';

            installments.forEach(function(installment) {
                installmentsHTML  += '<div class="col-md-12">';
                installmentsHTML  += '<div class="card mb-3">';
                installmentsHTML  += '<div class="card-body">';

                installmentsHTML += '<div class="row">';
                installmentsHTML += '<div class="col-md-2">';
                installmentsHTML += '<label class="form-label">@lang('Installment'):</label>';
                installmentsHTML += '<input type="text" class="form-control" value="' + installment.installmentNumber + '" disabled>';
                installmentsHTML += '</div>';
                installmentsHTML += '<div class="col-md-3">';
                installmentsHTML += '<label class="form-label">@lang('Start Date'):</label>';
                installmentsHTML += '<input type="text" required class="form-control" value="' + installment.startDate + '" disabled>';
                installmentsHTML += '</div>';
                installmentsHTML += '<div class="col-md-3">';
                installmentsHTML += '<label class="form-label">@lang('End Date'):</label>';
                installmentsHTML += '<input type="text" required class="form-control" value="' + installment.endDate + '" disabled>';
                installmentsHTML += '</div>';
                installmentsHTML += '<div class="col-md-3">';
                installmentsHTML += '<label class="form-label">@lang('Price'):</label>';
                installmentsHTML += '<input type="text" required class="form-control" value="' + installment.amount + '" disabled>';
                installmentsHTML += '</div>';
                installmentsHTML += '</div>';

                installmentsHTML += '</div>'; // end card-body
                installmentsHTML += '</div>'; // end card
                installmentsHTML += '</div>'; // end col-md-12
            });

            installmentsHTML += '</div>'; // نهاية row

            $('#contractDetails').html(installmentsHTML);
            $('#contractDetails').show();
        });
    });
</script> --}}



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

            if (unitId) {
                fetch(`/units/${unitId}/status`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'rented') {
                            unitStatusSpan.innerHTML = `This unit is rented. Start date: ${data.start_date}`;
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
