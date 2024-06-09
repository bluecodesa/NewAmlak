@extends('Admin.layouts.app')
@section('title', __('Show'))
@section('content')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <h4 class=""><a href="{{ route('Office.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                    <a href="{{ route('Office.Employee.index') }}" class="text-muted fw-light">@lang('Employees') </a> /
                    @lang('Show')
                </h4>
            </div>
        </div>

        <div class="col-xl-12">
            <div class="nav-align-top nav-tabs-shadow mb-4">
                <ul class="nav nav-tabs nav-fill" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-justified-home" aria-controls="navs-justified-home"
                            aria-selected="true">
                            <i class="tf-icons ti ti-user ti-xs me-1"></i> @lang('profile')
                            <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">3</span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-justified-messages" aria-controls="navs-justified-messages"
                            aria-selected="false">
                            <i class="tf-icons ti ti-message-dots ti-xs me-1"></i> @lang('Permissions')
                        </button>
                    </li>
                </ul>
                <div class="tab-content">
                    @include('Admin.layouts.Inc._errors')

                    <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">
                        <div class="row">
                            <input type="text" name="key_phone" hidden value="966" id="key_phone">
                            <input type="text" name="full_phone" hidden id="full_phone" value="966">

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Name') }}</label>
                                    <input type="text" id="modalRoleName" name="name" value="{{ $employee->UserData->name }}"
                                        class="form-control" placeholder="{{ __('Name') }}" disabled>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label"> @lang('Email')</label>
                                    <input type="email" name="email" class="form-control" value="{{ $employee->UserData->email }}"
                                        placeholder="@lang('Email')" disabled>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label"> @lang('phone')</label>
                                    <div class="input-group">
                                        <input type="text" placeholder="123456789" id="phone" name="phone"
                                            value="{{ $employee->UserData->phone }}" class="form-control" maxlength="9"
                                            pattern="\d{1,9}" aria-label="Text input with dropdown button" disabled>
                                        <button class="btn btn-outline-primary dropdown-toggle waves-effect" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false" disabled>
                                            966
                                        </button>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="tab-pane fade" id="navs-justified-messages" role="tabpanel">
                        <div class="col-12 mt-3">
                            <h4>@lang('Permissions')</h4>
                            <div class="mb-3">
                                <div class="col-12" id="Select_All">
                                    <div class="form-check">
                                        <input class="form-check-input all-checkbox" type="checkbox" id="all" disabled />
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
                                                                    value="{{ $model }}" type="checkbox" id="{{ $model }}"
                                                                    disabled />
                                                                <label class="form-check-label" for="{{ $model }}">
                                                                    @lang('Select/Deselect All')
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        @foreach ($permissions as $item)
                                                            <div class="col-md-3">
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" name="permissions[]"
                                                                        data-model="{{ $model }}" value="{{ $item->id }}"
                                                                        type="checkbox" id="{{ $item->id }}"
                                                                        @if(in_array($item->id, $employeePermissions)) checked @endif
                                                                        disabled />
                                                                    <label class="form-check-label" for="{{ $item->id }}">
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
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <button type="button" class="btn btn-secondary me-1" onclick="window.history.back()">
                            {{ __('Back') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
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
