@extends('Admin.layouts.app')
@section('title', __('Add New Project'))
@section('content')



    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-12">

                    <h4 class=""><a href="{{ route('Broker.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Broker.Project.index') }}" class="text-muted fw-light">@lang('Projects') </a> /
                        @lang('Add New Project')
                    </h4>
                </div>

            </div>


            <div class="row">
                <div class="card">
                    @include('Admin.layouts.Inc._errors')
                <div class="nav-align-top nav-tabs-shadow mb-4">
                  <ul class="nav nav-tabs nav-fill" role="tablist">
                    <li class="nav-item">
                      <button
                        type="button"
                        class="nav-link active"
                        role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-justified-home"
                        aria-controls="navs-justified-home"
                        aria-selected="true">
                        <i class="tf-icons ti ti-home ti-xs me-1"></i> @lang('Description')
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">7</span>
                      </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-justified-gallery" aria-controls="navs-justified-gallery"
                            aria-selected="false">
                            <i class="tf-icons ti ti-camera ti-xs me-1"></i> @lang('Gallery')
                            <span
                                class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">1</span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-justified-timeLine"
                          aria-controls="navs-justified-timeLine"
                          aria-selected="false">
                          <i class="tf-icons ti ti-bell-dollar ti-xs me-1"></i>  @lang('Time Line')
                          <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">0</span>
                        </button>
                      </li>
                    <li class="nav-item">
                      <button
                        type="button"
                        class="nav-link"
                        role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-justified-profile"
                        aria-controls="navs-justified-profile"
                        aria-selected="false">
                        <i class="tf-icons ti ti-bell-dollar ti-xs me-1"></i> @lang('Attachments')
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">0</span>
                      </button>
                    </li>

                  </ul>
                  <form action="{{ route('Broker.Project.store') }}" method="POST" class="row"
                  enctype="multipart/form-data">
                  @csrf
                  @method('post')
                  <div class="tab-content">

                        <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">

                        {{-- الوصف --}}
                            <div class="row">

                                <div class="col-md-3 col-12 mb-3">

                                    <label class="form-label">
                                        {{ __('project name') }} <span class="required-color">*</span></label>
                                    <input type="text" required id="modalRoleName" name="name" class="form-control"
                                        placeholder="{{ __('project name') }}">

                                </div>

                                <div class="col-md-3 col-12 mb-3">
                                    <label class="form-label">@lang('Region') <span class="required-color">*</span>
                                    </label>
                                    <select class="form-select" id="Region_id" required>
                                        <option disabled selected value="">@lang('Region') </option>
                                        @foreach ($Regions as $Region)
                                            <option value="{{ $Region->id }}"
                                                data-url="{{ route('Broker.Broker.GetCitiesByRegion', $Region->id) }}">
                                                {{ $Region->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 col-12 mb-3">
                                    <label class="form-label">@lang('city') <span class="required-color">*</span>
                                    </label>
                                    <select class="form-select" name="city_id" id="CityDiv" required>

                                    </select>
                                </div>


                                <div class="col-md-3 col-12 mb-3">
                                    <label class="form-label">@lang('district') <span class="required-color">*</span>
                                    </label>
                                    <select class="form-select" name="district_id" id="DistrictDiv" required>

                                    </select>
                                </div>

                                <div class="col-sm-12 col-md-4 mb-3">
                                    <label class="form-label">@lang('location name') <span
                                            class="required-color">*</span></label>
                                    <input type="text" required name="location" id="myAddressBar" class="form-control"
                                        placeholder="@lang('Address')" value="{{ old('location') }}" />
                                </div>

                                <div class="col-md-4 col-12 mb-3">
                                    <label class="form-label">@lang('Developer name')</label>
                                    <select class="form-select" name="developer_id">
                                        <option disabled selected value="">@lang('Developer name')</option>
                                        @foreach ($developers as $developer)
                                            <option value="{{ $developer->id }}">
                                                {{ $developer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="col-md-4 col-12 mb-3">
                                    <label class="form-label">@lang('Advisor name') </label>
                                    <select class="form-select" name="advisor_id">
                                        <option disabled selected value="">@lang('Advisor name')</option>
                                        @foreach ($advisors as $advisor)
                                            <option value="{{ $advisor->id }}">
                                                {{ $advisor->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 col-12 mb-3">
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
                                        <a href="{{ route('Broker.Owner.index') }}" target="_blank" class="btn btn-outline-primary"
                                        type="button">@lang('Add New Owner')</a>
                                        {{-- <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#addNewCCModal" type="button">@lang('Add New Owner')</button> --}}
                                    </div>
                                </div>

                                <div class="col-md-6 col-12 mb-3">
                                    <label class="form-label">@lang('service type') <span class="required-color">*</span>
                                    </label>
                                    <select class="form-select" name="service_type_id" required>
                                        <option disabled selected value="">@lang('service type')</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}">
                                                {{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 col-12 mb-3">
                                    <label class="form-label">@lang('Project statu') <span class="required-color"></span></label>
                                    <select class="form-select" name="project_status_id">
                                        <option disabled selected value="">@lang('Project statu')</option>
                                        @foreach ($projectStatuses as $status)
                                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="col-md-6 col-12 mb-3" hidden>
                                    <label class="form-label">@lang('lat&long')</label>
                                    <input type="text" required readonly name="lat_long" id="location_tag"
                                        class="form-control" placeholder="@lang('lat&long')"
                                        value="{{ old('location_tag') }}" />
                                </div>


                            </div>
                            <div class="col-12" style="text-align: center;">
                                <button type="button" class="btn btn-primary col-4 me-1 next-tab"
                                    data-next="#navs-justified-gallery">
                                    {{ __('Next') }}
                                </button>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="navs-justified-gallery" role="tabpanel">
                            @php
                            // Fetch all Fal licenses for the authenticated user
                            $falLicense = \App\Models\FalLicenseUser::where('user_id', auth()->id())
                                ->whereHas('falData', function ($query) {
                                    $query->whereTranslation('name', 'Real State FalLicense', 'en');
                                })
                                ->where('ad_license_status', 'valid')
                                ->first();
                                // dd($falLicense);

                            // $licenseDate = Auth::user()->UserFalData->falData->name;
                            $licenseDate = $falLicense ? $falLicense->ad_license_expiry : null;


                        @endphp

                            @if($falLicense)
                                <!-- Show the "Show in Gallery" switch if the user has a valid license -->
                                <div class="col-sm-12 col-md-4 mb-3">
                                    <label class="form-label" style="display: block !important;">@lang('Show in Gallery')</label>
                                    <label class="switch switch-lg">
                                        <input type="checkbox" name="show_in_gallery" class="switch-input" id="show_gallery"
                                            @if($falLicense->ad_license_status != 'valid') disabled @endif
                                            @if($falLicense->ad_license_status == 'valid') checked @endif />
                                        <span class="switch-toggle-slider">
                                            <span class="switch-on"><i class="ti ti-check"></i></span>
                                            <span class="switch-off"><i class="ti ti-x"></i></span>
                                        </span>
                                    </label>
                                </div>

                                <!-- Show gallery fields only if the license status is "valid" -->
                                <div class="row" id="gallery-fields" style="@if($falLicense->ad_license_status != 'valid') display: none; @endif">
                                    <div class="col-sm-12 col-md-4 mb-3">
                                        <label class="form-label">@lang('Ad License Number')<span class="required-color">*</span></label>
                                        <input type="number" name="ad_license_number" class="form-control" id="ad_license_number"
                                            @if($falLicense->ad_license_status != 'valid') disabled @endif required />
                                    </div>

                                    <div class="col-sm-12 col-md-4 mb-3">
                                        <label class="form-label">@lang('Ad License Expiry')<span class="required-color">*</span></label>
                                        <input type="date" name="ad_license_expiry" class="form-control" id="ad_license_expiry"
                                            @if($falLicense->ad_license_status != 'valid') disabled @endif required />
                                        <div id="date_error_message" style="color: red; display: none;">The selected date cannot be later than the license date.</div>
                                    </div>
                                </div>
                            @else
                                <!-- Display a message if the license is not valid or doesn't exist -->
                                <div class="col-sm-12 col-md-4 mb-3">
                                    <label class="form-label" style="display: block !important;">@lang('Show in Gallery')</label>
                                    <label class="switch switch-lg">
                                        <input type="checkbox" name="show_gallery" class="switch-input" id="show_gallery" disabled />
                                        <span class="switch-toggle-slider">
                                            <span class="switch-off"><i class="ti ti-x"></i></span>
                                        </span>
                                    </label>
                                    <!-- Add a message to indicate the license has expired -->
                                    <div class="alert alert-warning mt-2">
                                        @lang('Show in Gallery is not available because your license has expired or is not valid.')
                                    </div>
                                </div>
                            @endif

                            <div class="mb-3 col-12">
                                <label class="form-label mb-2">@lang('Description')</label>
                                <div>
                                    {{-- <textarea name="note" class="form-control" rows="5"></textarea> --}}
                                    <textarea id="textarea" class="form-control" name="note" cols="30" rows="30" placeholder=""
                                    ></textarea>
                                </div>
                            </div>


                            <div class="col-sm-12 col-md-12 mb-3">
                                <label class="form-label mb-2">@lang('Project images') </label>
                                <input type="file" name="images[]" multiple class="dropify"
                                accept="image/jpeg, image/png" />

                            </div>
                            <div class="col-12" style="text-align: center;">
                                <button type="button" class="btn btn-primary col-4 me-1 next-tab"
                                    data-next="#navs-justified-timeLine">
                                    {{ __('Next') }}
                                </button>
                            </div>
                        </div>
                            <div class="tab-pane fade" id="navs-justified-timeLine" role="tabpanel">
                                <label class="form-label">@lang('قم بإضافة مراحل المشروع هنا')</label>
                                <div id="features" class="row">
                                    <div class="row mb-3 stage-row">
                                        <div class="col-4">
                                            <select name="time_line[]" class="form-select w-100">
                                                <option value="">@lang('Project status')</option>
                                                @foreach ($projectStatuses as $status)
                                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-4">
                                            <input class="form-control" name="date[]" type="date" id="html5-date-input">
                                        </div>
                                        <div class="col-4">
                                            <button type="button" class="btn btn-primary w-100"
                                            onclick="addFeature()"><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                                                class="d-none d-sm-inline-block">@lang('Add stage')</span></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12" style="text-align: center;">
                                    <button type="button" class="btn btn-primary col-4 me-1 next-tab"
                                        data-next="#navs-justified-profile">
                                        {{ __('Next') }}
                                    </button>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
                                <div class="row">
                                    <div class=" col-6 mb-3">
                                        <label for="formFileMultiple" class="form-label">@lang('Project Masterplan')</label>
                                        <input class="form-control" type="file" name="project_masterplan" id="projectMasterplan" accept="image/*,application/pdf" multiple>
                                    </div>
                                    <div class=" col-6 mb-3">
                                        <label for="formFileMultiple" class="form-label">@lang('Project Brochure')</label>
                                        <input class="form-control" type="file" name="project_brochure" id="projectBrochure" accept="image/*,application/pdf" multiple>
                                    </div>
                                </div>
                                <div class="col-12" style="text-align: center;">
                                    <button class="btn btn-primary col-4 waves-effect waves-light" id="submit_button"
                                        type="submit">@lang('save')</button>
                                </div>
                            </div>


                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('Broker.ProjectManagement.Project.Unit.inc._model_new_owners')

{{-- نهايه الوصف --}}


@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        // Intercept form submission
        $('#OwnerForm').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'), // Form action URL
                data: formData, // Form data
                success: function(data) {
                    $('#OwnersDiv').empty();
                    $('#OwnersDiv').append(data);
                    $('#addNewCCModal').modal('hide');
                    alertify.success(@json(__('added successfully')));
                },
                error: function(xhr, status, error) {
                    // Handle error response here
                    console.error(xhr.responseText);
                }
            });
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

    $('#CityDiv').on('change', function() {
        var selectedOption = $(this).find(':selected');
        var url = selectedOption.data('url');
        $.ajax({
            type: "get",
            url: url,
            beforeSend: function() {
                $('#DistrictDiv').fadeOut('fast');
            },
            success: function(data) {
                $('#DistrictDiv').fadeOut('fast', function() {
                    $(this).empty().append(data);
                    $(this).fadeIn('fast');
                });
            },
        });
    });


    $('.Region_id').on('change', function() {
        var selectedOption = $(this).find(':selected');
        var url = selectedOption.data('url');
        $.ajax({
            type: "get",
            url: url,
            beforeSend: function() {
                $('.CityDiv').fadeOut('fast');
            },
            success: function(data) {
                $('.CityDiv').fadeOut('fast', function() {
                    $(this).empty().append(data);
                    $(this).fadeIn('fast');
                });
            },
        });
    });

    //
    $("#myAddressBar").on("keyup", function() {
        // This function will be called every time a key is pressed in the input field
        var input = document.getElementById("myAddressBar");
        var autocomplete = new google.maps.places.Autocomplete(input);
        var place = autocomplete.getPlace();

        // Listen for the place_changed event
        google.maps.event.addListener(autocomplete, "place_changed", function() {
            // Get the selected place
            var place = autocomplete.getPlace();

            // Get the details of the selected place
            var address = place.formatted_address;
            var lat = place.geometry.location.lat();
            var long = place.geometry.location.lng();
            // $("#address").val(address);
            $("#location_tag").val(lat + "," + long);
            // Log the details to the console (or do something else with them)
        });
    });





    $(document).ready(function() {
        $('#textarea').summernote({
            height: 100, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: true, // set focus to editable area after initializing summernote
            toolbar: [
                // Include only the options you want in the toolbar, excluding 'fontname', 'video', and 'table'
                ['style', ['bold', 'underline']],
                ['insert', ['link', 'picture', 'hr']], // 'video' is deliberately excluded
                ['para', ['ul', 'ol']],
                ['misc', ['fullscreen', 'undo', 'redo']],
                // Any other toolbar groups and options you want to include...
            ],
            // Explicitly remove table and font name options by not including them in the toolbar
        });
        $('.card-body .badge').click(function() {
            var variableValue = $(this).attr('data-variable');
            var $textarea = $('#textarea');
            var summernoteEditor = $textarea.summernote('code');

            // Check if Summernote editor is focused
            if ($('.note-editable').is(':focus')) {
                var node = document.createElement("span");
                node.innerHTML = variableValue;
                $('.note-editable').append(
                    node); // This line appends the variable as a new node to the editor
                var range = document.createRange();
                var sel = window.getSelection();
                range.setStartAfter(node);
                range.collapse(true);
                sel.removeAllRanges();
                sel.addRange(range);
            } else {
                var currentContent = $textarea.summernote('code');
                $textarea.summernote('code', currentContent + variableValue);
            }
        });
    });

    function addFeature() {
                const featuresContainer = document.getElementById('features');
                const newRow = document.createElement('div');
                newRow.classList.add('row', 'mb-3'); // Add any additional classes that your grid system requires

                // Use the exact same class names and structure as your existing rows
                newRow.innerHTML = `
                <div class="col-4">
                                            <select name="time_line[]" class="form-select w-100">
                                                <option value="">@lang('Project status')</option>
                                                @foreach ($projectStatuses as $status)
                                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-4">
                                            <input class="form-control" name="date[]" type="date" id="html5-date-input">
                                        </div>
        <div class="col">
            <button type="button" class="btn btn-danger w-100" onclick="removeFeature(this)">@lang('Remove')</button>
        </div>
    `;

                featuresContainer.appendChild(newRow);
            }

            function removeFeature(button) {
                const rowToRemove = button.parentNode.parentNode;
                rowToRemove.remove();
            }



//     $(document).ready(function() {
//     // Add Stage Button Click Event
//     $('.add-stage').click(function() {
//         var newRow = $('.stage-row').first().clone(); // Clone the first row
//         newRow.find('select').val(''); // Clear select value
//         newRow.find('input').val(''); // Clear input value
//         $('#features').append(newRow); // Append cloned row to the container
//     });

//     // Submit Button Click Event
//     $('#submit-btn').click(function() {
//         var data = {
//             time_line: [],
//             date: []
//         };
//         $('.stage-row').each(function() {
//             var status = $(this).find('select').val();
//             var date = $(this).find('input').val();
//             data.time_line.push(status);
//             data.date.push(date);
//         });
//         // Now 'data' contains the array of stage data, you can send it via AJAX or any other method
//         console.log(data);
//     });
// });


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
    document.getElementById('show_in_gallery').addEventListener('change', function () {
        var galleryFields = document.getElementById('gallery-fields');
        if (this.checked) {
            galleryFields.style.display = 'block';
            document.getElementById('ad_license_number').required = true;
            document.getElementById('ad_license_expiry').required = true;
        } else {
            galleryFields.style.display = 'none';
            document.getElementById('ad_license_number').required = false;
            document.getElementById('ad_license_expiry').required = false;
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var adLicenseExpiryInput = document.getElementById('ad_license_expiry');
        var errorMessage = document.getElementById('date_error_message');
        adLicenseExpiryInput.addEventListener('change', function() {
            var selectedDate = new Date(this.value);
            if (selectedDate > licenseDate) {
                errorMessage.style.display = 'block';
                adLicenseExpiryInput.setCustomValidity('');
            } else {
                errorMessage.style.display = 'none';
                adLicenseExpiryInput.setCustomValidity(''); /
            }
        });

        adLicenseExpiryInput.addEventListener('focus', function() {
            errorMessage.style.display = 'none';
        });
    });
</script>

<script>
    var licenseDate = new Date("{{ $licenseDate }}");
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var adLicenseExpiryInput = document.getElementById('ad_license_expiry');
        var errorMessage = document.getElementById('date_error_message');
        var submitButton = document.getElementById('submit_button');
        var form = document.getElementById('unit-form');

        function validateDate() {
            var selectedDate = new Date(adLicenseExpiryInput.value);
            if (selectedDate > licenseDate) {
                // Show error message if the selected date is after the license date
                errorMessage.style.display = 'block';
                submitButton.disabled = true; // Disable submit button
            } else {
                // Hide error message if the date is valid
                errorMessage.style.display = 'none';
                submitButton.disabled = false; // Enable submit button
            }
        }

        adLicenseExpiryInput.addEventListener('change', validateDate);

        form.addEventListener('submit', function(event) {
            var selectedDate = new Date(adLicenseExpiryInput.value);
            if (selectedDate > licenseDate) {
                // Prevent form submission if the selected date is invalid
                event.preventDefault();
                errorMessage.style.display = 'block';
            } else {
                // Allow form submission if the date is valid
                errorMessage.style.display = 'none';
            }
        });
    });
</script>


@endpush
