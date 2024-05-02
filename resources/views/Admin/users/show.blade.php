@extends('Admin.layouts.app')
@section('title', __('User management'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">
                                @lang('User Information')</h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item"><a
                                        href="{{ route('Admin.users.show', $user->id) }}">@lang('Show')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('Admin.users.index') }}">@lang('User management')</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('Admin.home') }}">@lang('dashboard')</a></li>
                            </ol>
                        </div>


                    </div> <!-- end row -->
                </div>
                <!-- end page-title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="mb-3 row">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-end text-start"><strong>@lang('Name'):</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        {{ $user->name }}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="email" class="col-md-4 col-form-label text-md-end text-start"><strong>
                                            @lang('Email')</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        {{ $user->email }}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="roles"
                                        class="col-md-4 col-form-label text-md-end text-start"><strong>@lang('Roles')</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        <span class="badge badge-primary">{{ app()->getLocale() == 'ar' ? $user->roles[0]->name_ar : $user->roles[0]->name ?? '' }}</span>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="roles"
                                        class="col-md-4 col-form-label text-md-end text-start"><strong>@lang('sections')</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        @foreach ($user->getAllPermissions()->unique('section_id') as $permission)
                                            <span
                                                class="badge badge-primary">{{ $permission->SectionDate->name ?? '' }}</span>
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="roles"
                                        class="col-md-4 col-form-label text-md-end text-start"><strong>@lang('Permissions')</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        @foreach ($user->getAllPermissions() as $permission)
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
