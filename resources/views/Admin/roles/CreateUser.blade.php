@extends('Admin.layouts.app')
@section('title', __('Add New Role'))
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
                                        @lang('Add New Role User')</h4>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('Admin.roles.create') }}">@lang('Add New Role User')</a></li>
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('Admin.roles.index') }}">@lang('Roles')</a></li>
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('Admin.home') }}">@lang('dashboard')</a></li>
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
                                <form action="{{ route('Admin.roles.store') }}" method="POST" class="row">
                                    @csrf
                                    @method('post')
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="modalRoleNamear">
                                                {{ __('Enter the name of the role in Arabic') }} <span
                                                    class="required-color">*</span></label>
                                            <input type="text" required id="modalRoleName" name="name_ar"
                                                class="form-control"
                                                placeholder="{{ __('Enter the name of the role in Arabic') }}">
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label"
                                                for="modalRoleName">{{ __('Enter the name of the role in English') }} <span
                                                    class="required-color">*</span></label>
                                            <input type="text" required id="modalRoleName" name="name"
                                                class="form-control"
                                                placeholder="{{ __('Enter the name of the role in English') }}">
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <label class="form-label" for="modalRoleNamear"> @lang('Role type') <span
                                                class="required-color">*</span></label>
                                        <div class="d-flex">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input TypeUser" data-hide="admin" checked
                                                    type="radio" name="type" value="user" id="customradio1">
                                                <label class="form-check-label" for="customradio1">@lang('User')</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-3">
                                        <h4>@lang('Permissions') <span class="required-color">*</span></h4>
                                        <!-- Permission table -->
                                        <div class="mb-3">
                                            <div class="col-12" id="Select_All">
                                                <div class="form-check">
                                                    <input class="form-check-input all-checkbox" type="checkbox"
                                                        id="all" />
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
                                                                    {{ $permissions[0]->SectionDate->name }}</h4>
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input model-checkbox"
                                                                                value="{{ $model }}" type="checkbox"
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
                                                                                    name="permission[]"
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
                $(document).ready(function() {
                    $('.model-checkbox').on('click', function() {
                        var model = $(this).val();
                        var checkboxes = $('input[name="permission[]"][data-model="' + model + '"]');
                        checkboxes.prop('checked', $(this).prop('checked'));
                    });

                    $('.all-checkbox').on('click', function() {
                        var model = $(this).val();
                        var checkboxes = $('input[name="permission[]"]');
                        checkboxes.prop('checked', $(this).prop('checked'));
                    });


                });
            </script>
        @endpush
    </div>
@endsection