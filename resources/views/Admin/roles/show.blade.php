@extends('Admin.layouts.app')
@section('title', __('Role Information'))
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
                                        @lang('Role Information')</h4>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item"><a href="{{ route('Admin.roles.show', $role->id) }}">@lang('Role Information')</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('Admin.roles.index') }}">@lang('Roles')</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('Admin.home') }}">@lang('dashboard')</a></li>
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
                                <div class="mb-3 row">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-end text-start"><strong>@lang('role name'):</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        {{ app()->getLocale() == 'ar' ? $role->name_ar : $role->name ?? '' }}                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="roles"
                                        class="col-md-4 col-form-label text-md-end text-start"><strong>@lang('Permissions'):</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">

                                        @foreach ($rolePermissions as $permission)
                                        <span
                                            class="badge badge-primary">{{ app()->getLocale() == 'ar' ? $permission->name_ar : $permission->name }}</span>
                                        @if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div>
        <!-- container-fluid -->

    </div>
@endsection
