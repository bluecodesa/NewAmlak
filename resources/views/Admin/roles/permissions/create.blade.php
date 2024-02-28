@extends('Admin.layouts.app')
@section('title', __('Add New Permission'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">
                                @lang('Add New Permission')</h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item"><a href="{{ route('Admin.Permissions.create') }}">@lang('Add New Permission')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('Admin.Permissions.index') }}">@lang('Permissions')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('Admin.home') }}">@lang('dashboard')</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                @include('Admin.layouts.Inc._errors')
                                <form action="{{ route('Admin.Permissions.store') }}" method="POST" class="row">
                                    @csrf
                                    <div class="form-group col-md-6">
                                        <label>@lang('Name') @lang('ar') <span class="required-color">*</span>
                                        </label>
                                        <input type="text" required name="name_ar" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>@lang('Name') @lang('en') <span
                                                class="required-color">*</span></label>
                                        <input type="text" required name="name" class="form-control">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>@lang('Model') </label>
                                        <select class="form-control" name="section_id" required>
                                            <option disabled selected value="">@lang('Model')</option>
                                            @foreach ($sections as $section)
                                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-4">
                                        <label class="form-label" for="modalRoleNamear"> @lang('user type') <span
                                                class="required-color">*</span></label>
                                        <div class="d-flex">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" required name="type"
                                                    value="admin" id="customradio1" checked="">
                                                <label class="form-check-label" for="customradio1">@lang('Admin')</label>
                                            </div>
                                            <div class="form-check mb-2 mx-2">
                                                <input class="form-check-input" type="radio" name="type" value="user"
                                                    id="customradio2" checked="">
                                                <label class="form-check-label"
                                                    for="customradio2">@lang('User')</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-primary" type="submit">@lang('save')</button>
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
