@extends('Admin.layouts.app')
@section('title', __('Add New'))
@section('content')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <h4 class=""><a href="{{ route('Office.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                    <a href="{{ route('Office.Employee.index') }}" class="text-muted fw-light">@lang('Employees') </a> /
                    @lang('Add New Employee')
                </h4>
            </div>
        </div>

        <div class="col-xl-12">
            <div class="nav-align-top nav-tabs-shadow mb-4">
              <ul class="nav nav-tabs nav-fill" role="tablist">
                <li class="nav-item">
                  <button
                    type="button"
                    class="nav-link active"
                    role="tab"
                    data-bs-toggle="tab"
                    data-bs-target="#navs-justified-home"
                    aria-controls="navs-justified-home"
                    aria-selected="true">
                    <i class="tf-icons ti ti-user ti-xs me-1"></i> @lang('profile')
                    <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">3</span>
                  </button>
                </li>

                <li class="nav-item">
                  <button
                    type="button"
                    class="nav-link"
                    role="tab"
                    data-bs-toggle="tab"
                    data-bs-target="#navs-justified-messages"
                    aria-controls="navs-justified-messages"
                    aria-selected="false">
                    <i class="tf-icons ti ti-message-dots ti-xs me-1"></i> @lang('Permissions')
                  </button>
                </li>
              </ul>
              <div class="tab-content">
                @include('Admin.layouts.Inc._errors')

                    <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">
                        <form action="{{ route('Office.Employee.store') }}" method="POST" class="row">
                            @csrf
                            @method('post')

                            <input type="text" name="key_phone" hidden value="966" id="key_phone">
                            <input type="text" name="full_phone" hidden id="full_phone" value="966">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ __('Name') }} <span class="required-color">*</span></label>
                                    <input type="text" required id="modalRoleName" name="name"
                                        class="form-control" placeholder="{{ __('Name') }}">
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label"> @lang('Email') <span
                                            class="required-color">*</span></label>
                                    <input type="email" required name="email" class="form-control"
                                        placeholder="@lang('Email')">
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label"> @lang('phone') <span
                                            class="required-color">*</span></label>

                                            <div class="input-group">
                                                <input type="text" placeholder="123456789" id="phone" name="phone"
                                                    value="" class="form-control" maxlength="9" pattern="\d{1,9}"
                                                    oninput="updateFullPhone(this)"
                                                    aria-label="Text input with dropdown button">
                                                <button class="btn btn-outline-primary dropdown-toggle waves-effect"
                                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    966
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" style="">
                                                    <li><a class="dropdown-item" data-key="971"
                                                            href="javascript:void(0);">971</a></li>
                                                    <li><a class="dropdown-item" data-key="966"
                                                            href="javascript:void(0);">966</a></li>
                                                </ul>

                                            </div>
                                </div>
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
                    </div>
                    <div class="tab-pane fade" id="navs-justified-messages" role="tabpanel">

                        <div class="col-12 mt-3">
                            <h4>@lang('Permissions') <span class="required-color">*</span></h4>
                            <!-- Permission table -->
                            <div class="mb-3">
                                <div class="col-12" id="Select_All">
                                    <div class="form-check">
                                        <input class="form-check-input all-checkbox" type="checkbox" id="all" />
                                        <label class="form-check-label" for="all">
                                            @lang('Select/Deselect All')
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12" id="permissions">
                                    @foreach ($permissions->groupBy('section_id') as $model => $permissions)
                                    <div class="col-md-12 col-xl-12">
                                        <div class="card shadow-none bg-transparent border-primary mb-0">
                                            <div class="card-body p-3 px-0">
                                                <h4 class="card-title">
                                                    {{ $permissions[0]->SectionDate->name }}
                                                </h4>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-check">
                                                            <input class="form-check-input model-checkbox"
                                                                   value="{{ $model }}"
                                                                   type="checkbox"
                                                                   id="{{ $model }}" />
                                                            <label class="form-check-label"
                                                                   for="{{ $model }}">
                                                                @lang('Select/Deselect All')
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    @foreach ($permissions as $item)
                                                        <div class="col-md-3">
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input"
                                                                       name="permissions[]"
                                                                       data-model="{{ $model }}"
                                                                       value="{{ $item->id }}"
                                                                       type="checkbox"
                                                                       id="{{ $item->id }}" />
                                                                <label class="form-check-label"
                                                                       for="{{ $item->id }}">
                                                                    {{ app()->getLocale() == 'ar' ? $item->name_ar : $item->name }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach


                                </div>
                            </div>
                            <!-- Permission table -->
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <button type="submit" class="btn btn-primary me-1">

                            {{ __('save') }}
                        </button>

                    </div>
                </form>
              </div>
            </div>
        </div>




    </div> <!-- end row -->
</div>
        <!-- container-fluid -->

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