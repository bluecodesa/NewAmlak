@extends('Admin.layouts.app')
@section('title', __('Edit Service'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6">
                    <h4 class=""><a href="{{ route('ServiceProvider.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('ServiceProvider.ProviderService.index') }}" class="text-muted fw-light">@lang('Services') </a> /
                        @lang('Edit')
                    </h4>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @include('Admin.layouts.Inc._errors')
                        <div class="card-body">
                            <form action="{{ route('ServiceProvider.ProviderService.update', $providerService->id) }}" method="POST" class="row">
                                @csrf
                                @method('PUT')

                                <div class="col-md-6 col-12 mb-3">
                                    <label class="form-label">@lang('service type') <span class="required-color">*</span></label>
                                    <select class="form-select" id="provider_service_type_id" name="provider_service_type_id" required>
                                        <option disabled selected value="">@lang('service type')</option>
                                        @foreach($providerServiceTypes as $providerServiceType)
                                            <option value="{{ $providerServiceType->id }}"
                                                    @if($providerServiceType->id == $providerService->provider_service_type_id) selected @endif>
                                                    {{ $providerServiceType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 col-12 mb-3">
                                    <label class="form-label">{{ __('price') }} <span class="required-color">*</span></label>
                                    <input type="number" required id="price" name="price" class="form-control"
                                        placeholder="{{ __('price') }}" value="{{ old('price', $providerService->price) }}">
                                </div>

                                <div class="col-md-6 col-12 mb-3">
                                    <label class="form-label">@lang('Description')</label>
                                    <textarea id="textarea" name="description" class="form-control"
                                        placeholder="@lang('Description')">{{ old('description', $providerService->description) }}</textarea>
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
            </div> <!-- end row -->
        </div> <!-- end container -->
    </div>

@endsection

