@extends('Admin.layouts.app')
@section('title', __('Role Information'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 py-3 mb-1">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Admin.roles.index') }}" class="text-muted fw-light">@lang('Roles')
                        </a> /
                        @lang('Role Information')
                    </h4>
                </div>

            </div>
            <!-- DataTable with Buttons -->
            <div class="card m-b-30">
                @include('Admin.layouts.Inc._errors')
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <button type="button"
                                class="btn btn-primary waves-effect">{{ app()->getLocale() == 'ar' ? $role->name_ar : $role->name ?? '' }}</button>
                        </div>
                        <div class="divider divider-success">
                            <div class="divider-text"> @lang('Permissions') </div>
                        </div>

                        <div class="col-12">

                            <table class="table" id="table">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('Name')</th>
                                        <th>@lang('Model')</th>
                                        <th>@lang('user type')</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @forelse ($rolePermissions as $index=> $permission)
                                        <tr>
                                            <th>{{ $index + 1 }}</th>
                                            <td>{{ app()->getLocale() == 'ar' ? $permission->name_ar : $permission->name }}
                                            </td>
                                            <td>{{ $permission->SectionDate->name ?? '' }}</td>
                                            <td>{{ __($permission->type) ?? '' }}</td>
                                        </tr>
                                    @empty

                                        <td colspan="5">
                                            <div class="alert alert-info d-flex align-items-center" role="alert">
                                                <span class="alert-icon text-info me-2">
                                                    <i class="ti ti-info-circle ti-xs"></i>
                                                </span>
                                                @lang('No Data Found!')
                                            </div>

                                        </td>
                                    @endforelse

                                </tbody>
                            </table>


                        </div>

                    </div>





                </div>
            </div>
            <!-- Modal to add new record -->

            <!--/ DataTable with Buttons -->


        </div>

        <div class="content-backdrop fade"></div>
    </div>


@endsection
