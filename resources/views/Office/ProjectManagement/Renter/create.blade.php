@extends('Admin.layouts.app')
@section('title', __('Add New Renter'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 ">

                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Office.Renter.index') }}" class="text-muted fw-light">@lang('Renters')
                        </a> /
                        @lang('Add New Renter')
                    </h4>
                </div>
            </div>
            <!-- DataTable with Buttons -->
            <div class="card">
                @include('Admin.layouts.Inc._errors')
                <div class="card-body">
                    <form action="{{ route('Office.Renter.store') }}" method="POST" class="row">
                        <input type="text" name="key_phone" hidden value="966" id="key_phone">
                        <input type="text" name="full_phone" hidden id="full_phone" value="966">
                        @csrf
                        @method('post')
                        <div class="col-md-6 col-12 mb-3">

                            <label class="form-label">
                                {{ __('Name') }} <span class="required-color">*</span></label>
                            <input type="text" required id="modalRoleName" name="name" class="form-control"
                                placeholder="{{ __('Name') }}">

                        </div>

                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label"> @lang('Email') <span class="required-color">*</span></label>
                            <input type="email" required name="email" class="form-control"
                                placeholder="@lang('Email')">
                        </div>

                        <div class="col-12 mb-3 col-md-6">
                            <label for="color" class="form-label">@lang('phone') <span
                                    class="required-color">*</span></label>
                            <div class="input-group">
                                <input type="text" placeholder="123456789" name="phone" id="phone" value=""
                                    class="form-control" maxlength="9" pattern="\d{1,9}" oninput="updateFullPhone(this)"
                                    aria-label="Text input with dropdown button">
                                <button class="btn btn-outline-primary dropdown-toggle waves-effect" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    966
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" style="">
                                    <li><a class="dropdown-item" data-key="971" href="javascript:void(0);">971</a></li>
                                    <li><a class="dropdown-item" data-key="966" href="javascript:void(0);">966</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-6 col-12 mb-3">

                            <label for="id_number" class="form-label">@lang('id number')<span
                                class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="id_number" name="id_number" required>
                        </div>

                        <div class="mb-3 row">

                            <div class="col-md-6">

                                <div class="mb-3 form-password-toggle">
                                    <label class="form-label" for="password">@lang('password') <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" class="form-control"
                                            name="password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="password" required />
                                        <span class="input-group-text cursor-pointer"><i
                                                class="ti ti-eye-off"></i></span>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="mb-3 form-password-toggle">
                                    <label class="form-label" for="password">@lang('Confirm Password') <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password_confirmation" class="form-control"
                                            name="password_confirmation"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="password" required />
                                        <span class="input-group-text cursor-pointer"><i
                                                class="ti ti-eye-off"></i></span>
                                    </div>
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
            <!-- Modal to add new record -->

            <!--/ DataTable with Buttons -->


        </div>

        <div class="content-backdrop fade"></div>
    </div>
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