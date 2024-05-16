@extends('Admin.layouts.app')
@section('title', __('Edit Interest'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-12 ">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Admin.settings.index') }}" class="text-muted fw-light">
                        </a>
                        <span class="text-muted fw-light"> @lang('Settings') / <a class="text-muted fw-light"
                                href="{{ route('Admin.settings.index') }}">@lang('General Settings')</a> / @lang('Gallary Mange') /
                        </span>
                        @lang('Edit Interest')
                    </h4>
                </div>

            </div>
            <!-- DataTable with Buttons -->
            <div class="card">
                @include('Admin.layouts.Inc._errors')
                <div class="card-body">
                    <form action="{{ route('Admin.update.interest-type', $Interest->id) }}" method="POST" class="row">
                        @csrf
                        @method('PUT')
                        @foreach (config('translatable.locales') as $locale)
                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">
                                    {{ __('Name') }} {{ __($locale) }} <span class="required-color">*</span></label>
                                <input type="text" required value="{{ $Interest->translate($locale)->name }}"
                                    name="{{ $locale }}[name]" class="form-control"
                                    placeholder="{{ __('Name') }} {{ __($locale) }}">
                            </div>
                        @endforeach
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
