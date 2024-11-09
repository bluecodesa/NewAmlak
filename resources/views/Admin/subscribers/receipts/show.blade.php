@extends('Admin.layouts.app')
@section('title', __('Show Receipt'))
@section('content')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        @if ($receipt->status != "rejected")
            <div class="card">
                <div class="card-body">
                    <!-- Form for Accepting the Receipt -->
                    <form action="{{ route('Admin.Receipt.updateStatus', $receipt->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="accepted">
                        <button type="submit" class="btn btn-primary">@lang('accepted')</button>
                    </form>

                    <!-- Form for Rejecting the Receipt -->
                    <form action="{{ route('Admin.Receipt.updateStatus', $receipt->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit" class="btn btn-danger">@lang('rejected')</button>
                    </form>
                </div>

            </div>
        @endif
        <div class="row">
            <div class="col-12" dir="rtl">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="card-title">Receipt</h4>
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
