@extends('Admin.layouts.app')
@section('title', __('Show'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-12">
                    <h4 class="">
                        <a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Broker.Owner.index') }}" class="text-muted fw-light">@lang('owners')</a> /
                        @lang('Show') : {{ $Owner->name }}
                    </h4>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3 col-12">
                            <label class="form-label">{{ __('Name') }}</label>
                            <input type="text" disabled value="{{ $Owner->name }}" readonly class="form-control">
                        </div>
                        <div class="col-md-4 mb-3 col-12">
                            <label class="form-label">@lang('Email')</label>
                            <input type="email" disabled value="{{ $Owner->email }}" readonly class="form-control">
                        </div>
                        <div class="col-md-4 mb-3 col-12">
                            <label class="form-label">@lang('id number')</label>
                            <input type="email" disabled value="{{ $Owner->UserData->id_number }}" readonly class="form-control">
                        </div>
                        <div class="col-12 mb-3 col-md-4">
                            <label for="color" class="form-label">@lang('phone')</label>
                            <div class="input-group">
                                <input type="text" placeholder="123456789" name="phone" id="phone" disabled
                                    value="{{ $Owner->UserData->phone }}" readonly class="form-control" maxlength="10">
                                <button class="btn btn-outline-primary dropdown-toggle waves-effect" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false" disabled>
                                    {{ $Owner->key_phone ?? '966' }}
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 col-12">
                            <label class="form-label">@lang('Region')</label>
                            <select class="form-select" id="Region_id" disabled>
                                <option disabled>@lang('Region')</option>
                                @foreach ($Regions as $Region)
                                    <option value="{{ $Region->id }}"
                                        {{ $Owner->CityData && $Owner->CityData->RegionData && $Region->id == $Owner->CityData->RegionData->id ? 'selected' : '' }}>
                                        {{ $Region->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3 col-12">
                            <label class="form-label">@lang('city')</label>
                            <select class="form-select" name="city_id" id="CityDiv" disabled>
                                <option disabled>@lang('city')</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}"
                                        {{ $city->id == $Owner->city_id ? 'selected' : '' }}>
                                        {{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-backdrop fade"></div>
    </div>
@endsection
