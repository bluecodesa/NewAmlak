@extends('Admin.layouts.app')
@section('title', __('Add New Advisor'))
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
                                        @lang('Add New Advisor')</h4>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item" style="margin-top: 2px;"><a
                                                href="{{ route('Broker.Advisor.create') }}">@lang('Add New Advisor')</a></li>
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('Broker.Advisor.index') }}">@lang('advisors')</a></li>
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('Broker.home') }}">@lang('dashboard')</a></li>
                                    </ol>
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
                                <form action="{{ route('Broker.Advisor.store') }}" method="POST" class="row">
                                    @csrf
                                    @method('post')

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                {{ __('Name') }} <span class="required-color">*</span></label>
                                            <input type="text" required id="modalRoleName" name="name"
                                                class="form-control" placeholder="{{ __('Name') }}">
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> @lang('Email') <span
                                                    class="required-color">*</span></label>
                                            <input type="email" required name="email" class="form-control"
                                                placeholder="@lang('Email')">
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="mb-3">

                                            <label for="phone">@lang('phone')<span
                                                    class="text-danger">*</span></label>
                                            <div style="position:relative">

                                                <input type="tel" class="form-control" id="phone" minlength="9"
                                                    maxlength="9" pattern="[0-9]*"
                                                    oninvalid="setCustomValidity('Please enter 9 numbers.')"
                                                    onchange="try{setCustomValidity('')}catch(e){}" placeholder="599123456"
                                                    name="phone" required="" value="">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>@lang('Region') <span class="required-color">*</span> </label>
                                        <select class="form-control" id="Region_id" required>
                                            <option disabled selected value="">@lang('Region')</option>
                                            @foreach ($Regions as $Region)
                                                <option value="{{ $Region->id }}"
                                                    data-url="{{ route('Broker.Broker.GetCitiesByRegion', $Region->id) }}">
                                                    {{ $Region->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>@lang('city') <span class="required-color">*</span> </label>
                                        <select class="form-control" name="city_id" id="CityDiv" required>

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
