@extends('Admin.layouts.app')
@section('title', __('Advertisement Details'))
@section('content')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <h4 class="">
                    <a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                    <a href="{{ route('Admin.Advertisings.index') }}" class="text-muted fw-light">@lang('Ads')</a> /
                    @lang('Advertisement Details')
                </h4>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-12 mb-3">
                        <label class="form-label">@lang('Ad Name')</label>
                        <p>{{ $advertisement->ad_name }}</p>
                    </div>
                 

                    <div class="col-md-6 col-12 mb-3">
                        <label class="form-label">@lang('Client Name')</label>
                        <p>{{ $advertisement->client_name }}</p>
                    </div>

                    <div class="col-md-6 col-12 mb-3">
                        <label class="form-label">@lang('Ad URL')</label>
                        <p><a href="{{ $advertisement->ad_url }}" target="_blank">{{ $advertisement->ad_url }}</a></p>
                    </div>

                    <div class="col-md-6 col-12 mb-3">
                        <label class="form-label">@lang('Display Start Date')</label>
                        <p>{{ $advertisement->show_start_date }}</p>
                    </div>
                    <div class="col-md-6 col-12 mb-3">
                        <label class="form-label">@lang('Display End Date')</label>
                        <p>{{ $advertisement->show_end_date }}</p>
                    </div>
                    <div class="col-md-6 col-12 mb-3">
                        <label class="form-label">@lang('Ad Duration (days)')</label>
                        <p>{{ $advertisement->ad_duration }}</p>
                    </div>
                    <div class="col-md-6 col-12 mb-3">
                        <label class="form-label">@lang('Content')</label>
                        @if(pathinfo($advertisement->content, PATHINFO_EXTENSION) == 'pdf')
                            <a href="{{ asset($advertisement->content) }}" target="_blank">@lang('View PDF')</a>
                        @elseif(pathinfo($advertisement->content, PATHINFO_EXTENSION) == 'docx')
                            <a href="{{ asset($advertisement->content) }}" target="_blank">@lang('View DOCX')</a>
                        @elseif(in_array(pathinfo($advertisement->content, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                            <img src="{{ asset($advertisement->content) }}" alt="@lang('Advertisement Image')" class="img-fluid" style="max-width: 100%; height: 100px;">
                        @else
                            <video width="100%" controls style="max-width: 200px;">
                                <source src="{{ asset($advertisement->content) }}" type="video/mp4">
                                @lang('Your browser does not support the video tag.')
                            </video>
                        @endif
                    </div>
                    
                </div>
                <div class="col-12">
                    <a href="{{ route('Admin.Advertisings.index') }}" class="btn btn-secondary">
                        {{ __('Back') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="content-backdrop fade"></div>
</div>

@endsection
