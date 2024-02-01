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
                                <li class="breadcrumb-item">@lang('Settings')</li>
                                <li class="breadcrumb-item"><a href="{{ route('Admin.settings.index') }}">Amlak</a></li>
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
                                                @lang('Website setting')</button>
                                            <button class="nav-link" id="v-pills-profile-tab" data-toggle="pill"
                                                data-target="#v-pills-profile" type="button" role="tab"
                                                aria-controls="v-pills-profile" aria-selected="false">
                                                @lang('PayTabs')</button>
                                            <button class="nav-link" id="v-pills-messages-tab" data-toggle="pill"
                                                data-target="#v-pills-messages" type="button" role="tab"
                                                aria-controls="v-pills-messages" aria-selected="false">
                                                @lang('Notification mange')</button>
                                            <button class="nav-link" id="v-pills-settings-tab" data-toggle="pill"
                                                data-target="#v-pills-settings" type="button" role="tab"
                                                aria-controls="v-pills-settings"
                                                aria-selected="false">@lang('Gallary mange')</button>
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
                                                                <form action="" class="row" method="POST"
                                                                    enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')

                                                                    <div class="form-group col-md-6">
                                                                        <label for="title_ar">@lang('Website name ar')</label>

                                                                        <input name="title_ar" class="form-control"
                                                                            type="text" id="title_ar"
                                                                            value="{{ $settings->title ?? '' }}">
                                                                    </div>

                                                                    <div class="form-group col-md-6">
                                                                        <label for="title_en">@lang('Website name en')</label>

                                                                        <input name="title_en" class="form-control"
                                                                            type="text" id="title_en"
                                                                            value="{{ $settings->title ?? '' }}">

                                                                    </div>

                                                                    <div class="form-group col-md-6">
                                                                        <label for="url">@lang('URL')</label>

                                                                        <input name="url" class="form-control"
                                                                            type="url"
                                                                            value="{{ $settings->url ?? '' }}"
                                                                            id="url">

                                                                    </div>


                                                                    <div class="form-group col-md-6">
                                                                        <label for="logo">@lang('Logo')</label>

                                                                        @if (isset($settings) && $settings->icon)
                                                                            <img src="{{ asset($settings->icon) }}"
                                                                                alt="Current Logo" width="100px">
                                                                        @else
                                                                            <p>No logo uploaded yet.</p>
                                                                        @endif
                                                                        <input name="icon" class="form-control"
                                                                            type="file" id="logo"
                                                                            accept="image/png, image/jpg, image/jpeg">

                                                                    </div>



                                                                    <div class="form-group col-md-6">
                                                                        <label for="color">@lang('Color')</label>
                                                                        <div class="col-sm-8">
                                                                            <input name="color" class="form-control"
                                                                                type="color"
                                                                                value="{{ $settings->color ?? '#30419b' }}"
                                                                                id="color">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-12">
                                                                            <button type="submit"
                                                                                class="btn btn-primary waves-effect waves-light">@lang('save')</button>
                                                                            <button type="reset"
                                                                                class="btn btn-secondary waves-effect m-l-5">@lang('Cancel')</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div> <!-- end col -->
                                                </div> <!-- end row -->

                                            </div>
                                            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                                aria-labelledby="v-pills-profile-tab">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card m-b-30">
                                                            <div class="card-body">
                                                                <form action="" method="POST"
                                                                    enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')

                                                                    <div class="form-group row">
                                                                        <label for="title_ar"
                                                                            class="col-sm-2 col-form-label">@lang('Api Key')</label>
                                                                        <div class="col-sm-8">
                                                                            <input name="title_ar" class="form-control"
                                                                                type="text" id="title_ar"
                                                                                value="{{ $settings->title ?? '' }}">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                        <label for="title_en"
                                                                            class="col-sm-2 col-form-label">@lang('Website name en')</label>
                                                                        <div class="col-sm-8">
                                                                            <input name="title_en" class="form-control"
                                                                                type="text" id="title_en">
                                                                        </div>
                                                                    </div>


                                                                    <button type="submit"
                                                                        class="btn btn-primary waves-effect waves-light">@lang('save')</button>
                                                                    <button type="reset"
                                                                        class="btn btn-secondary waves-effect m-l-5">@lang('Cancel')</button>
                                                            </div>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                                                aria-labelledby="v-pills-messages-tab">...</div>
                                            <div class="tab-pane fade" id="v-pills-settings" role="tabpanel"
                                                aria-labelledby="v-pills-settings-tab">...</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->


            </div> <!-- end col -->
        </div> <!-- end row -->



    </div> <!-- end container-fluid -->
    </div>
    <!-- container-fluid -->
    </div>
@endsection
