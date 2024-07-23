@extends('Admin.layouts.app')

@section('title', __('Real Estate Requests'))

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-6">
                <h4 class=""><a href="{{ route('Broker.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                    <a href="{{ route('PropertyFinder.RealEstateRequest.index') }}" class="text-muted fw-light">@lang('Real Estate Requests') </a> /
                    @lang('Show') {{ $request->number_of_requests }}
                </h4>

            </div>
        </div>
    <div class="row">
        <!-- Request Details Card -->
        <div class="col-md-8 col-12 mb-3">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title m-0">@lang('Request Details')</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-start align-items-center mb-4">
                        <!-- Avatar Placeholder or Request Icon -->
                        <div class="avatar me-2">
                            <img src="{{ url('Offices/Projects/default.svg') }}" alt="Avatar" class="rounded-circle" />
                        </div>
                        <div class="d-flex flex-column">
                            <h6 class="mb-0">{{ $request->number_of_requests }}</h6>
                            {{-- <small class="text-muted">Request ID: #{{ $request->id }}</small> --}}
                        </div>
                    </div>
                    <div class="d-flex justify-content-start align-items-center mb-4">
                        <!-- Status Badge -->
                        @lang('Validation'):<span class="badge bg-{{ $request->request_valid == 'active' ? 'primary' : 'danger' }} me-2">
                          {{ __($request->request_valid) }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6>@lang('Details')</h6>
                    </div>
                    <p class="mb-1">@lang('Property type'): {{ $request->propertyType->name }}</p>
                    <p class="mb-1">@lang('city'): {{ $request->city->name }}</p>
                    <p class="mb-1">@lang('district'): {{ $request->district->name ?? ''}}</p>
                    <p class="mb-1">@lang('Area (square metres)'): {{ $request->area }}</p>
                    <p class="mb-1">@lang('number rooms'): {{ $request->rooms }}</p>
                    <p class="mb-0">@lang('Description'): {{ $request->description }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-12 mb-3">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title m-0">@lang('Client Details') </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-start align-items-center mb-4">
                        <!-- Avatar Placeholder or Request Icon -->
                        <div class="avatar me-2">
                            <img src="{{ $request->user->avatar ?? url('HOME_PAGE/img/avatars/14.png') }}" alt="Avatar" class="rounded-circle" />
                        </div>
                        <div class="d-flex flex-column">
                            <h6 class="mb-0">{{ $request->user->name }}</h6>
                            {{-- <small class="text-muted">Request ID: #{{ $request->id }}</small> --}}
                        </div>
                    </div>
                    <div class="d-flex flex-column mb-4">

                    <p class="mb-1">@lang('Email'): {{ $request->user->email }}</p>
                    <p class="mb-1">@lang('mobile'): {{ $request->user->full_phone }}</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6>@lang('تغيير حالة الطلب')</h6>
                        @if (Auth::user()->hasPermission('update-requests-interest') )
                        <!-- Dropdown Form for Status Update -->
                        <form method="POST" action="{{ route('PropertyFinder.updateInterestType', $request->id) }}">
                            @csrf
                            @if($request->request_valid == 'active')
                            <select class="form-control select-input w-auto" name="status" onchange="this.form.submit()">
                                @foreach ($interestsTypes as $interestsType)
                                    <option value="{{ $interestsType->id }}"
                                        {{ $requestStatus && $requestStatus->request_status_id == $interestsType->id ? 'selected' : '' }}>
                                        {{ __($interestsType->name) }}
                                    </option>
                                @endforeach

                            </select>
                            @else
                            <select disabled class="form-control select-input w-auto" name="status" onchange="this.form.submit()">
                                @foreach ($interestsTypes as $interestsType)
                                    <option value="{{ $interestsType->id }}"
                                        {{ $requestStatus && $requestStatus->request_status_id == $interestsType->id ? 'selected' : '' }}>
                                        {{ __($interestsType->name) }}
                                    </option>
                                @endforeach

                            </select>
                            @endif
                            <button type="submit" class="submit-from" hidden=""></button>
                        </form>
                    @endif
                    
                    
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>
@endsection
