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
                            @lang('User management')</h4>
                    </div>

                </div> <!-- end row -->
            </div>
            <!-- end page-title -->

            <div class="row">

                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <strong class="card-title"> @lang('file') @lang('Broker')</strong>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-12">
                                        <div class="row align-items-center">
                                            <div class="col-md-7" style="display: flex;margin-bottom: 30px;align-items: center;">
                                                <img src="" class="avatar-img " width="50px" style="border-radius: 12px;margin-left: 15px;">
                                                <h4 class="mb-3"></h4>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-12">
                                                <div class="form-row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationCustom03">@lang('Subscriber Name')</label>
                                                        <input type="text" class="form-control" id="validationCustom03" disabled="" value="{{ $broker->name }}">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationCustom04">@lang('Subscriber City')</label>
                                                        <input type="text" class="form-control" id="validationCustom03" disabled="" value="{{ $broker->city }}">
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationCustom04">@lang('mobile') @lang('Broker')</label>
                                                        <input type="text" class="form-control" id="validationCustom03" disabled="" value="{{ $broker->mobile }}">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationCustom04">@lang('Email')</label>
                                                        <input type="text" class="form-control" id="validationCustom03" disabled="" value="{{ $broker->email }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 mb-4">
                        <div class="card timeline shadow">
                            <div class="card-header">
                                <strong class="card-title">احصائيات</strong>
                            </div>
                            <div class="card-body">
                                <!-- Statistics content -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row ArFont">
                    <!-- Recent Activity -->
                    <div class="col-md-8 col-lg-12 mb-4">
                        <div class="card timeline shadow">
                            <div class="card-header">
                                <strong class="card-title">مميزات الاشتراك الحالي</strong>
                            </div>
                            <div class="card-body">
                                <!-- Current subscription features content -->
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</main>

@endsection
