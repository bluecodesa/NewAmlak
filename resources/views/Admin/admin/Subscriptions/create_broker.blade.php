@extends('Admin.layouts.app')

@section('title', __('Add New Subscriber'))

@section('content')



    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6">

                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Admin.Subscribers.index') }}" class="text-muted fw-light">@lang('Subscribers') </a> /
                        @lang('Add New Subscriber')
                    </h4>
                </div>

            </div>


            <!-- DataTable with Buttons -->
            <div class="card">
                @include('Admin.layouts.Inc._errors')
                <div class="card-body">

                    <form action="{{ route('Admin.Subscribers.CreateBroker') }}" class="row" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="key_phone" hidden value="996" id="key_phone">
                        <input type="text" name="full_phone" hidden id="full_phone" value="996">
                        <div class="col-md-6 col-12 mb-3">
                            <label for="name" class="form-label"> @lang('Broker name')<span
                                    class="text-danger">*</span></label>

                            <input type="text" class="form-control" id="name" name="name" required>

                        </div>
                        <div class="col-md-6 col-12 mb-3">
                            <label for="license_number" class="form-label"> @lang('license number')<span
                                    class="text-danger">*</span></label>

                            <input type="text" class="form-control" id="license_number" name="license_number" required>
                        </div>


                        <div class="col-md-6 col-12 mb-3">
                            <label for="email" class="form-label">@lang('Email')<span
                                    class="text-danger">*</span></label>

                            <input type="email" class="form-control" id="email" name="email">

                        </div>

                        <div class="col-md-6 col-12 mb-3">
                            <label for="mobile" class="form-label">@lang('Mobile Whats app')<span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" placeholder="123456789" name="mobile" id="phone" value=""
                                    class="form-control" maxlength="9" pattern="\d{1,9}" oninput="updateFullPhone(this)"
                                    aria-label="Text input with dropdown button">
                                <button class="btn btn-outline-primary dropdown-toggle waves-effect" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    996
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" style="">
                                    <li><a class="dropdown-item" data-key="971" href="javascript:void(0);">971</a></li>
                                    <li><a class="dropdown-item" data-key="996" href="javascript:void(0);">996</a></li>
                                </ul>

                            </div>
                        </div>

                        <div class="form-group col-md-4 col-12 mb-3">
                            <label class="form-label">@lang('Region') <span class="text-danger">*</span></label>
                            <select class="form-select" id="Region_id" name="region_id" required>
                                <option disabled selected value="">@lang('Region')</option>
                                @foreach ($Regions as $Region)
                                    <option value="{{ $Region->id }}"
                                        data-url="{{ route('Home.Region.show', $Region->id) }}">
                                        {{ $Region->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4 col-12 mb-3">
                            <label class="form-label">@lang('city') <span class="text-danger">*</span> </label>
                            <select class="form-select" name="city_id" id="CityDiv" required>
                            </select>
                        </div>

                        <div class="col-md-4 col-12 mb-3">
                            <label for="package" class="form-label"> @lang('Subscription Type') <span
                                    class="text-danger">*</span></label>
                            <select type="package" class="form-select" name="subscription_type_id" required="">
                                <option value="" selected disabled> @lang('Subscription Type') </option>
                                @foreach ($subscriptionTypes as $subscriptionType)
                                    <option value="{{ $subscriptionType->id }}">
                                        {{ $subscriptionType->name }}</option>
                                @endforeach
                            </select>
                        </div>





                        <div class="form-password-toggle col-md-4 col-12 mb-3">
                            <label class="form-label" for="basic-default-password33">@lang('password') <span
                                    class="text-danger">*</span> </label>
                            <div class="input-group input-group-merge">
                                <input type="password" class="form-control" name="password"
                                    id="basic-default-password33" placeholder="············" required
                                    aria-describedby="basic-default-password">
                                <span class="input-group-text cursor-pointer" id="basic-default-password"><i
                                        class="ti ti-eye-off"></i></span>
                            </div>
                        </div>


                        <div class="form-password-toggle col-md-4 col-12 mb-3">
                            <label class="form-label" for="basic-default-password32">@lang('Confirm Password') <span
                                    class="text-danger">*</span> </label>
                            <div class="input-group input-group-merge">
                                <input type="password" class="form-control" name="password_confirmation"
                                    id="basic-default-password32" placeholder="············" required
                                    aria-describedby="basic-default-password">
                                <span class="input-group-text cursor-pointer" id="basic-default-password"><i
                                        class="ti ti-eye-off"></i></span>
                            </div>
                        </div>


                        <div class="col-md-4 col-12 mb-3">
                            <label for="id_number" class="form-label">@lang('id number')</label>
                            <input type="text" class="form-control"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 9);" id="id_number"
                                name="id_number">
                        </div>

                        <div class="col-md-4 mb-6 col-12 mb-3">
                            <label for="broker_logo">@lang('Broker logo')</label>
                            <span class="not_required">(@lang('optional'))</span>
                            <input type="file" class="form-control d-none" id="broker_logo" name="broker_logo"
                                accept="image/png, image/jpg, image/jpeg">
                            <img id="broker_logo_preview" src="url('HOME_PAGE/img/avatars/14.png')"
                                class="d-flex mr-3 rounded-circle" height="64" style="cursor: pointer;" />

                        </div>




                        <div class="col-md-12">
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">@lang('Cancel')</a>

                            <button type="submit"
                                class="btn btn-primary waves-effect waves-light">@lang('Submit')</button>
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
            $(document).ready(function() {
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
                                // Empty the city select element
                                $(this).empty();
                                // Append the new options based on the received data
                                $.each(data, function(key, city) {
                                    $('#CityDiv').append($('<option>', {
                                        value: city.id,
                                        text: city.name
                                    }));
                                });
                                // Fade in the city select element with new options
                                $(this).fadeIn('fast');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                });
            });

            $('#broker_logo_preview').click(function() {
                $('#broker_logo').click(); // Trigger file input click on image click
            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#broker_logo_preview').attr('src', e.target.result); // Update the preview image
                    };

                    reader.readAsDataURL(input.files[0]); // Convert image to base64 string
                }
            }

            $("#broker_logo").change(function() {
                readURL(this); // Call readURL function when a file is selected
            });
        </script>
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
        </script>
    @endpush

@endsection
