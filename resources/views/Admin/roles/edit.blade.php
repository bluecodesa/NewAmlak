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
                                        @lang('Add New Role')</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <form action="{{ route('Admin.roles.update', $role->id) }}" method="POST" class="row">
                                    @csrf
                                    @method('PUT')

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label"
                                                for="modalRoleName">{{ __('Enter the name of the role in English') }}</label>
                                            <input type="text" id="modalRoleName" value="{{ $role->name }}"
                                                name="name" class="form-control"
                                                placeholder="{{ __('Enter the name of the role in English') }}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="modalRoleNamear">
                                                {{ __('Enter the name of the role in Arabic') }}</label>
                                            <input type="text" id="modalRoleName" value="{{ $role->name_ar }}"
                                                name="name_ar" class="form-control"
                                                placeholder="{{ __('Enter the name of the role in Arabic') }}">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label" for="modalRoleNamear"> @lang('Role type')</label>
                                        <div class="d-flex">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input TypeUser" data-hide="admin" type="radio"
                                                    name="type" value="user" id="customradio1"
                                                    {{ $role->type == 'user' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="customradio1">@lang('User')</label>
                                            </div>
                                            <div class="form-check mb-2 mx-2">
                                                <input class="form-check-input TypeUser"
                                                    {{ $role->type == 'admin' ? 'checked' : '' }} data-hide="user"
                                                    type="radio" name="type" value="admin" id="customradio2">
                                                <label class="form-check-label" for="customradio2">@lang('Admin')</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-3">
                                        <h4>@lang('Permissions')</h4>
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
                                                @foreach ($permissions->groupBy('model') as $model => $permissions)
                                                    <div class="col-md-12 col-xl-12 {{ $permissions[0]->type }}">
                                                        <div class="card shadow-none bg-transparent border-primary mb-0">
                                                            <div class="card-body p-3 px-0">
                                                                <h4 class="card-title">{{ __($model) }}</h4>
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
                                                                                    @if (in_array($item->id, $role_permissions)) checked @endif
                                                                                    value="{{ $item->id }}"
                                                                                    type="checkbox"
                                                                                    id="{{ $item->id }}" />
                                                                                <label class="form-check-label"
                                                                                    for="{{ $item->id }}">
                                                                                    {{ __($item->name) }} </label>
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
                                        <button type="submit" class="btn btn-main me-1">
                                            <i class="fe-check"></i>
                                            {{ __('save') }}
                                        </button>
                                        <button type="reset" class="btn btn-outline-info">
                                            <i class="fe-x-circle"></i>
                                            {{ __('cancle') }}
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

                    $('.TypeUser').on('click', function() {

                        var show = $(this).val();
                        var hide = $(this).data('hide');
                        $('.' + show).css('display', 'block')
                        $('.' + hide).css('display', 'none');
                    });

                });
            </script>
        @endpush
    </div>
@endsection
