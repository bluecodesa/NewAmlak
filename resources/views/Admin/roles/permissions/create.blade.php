@extends('Admin.layouts.app')
@section('title', __('Add New Permission'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 py-3 mb-1">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Admin.Permissions.index') }}" class="text-muted fw-light">@lang('Permissions')
                        </a> /
                        @lang('Add New Permission')
                    </h4>
                </div>

            </div>
            <!-- DataTable with Buttons -->
            <div class="card">
                @include('Admin.layouts.Inc._errors')
                <div class="card-body">
                    <form action="{{ route('Admin.Permissions.store') }}" method="POST" class="row">
                        @csrf
                        <div class="col-12 mb-3 col-md-6">
                            <label>@lang('Name') @lang('ar') <span class="required-color">*</span>
                            </label>
                            <input type="text" required name="name_ar" class="form-control">
                        </div>
                        <div class="col-12  mb-3 col-md-6">
                            <label>@lang('Name') @lang('en') <span class="required-color">*</span></label>
                            <input type="text" required name="name" class="form-control">
                        </div>

                        <div class="col-md-6  mb-3 col-12">
                            <label>@lang('Model') </label>
                            <select class="form-select" name="section_id" required>
                                <option disabled selected value="">@lang('Model')</option>
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}">{{ $section->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-4 col-12  mb-3">
                            <label class="form-label" for="modalRoleNamear"> @lang('user type') <span
                                    class="required-color">*</span></label>
                            <div class="d-flex">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" required name="type" value="admin"
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

                        <div class="col-12 mt-3">
                            <button type="submit"
                                class="btn btn-primary waves-effect waves-light">@lang('save')</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Modal to add new record -->

            <!--/ DataTable with Buttons -->


        </div>

        <div class="content-backdrop fade"></div>
    </div>


@endsection
