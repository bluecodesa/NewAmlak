@extends('Admin.layouts.app')
@section('title', __('Add'))
@section('content')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <h4 class="">
                    <a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                    <a href="{{ route('Admin.Advertisings.index') }}" class="text-muted fw-light">@lang('Ads')</a> /
                    @lang('Add')
                </h4>
            </div>
        </div>
        <div class="card">
            @include('Admin.layouts.Inc._errors')
            <div class="card-body">
                <form action="{{ route('Admin.Advertisings.store') }}" class="row" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-6 col-12 mb-3">
                        <label class="form-label">@lang('Ad Name')</label>
                        <input class="form-control" type="text" id="ad_name" name="ad_name" required>
                    </div>
                    <div class="col-md-6 col-12 mb-3">
                        <label class="form-label">@lang('Content')</label>
                        <input class="form-control" type="file" id="content" name="content" required accept="image/*,video/*,.pdf,.docx" required>
                        <small>@lang('Content can be an image, video, or file (PDF, DOCX)')</small>
                    </div>

                    <div class="col-md-6 col-12 mb-3">
                        <label class="form-label">@lang('Client Name')</label>
                        <input class="form-control" type="text" id="client_name" name="client_name" required>
                    </div>

                    <div class="col-md-6 col-12 mb-3">
                        <label class="form-label">@lang('Ad Url')</label>
                        <input class="form-control" type="text" id="ad_url" name="client_name" placeholder="https://tryamlak.com" required>
                    </div>

                    <div class="col-md-6 col-12 mb-3">
                        <label class="form-label">@lang('Display Start Date')</label>
                        <input class="form-control" type="date" id="show_start_date" name="show_start_date" required>
                    </div>
                    <div class="col-md-6 col-12 mb-3">
                        <label class="form-label">@lang('Display End Date')</label>
                        <input class="form-control" type="date" id="show_end_date" name="show_end_date" required>
                    </div>
                    <div class="col-md-6 col-12 mb-3">
                        <label class="form-label">@lang('Ad Duration (days)')</label>
                        <input class="form-control" type="number" id="ad_duration" name="ad_duration" required readonly>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">
                            {{ __('save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="content-backdrop fade"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const today = new Date().toISOString().split('T')[0];
        const startDateInput = document.getElementById('show_start_date');
        const endDateInput = document.getElementById('show_end_date');

        startDateInput.setAttribute('min', today);
        endDateInput.setAttribute('min', today);

        startDateInput.addEventListener('change', calculateDuration);
        endDateInput.addEventListener('change', calculateDuration);

        function calculateDuration() {
            const startDate = startDateInput.value;
            const endDate = endDateInput.value;

            if (startDate && endDate) {
                const start = new Date(startDate);
                const end = new Date(endDate);

                // Calculate the difference in time
                const diffTime = Math.abs(end - start);

                // Calculate the difference in days
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                // Set the duration in the input field
                document.getElementById('ad_duration').value = diffDays;
            }
        }
    });
</script>

@endsection
