@extends('Home.layouts.home.app')
@section('title', __('حسابي'))

@section('content')

<section class="section-py bg-body first-section-pt">
    <div class="container mt-2">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('welcome') }}">الرئيسيه</a>/ </span>حسابي
        </h4>



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
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">9</span>
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
                        data-bs-target="#navs-justified-profile"
                        aria-controls="navs-justified-profile"
                        aria-selected="false">
                        <i class="tf-icons ti ti-bell-dollar ti-xs me-1"></i> @lang('Attachments')
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">0</span>
                      </button>
                    </li>

                  </ul>
                        <form action="{{ route('Owner.store-Property') }}" method="POST" class="row"
                            enctype="multipart/form-data">
                            @csrf
                            @method('post')

                        <div class="tab-content">

                        <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">
                            <div class="row">

                                <input type="text" hidden value="{{ 1 }}" name="is_divided">

                                <div class="col-md-3 mb-3">

                                    <label class="form-label">
                                        {{ __('property name') }} <span class="required-color">*</span></label>
                                    <input type="text" required id="modalRoleName" name="name" class="form-control"
                                        placeholder="{{ __('property name') }}">

                                </div>


                                <div class="form-group col-12 col-md-3">
                                    <label class="form-label">@lang('Region') <span class="required-color">*</span>
                                    </label>
                                    <select class="form-select" id="Region_id" required>
                                        <option disabled value="">@lang('Region') </option>
                                        @foreach ($Regions as $Region)
                                            <option value="{{ $Region->id }}"
                                                data-url="{{ route('Owner.GetCitiesRegion', $Region->id) }}">
                                                {{ $Region->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-12 col-md-3">
                                    <label class="form-label">@lang('city') <span class="required-color">*</span>
                                    </label>
                                    <select class="form-select" name="city_id" id="CityDiv" required>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}"
                                                data-url="{{ route('Owner.GetDistrictsCity', $city->id) }}">
                                                {{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>



                                <div class="form-group col-12 col-md-3">
                                    <label class="form-label">@lang('district') <span class="required-color">*</span>
                                    </label>
                                    <select class="form-select" name="district_id" id="DistrictDiv" required>

                                    </select>
                                </div>

                                <div class="col-sm-12 col-md-4 col-12 mb-3">
                                    <label class="form-label">@lang('location') <span
                                            class="required-color">*</span></label>
                                    <input type="text" required name="location" id="myAddressBar" class="form-control"
                                        placeholder="@lang('Address')" value="{{ old('location') }}" />
                                </div>


                                <div class="form-group col-12 col-md-4">
                                    <label class="form-label">@lang('Property type') <span class="required-color">*</span>
                                    </label>
                                    <select class="form-select" name="property_type_id" required>
                                        <option disabled selected value="">@lang('Property type')</option>
                                        @foreach ($types as $type)
                                            <option value="{{ $type->id }}">
                                                {{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-12 col-md-4">
                                    <label class="form-label">@lang('Type use') <span class="required-color">*</span>
                                    </label>
                                    <select class="form-select" name="property_usage_id" required>
                                        <option disabled selected value="">@lang('Type use')</option>
                                        @foreach ($usages as $usage)
                                            <option value="{{ $usage->id }}">
                                                {{ $usage->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 col-md-4 mb-3">
                                    <label class="col-md-6 form-label">@lang('owner name') <span
                                            class="required-color">*</span>
                                    </label>
                                    {{-- <div class="input-group">
                                        <option selected selected value="{{ Auth::user()->UserOwnerData->id }}">{{ Auth::user()->UserOwnerData->name }}</option>

                                     </div> --}}
                                     <input type="hidden" id="owner_id" name="owner_id" value="{{ Auth::user()->UserOwnerData->id }}">

                                     <!-- Visible input for owner's name -->
                                     <input type="text" required id="modalRoleName" readonly  class="form-control"
                                            value="{{ Auth::user()->UserOwnerData->name }}"
                                            placeholder="{{ __('property name') }}">
                                </div>


                                <div class="col-sm-12 col-md-4 mb-3">
                                    <label class="form-label">@lang('Instrument number')</label>
                                    <input type="number" name="instrument_number" class="form-control"
                                        placeholder="@lang('Instrument number')" value="{{ old('Instrument number') }}" />
                                </div>


                                <div class="form-group col-md-4 mb-3">
                                    <label class="form-label">@lang('offered service') <span class="required-color">*</span>
                                    </label>
                                    <select class="form-select" name="service_type_id" required>
                                        <option disabled selected value="">@lang('offered service')</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}">
                                                {{ $service->name }}</option>
                                        @endforeach
                                    </select>
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

                            <div class="col-sm-12 col-md-4 mb-3">
                                <label class="form-label" style="display: block !important;">@lang('Show in Gallery')</label>
                                <label class="switch switch-lg">
                                    <input type="checkbox" name="show_in_gallery" disabled class="switch-input" id="show_in_gallery"  />
                                    <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="ti ti-check"></i></span>
                                        <span class="switch-off"><i class="ti ti-x"></i></span>
                                    </span>
                                </label>
                            </div>



                            <div class="mb-3 col-12">
                                <label class="form-label mb-2">@lang('Description')</label>
                                <div>
                                    <textarea id="textarea" class="form-control" name="note" cols="30" rows="30" placeholder=""
                                    ></textarea>
                                </div>
                            </div>

                                <div class="col-sm-12 col-md-12 mb-3">
                                    <label class="form-label">@lang('Pictures property') </label>
                                    <input type="file" name="images[]" multiple class="dropify"
                                        accept="image/jpeg, image/png" />

                                </div>



                                <div class="col-sm-12 col-md-6 mb-3" hidden>
                                    <label class="form-label">@lang('lat&long')</label>
                                    <input type="text" required readonly name="lat_long" id="location_tag"
                                        class="form-control" placeholder="@lang('lat&long')"
                                        value="{{ old('location_tag') }}" />
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
                                    <label for="formFileMultiple" class="form-label">@lang('Property Masterplan')</label>
                                    <input class="form-control" type="file" name="property_masterplan" id="projectMasterplan" accept="image/*,application/pdf" multiple>
                                </div>
                                <div class=" col-6 mb-3">
                                    <label for="formFileMultiple" class="form-label">@lang('Property Brochure')</label>
                                    <input class="form-control" type="file" name="property_brochure" id="projectBrochure" accept="image/*,application/pdf" multiple>
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
</section>

    <!-- container-fluid -->

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
            //

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




    @endpush
@endsection