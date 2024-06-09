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
                    <form action="{{ route('Admin.Subscribers.store') }}" method="POST" class="row"
                        enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <input type="text" name="key_phone" hidden value="996" id="key_phone">
                        <input type="text" name="full_phone" hidden id="full_phone" value="996">
                        <div class="col-md-4 col-12 mb-3">
                            <label class="form-label" for="company_name"> @lang('Company Name')<span
                                class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="@lang('Company Name')" id="company_name" name="name">

                        </div>
                        <div class="col-md-4 col-12 mb-3">
                            <label class="form-label" for="name"> @lang('Commercial Registration No')<span
                                class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="@lang('Commercial Registration No')" id="CR_number"
                                    required name="CRN" value="">
                        </div>

                        <div class="col-md-4 col-12 mb-3">
                            <label for="presenter_email">@lang('Company email') <span class="text-danger">*</span>
                            </label>

                            <input type="email" class="form-control" id="presenter_email" value="" name="email"
                                required="" placeholder="@lang('Company email')">
                        </div>

                        <div class="col-md-4 col-12 mb-3">
                            <label class="form-label" for="mobile">@lang('Company Mobile')<span
                                class="text-danger">*</span></label>

                        <div class="input-group">
                            <input type="text" placeholder="123456789" id="phone" name="phone"
                                value="" class="form-control" maxlength="9" pattern="\d{1,9}"
                                oninput="updateFullPhone(this)"
                                aria-label="Text input with dropdown button">
                            <button class="btn btn-outline-primary dropdown-toggle waves-effect"
                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                996
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" style="">
                                <li><a class="dropdown-item" data-key="971"
                                        href="javascript:void(0);">971</a></li>
                                <li><a class="dropdown-item" data-key="966"
                                        href="javascript:void(0);">966</a></li>
                            </ul>

                        </div>
                        </div>
                        <div class="col-md-4 col-12 mb-3">
                            <label>@lang('Region') <span class="text-danger">*</span> </label>
                            <select class="form-select" id="Region_id" required>
                                <option disabled selected value="">@lang('Region')</option>
                                @foreach ($Regions as $Region)
                                    <option value="{{ $Region->id }}"
                                        data-url="{{ route('Admin.Region.show', $Region->id) }}">
                                        {{ $Region->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 col-12 mb-3">
                            <label>@lang('city') <span class="text-danger">*</span> </label>
                            <select class="form-select" name="city_id" id="CityDiv" required>
                            </select>
                        </div>


                        <div class="col-md-6 col-12 mb-3">
                            <label for="package"> @lang('Subscription Type') <span class="text-danger">*</span></label>
                            <select type="package" class="form-select" name="subscription_type_id" required="">
                                <option value="" selected disabled> @lang('Subscription Type') </option>
                                @foreach ($subscriptionTypes as $subscriptionType)
                                    <option value="{{ $subscriptionType->id }}">
                                        {{ $subscriptionType->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 col-12 mb-3">
                            <img src="{{ asset('HOME_PAGE/img/avatars/14.png') }}" alt="user-avatar"
                            class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
                        <div class="button-wrapper">
                            <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                                <span class="d-none d-sm-block">@lang('Company logo')</span>
                                <i class="ti ti-upload d-block d-sm-none"></i>
                                <input type="file" id="upload" class="account-file-input"
                                    name="company_logo" hidden accept="image/png, image/jpeg" />
                            </label>
                            <button type="button" id="account-image-reset"
                                class="btn btn-label-secondary account-image-reset mb-3">
                                <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">@lang('إعادة تعيين الصورة')</span>
                            </button>

                            <div class="text-muted">Allowed JPG, GIF or PNG. Max size of 800K</div>
                        </div>
                        </div>

                        <div class="form-password-toggle col-md-6 col-12 mb-3">
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


                        <div class="form-password-toggle col-md-6 col-12 mb-3">
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


                        <div class="col-12">
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">@lang('Cancel')</a>
                            <button type="submit"
                                class="btn btn-primary waves-effect waves-light">@lang('save')</button>

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
            //

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


    function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#uploadedAvatar').attr('src', e.target.result); // Update the preview image
                };

                reader.readAsDataURL(input.files[0]); // Convert image to base64 string
            }
        }

        $("#upload").change(function() {
            readURL(this); // Call readURL function when a file is selected
        });
        // JavaScript to handle the reset button functionality
        $('#account-image-reset').click(function() {
            // Reset the file input by clearing its value
            $('#upload').val('');

            // Reset the preview image to the default avatar
            $('#uploadedAvatar').attr('src', '{{ asset('HOME_PAGE/img/avatars/14.png') }}');
        });


</script>
    @endpush

@endsection
