@extends('Admin.layouts.app')
@section('title', __('developers'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-sm-6">
                                    <h4 class="page-title">
                                        @lang('Edit') : {{ $Employee->name }} </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            @include('Admin.layouts.Inc._errors')
                            <div class="card-body">
                                <form action="{{ route('Office.Employee.update', $Employee->id) }}" method="POST"
                                    class="row">
                                    @csrf
                                    @method('PUT')
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                {{ __('Name') }} <span class="required-color">*</span></label>
                                            <input type="text" value="{{ $Employee->UserData->name ?? '' }}" required
                                                id="modalRoleName" name="name" class="form-control"
                                                placeholder="{{ __('Name') }}">
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> @lang('Email') <span
                                                    class="required-color">*</span></label>
                                            <input type="email" value="{{ $Employee->UserData->email ?? '' }}" required
                                                name="email" class="form-control" placeholder="@lang('Email')">
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label"> @lang('phone') <span
                                                    class="required-color">*</span></label>
                                            <input type="text" required value="{{ $Employee->UserData->phone ?? '' }}"
                                                name="phone" class="form-control" placeholder="@lang('phone')">
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label class="form-label">@lang('Region') </label>
                                        <select class="form-control" id="Region_id" required>
                                            <option disabled value="">@lang('Region')</option>
                                            @foreach ($Regions as $Region)
                                                <option value="{{ $Region->id }}"
                                                    data-url="{{ route('Office.Office.GetCitiesByRegion', $Region->id) }}"
                                                    {{ $Region->id == $Employee->CityData->RegionData->id ? 'selected' : '' }}>
                                                    {{ $Region->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label class="form-label">@lang('city') </label>
                                        <select class="form-control" name="city_id" id="CityDiv" required>
                                            <option disabled value="">@lang('city')</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}"
                                                    {{ $city->id == $Employee->city_id ? 'selected' : '' }}>
                                                    {{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>



                                    <div class="form-group col-md-3">
                                        <label>@lang('role name') <span class="required-color">*</span> </label>
                                        <select class="form-control" name="roles" required>
                                            <option disabled value="">@lang('role name')</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}"
                                                    {{ $role->id == $Employee->UserData->roles[0]->id ? 'selected' : '' }}>

                                                    {{ app()->getLocale() == 'ar' ? $role->name_ar : $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary me-1">

                                            {{ __('save') }}
                                        </button>

                                    </div>
                                </form>

                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div>
        <!-- container-fluid -->

    </div>
    @push('scripts')
        <script>
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
    @endpush
@endsection
