@extends('Admin.layouts.app')
@section('title', __('Show Receipt'))
@section('content')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-6 py-3">
                <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                    <a href="{{ route('Admin.Receipt.index') }}" class="text-muted fw-light">@lang('Subscriber Receipts') /</a>
                    @lang('Receipt'): {{ __($receipt->receipt_id) }}</h4>
            </div>

        </div>
        <!-- DataTable with Buttons -->
            <div class="card">
                <div class="card-body">
                    @if ($receipt->status === 'Under review')

                    <!-- Form for Accepting the Receipt -->
                    <form action="{{ route('Admin.Receipt.updateStatus', $receipt->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="accepted">
                        <button type="submit" class="btn btn-primary">@lang('accepted')</button>
                    </form>

                    <!-- Form for Rejecting the Receipt -->
                    {{-- <form action="{{ route('Admin.Receipt.updateStatus', $receipt->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit" class="btn btn-danger">@lang('rejected')</button>
                    </form> --}}
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#commentModal">
                        @lang('rejected')
                    </button>
                    @endif
                    {{-- <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#commentModal">
                        @lang('Add comment')
                    </button> --}}
                    {{-- comment --}}

                    {{-- <!-- Comment Modal -->
                    <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="commentModalLabel">@lang('Add Comment')</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Comment Form -->
                                    <form action="{{ route('Admin.Receipt.addComment', $receipt->id) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="commentText" class="form-label">@lang('Your Comment')</label>
                                            <textarea class="form-control" id="commentText" name="comment" rows="4" required></textarea>
                                        </div>
                                        <!-- Hidden input for linking the comment to a specific item (like receipt, project, etc.) -->
                                        <input type="hidden" name="item_id" value="{{ $receipt->id }}">
                                        <input type="hidden" name="item_type" value="receipt"> <!-- Change 'receipt' to match your context -->

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Cancel')</button>
                                            <button type="submit" class="btn btn-primary">@lang('Submit Comment')</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> --}}
<!-- Modal -->
<div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commentModalLabel">@lang('Add Comment')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('Admin.Receipt.updateStatus', $receipt->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="comment" class="form-label">@lang('Comment')</label>
                        <textarea class="form-control" id="comment" name="comment" rows="4" required></textarea>
                    </div>
                    <!-- إضافة حقل مخفي لحالة الرفض -->
                    <input type="hidden" name="status" value="rejected">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Cancel')</button>
                        <button type="submit" class="btn btn-danger">@lang('Reject')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



                    {{-- end of comment modal --}}

                </div>

            </div>
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
