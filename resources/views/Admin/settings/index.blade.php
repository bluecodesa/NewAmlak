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



                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-4">@lang('Settings')</h4>

                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="nav flex-column nav-pills nav-pills-tab" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        <a class="nav-link active show mb-1" id="v-pills-home-tab" data-bs-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">
                                            @lang('Website setting')
                                        </a>
                                        <a class="nav-link mb-1" id="v-pills-profile-tab" data-bs-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile"
                                            aria-selected="false">
                                            @lang('PayTabs')</a>
                                        <a class="nav-link mb-1" id="v-pills-messages-tab" data-bs-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages"
                                            aria-selected="false">
                                            @lang('Notification mange')</a>
                                        <a class="nav-link mb-1" id="v-pills-settings-tab" data-bs-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings"
                                            aria-selected="false">
                                            @lang('Gallary mange')</a>
                                    </div>
                                </div> <!-- end col-->
                                <div class="col-md-9">
                                    <div class="tab-content pt-0">
                                        <div class="tab-pane fade active show" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                            <div class="form-container" id="website-setting-form">

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card m-b-30">
                                                            <div class="card-body">
                                                                <form action="" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')

                                                                    <div class="form-group col-md-6">
                                                                        <label for="title_ar">@lang('Website name ar')</label>

                                                                            <input name="title_ar" class="form-control" type="text" id="title_ar" value="{{ $settings->title ?? '' }}">
                                                                    </div>


                                                                    <div class="form-group col-md-6">
                                                                        <label for="title_en" >@lang('Website name en')</label>

                                                                            <input name="title_en" class="form-control" type="text" id="title_en" value="{{ $settings->title ?? '' }}">

                                                                    </div>

                                                                    <div class="form-group col-md-6">
                                                                        <label for="url">@lang('URL')</label>

                                                                            <input name="url" class="form-control" type="url" value="{{ $settings->url ?? '' }}" id="url">

                                                                    </div>


                                                                    <div class="form-group col-md-6">
                                                                        <label for="logo" >@lang('Logo')</label>

                                                                            @if(isset($settings) && $settings->icon)
                                                                            <img src="{{ asset($settings->icon) }}" alt="Current Logo" width="100px">
                                                                        @else
                                                                            <p>No logo uploaded yet.</p>
                                                                        @endif
                                                                            <input name="icon" class="form-control" type="file" id="logo" accept="image/png, image/jpg, image/jpeg">

                                                                    </div>



                                                                    <div class="form-group col-md-6">
                                                                        <label for="color">@lang('Color')</label>
                                                                        <div class="col-sm-8">
                                                                            <input name="color" class="form-control" type="color" value="{{ $settings->color ?? '#30419b' }}" id="color">
                                                                        </div>
                                                                    </div>
                                                                   <div class="form-group row">
                                                                    <div class="col-12">
                                                                          <button type="submit" class="btn btn-primary waves-effect waves-light">@lang('save')</button>
                                                                            <button type="reset" class="btn btn-secondary waves-effect m-l-5">@lang('Cancel')</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div> <!-- end col -->
                                                </div> <!-- end row -->

                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                            <div class="form-container" id="paytabs-settings-form">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card m-b-30">
                                                            <div class="card-body">
                                                                <form action="" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')

                                                                    <div class="form-group col-md-6">
                                                                        <label for="title_ar" class="col-sm-2 col-form-label">@lang('Api Key')</label>
                                                                        <input name="title_ar" class="form-control" type="text" id="title_ar" value="{{ $settings->title ?? '' }}">
                                                                    </div>

                                                                    <div class="form-group col-md-6">
                                                                        <label for="title_ar" class="col-sm-2 col-form-label">@lang('PayTab Id')</label>
                                                                        <input name="title_ar" class="form-control" type="text" id="title_ar" value="{{ $settings->title ?? '' }}">
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-8">
                                                                            <button type="submit" class="btn btn-primary waves-effect waves-light">@lang('save')</button>
                                                                            <button type="reset" class="btn btn-secondary waves-effect m-l-5">@lang('Cancel')</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div> <!-- end col -->
                                                </div> <!-- end row -->
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">

                                        </div>
                                        <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                            </div>
                                    </div>
                                </div> <!-- end col-->
                            </div> <!-- end row-->
                        </div>
                    </div> <!-- end card-->
                </div> <!-- end col -->


                <!-- end page-title -->





            </div>

         </div>

    </div> <!-- end container-fluid -->





<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tabs = document.querySelectorAll('.nav-pills-tab .nav-link');
        var formContainers = document.querySelectorAll('.tab-content .form-container');

        tabs.forEach(function (tab, index) {
            tab.addEventListener('click', function () {
                // Hide all forms and content
                formContainers.forEach(function (container) {
                    container.style.display = 'none';
                });

                // Show the corresponding form and content
                formContainers[index].style.display = 'block';
            });
        });

        // Initial hide all forms except the first one
        formContainers.forEach(function (container, index) {
            if (index !== 0) {
                container.style.display = 'none';
            }
        });

        // Handle form submission for website setting
        var websiteSettingForm = document.getElementById('website-setting-form');
        websiteSettingForm.addEventListener('submit', function (event) {
            event.preventDefault();
            // Add your AJAX or form submission logic here
            console.log('Website Setting Form Submitted');
        });

        // Handle form submission for PayTabs setting
        var paytabsSettingForm = document.getElementById('paytabs-settings-form');
        paytabsSettingForm.addEventListener('submit', function (event) {
            event.preventDefault();
            // Add your AJAX or form submission logic here
            console.log('PayTabs Setting Form Submitted');
        });
    });
</script>




@endsection




