@extends('Admin.layouts.app')
@section('title', __('Settings'))
@section('content')
    <style>
        .nav-pills .nav-link {
            background-color: transparent;
            border: 2px solid silver;
            margin-bottom: 4px;
            border-radius: 10px;
        }
    </style>
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
                                <li class="breadcrumb-item">@lang('Settings')</li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('Admin.settings.index') }}">@lang('dashboard')</a></li>
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
                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
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
                                                <button class="nav-link" id="v-pills-gallary-tab" data-toggle="pill"
                                                    data-target="#v-pills-gallary" type="button" role="tab"
                                                    aria-controls="v-pills-gallary"
                                                    aria-selected="false">@lang('Gallary Mange')</button>

                                            </div>
                                        </div>


                                        <div class="col-9">
                                            <div class="tab-content" id="v-pills-tabContent">

                                                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                                    aria-labelledby="v-pills-home-tab">

                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="card m-b-30">
                                                                <div class="card-body">
                                                                    <form
                                                                        action="{{ route('Broker.Setting.update', $broker->id) }}"
                                                                        method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        @method('PUT')

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
                                                                                <label for="name">
                                                                                    @lang('Broker name')<span
                                                                                        class="text-danger">*</span></label>

                                                                                <input type="text" class="form-control"
                                                                                    id="name" name="name"
                                                                                    value="{{ $user->name }}" required>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label for="license_number">
                                                                                    @lang('license number')<span
                                                                                        class="text-danger">*</span></label>

                                                                                <input type="text" class="form-control"
                                                                                    id="license_number"
                                                                                    name="license_number"
                                                                                    value="{{ $broker->broker_license }}"
                                                                                    required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mb-3 row">
                                                                            <div class="col-md-6">
                                                                                <label
                                                                                    for="email">@lang('Email')<span
                                                                                        class="text-danger">*</span></label>

                                                                                <input type="email" class="form-control"
                                                                                    id="email" name="email"
                                                                                    value="{{ $user->email }}">
                                                                            </div>

                                                                            <div class="col-md-6">

                                                                                <label
                                                                                    for="mobile">@lang('Mobile Whats app')<span
                                                                                        class="text-danger">*</span></label>
                                                                                <div style="position:relative">

                                                                                    <input type="tel"
                                                                                        class="form-control" id="mobile"
                                                                                        minlength="9" maxlength="9"
                                                                                        pattern="[0-9]*"
                                                                                        oninvalid="setCustomValidity('Please enter 9 numbers.')"
                                                                                        onchange="try{setCustomValidity('')}catch(e){}"
                                                                                        placeholder="599123456"
                                                                                        name="mobile" required=""
                                                                                        value="{{ $broker->mobile }}">

                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <div class="mb-3 row">
                                                                            <div class="col-md-4 mb-4">
                                                                                <label
                                                                                    for="broker_logo">@lang('Broker logo')</label>
                                                                                <span
                                                                                    class="not_required">(@lang('optional'))</span>
                                                                                <input type="file" class="form-control"
                                                                                    id="broker_logo" name="company_logo"
                                                                                    accept="image/png, image/jpg, image/jpeg">
                                                                                <img id="broker_logo_preview"
                                                                                    src="https://www.svgrepo.com/show/29852/user.svg"
                                                                                    class="d-flex mr-3 rounded-circle"
                                                                                    height="64"
                                                                                    style="cursor: pointer;" />
                                                                            </div>

                                                                            <div class="form-group col-md-4">
                                                                                <label>@lang('Region') <span
                                                                                        class="text-danger">*</span></label>
                                                                                <select class="form-control"
                                                                                    id="Region_id" required>
                                                                                    <option selected
                                                                                        value="{{ $region->id }}">
                                                                                        {{ $region->name }}</option>
                                                                                    @foreach ($Regions as $Region)
                                                                                        <option value="{{ $Region->id }}"
                                                                                            data-url="{{ route('Admin.Region.show', $Region->id) }}">
                                                                                            {{ $Region->name }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>

                                                                            <div class="form-group col-md-4">
                                                                                <label>@lang('city') <span
                                                                                        class="text-danger">*</span></label>
                                                                                <select class="form-control"
                                                                                    name="city_id" id="CityDiv"
                                                                                    value="" required>
                                                                                    <option selected
                                                                                        value="{{ $city->id }}">
                                                                                        {{ $city->name }}</option>
                                                                                </select>
                                                                            </div>

                                                                        </div>

                                                                        <div class="mb-3 row">

                                                                            <div class="col-md-6">
                                                                                <label for="password"> @lang('password')
                                                                                    <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input type="password"
                                                                                    class="form-control" id="password"
                                                                                    name="password" required>
                                                                            </div>

                                                                            <div class="col-md-6">
                                                                                <label for="password_confirmation">
                                                                                    @lang('Confirm Password') <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input type="password"
                                                                                    class="form-control"
                                                                                    id="password_confirmation"
                                                                                    name="password_confirmation" required>
                                                                            </div>
                                                                        </div>


                                                                        <div class="mb-3 row">
                                                                            <div class="col-md-6">
                                                                                <label for="id_number"
                                                                                    class="col-form-label">@lang('id number')</label>
                                                                                <input type="text" class="form-control"
                                                                                    id="id_number" name="id_number"
                                                                                    value="{{ $broker->id_number }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-3">
                                                                            <div class="col-md-4"></div>
                                                                            <div class="col-md-8">
                                                                                <button type="submit"
                                                                                    class="btn btn-primary">@lang('save')</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div> <!-- end col -->
                                                    </div> <!-- end row -->
                                                    <!--  اعدادات المنصه -->

                                                </div>


                                                <!-- gallary mange -->
                                                @if ($gallery)
                                                    <div class="tab-pane fade" id="v-pills-gallary" role="tabpanel"
                                                        aria-labelledby="v-pills-gallary-tab">
                                                        <div class="row justify-content-center">
                                                            <div class="col-lg-10">
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h5 class="card-title">@lang('Gallary Mange')</h5>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <form action="" method="post">
                                                                            @csrf

                                                                            <div class="form-group">
                                                                                <label
                                                                                    for="galleryName">@lang('Gallery URL')</label>
                                                                                <div class="input-group-append">
                                                                                    <button class="btn btn-primary"
                                                                                        type="button"
                                                                                        onclick="copyGalleryUrl()">@lang('Copy URL')</button>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        id="galleryName" disabled
                                                                                        value="{{ env('APP_URL') }}/ar/broker/Gallary/{{ $gallery->gallery_name }}">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6 mb-3"
                                                                                style="padding-right: 33px;">
                                                                                <div class="row">
                                                                                    <div class="p-0 m-0">
                                                                                        <span>تعديل لينك المعرض</span>
                                                                                        <div class="d-flex "
                                                                                            style="margin-top: 10px">


                                                                                            <input type="text"
                                                                                                class="form-control edit-gallery-name"
                                                                                                id="gallery_name"
                                                                                                placeholder="officename"
                                                                                                name="gallery_name"
                                                                                                value="{{ $gallery->gallery_name }}"
                                                                                                oninput="validateName(this)">
                                                                                            <input hidden
                                                                                                name="broker_id_for_gallery"
                                                                                                value="{{ $gallery->id }}" />

                                                                                            <input type="text"
                                                                                                class="form-control"
                                                                                                id="galleryName" disabled
                                                                                                value="{{ env('APP_URL') }}/ar/broker/Gallary/">

                                                                                        </div>
                                                                                        <div class="row validate-result"
                                                                                            style="display: none">
                                                                                            <span
                                                                                                class=" alert alert-success"></span>
                                                                                            <span
                                                                                                class=" alert alert-error"></span>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <button type="submit"
                                                                                class="btn btn-primary">@lang('Edit')</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                <!--end of gallary mange-->

                                                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                                                    aria-labelledby="v-pills-messages-tab">

                                                    @include('Admin.settings.inc._NotificationsManagement')
                                                    <!-- نهايه التنبيهات-->
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
