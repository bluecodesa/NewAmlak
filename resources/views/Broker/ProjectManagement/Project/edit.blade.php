
@extends('Admin.layouts.app')
@section('title', __('Edit') . ' ' . __('Project') . ' ' . $project->name)
@section('content')



<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-6">

                <h4 class=""><a href="{{ route('Broker.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                    <a href="{{ route('Broker.Project.index') }}" class="text-muted fw-light">@lang('Projects') </a> /
                    @lang('Edit') : {{ $project->name }}
                </h4>
            </div>

        </div>



            <div class="row">
                <div class="col-12">
                        @include('Admin.layouts.Inc._errors')
            <div class="col-xl-12">
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
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">3</span>
                      </button>
                    </li>
                    <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-justified-gallery"
                          aria-controls="navs-justified-gallery"
                          aria-selected="false">
                          <i class="tf-icons ti ti-bell-dollar ti-xs me-1"></i>  @lang('Time Line')
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
                      </button>
                    </li>

                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">


                        {{-- الوصف --}}

                        <form action="{{ route('Broker.Project.update', $project->id) }}" method="POST" class="row"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="col-md-3 col-12 mb-3">

                                <label class="form-label">
                                    {{ __('project name') }} <span class="required-color">*</span></label>
                                <input type="text" value="{{ $project->name }}" required id="modalRoleName"
                                    name="name" class="form-control" placeholder="{{ __('project name') }}">

                            </div>

                            <div class="col-md-3 col-12 mb-3">
                                <label class="form-label">@lang('Region') </label>
                                <select class="form-select" id="Region_id" required>
                                    <option disabled value="">@lang('Region') <span
                                            class="required-color">*</span></option>
                                    @foreach ($Regions as $Region)
                                        <option value="{{ $Region->id }}"
                                            {{ $Region->id == $project->Region_id ? 'selected' : '' }}
                                            data-url="{{ route('Broker.Broker.GetCitiesByRegion', $Region->id) }}">
                                            {{ $Region->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 col-12 mb-3">
                                <label class="form-label">@lang('city') <span class="required-color">*</span>
                                </label>
                                <select class="form-select" name="city_id" id="CityDiv" required>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}"
                                            data-url="{{ route('Broker.Broker.GetDistrictsByCity', $city->id) }}"
                                            {{ $city->id == $project->city_id ? 'selected' : '' }}>
                                            {{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>



                            <div class="col-md-3 col-12 mb-3">
                                <label class="form-label">@lang('district') <span class="required-color">*</span>
                                </label>
                                <select class="form-select" name="district_id" id="DistrictDiv" required>
                                    @foreach ($project->CityData->DistrictsCity as $district)
                                        <option value="{{ $district->id }}"
                                            {{ $district->id == $project->district_id ? 'selected' : '' }}>
                                            {{ $district->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-12 col-md-4 mb-3">
                                <label class="form-label">@lang('location name') <span
                                        class="required-color">*</span></label>
                                <input type="text" required name="location" id="myAddressBar" class="form-control"
                                    placeholder="@lang('Address')" value="{{ $project->location }}" />
                            </div>

                            <div class="col-md-4 col-12 mb-3">
                                <label class="form-label">@lang('Developer name') </label>
                                <select class="form-select" name="developer_id">
                                    <option value="">@lang('Developer name')</option>
                                    @foreach ($developers as $developer)
                                        <option value="{{ $developer->id }}"
                                            {{ $developer->id == $project->developer_id ? 'selected' : '' }}>
                                            {{ $developer->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-md-4 col-12 mb-3">
                                <label class="form-label">@lang('Advisor name') </label>
                                <select class="form-select" name="advisor_id">
                                    <option selected value="">@lang('Advisor name')</option>
                                    @foreach ($advisors as $advisor)
                                        <option value="{{ $advisor->id }}"
                                            {{ $advisor->id == $project->advisor_id ? 'selected' : '' }}>
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
                                            <option value="{{ $owner->id }}"
                                                {{ $owner->id == $project->owner_id ? 'selected' : '' }}>
                                                {{ $owner->name }}</option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#addNewCCModal" type="button">@lang('Add New Owner')</button>
                                </div>
                            </div>


                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">@lang('service type') <span class="required-color">*</span>
                                </label>
                                <select class="form-select" name="service_type_id" required>
                                    <option disabled value="">@lang('service type')</option>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}"
                                            {{ $service->id == $project->service_type_id ? 'selected' : '' }}>
                                            {{ $service->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">@lang('Project statu') <span class="required-color"></span></label>
                                <select class="form-select" name="project_status_id">
                                    <option disabled selected value="">@lang('Project statu')</option>
                                    @foreach ($projectStatuses as $status)
                                    <option value="{{ $status->id }}"
                                        {{ $status->id == $project->project_status_id ? 'selected' : '' }}>
                                        {{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">@lang('Delivery Case') <span class="required-color"></span></label>
                                <select class="form-select" name="delivery_case_id">
                                    <option disabled selected value="">@lang('Delivery Case')</option>
                                    @foreach ($deliveryCases as $case)
                                    <option value="{{ $case->id }}"
                                        {{ $case->id == $project->delivery_case_id ? 'selected' : '' }}>
                                        {{ $case->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="mb-3 col-12">
                                <label class="form-label mb-2">@lang('Description')</label>
                                <div>
                                    {{-- <textarea name="note" class="form-control" rows="5"></textarea> --}}
                                    <textarea id="textarea" class="form-control" name="note" cols="30" rows="30" placeholder=""
                                    >{{ $project->note }}</textarea>
                                </div>
                            </div>


                            <div class="col-sm-12 col-md-12 mb-3">
                                <label class="form-label mb-2">@lang('Project photo') </label>
                                <input type="file" name="images[]"
                                    data-url="{{ route('Broker.Project.deleteImage', $project->id) }}"
                                    @if ($project->ProjectImages->count() > 0) data-default-file="{{ url($project->ProjectImages[0]->image) }}" @endif
                                    multiple class="dropify" accept="image/jpeg, image/png" />
                            </div>





                            {{-- <div class="col-sm-12 col-md-6 mb-3">
                                    <label class="form-label">@lang('address')</label>
                                    <input type="text" required name="address" id="address" class="form-control"
                                        placeholder="@lang('address')" value="{{ old('address') }}" />
                                </div> --}}

                            <div class="col-sm-12 col-md-6 mb-3" hidden>
                                <label class="form-label">@lang('lat&long')</label>
                                <input type="text" required readonly name="lat_long" id="location_tag"
                                    class="form-control" placeholder="@lang('lat&long')"
                                    value="{{ $project->lat_long }}" />
                            </div>


                    </div>
                    <div class="tab-pane fade" id="navs-justified-gallery" role="tabpanel">
                        <div class="col-12 mb-3">
                            <label class="form-label">@lang('Additional details')</label>
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="addFeature()">@lang('Add stage')</button>
                            <div id="features" class="row p-2">
                                @foreach ($project->ProjectTimeLineData as $timeLine)
                                    <div class="row p-1">
                                        <div class="col">
                                            <select id="selectpickerGroups" name="time_line[][status_id]" class="form-select selectpicker w-100" data-style="btn-default">
                                                <option value="">@lang('Project statu')</option>
                                                @foreach ($projectStatuses as $status)
                                                    <option value="{{ $status->id }}" {{ $status->id == $timeLine->status_id ? 'selected' : '' }}>{{ $status->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <select id="selectpickerGroups" name="time_line[][delivery_id]" class="form-select selectpicker w-100" data-style="btn-default">
                                                <option value="">@lang('Delivery Case')</option>
                                                @foreach ($deliveryCases as $case)
                                                    <option value="{{ $case->id }}" {{ $case->id == $timeLine->delivery_id ? 'selected' : '' }}>{{ $case->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <input class="form-control" name="date[]" type="date" id="html5-date-input" value="{{ $timeLine->date }}">
                                        </div>
                                        <div class="col">
                                            <button type="button" class="btn btn-outline-danger w-100 remove-feature" onclick="removeFeature(this)">@lang('Remove')</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="formFileMultiple" class="form-label">@lang('Project Masterplan')</label>
                                <input class="form-control" type="file" name="project_masterplan" id="projectMasterplan" accept="image/*,application/pdf" multiple>
                                @if($project->project_masterplan)
                                    <div class="mt-2">
                                        <label>@lang('Project Masterplan'):</label>
                                        <a href="{{ url($project->project_masterplan) }}" target="_blank">@lang('View')</a>
                                    </div>
                                @endif
                            </div>
                            <div class="col-6 mb-3">
                                <label for="formFileMultiple" class="form-label">@lang('Project Brochure')</label>
                                <input class="form-control" type="file" name="project_brochure" id="projectBrochure" accept="image/*,application/pdf" multiple>
                                @if($project->project_brochure)
                                    <div class="mt-2">
                                        <label>@lang('Project Brochure'):</label>
                                        <a href="{{ url($project->project_brochure) }}" target="_blank">@lang('View')</a>
                                    </div>
                                @endif
                            </div>
                        </div>


                    </div>

                    <div class="col-12">
                        <button class="btn btn-primary waves-effect waves-light"
                            type="submit">@lang('save')</button>
                    </div>



                </form>
                  </div>

                </div>

              </div>




        </div> <!-- end row -->

    </div>
    <!-- container-fluid -->

</div>
</div>
@include('Broker.ProjectManagement.Project.Unit.inc._model_new_owners')

{{-- نهايه الوصف --}}

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



    function addFeature(status_id = '', delivery_id = '', date = '') {
    const featuresContainer = document.getElementById('features');
    const newRow = document.createElement('div');
    newRow.classList.add('row', 'mb-3');

    newRow.innerHTML = `
        <div class="col">
            <select name="time_line[][status_id]" class="form-select selectpicker w-100" data-style="btn-default">
                <option value="">@lang('Project statu')</option>
                @foreach ($projectStatuses as $status)
                    <option value="{{ $status->id }}" ${status_id == {{ $status->id }} ? 'selected' : ''}>{{ $status->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col">
            <select name="time_line[][delivery_id]" class="form-select selectpicker w-100" data-style="btn-default">
                <option value="">@lang('Delivery Case')</option>
                @foreach ($deliveryCases as $case)
                    <option value="{{ $case->id }}" ${delivery_id == {{ $case->id }} ? 'selected' : ''}>{{ $case->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col">
            <input class="form-control" name="date[]" type="date" value="${date}">
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



</script>
@endpush
@endsection
