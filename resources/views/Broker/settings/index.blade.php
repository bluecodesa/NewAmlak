@extends('Admin.layouts.app')
@section('title', __('Settings'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">@lang('Settings')</h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item"><a href="{{ route('Broker.Setting.index') }}">@lang('Settings')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('Broker.home') }}">@lang('dashboard')</a></li>
                            </ol>
                        </div>
                    </div> <!-- end row -->
                </div>
                <!-- end page-title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                            aria-orientation="vertical">
                                            <button class="nav-link active" id="v-pills-home-tab" data-toggle="pill"
                                                data-target="#v-pills-home" type="button" role="tab"
                                                aria-controls="v-pills-home" aria-selected="true">
                                                @lang('الملف التعريفي')</button>
                                            <button class="nav-link" id="v-pills-messages-tab" data-toggle="pill"
                                                data-target="#v-pills-messages" type="button" role="tab"
                                                aria-controls="v-pills-messages" aria-selected="false">
                                                @lang('Notification Mange')</button>
                                            <button class="nav-link" id="v-pills-settings-tab" data-toggle="pill"
                                                data-target="#v-pills-settings" type="button" role="tab"
                                                aria-controls="v-pills-settings"
                                                aria-selected="false">@lang('Gallary Mange')</button>

                                        </div>
                                    </div>

                                    <!--  -->
                                    <div class="col-9">


                                 <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                    aria-labelledby="v-pills-home-tab">

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card m-b-30">
                                                <div class="card-body">
                                                    <form action="{{ route('Admin.Subscribers.CreateBroker') }}" method="POST">
                                                        @csrf

                                                        @if ($errors->any())
                                                            <div class="alert alert-danger">
                                                                <ul>
                                                                    @foreach ($errors->all() as $error)
                                                                        <li>{{ $error }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endif

                                                        <div class="mb-3 row">
                                                            <div class="col-md-6">
                                                                <label for="name"> @lang('Broker name')<span class="text-danger">*</span></label>

                                                                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="license_number"> @lang('license number')<span class="text-danger">*</span></label>

                                                                <input type="text" class="form-control" id="license_number" name="license_number" value="{{ $user->broker_license }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <div class="col-md-6">
                                                                <label for="email">@lang('Email')<span class="text-danger">*</span></label>

                                                                <input type="email" class="form-control" id="email" name="email">
                                                            </div>

                                                            <div class="col-md-6">

                                                                <label for="mobile">@lang('Mobile Whats app')<span
                                                                        class="text-danger">*</span></label>
                                                                <div style="position:relative">

                                                                    <input type="tel" class="form-control" id="mobile" minlength="9"
                                                                        maxlength="9" pattern="[0-9]*"
                                                                        oninvalid="setCustomValidity('Please enter 9 numbers.')"
                                                                        onchange="try{setCustomValidity('')}catch(e){}" placeholder="599123456"
                                                                        name="mobile" required="" value="">

                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="mb-3 row">

                                                            <div class="form-group col-md-4">
                                                                <label>@lang('Region') </label>
                                                                <select class="form-control" id="Region_id" required>
                                                                    <option disabled selected value="">@lang('Region')</option>
                                                                    @foreach ($Regions as $Region)
                                                                        <option value="{{ $Region->id }}"
                                                                            data-url="{{ route('Admin.Region.show', $Region->id) }}">
                                                                            {{ $Region->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group col-md-4">
                                                                <label>@lang('city') </label>
                                                                <select class="form-control" name="city_id" id="CityDiv" required>
                                                                </select>
                                                            </div>


                                                        </div>

                                                        <div class="mb-3 row">

                                                            <div class="col-md-6">
                                                                <label for="password"> @lang('password') <span
                                                                    class="text-danger">*</span></label>
                                                      <input type="password" class="form-control" id="password" name="password" required>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label for="password_confirmation"> @lang('Confirm Password') <span
                                                                    class="text-danger">*</span></label>            <input type="password" class="form-control" id="password_confirmation"
                                                                    name="password_confirmation" required>
                                                            </div>
                                                        </div>


                                                        <div class="mb-3 row">
                                                            <div class="col-md-6">
                                                                <label for="id_number" class="col-form-label">@lang('id number')</label>
                                                                <input type="text" class="form-control" id="id_number" name="id_number">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-4"></div>
                                                            <div class="col-md-8">
                                                                <button type="submit" class="btn btn-primary">@lang('save')</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div> <!-- end col -->
                                    </div> <!-- end row -->
                                    <!--  اعدادات المنصه -->

                                </div>


                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection
