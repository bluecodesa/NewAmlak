@extends('Admin.layouts.app')
@section('title', __('Add New Ticket'))
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
                                        @lang('Add New Ticket')</h4>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item" style="margin-top: 2px;"><a
                                                href="{{ route('Broker.Tickets.create') }}">@lang('Add New Ticket')</a></li>
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('Broker.Tickets.index') }}">@lang('Tickets')</a></li>
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
                                            <label class="form-label">{{ __('Type') }} <span class="required-color">*</span></label>
                                            <select id="modalRoleName" name="type" class="form-control" required>
                                                <option value="option1">{{ __('Option 1') }}</option>
                                                <option value="option2">{{ __('Option 2') }}</option>
                                                <option value="option3">{{ __('Option 3') }}</option>
                                                <!-- Add more options as needed -->
                                            </select>
                                        </div>
                                    </div>



                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> @lang('Ticket Address') <span
                                                    class="required-color">*</span></label>
                                            <input type="text" required name="address" class="form-control"
                                                placeholder="@lang('Ticket Address')">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                {{ __('Description') }} <span class="required-color">*</span></label>
                                                <textarea  class="form-control"  name="desc" id="modalRoleName" cols="50" rows="10" required placeholder="{{ __('Name') }}">@lang('Description')</textarea>

                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="mb-3">

                                            <label for="phone">@lang('Image')
                                            <div style="position:relative">

                                                <input type="file" class="form-control" id="phone"

                                                    name="image" required="" value="">

                                            </div>
                                        </div>
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
