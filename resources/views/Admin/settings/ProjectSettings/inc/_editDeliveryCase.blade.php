@extends('Admin.layouts.app')
@section('title', __('Edit Ticket Type'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-12 ">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <span class="text-muted fw-light"> @lang('Settings')  /</span>
                        <a href="{{ route('Admin.ProjectSettings.index') }}"
                            class="text-muted fw-light">@lang('Project Settings')
                        </a> /@lang('Edit Delivery Cases')

                    </h4>
                </div>

            </div>
            <!-- DataTable with Buttons -->
            <div class="card">
                @include('Admin.layouts.Inc._errors')
                <div class="card-body">
                    <form action="{{ route('Admin.ProjectSettings.updateDelivery-case', $deliveryCase->id) }}" method="POST"
                        class="row">
                        @csrf
                        @method('PUT')
                        @foreach (config('translatable.locales') as $locale)
                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">
                                    {{ __('Name') }} {{ __($locale) }} <span class="required-color">*</span></label>
                                <input type="text" required value="{{ $deliveryCase->translate($locale)->name }}"
                                    name="{{ $locale }}[name]" class="form-control"
                                    placeholder="{{ __('Name') }} {{ __($locale) }}">

                            </div>
                        @endforeach
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">
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