@extends('Admin.layouts.app')
@section('title', __('Edit'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 py-3 mb-1">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Admin.ServiceType.index') }}" class="text-muted fw-light">@lang('services types')
                        </a> /
                        @lang('Edit')
                    </h4>
                </div>

            </div>
            <!-- DataTable with Buttons -->
            <div class="card">
                @include('Admin.layouts.Inc._errors')
                <div class="card-body">
                    <form action="{{ route('Admin.ServiceType.update', $ServiceType->id) }}" method="POST" class="row">
                        @csrf
                        @method('PUT')
                        @foreach (config('translatable.locales') as $locale)
                            <div class="col-md-4 col-12 mb-3">

                                <label class="form-label">
                                    {{ __('Name') }} {{ __($locale) }} <span class="required-color">*</span></label>
                                <input type="text" required id="modalRoleName"
                                    value="{{ $ServiceType->translate($locale)->name }}" name="{{ $locale }}[name]"
                                    class="form-control" placeholder="{{ __('Name') }} {{ __($locale) }}">

                            </div>
                        @endforeach

                        <div class="col-md-4 col-12 mb-3">
                            <label class="form-label" for="modalRoleNamear"> @lang('user type') <span
                                    class="required-color">*</span></label>
                            <div class="d-flex">
                                <div class="form-check mb-2">
                                    <input class="form-check-input TypeUser" data-hide="admin" type="radio"
                                        name="type_user" {{ $ServiceType->type_user === 1 ? 'checked' : '' }}
                                        value="{{ 1 }}" id="customradio1">
                                    <label class="form-check-label" for="customradio1">@lang('Office')</label>
                                </div>
                                <div class="form-check mb-2 mx-2">
                                    <input class="form-check-input TypeUser" data-hide="user" type="radio"
                                        name="type_user" {{ $ServiceType->type_user === 0 ? 'checked' : '' }}
                                        value="{{ 0 }}" id="customradio2">
                                    <label class="form-check-label" for="customradio2">@lang('Broker')</label>
                                </div>
                            </div>
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
