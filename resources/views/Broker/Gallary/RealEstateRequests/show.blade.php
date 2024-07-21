@extends('Admin.layouts.app')

@section('title', __('Real Estate Requests'))

@section('content')
<div class="container">
    <div class="row">
        <!-- Request Details Card -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="card-title m-0">Request Details</h6>
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
                    <span class="badge bg-label-{{ $request->request_valid == 'active' ? 'success' : 'danger' }} me-2">
                        {{ ucfirst($request->request_valid) }}
                    </span>
                </div>
                <div class="d-flex justify-content-between">
                    <h6>Details</h6>
                    @if (Auth::user()->hasPermission('update-requests-interest'))
                    <!-- Dropdown Form for Status Update -->
                    <form method="POST" action="">
                        @csrf
                        <select class="form-control select-input w-auto" name="status" onchange="this.form.submit()">
                            @foreach ($interestsTypes as $interestsType)
                            <option value="{{ $interestsType->id }}"
                                {{ $request->status == $interestsType->id ? 'selected' : '' }}>
                                {{ __($interestsType->name) }}
                            </option>
                            @endforeach
                        </select>
                        <button type="submit" class="submit-from" hidden=""></button>
                    </form>
                    @endif
                </div>
                <p class="mb-1">Property Type: {{ $request->propertyType->name }}</p>
                <p class="mb-1">City: {{ $request->city->name }}</p>
                <p class="mb-1">District: {{ $request->district->name }}</p>
                <p class="mb-1">Area: {{ $request->area }} sq.m</p>
                <p class="mb-1">Rooms: {{ $request->rooms }}</p>
                <p class="mb-0">Description: {{ $request->description }}</p>
            </div>
        </div>
    </div>
</div>

@endsection
