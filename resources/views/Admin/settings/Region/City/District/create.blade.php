@extends('Admin.layouts.app')
@section('title', __('Add New District'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-sm-6">
                                    <h4 class="page-title">
                                        @lang('Add New District')</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            @include('Admin.layouts.Inc._errors')
                            <div class="card-body">
                                <form action="{{ route('Admin.District.store') }}" method="POST" class="row">
                                    @csrf
                                    @method('post')

                                    @foreach (config('translatable.locales') as $locale)
                                        <div class="col-4">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    {{ __('Name') }} {{ __($locale) }} <span
                                                        class="required-color">*</span></label>
                                                <input type="text" required id="modalRoleName"
                                                    name="{{ $locale }}[name]" class="form-control"
                                                    placeholder="{{ __('Name') }} {{ __($locale) }}">
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="form-group col-md-4">
                                        <label>@lang('city') </label>
                                        <select class="form-control" name="city_id" required>
                                            <option disabled selected value="">@lang('city')</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary me-1">

                                            {{ __('save') }}
                                        </button>

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
