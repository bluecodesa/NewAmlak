@extends('Admin.layouts.app')
@section('title', __('Add New Owner'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 ">

                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Broker.Owner.index') }}" class="text-muted fw-light">@lang('owners')
                        </a> /
                        @lang('Add New Owner')
                    </h4>
                </div>
            </div>
            <!-- DataTable with Buttons -->
            <div class="card">
                @include('Admin.layouts.Inc._errors')
                <div class="card-body">
                    <form action="{{ route('Broker.Owner.store') }}" method="POST" class="row">
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

                        <div class="col-md-6 col-12 mb-3">
                            <label for="id_number" class="form-label">@lang('id number')<span
                                class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="id_number" name="id_number" required>
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
                            <label class="form-label">@lang('Region') </label>
                            <select class="form-select" id="Region_id" required>
                                <option disabled selected value="">@lang('Region')</option>
                                @foreach ($Regions as $Region)
                                    <option value="{{ $Region->id }}"
                                        data-url="{{ route('Broker.Broker.GetCitiesByRegion', $Region->id) }}">
                                        {{ $Region->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label">@lang('city') </label>
                            <select class="form-select" name="city_id" id="CityDiv" required>

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

 <!-- Modal to confirm adding new owner -->
 <div class="modal fade" id="confirmOwnerModal" tabindex="-1" aria-labelledby="confirmOwnerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmOwnerModalLabel">Confirm Owner Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>This account is already registered as a <span id="user-role"></span>.</p>
                <p>Name: <span id="user-name"></span></p>
                <p>Email: <span id="user-email"></span></p>
                <p>ID Number: <span id="user-id-number"></span></p>
                <p>Do you want to add them as an owner?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmAddOwner">Yes, Add as Owner</button>
            </div>
        </div>
    </div>
</div>


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
