@extends('Admin.layouts.app')
@section('title', __('Show Receipt'))
@section('content')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-6 ">

                <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                    <a href="{{ route('Office.ShowSubscription') }}" class="text-muted fw-light">@lang('Subscription Management')
                    </a> /
                    @lang('Receipt')
                </h4>
            </div>
        </div>

        @if($receipt->comment)
        <div class="card">
            <div class="card-body">
                <h4>@lang('comment')</h4>
                <textarea disabled cols="150" rows="5">{!! ($receipt->comment) !!}</textarea>
            </div>
        </div>
        @endif

        <div class="row">
            <div class="col-12" dir="rtl">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="card-title">@lang('Receipt')</h4>
                        <div class="embed-responsive embed-responsive-16by9">
                            @if($receipt->receipt)
                                <div class="card card-action mb-4">
                                    <div class="card-body pb-0">
                                        @php
                                            $filePath = asset($receipt->receipt); // Generate public URL
                                        @endphp

                                        {{-- Check if the file is a PDF --}}
                                        @if (Str::endsWith($filePath, '.pdf'))
                                            <embed src="{{ $filePath }}" type="application/pdf" width="100%" height="500px" />
                                            <br>
                                            <a href="{{ $filePath }}" class="btn btn-success mt-3" download>
                                                تحميل الملف
                                            </a>
                                        @else
                                            {{-- Display image --}}
                                            <img src="{{ $filePath }}" class="img-fluid" alt="Receipt Image">
                                            <br>
                                            <a href="{{ $filePath }}" class="btn btn-success mt-3" download>
                                                تحميل الصورة
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <p>@lang('No receipt available')</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>

    <div class="content-backdrop fade"></div>
</div>

@endsection
