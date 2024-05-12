@extends('Admin.layouts.app')
@section('title', __('Add New City'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 ">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Admin.City.index') }}" class="text-muted fw-light">@lang('Cities')
                        </a> /
                        @lang('Add New City')
                    </h4>
                </div>

            </div>
            <!-- DataTable with Buttons -->
            <div class="card">
                @include('Admin.layouts.Inc._errors')
                <div class="card-body">
                    <form action="{{ route('Admin.City.store') }}" method="POST" class="row">
                        @csrf
                        @method('post')
                        @foreach (config('translatable.locales') as $locale)
                            <div class="col-md-4 col-12 mb-3">

                                <label class="form-label">
                                    {{ __('Name') }} {{ __($locale) }} <span class="required-color">*</span></label>
                                <input type="text" required id="modalRoleName" name="{{ $locale }}[name]"
                                    class="form-control" placeholder="{{ __('Name') }} {{ __($locale) }}">

                            </div>
                        @endforeach

                        <div class="col-md-4 col-12 mb-3">
                            <label>@lang('Region') </label>
                            <select class="form-select" name="region_id" required>
                                <option disabled selected value="">@lang('Region')</option>
                                @foreach ($Regions as $Region)
                                    <option value="{{ $Region->id }}">{{ $Region->name }}</option>
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
            <!-- Modal to add new record -->

            <!--/ DataTable with Buttons -->


        </div>

        <div class="content-backdrop fade"></div>
    </div>


@endsection
