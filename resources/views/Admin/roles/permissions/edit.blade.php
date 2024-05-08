@extends('Admin.layouts.app')
@section('title', __('Edit Permission'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 py-3 mb-1">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Admin.Permissions.index') }}" class="text-muted fw-light">@lang('Permissions')
                        </a> /
                        @lang('Edit Permission')
                    </h4>
                </div>

            </div>
            <!-- DataTable with Buttons -->
            <div class="card">
                @include('Admin.layouts.Inc._errors')
                <div class="card-body">
                    <form action="{{ route('Admin.Permissions.update', $Permission->id) }}" method="POST" class="row">
                        @csrf
                        @method('PUT')
                        <div class="form-group col-md-6">
                            <label>@lang('Name') @lang('ar')</label>
                            <input type="text" required value="{{ $Permission->name_ar }}" name="name_ar"
                                class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>@lang('Name') @lang('en')</label>
                            <input type="text" required value="{{ $Permission->name }}" readonly name="name"
                                class="form-control">
                        </div>

                        <div class="form-group col-md-6 mt-2">
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


                        <div class="col-4 mt-2">
                            <label class="form-label" for="modalRoleNamear"> @lang('user type')</label>
                            <div class="d-flex">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="type" value="admin"
                                        id="customradio1" {{ $Permission->type == 'admin' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="customradio1">@lang('Admin')</label>
                                </div>
                                <div class="form-check mb-3 mx-2">
                                    <input class="form-check-input" type="radio" name="type" value="user"
                                        id="customradio2" {{ $Permission->type == 'user' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="customradio2">@lang('User')</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <button class="btn btn-primary" type="submit">@lang('save')</button>
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
