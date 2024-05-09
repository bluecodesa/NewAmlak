@extends('Admin.layouts.app')
@section('title', __('Edit Role'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 py-3 mb-1">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Admin.roles.index') }}" class="text-muted fw-light">@lang('Roles')
                        </a> /
                        @lang('Edit Role')
                    </h4>
                </div>

            </div>
            <!-- DataTable with Buttons -->
            <div class="card">
                @include('Admin.layouts.Inc._errors')
                <div class="card-body">
                    <form action="{{ route('Admin.roles.update', $role->id) }}" method="POST" class="row">
                        @csrf
                        @method('PUT')

                        <div class="col-md-6 col-12 mb-3">

                            <label class="form-label"
                                for="modalRoleName">{{ __('Enter the name of the role in English') }}</label>
                            <input type="text" id="modalRoleName" value="{{ $role->name }}" name="name"
                                class="form-control" placeholder="{{ __('Enter the name of the role in English') }}">

                        </div>

                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label" for="modalRoleNamear">
                                {{ __('Enter the name of the role in Arabic') }}</label>
                            <input type="text" id="modalRoleName" value="{{ $role->name_ar }}" name="name_ar"
                                class="form-control" placeholder="{{ __('Enter the name of the role in Arabic') }}">
                        </div>

                        <div class="col-4" hidden>
                            <label class="form-label" for="modalRoleNamear"> @lang('Role type')</label>
                            <div class="d-flex">
                                <div class="form-check mb-2">
                                    <input class="form-check-input TypeUser" data-hide="admin" type="radio" name="type"
                                        value="user" id="customradio1" {{ $role->type == 'user' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="customradio1">@lang('User')</label>
                                </div>
                                <div class="form-check mb-2 mx-2">
                                    <input class="form-check-input TypeUser" {{ $role->type == 'admin' ? 'checked' : '' }}
                                        data-hide="user" type="radio" name="type" value="admin" id="customradio2">
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
                                        <input class="form-check-input all-checkbox" type="checkbox" id="all" />
                                        <label class="form-check-label" for="all">
                                            @lang('Select/Deselect All')
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12" id="permissions">
                                    @foreach ($permissions->groupBy('section_id') as $model => $permissions)
                                        <div class="col-md-12 col-12 mb-3">
                                            <div class="card shadow-none bg-transparent border-primary mb-0">
                                                <div class="card-body p-3 px-0">
                                                    <h4 class="card-title">
                                                        {{ $permissions[0]->SectionDate->name ?? '' }}</h4>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-check">
                                                                <input class="form-check-input model-checkbox"
                                                                    value="{{ 'section_' . $model }}" type="checkbox"
                                                                    id="{{ 'section_' . $model }}" />
                                                                <label class="form-check-label"
                                                                    for="{{ 'section_' . $model }}">
                                                                    @lang('Select/Deselect All')
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        @foreach ($permissions as $item)
                                                            {{-- @if ($role->type == $item->type) --}}
                                                            <div class="col-md-3">
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" name="permission[]"
                                                                        data-model="{{ 'section_' . $model }}"
                                                                        @if (in_array($item->id, $role_permissions)) checked @endif
                                                                        value="{{ $item->id }}" type="checkbox"
                                                                        id="{{ $item->id }}" />
                                                                    <label class="form-check-label"
                                                                        for="{{ $item->id }}">
                                                                        {{ app()->getLocale() == 'ar' ? $item->name_ar : $item->name }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            {{-- @endif --}}
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
            <!-- Modal to add new record -->

            <!--/ DataTable with Buttons -->


        </div>

        <div class="content-backdrop fade"></div>
    </div>


@endsection
