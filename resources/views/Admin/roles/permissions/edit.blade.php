@extends('Admin.layouts.app')
@section('title', __('Edit Permission'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">
                                @lang('Edit Permission')</h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item"><a href="{{ route('Admin.Permissions.update', $Permission->id) }}">@lang('Edit Permission')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('Admin.Permissions.index') }}">@lang('Permissions')</a></li>
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
                                @include('Admin.layouts.Inc._errors')

                                <form action="{{ route('Admin.Permissions.update', $Permission->id) }}" method="POST"
                                    class="row">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group col-md-6">
                                        <label>@lang('Name') @lang('ar')</label>
                                        <input type="text" required value="{{ $Permission->name_ar }}" name="name_ar"
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>@lang('Name') @lang('en')</label>
                                        <input type="text" required value="{{ $Permission->name }}" name="name"
                                            class="form-control">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>@lang('Model') </label>
                                        <select class="form-control" name="section_id" required>
                                            <option disabled value="">@lang('Model')</option>
                                            @foreach ($sections as $section)
                                                <option value="{{ $section->id }}"
                                                    {{ $section->id == $Permission->section_id ? 'selected' : '' }}>
                                                    {{ $section->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-4">
                                        <label class="form-label" for="modalRoleNamear"> @lang('user type')</label>
                                        <div class="d-flex">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="type" value="admin"
                                                    id="customradio1" {{ $Permission->type == 'admin' ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="customradio1">@lang('Admin')</label>
                                            </div>
                                            <div class="form-check mb-2 mx-2">
                                                <input class="form-check-input" type="radio" name="type" value="user"
                                                    id="customradio2" {{ $Permission->type == 'user' ? 'checked' : '' }}>
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
