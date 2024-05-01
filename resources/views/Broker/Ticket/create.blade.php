@extends('Admin.layouts.app')
@section('title', __('Add New Ticket'))
@section('content')

<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">
            <div class="page-title-box">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                <h4 class="page-title">
                                    @lang('Add New Ticket')</h4>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-right">
                                    <li class="breadcrumb-item" style="margin-top: 2px;"><a
                                            href="{{ route('Broker.Tickets.create') }}">@lang('Add New Ticket')</a></li>
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('Broker.Tickets.index') }}">@lang('Tickets')</a></li>
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('Broker.home') }}">@lang('dashboard')</a></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        @include('Admin.layouts.Inc._errors')
                        <div class="card-body">
                            <form action="{{ route('Broker.Tickets.store') }}" method="POST" class="row" enctype="multipart/form-data">
                                @csrf

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('Ticket Type') }} <span class="required-color">*</span></label>
                                        <select class="form-control" name="type" required>
                                            <option value="" selected disabled> @lang('Ticket Type') </option>
                                            @foreach ($ticketTypes as $ticketType)
                                            <option value="{{ $ticketType->id }}">
                                                {{ $ticketType->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label"> @lang('Ticket Address') <span class="required-color">*</span></label>
                                        <input type="text" required name="subject" class="form-control" placeholder="@lang('Ticket Address')">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('Description') }} <span class="required-color">*</span></label>
                                        <textarea class="form-control" name="content" rows="5" required></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">@lang('Image')</label>
                                        <input type="file" class="form-control" name="image" accept="image/jpeg,image/png,image/gif,image/jpg">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary me-1">{{ __('save') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- container-fluid -->
</div>

@endsection
