@extends('Admin.layouts.app')
@section('title', __('Add New Role Admin'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 ">

                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Admin.roles.index') }}" class="text-muted fw-light">@lang('Roles')
                        </a> /
                        @lang('Add New Role Admin')
                    </h4>
                </div>
            </div>
            <!-- DataTable with Buttons -->
            <div class="card">
                @include('Admin.layouts.Inc._errors')
                <div class="card-body">
                    <form action="{{ route('Admin.roles.store') }}" method="POST" class="row">
                        @csrf
                        @method('post')
                        <div class="col-md-6 col-12 mb-3">

                            <label class="form-label" for="modalRoleNamear">
                                {{ __('Enter the name of the role in Arabic') }} <span
                                    class="required-color">*</span></label>
                            <input type="text" required id="modalRoleName" name="name_ar" class="form-control"
                                placeholder="{{ __('Enter the name of the role in Arabic') }}">
                        </div>


                        <div class="col-md-6 col-12 mb-3">

                            <label class="form-label" for="modalRoleName">{{ __('Enter the name of the role in English') }}
                                <span class="required-color">*</span></label>
                            <input type="text" required id="modalRoleName" name="name" class="form-control"
                                placeholder="{{ __('Enter the name of the role in English') }}">

                        </div>

                        <div class="col-md-4 col-12 mb-3">
                            <label class="form-label" for="modalRoleNamear"> @lang('Role type') <span
                                    class="required-color">*</span></label>
                            <div class="d-flex">

                                <div class="form-check mb-2 mx-2">
                                    <input class="form-check-input TypeUser" data-hide="user" type="radio" name="type"
                                        value="admin" id="customradio2" checked="">
                                    <label class="form-check-label" for="customradio2">@lang('Admin')</label>
                                </div>
                            </div>
                        </div>

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
                                                        {{ $permissions[0]->SectionDate->name }}</h4>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-check">
                                                                <input class="form-check-input model-checkbox"
                                                                    value="{{ $model }}" type="checkbox"
                                                                    id="{{ $model }}" />
                                                                <label class="form-check-label" for="{{ $model }}">
                                                                    @lang('Select/Deselect All')
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        @foreach ($permissions as $item)
                                                            <div class="col-md-3">
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" name="permission[]"
                                                                        data-model="{{ $model }}"
                                                                        value="{{ $item->id }}" type="checkbox"
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
                            <button type="submit" class="btn btn-primary waves-effect waves-light">
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

                $('.TypeUser').on('click', function() {

                    var show = $(this).val();
                    var hide = $(this).data('hide');
                    $('.' + show).css('display', 'block')
                    $('.' + hide).css('display', 'none');
                });

            });
        </script>
    @endpush

@endsection
