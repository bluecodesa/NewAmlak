@extends('Admin.layouts.app')
@section('title', __('Edit Project status'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-12 ">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <span class="text-muted fw-light"> @lang('Settings') / @lang('technical support') /</span>
                        <a href="{{ route('Admin.SupportTickets.tickets-type') }}"
                            class="text-muted fw-light">@lang('Add New Project Status')
                        </a>
                    </h4>
                </div>

            </div>
            <!-- DataTable with Buttons -->
            <div class="card">
                @include('Admin.layouts.Inc._errors')
                <div class="card-body">
                    <form action="{{ route('Admin.ProjectSettings.store') }}" method="POST" class="row">
                        @csrf
                        @method('post')
                        @foreach (config('translatable.locales') as $locale)
                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">
                                    {{ __('Name') }} {{ __($locale) }} <span class="required-color">*</span></label>
                                <input type="text" required id="modalRoleName" name="{{ $locale }}[name]"
                                    class="form-control" placeholder="{{ __('Name') }} {{ __($locale) }}">

                            </div>
                        @endforeach
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label">
                                @lang('type') <span class="required-color">*</span></label>
                                <select class="form-select" name="type" id="type" required>
                                    <option disabled value="">@lang('Status of Project') </option>
                                    @foreach (['Project_Status', 'Delivery_Case'] as $type)
                                        <option value="{{ $type }}">
                                            {{ __($type) }}</option>
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
