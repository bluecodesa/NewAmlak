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
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <form action="{{ route('Admin.Permissions.store') }}" method="POST" class="row">
                                    @csrf
                                    <div class="form-group col-md-6">
                                        <label>@lang('Name') @lang('en')</label>
                                        <input type="text" required name="name" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>@lang('Name') @lang('ar')</label>
                                        <input type="text" required name="name_ar" class="form-control">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>@lang('Model') </label>
                                        <input type="text" required name="model" class="form-control">
                                    </div>

                                    <div class="col-4">
                                        <label class="form-label" for="modalRoleNamear"> @lang('type permission')</label>
                                        <div class="d-flex">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="type" value="admin"
                                                    id="customradio1" checked="">
                                                <label class="form-check-label" for="customradio1">@lang('Admin')</label>
                                            </div>
                                            <div class="form-check mb-2 mx-2">
                                                <input class="form-check-input" type="radio" name="type" value="user"
                                                    id="customradio2" checked="">
                                                <label class="form-check-label" for="customradio2">@lang('User')</label>
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
