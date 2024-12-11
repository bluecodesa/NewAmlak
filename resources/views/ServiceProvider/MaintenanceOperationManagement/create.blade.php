@extends('Admin.layouts.app')
@section('title', __('Add New service'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6">

                    <h4 class=""><a href="{{ route('ServiceProvider.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('ServiceProvider.ProviderService.index') }}" class="text-muted fw-light">@lang('Services') </a> /
                        @lang('Add New service')
                    </h4>
                </div>

            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @include('Admin.layouts.Inc._errors')
                        <div class="card-body">
                            <form action="{{ route('ServiceProvider.ProviderService.store') }}" method="POST" class="row">
                                @csrf
                                @method('post')


                                <div class="col-md-6 col-12 mb-3">
                                    <label class="form-label">@lang('service type') <span class="required-color">*</span>
                                    </label>
                                    <select class="form-select" id="provider_service_type_id" name="provider_service_type_id" required>
                                        <option disabled selected value="">@lang('service type')</option>
                                        @foreach($providerServiceTypes as $providerServiceType)
                                            <option value="{{ $providerServiceType->id }}">{{ $providerServiceType->name }}</option>
                                        @endforeach
                                    </select>

                                </div>

                                <div class="col-md-6 col-12 mb-3">

                                    <label class="form-label">
                                        {{ __('price') }} <span class="required-color">*</span></label>
                                    <input type="number" required id="modalRoleName" name="price" class="form-control"
                                        placeholder="{{ __('price') }}">

                                </div>


                                <div class="col-md-6 col-12 mb-3">
                                    <label class="form-label"> @lang('Description')</label>
                                            <textarea id="textarea"  name="description" class="form-control"
                                            placeholder="@lang('Description')"></textarea>

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

    @push('scripts')
        <script>
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
            //


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
