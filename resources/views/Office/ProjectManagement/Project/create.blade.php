@extends('Admin.layouts.app')
@section('title', __('Add New'))
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
                                        @lang('Add New')</h4>
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
                                <form action="{{ route('Office.Owner.store') }}" method="POST" class="row">
                                    @csrf
                                    @method('post')

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                {{ __('project name') }} <span class="required-color">*</span></label>
                                            <input type="text" required id="modalRoleName" name="name"
                                                class="form-control" placeholder="{{ __('project name') }}">
                                        </div>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>@lang('Region') </label>
                                        <select class="form-control" id="Region_id" required>
                                            <option disabled selected value="">@lang('Region')</option>
                                            @foreach ($Regions as $Region)
                                                <option value="{{ $Region->id }}"
                                                    data-url="{{ route('Admin.Region.show', $Region->id) }}">
                                                    {{ $Region->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>@lang('city') </label>
                                        <select class="form-control" name="city_id" id="CityDiv" required>

                                        </select>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>@lang('Developer name') </label>
                                        <select class="form-control" name="developer_id" required>
                                            <option disabled selected value="">@lang('Developer name')</option>
                                            @foreach ($developers as $developer)
                                                <option value="{{ $developer->id }}">
                                                    {{ $developer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="form-group col-md-3">
                                        <label>@lang('Advisor name') </label>
                                        <select class="form-control" name="advisor_id" required>
                                            <option disabled selected value="">@lang('Advisor name')</option>
                                            @foreach ($advisors as $advisor)
                                                <option value="{{ $advisor->id }}">
                                                    {{ $advisor->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>@lang('Employee Name') </label>
                                        <select class="form-control" name="employee_id" required>
                                            <option disabled selected value="">@lang('Employee Name')</option>
                                            @foreach ($owners as $owner)
                                                <option value="{{ $owner->id }}">
                                                    {{ $owner->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="form-group col-md-3">
                                        <label>@lang('name owner') </label>
                                        <select class="form-control" name="owner_id" required>
                                            <option disabled selected value="">@lang('name owner')</option>
                                            @foreach ($owners as $owner)
                                                <option value="{{ $owner->id }}">
                                                    {{ $owner->name }}</option>
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
