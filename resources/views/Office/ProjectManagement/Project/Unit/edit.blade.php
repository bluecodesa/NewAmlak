@extends('Admin.layouts.app')
@section('title', __('Edit') . ' ' . __('Edit') . ' ' . $Unit->number_unit)
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6">

                    <h4 class=""><a href="{{ route('Office.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Office.Unit.index') }}" class="text-muted fw-light">@lang('Units') </a> /
                        @lang('Edit') : {{ $Unit->number_unit }}
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
                          <i class="tf-icons ti ti-bell-dollar ti-xs me-1"></i> @lang('Gallery')
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
                        <i class="tf-icons ti ti-bell-dollar ti-xs me-1"></i> @lang('price')
                      </button>
                    </li>
                    <li class="nav-item">
                      <button
                        type="button"
                        class="nav-link"
                        role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-justified-messages"
                        aria-controls="navs-justified-messages"
                        aria-selected="false">
                        <i class="tf-icons ti ti-file ti-xs me-1"></i> @lang('Attachments')
                      </button>
                    </li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">


                        {{-- الوصف --}}


                        <form action="{{ route('Office.Unit.update', $Unit->id) }}" method="POST" class="row"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="col-md-4 mb-3 col-12">
                                <label class="form-label">@lang('Project') <span class="required-color"></span></label>
                                <select class="form-select" name="project_id" id="projectSelect">
                                    <option disabled selected value="">@lang('Choose')</option>
                                    <option  value="">@lang('without')</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}" {{ $Unit->project_id == $project->id ? 'selected' : '' }}>
                                            {{ $project->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3 col-12">
                                <label class="form-label">@lang('property') <span class="required-color"></span></label>
                                <select class="form-select" name="property_id" id="propertySelect">
                                    <option  value="">@lang('without')</option>
                                    @foreach ($properties as $property)
                                        <option value="{{ $property->id }}" {{ $Unit->property_id == $property->id ? 'selected' : '' }}>
                                            {{ $property->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 col-12 mb-3">
                                <label class="form-label">
                                    {{ __('Residential number') }} <span class="required-color">*</span></label>
                                <input type="text" value="{{ $Unit->number_unit }}" required
                                    id="modalRoleName" name="number_unit" class="form-control"
                                    placeholder="{{ __('Residential number') }}">

                            </div>

                            <div class="col-12 mb-3 col-md-4">
                                <label class="form-label">@lang('Region') <span class="required-color">*</span>
                                </label>
                                <select class="form-select" id="Region_id" required>
                                    <option disabled value="">@lang('Region') </option>
                                    @foreach ($Regions as $Region)
                                        <option value="{{ $Region->id }}"
                                            {{ $Region->id == $Unit->CityData->RegionData->id ? 'selected' : '' }}
                                            data-url="{{ route('Office.Office.GetCitiesByRegion', $Region->id) }}">
                                            {{ $Region->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 mb-3 col-md-4">
                                <label class="form-label">@lang('city') <span class="required-color">*</span>
                                </label>
                                <select class="form-select" name="city_id" id="CityDiv" required>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}"
                                            data-url="{{ route('Office.Office.GetDistrictsByCity', $city->id) }}"
                                            {{ $city->id == $Unit->city_id ? 'selected' : '' }}>
                                            {{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-12 mb-3 col-md-4">
                                <label class="form-label">@lang('district') <span class="required-color">*</span>
                                </label>
                                <select class="form-select" name="district_id" id="DistrictDiv" required>
                                    @foreach ($Unit->CityData->DistrictsCity as $district)
                                        <option value="{{ $district->id }}"
                                            {{ $district->id == $Unit->district_id ? 'selected' : '' }}>
                                            {{ $district->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-sm-12 col-md-4 mb-3">
                                <label class="form-label">@lang('location') <span
                                        class="required-color">*</span></label>
                                <input type="text" required name="location" id="myAddressBar" class="form-control"
                                    placeholder="@lang('location name')" value="{{ $Unit->location }}" />
                            </div>


                            <div class="col-12 mb-3 col-md-4">
                                <label class="form-label">@lang('Property type') <span class="required-color">*</span>
                                </label>
                                <select class="form-select" name="property_type_id" required>
                                    <option disabled value="">@lang('Property type')</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}"
                                            {{ $type->id == $Unit->property_type_id ? 'selected' : '' }}>
                                            {{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 mb-3 col-md-4">
                                <label class="form-label">@lang('Type use') <span class="required-color">*</span>
                                </label>
                                <select class="form-select" name="property_usage_id" required>
                                    <option disabled value="">@lang('Type use')</option>
                                    @foreach ($usages as $usage)
                                        <option value="{{ $usage->id }}"
                                            {{ $usage->id == $Unit->property_usage_id ? 'selected' : '' }}>
                                            {{ $usage->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-md-4 col-12 mb-3">
                                <label class="col-md-6 form-label">@lang('owner name') <span
                                        class="required-color">*</span>
                                </label>
                                <div class="input-group">
                                    <select class="form-select" id="OwnersDiv"
                                        aria-label="Example select with button addon" name="owner_id" required>
                                        <option disabled selected value="">@lang('owner name')</option>
                                        @foreach ($owners as $owner)
                                            <option value="{{ $owner->id }}"
                                                {{ $owner->id == $Unit->owner_id ? 'selected' : '' }}>
                                                {{ $owner->name }}</option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#addNewCCModal" type="button">@lang('Add New Owner')</button>
                                </div>
                            </div>


                            <div class="col-sm-12 col-md-4 mb-3">
                                <label class="form-label">@lang('Instrument number')</label>
                                <input type="number" name="instrument_number" class="form-control"
                                    placeholder="@lang('Instrument number')" value="{{ $Unit->instrument_number }}" />
                            </div>


                            <div class="col-12 col-md-4 mb-3">
                                <label class="form-label">@lang('offered service') <span class="required-color">*</span>
                                </label>
                                <select class="form-select" name="service_type_id" required>
                                    <option disabled selected value="">@lang('offered service')</option>
                                    @foreach ($servicesTypes as $service)
                                        <option value="{{ $service->id }}"
                                            {{ $service->id == $Unit->service_type_id ? 'selected' : '' }}>
                                            {{ $service->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-sm-12 col-md-4 mb-3">
                                <label class="form-label">@lang('Area (square metres)') </label>
                                <input type="number" name="space" class="form-control"
                                    placeholder="@lang('Area (square metres)')" value="{{ $Unit->space }}" />
                            </div>


                            <div class="col-sm-12 col-md-4 mb-3">
                                <label class="form-label">@lang('number rooms') </label>
                                <input type="number" name="rooms" class="form-control"
                                    placeholder="@lang('number rooms')" value="{{ $Unit->rooms }}" />
                            </div>



                            <div class="col-sm-12 col-md-4 mb-3">
                                <label class="form-label">@lang('Number bathrooms') </label>
                                <input type="number" name="bathrooms" class="form-control"
                                    placeholder="@lang('Number bathrooms')" value="{{ $Unit->bathrooms }}" />
                            </div>
                                <div class="col-12 mb-2 col-md-4">
                                    <label class="form-label">@lang('Status of Unit') <span class="required-color">*</span>
                                    </label>
                                    <select class="form-select" name="status" id="type" required>
                                        <option disabled value="">@lang('Status of Unit') </option>
                                        @foreach (['vacant', 'rented'] as $type)
                                        <option value="{{ $type }}"
                                        {{ $Unit->status == $type ? 'selected' : '' }}>
                                        {{ __($type) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 col-md-4 mb-3">
                                    <label class="form-label">@lang('Amenities')</label>
                                    <select class="select2 form-select" name="service_id[]" multiple="multiple">
                                        <option disabled value="">@lang('services')</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}"
                                                {{ in_array($service->id, $Unit->UnitServicesData->pluck('service_id')->toArray()) == true ? 'selected' : '' }}>
                                                {{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 mb-2 col-md-4">
                                    <label class="form-label">@lang('The Responsible Employee')
                                    </label>
                                    <select class="form-select" name="employee_id" id="type">
                                        <option disabled selected value="">@lang('The Responsible Employee') </option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}"
                                                {{ $employee->id == $Unit->employee_id ? 'selected' : '' }}>
                                                {{ $employee->UserData->name  }}</option>
                                    @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-12 col-md-6 mb-3" hidden>
                                    <label class="form-label">@lang('lat&long')</label>
                                    <input type="text" readonly name="lat_long" id="location_tag"
                                        class="form-control" placeholder="@lang('lat&long')"
                                        value="{{ old('location_tag') }}" />
                                </div>


                                <div class="col-12 mb-3">
                                    <label class="form-label">@lang('Additional details')</label>
                                    <button type="button" class="btn btn-outline-primary btn-sm"
                                        onclick="addFeature()">@lang('Add details')</button>
                                    @foreach ($Unit->UnitFeatureData as $feature)
                                        <div class="row p-1">
                                            <div class="col">
                                                <input type="text" name="name[]" class="form-control search"
                                                    placeholder="@lang('Field name')"
                                                    value="{{ $feature->FeatureData->name }}" />
                                            </div>
                                            <div class="col">
                                                <input type="text" name="qty[]" value="{{ $feature->qty }}"
                                                    class="form-control" placeholder="@lang('value')"
                                                    value="" />
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

                                <div class="col-12" style="text-align: center;">
                                    <button type="button" class="btn btn-primary col-4 me-1 next-tab" data-next="#navs-justified-gallery">
                                        {{ __('Next') }}
                                    </button>
                                </div>

          

                    </div>
                    <div class="tab-pane fade" id="navs-justified-gallery" role="tabpanel">
                        <div class="row">


                            <div class="col-md-4 col-12 mb-3">

                                <label class="form-label">
                                    {{ __('ad name') }} <span class="required-color">*</span></label>
                                <input type="text" required name="ad_name" value="{{ $Unit->ad_name }}"
                                    class="form-control" placeholder="{{ __('ad name') }}">

                            </div>


                            <div class="col-12 mb-3 col-md-4">
                                <label class="form-label">@lang('Ad type') <span
                                        class="required-color">*</span>
                                </label>
                                <select class="form-select" name="type" id="type" required>
                                    <option disabled value="">@lang('Ad type') </option>
                                    @foreach (['rent', 'sale', 'rent and sale'] as $type)
                                        <option value="{{ $type }}"
                                            {{ $Unit->type == $type ? 'selected' : '' }}>
                                            {{ __($type) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-12 col-md-4 mb-3">
                                <div class="small fw-medium mb-3">@lang('Show in Gallery')</div>
                                <label class="switch switch-primary">
                                    <input type="checkbox" name="show_gallery"
                                        class="switch-input toggleHomePage"
                                        {{ $Unit->show_gallery == 1 ? 'checked' : '' }}>
                                    <span class="switch-toggle-slider">
                                        <span class="switch-on">
                                            <i class="ti ti-check"></i>
                                        </span>
                                        <span class="switch-off">
                                            <i class="ti ti-x"></i>
                                        </span>
                                    </span>

                                </label>
                            </div>
                            <div class="mb-3 col-12">
                                <label class="form-label mb-2">@lang('Description')</label>
                                <div>
                                    {{-- <textarea name="note" class="form-control" rows="5">{{ $Unit->note }}</textarea> --}}
                                    <textarea id="textarea" class="form-control" name="note" cols="30" rows="30" placeholder="">{!! $Unit->note !!}</textarea>
                                </div>
                            </div>
                         
                            <div class="col-sm-12 col-md-12 mb-3">
                                <label class="form-label mb-2">@lang('Unit Images')</label>
                                <div class="input-group">
                                <input class="form-control" type="file" id="imageInput" name="images[]" multiple accept="image/jpeg, image/png" />
                                <button class="btn btn-outline-primary waves-effect" type="button" id="button-addon1"><i class="ti ti-refresh"></i></button>
                                </div>
                                @if(!$Unit->UnitImages->isEmpty())
                                    <div class="mt-3" id="currentImages">
                                        <h5>@lang('Current Images')</h5>
                                        <div class="d-flex flex-wrap">
                                            @foreach($Unit->UnitImages as $image)
                                                <div class="position-relative m-2 image-container">
                                                    <img src="{{ asset($image->image) }}" alt="Unit Image" class="img-thumbnail" style="height: 150px; object-fit: contain;">
                                                    <button type="button" class="btn btn-danger btn-sm remove-image" data-id="{{ $image->id }}" style="position: absolute; top: 5px; right: 5px;">X</button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="col-sm-12 col-md-12 mb-3">
                                <label class="form-label mb-2">@lang('Unit Video')</label>
                                <div class="input-group">
                                <input class="form-control" type="file" id="videoInput" name="video" accept="video/mp4, video/webm, video/ogg" />
                                <button class="btn btn-outline-primary waves-effect" type="button" id="button-addon2"><i class="ti ti-refresh"></i></button>
                                </div>
                                @if($Unit->video)
                                    <div class="mt-3" id="currentVideo">
                                        <h5>@lang('Current Video')</h5>
                                        <div class="position-relative m-2 video-container">
                                            <video controls class="d-block w-100" style="height: 350px; object-fit: contain;">
                                                <source src="{{ asset($Unit->video) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                            <button type="button" class="btn btn-danger btn-sm remove-video" style="position: absolute; top: 5px; right: 5px;">X</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            


                        </div>

                        <div class="col-12" style="text-align: center;">
                            <button type="button" class="btn btn-primary col-4 me-1 next-tab" data-next="#navs-justified-profile">
                                {{ __('Next') }}
                            </button>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
                        <div class="row">


                            <div class="col-sm-12 col-md-2 mb-3">

                                <label for="price" class="form-label">@lang('selling price')</label>
                                <div class="input-group">
                                    <input type="text" name="price" value="{{ $Unit->price }}"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12);"
                                        class="form-control" placeholder="@lang('selling price')"
                                        aria-label="@lang('selling price')" aria-describedby="button-addon2">
                                    <button class="btn btn-outline-primary waves-effect" type="button"
                                        id="button-addon2">@lang('SAR')</button>
                                </div>


                            </div>


                            <div class="col-sm-12 col-md-2 mb-3">
                                <label for="daily" class="form-label">@lang('daily rental price')</label>
                                <div class="input-group">
                                    <input type="text" name="daily" value="{{ $Unit->UnitRentPrice->daily }}"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12);"
                                        class="form-control" placeholder="@lang('daily rental price')"
                                        aria-label="@lang('daily rental price')" aria-describedby="button-addon2">
                                    <button class="btn btn-outline-primary waves-effect" type="button"
                                        id="button-addon2">@lang('SAR')</button>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-2 mb-3">
                                <label for="monthly" class="form-label">@lang('Monthly rental price')</label>
                                <div class="input-group">
                                    <input type="text" name="monthly" value="{{ $Unit->UnitRentPrice->monthly }}"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12);"
                                        class="form-control" placeholder="@lang('Monthly rental price')"
                                        aria-label="@lang('Monthly rental price')" aria-describedby="button-addon2">
                                    <button class="btn btn-outline-primary waves-effect" type="button"
                                        id="button-addon2">@lang('SAR')</button>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-2 mb-3">

                                <label for="quarterly" class="form-label">@lang('quarterly rental price')</label>
                                <div class="input-group">
                                    <input type="text" name="quarterly"
                                        value="{{ $Unit->UnitRentPrice->quarterly }}"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12);"
                                        class="form-control" placeholder="@lang('quarterly rental price')"
                                        aria-label="@lang('quarterly rental price')" aria-describedby="button-addon2">
                                    <button class="btn btn-outline-primary waves-effect" type="button"
                                        id="button-addon2">@lang('SAR')</button>
                                </div>

                            </div>

                            <div class="col-sm-12 col-md-2 mb-3">

                                <label for="midterm" class="form-label">@lang('midterm rental price')</label>
                                <div class="input-group">
                                    <input type="text" name="midterm" value="{{ $Unit->UnitRentPrice->midterm }}"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12);"
                                        class="form-control" placeholder="@lang('midterm rental price')"
                                        aria-label="@lang('midterm rental price')" aria-describedby="button-addon2">
                                    <button class="btn btn-outline-primary waves-effect" type="button"
                                        id="button-addon2">@lang('SAR')</button>
                                </div>

                            </div>

                            <div class="col-sm-12 col-md-2 mb-3">

                                <label for="yearly" class="form-label">@lang('yearly rental price')</label>
                                <div class="input-group">
                                    <input type="text" name="yearly" value="{{ $Unit->UnitRentPrice->yearly }}"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12);"
                                        class="form-control" placeholder="@lang('yearly rental price')"
                                        aria-label="@lang('yearly rental price')" aria-describedby="button-addon2">
                                    <button class="btn btn-outline-primary waves-effect" type="button"
                                        id="button-addon2">@lang('SAR')</button>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-2 mb-3">
                                <div class="small fw-medium mb-3">@lang('Daily Rent')</div>
                                <label class="switch switch-primary">
                                    <input type="checkbox" name="daily_rent" class="switch-input toggleHomePage"
                                        {{ $Unit->daily_rent == 1 ? 'checked' : '' }}>
                                    <span class="switch-toggle-slider">
                                        <span class="switch-on">
                                            <i class="ti ti-check"></i>
                                        </span>
                                        <span class="switch-off">
                                            <i class="ti ti-x"></i>
                                        </span>
                                    </span>

                                </label>
                            </div>


                        </div>
                        <div class="col-12" style="text-align: center;">
                            <button type="button" class="btn btn-primary col-4 me-1 next-tab" data-next="#navs-justified-messages">
                                {{ __('Next') }}
                            </button>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-justified-messages" role="tabpanel">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="formFileMultiple" class="form-label">@lang('Unit Masterplan')</label>
                                <div class="input-group">
                                    <input class="form-control" type="file" name="unit_masterplan"
                                        id="projectMasterplan" accept="image/*,application/pdf" multiple>
                                        <button class="btn btn-outline-primary waves-effect" type="button" id="button-addon3"><i class="ti ti-refresh"></i></button>
                                    </div>
                                @if ($Unit->unit_masterplan)
                                    <div class="mt-2">
                                        <label>@lang('Unit Masterplan'):</label>
                                        <a href="{{ url($Unit->unit_masterplan) }}"
                                            target="_blank">@lang('View')</a>
                                    </div>
                                @endif
                            </div>

                        </div>
                        <div class="col-12" style="text-align: center;" >
                            <button class="btn btn-primary col-4 waves-effect waves-light"
                                type="submit">@lang('save')</button>
                        </div>
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
@include('Office.ProjectManagement.Project.Unit.inc._model_new_owners')

{{-- نهايه الوصف --}}
    @push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.remove-feature', function() {
                $(this).closest('.row').remove();
            });
        });

        $('.dropify-clear').click(function() {
            var url = $('.dropify').data('url');
            $.ajax({
                type: "get",
                url: url,
                success: function(data) {
                    alertify.success(@json(__('The image has been successfully deleted')));
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

        var path = "{{ route('Office.Property.autocomplete') }}";

        $(document).on("focus", ".search", function() {
            $(this).autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: path,
                        type: 'GET',
                        dataType: "json",
                        data: {
                            search: request.term
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $(this).val(ui.item.label);
                    console.log(ui.item);
                    return false;
                }
            });
        });

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
<input type="text" required name="qty[]" class="form-control" placeholder="@lang('value')" value="" />
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
    $(document).ready(function() {
        var allProperties = {!! json_encode($properties) !!};
        function refreshProperties(properties, selectedPropertyId = null) {
            var propertySelect = $('#propertySelect');
            propertySelect.empty();
            propertySelect.append('<option value="">@lang('without')</option>');

            $.each(properties, function(key, property) {
                propertySelect.append('<option value="' + property.id + '"' + (property.id == selectedPropertyId ? ' selected' : '') + '>' + property.name + '</option>');
            });
        }

        $('#projectSelect').on('change', function() {
            var projectId = $(this).val();

            if (projectId) {
                $.ajax({
                    url: '{{ route('Office.GetPropertiesByProject', '') }}/' + projectId,
                    type: 'GET',
                    success: function(response) {
                    refreshProperties(response.properties, '{{ $Unit->property_id }}');
                },
                    error: function(error) {
                        console.error('Error fetching properties:', error);
                    }
                });
            } else {
                refreshProperties(allProperties);
            }
        });

        var initialProjectId = $('#projectSelect').val();
        if (initialProjectId) {
            $('#projectSelect').trigger('change');
        } else {
            refreshProperties(allProperties, '{{ $Unit->property_id }}');
        }
    });
</script>

            
    <script>
               document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.remove-image').forEach(button => {
                    button.addEventListener('click', function () {
                        var imageId = this.getAttribute('data-id');
                        this.closest('.image-container').remove();
                        $.ajax({
                            url: '{{ route('Broker.UnitImage.destroy', '') }}/' + imageId,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                console.log('Image deleted');
                            }
                        });
                    });
                });

                document.querySelector('.remove-video').addEventListener('click', function () {
                    this.closest('.video-container').remove();
                    $.ajax({
                        url: '{{ route('Broker.UnitVideo.destroy', $Unit->id) }}',
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log('Video deleted');
                        }
                    });
                });

                document.querySelector('#imageInput').addEventListener('change', function() {
                    if (this.files.length > 0) {
                        document.querySelector('#currentImages').innerHTML = '';
                    }
                });

                document.querySelector('#videoInput').addEventListener('change', function() {
                    if (this.files.length > 0) {
                        document.querySelector('#currentVideo').innerHTML = '';
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
        $('#button-addon1').click(function() {
            $('#imageInput').val('');

        });
    </script>
     <script>
        $('#button-addon2').click(function() {
            $('#videoInput').val('');
        });
    </script>
     <script>
        $('#button-addon3').click(function() {
            $('#projectMasterplan').val('');
        });
    </script>
    @endpush
@endsection
