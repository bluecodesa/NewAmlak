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
                                <form action="" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group row">
                                        <label for="title_ar" class="col-sm-2 col-form-label">@lang('Website name ar')</label>
                                        <div class="col-sm-8">
                                            <input name="title_ar" class="form-control" type="text" id="title_ar" value="{{ $settings->title ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="title_en" class="col-sm-2 col-form-label">@lang('Website name en')</label>
                                        <div class="col-sm-8">
                                            <input name="title_en" class="form-control" type="text" id="title_en" value="{{ $settings->title ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="url" class="col-sm-2 col-form-label">@lang('URL')</label>
                                        <div class="col-sm-8">
                                            <input name="url" class="form-control" type="url" value="{{ $settings->url ?? '' }}" id="url">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="logo" class="col-sm-2 col-form-label">@lang('Logo')</label>
                                        <div class="col-sm-8">
                                            @if(isset($settings) && $settings->icon)
                                            <img src="{{ asset($settings->icon) }}" alt="Current Logo" width="100px">
                                        @else
                                            <p>No logo uploaded yet.</p>
                                        @endif
                                            <input name="icon" class="form-control" type="file" id="logo" accept="image/png, image/jpg, image/jpeg">
                                        </div>
                                    </div>



                                    <div class="form-group row">
                                        <label for="color" class="col-sm-2 col-form-label">@lang('Color')</label>
                                        <div class="col-sm-8">
                                            <input name="color" class="form-control" type="color" value="{{ $settings->color ?? '#30419b' }}" id="color">
                                        </div>
                                    </div>

                                            <button type="submit" class="btn btn-primary waves-effect waves-light">@lang('save')</button>
                                            <button type="reset" class="btn btn-secondary waves-effect m-l-5">@lang('Cancel')</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->

                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group row">
                                        <label for="title_ar" class="col-sm-2 col-form-label">@lang('Api Key')</label>
                                        <div class="col-sm-8">
                                            <input name="title_ar" class="form-control" type="text" id="title_ar" value="{{ $settings->title ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="title_en" class="col-sm-2 col-form-label">@lang('Website name en')</label>
                                        <div class="col-sm-8">
                                            <input name="title_en" class="form-control" type="text" id="title_en">
                                        </div>
                                    </div>


                                            <button type="submit" class="btn btn-primary waves-effect waves-light">@lang('save')</button>
                                            <button type="reset" class="btn btn-secondary waves-effect m-l-5">@lang('Cancel')</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->



            </div> <!-- end container-fluid -->
        </div>
        <!-- container-fluid -->
    </div>
@endsection
