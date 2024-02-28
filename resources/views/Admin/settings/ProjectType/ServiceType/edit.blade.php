@extends('Admin.layouts.app')
@section('title', __('Edit'))
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
                                        @lang('Edit') : {{ $ServiceType->name }} </h4>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item"><a href="{{ route('Admin.ServiceType.edit',$ServiceType->id) }}">@lang('Edit')</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('Admin.ServiceType.index') }}">@lang('services types')</a></li>
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
                                <form action="{{ route('Admin.ServiceType.update', $ServiceType->id) }}" method="POST"
                                    class="row">
                                    @csrf
                                    @method('PUT')
                                    @foreach (config('translatable.locales') as $locale)
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    {{ __('Name') }} {{ __($locale) }} <span
                                                        class="required-color">*</span></label>
                                                <input type="text" required id="modalRoleName"
                                                    value="{{ $ServiceType->translate($locale)->name }}"
                                                    name="{{ $locale }}[name]" class="form-control"
                                                    placeholder="{{ __('Name') }} {{ __($locale) }}">
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="col-4">
                                        <label class="form-label" for="modalRoleNamear"> @lang('user type') <span
                                                class="required-color">*</span></label>
                                        <div class="d-flex">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input TypeUser" data-hide="admin" type="radio"
                                                    name="type_user" {{ $ServiceType->type_user === 1 ? 'checked' : '' }}
                                                    value="{{ 1 }}" id="customradio1">
                                                <label class="form-check-label" for="customradio1">@lang('Office')</label>
                                            </div>
                                            <div class="form-check mb-2 mx-2">
                                                <input class="form-check-input TypeUser" data-hide="user" type="radio"
                                                    name="type_user" {{ $ServiceType->type_user === 0 ? 'checked' : '' }}
                                                    value="{{ 0 }}" id="customradio2">
                                                <label class="form-check-label" for="customradio2">@lang('Broker')</label>
                                            </div>
                                        </div>
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

    </div>
@endsection
