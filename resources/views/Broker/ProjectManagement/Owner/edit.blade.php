@extends('Admin.layouts.app')
@section('title', __('Edit'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 ">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Broker.Owner.index') }}" class="text-muted fw-light">@lang('owners')
                        </a> /
                        @lang('Edit')
                    </h4>
                </div>

            </div>
            <!-- DataTable with Buttons -->
            <div class="card">
                @include('Admin.layouts.Inc._errors')
                <div class="card-body">
                    <form action="{{ route('Broker.Owner.update', $Owner->id) }}" method="POST" class="row">
                        @csrf
                        @method('PUT')
                        <div class="col-md-6 mb-3 col-12">
                                <label class="form-label">
                                    {{ __('Name') }} <span class="required-color">*</span></label>
                                <input type="text" value="{{ $Owner->name }}" required id="modalRoleName"
                                    name="name" class="form-control" placeholder="{{ __('Name') }}">

                        </div>
                        <div class="col-md-6 mb-3 col-12">
                                <label class="form-label"> @lang('Email') <span
                                        class="required-color">*</span></label>
                                <input type="email" value="{{ $Owner->email }}" required name="email"
                                    class="form-control" placeholder="@lang('Email')">

                        </div>


                        <div class="col-md-4 mb-3 col-12">
                                <label class="form-label"> @lang('phone') <span
                                        class="required-color">*</span></label>
                                <input type="text" required value="{{ $Owner->phone }}" name="phone"
                                    class="form-control" placeholder="@lang('phone')">

                        </div>

                        <div class="col-md-4 mb-3 col-12">
                            <label>@lang('Region') <span class="required-color">*</span> </label>
                            <select class="form-select" id="Region_id" required>
                                <option disabled value="">@lang('Region')</option>
                                @foreach ($Regions as $Region)
                                    <option value="{{ $Region->id }}"
                                        data-url="{{ route('Broker.Broker.GetCitiesByRegion', $Region->id) }}"
                                        {{ $Region->id == $Owner->CityData->RegionData->id ? 'selected' : '' }}>
                                        {{ $Region->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3 col-12">
                            <label>@lang('city') <span class="required-color">*</span> </label>
                            <select class="form-select" name="city_id" id="CityDiv" required>
                                <option disabled value="">@lang('city')</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}"
                                        {{ $city->id == $Owner->city_id ? 'selected' : '' }}>
                                        {{ $city->name }}</option>
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
            <!-- Modal to add new record -->

            <!--/ DataTable with Buttons -->


        </div>

        <div class="content-backdrop fade"></div>
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
