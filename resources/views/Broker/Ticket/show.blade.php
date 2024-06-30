@extends('Admin.layouts.app')
@section('title', __('View Ticket'))
@section('content')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-6">
                <h4 class="">
                    <a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                    <a href="{{ route('Broker.Tickets.index') }}" class="text-muted fw-light">@lang('Tickets')</a> /
                    @lang('View Ticket')
                </h4>
            </div>
        </div>
        <!-- DataTable with Buttons -->
        <div class="card">
            <div class="row">
                <div class="col-xl-8 col-lg-6 col-md-5 order-1 order-md-0">
                    <!-- User Card -->
                    <div class="card mb-4">
                        @include('Admin.layouts.Inc._errors')
                        <div class="card-body">
                            <h5 class="mt-4 small text-uppercase text-muted">@lang('Ticket Details')</h5>
                            <div class="info-container">
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <span class="fw-medium me-1">@lang('Ticket Number'):</span>
                                        <span>{{ $formatted_id }}</span>
                                    </li>
                                    <li class="mb-2">
                                        <span class="fw-medium me-1">@lang('Client Name'):</span>
                                        <span>{{ $ticket->UserData->name }}</span>
                                    </li>
                                    <li class="mb-2 pt-1">
                                        <span class="fw-medium me-1">@lang('Ticket Type'):</span>
                                        <span>{{ $ticket->ticketType->name }}</span>
                                    </li>
                                    <li class="mb-2 pt-1">
                                        <span class="fw-medium me-1">@lang('Ticket Status'):</span>
                                        <span class="badge bg-label-primary">{{ __($ticket->status) }}</span>
                                    </li>
                                    <li class="mb-2 pt-1">
                                        <span class="fw-medium me-1">@lang('Ticket Address'):</span>
                                        <p>{{ $ticket->subject }}</p>
                                    </li>
                                    <li class="mb-2 pt-1">
                                        <span class="fw-medium me-1">@lang('Description'):</span>
                                        {{-- <span>{{ $ticket->content }}</span> --}}
                                        <span class="mb-1">{!!  $ticket->content !!}</span>

                                    </li>
                                    <li class="mb-2 pt-1">
                                        <span class="fw-medium me-1">@lang('Create Date'):</span>
                                        <span>{{ $ticket->created_at }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-5 order-1 order-md-0">
                    <div class="card mb-4">
                        <div class="card-body">
                            <span class="card-title badge bg-label-primary">@lang('Ticket Image')</span>
                            @if ($ticket->image)
                            <div class="d-flex justify-content-between align-items-start">
                                <img src="{{ asset($ticket->image) }}" alt="Ticket Image" class="img-fluid">
                            </div>
                            @else
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <span class="alert-icon text-danger me-2">
                                    <i class="ti ti-ban ti-xs"></i>
                                </span>
                                @lang('No Data Found!')
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="m-0" />
        <div class="card">
            <div class="row">

                <!-- User List Style -->
                <div class="col-12 col-lg-10 mb-4 mb-xl-0">
                    <div class="card overflow-hidden mb-4">
                        <div class="card-body"  id="vertical-example">
                            <h5 class="mt-4 small text-uppercase text-muted">@lang('Comments')</h5>
                            <div class="demo-inline-spacing mt-3">
                                <div class="list-group" style="max-height: 400px; overflow-y: auto;">
                                    @if($ticketResponses && $ticketResponses->isNotEmpty())
                                        @foreach ($ticketResponses as $response)
                                        <div class="list-group-item list-group-item-action d-flex align-items-center cursor-pointer">
                                            <img src="{{ optional($response->UserData)->avatar ?: 'url('HOME_PAGE/img/avatars/14.png')' }}"
                                                 alt="{{ optional($response->UserData)->name ?? 'Default Name' }}" class="rounded-circle me-3 w-px-50" />
                                            <div class="w-100">
                                                <div class="d-flex justify-content-between">
                                                    <div class="user-info">
                                                        <h6 class="mb-1">{!! $response->response !!}</h6>
                                                        <small>{{ optional($response->UserData)->name ?? 'Anonymous' }}</small>
                                                        <div class="user-status">
                                                            <span class="badge"></span>
                                                            <small>{{ $response->created_at->format('Y-m-d H:i:s') }}</small>
                                                        </div>
                                                    </div>
                                                    <div class="add-btn">
                                                        @if ($response->response_attachment)
                                                        <span class="badge bg-label-secondary">{{ basename($response->response_attachment) }}</span>
                                                        <a class="btn btn-primary ti ti-download btn-sm" href="{{ asset($response->response_attachment) }}" download></a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                                        <span class="alert-icon text-danger me-2">
                                            <i class="ti ti-ban ti-xs"></i>
                                        </span>
                                        @lang('No Comments Found!')
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
                <!--/ User List Style -->
                <!-- Progress Style -->
                @if ($ticket->status != 'Closed')
                <div class="row">
                    <div class="col-12 col-lg-10 mb-4 mb-xl-0">
                        <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="mt-4 small text-uppercase text-muted">@lang('Add your comment')</h5>
                    <div class="demo-inline-spacing mt-3">
                        <div class="list-group">
                                <!-- Form to add response -->

                                @if (Auth::user()->hasPermission('update-support-ticket-user'))
                                    <div class="mt-4">
                                        <h5>@lang('Add your comment')</h5>
                                        <form id="commentForm"
                                            action="{{ route('Broker.tickets.addResponse', $ticket->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="response" class="form-label">@lang('comment')</label>
                                                {{-- <textarea class="form-control" id="response" name="response" rows="5"
                                                    @if ($ticket->status === 'closed') disabled @endif required></textarea> --}}
                                                    <textarea id="textarea" class="form-control" name="response" cols="30" rows="30" placeholder=""
                                                    @if ($ticket->status === 'closed') disabled @endif required></textarea>

                                            </div>
                                            <div class="mb-3">
                                                <label for="attachment" class="form-label">@lang('file')</label>
                                                <input type="file" class="form-control" id="attachment"
                                                    name="response_attachment"
                                                    accept="image/jpeg, image/png, image/jpg, image/gif, application/pdf"
                                                    @if ($ticket->status === 'closed') disabled @endif>
                                            </div>
                                            <button type="submit" class="btn btn-primary"
                                                @if ($ticket->status === 'closed') disabled @endif>@lang('Submit Comment')</button>
                                        </form>
                                    </div>
                                @endif

                        </div>
                    </div>
                        </div>
                    </div>
                </div>
                <!--/ Progress Style -->
            </div>
            @endif
        </div>

    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.model-checkbox').on('click', function() {
            var model = $(this).val();
            var checkboxes = $('input[name="permission[]"][data-model="' + model + '"]');
            checkboxes.prop('checked', $(this).prop('checked'));
        });

        $('.all-checkbox').on('click', function() {
            var checkboxes = $('input[name="permission[]"]');
            checkboxes.prop('checked', $(this).prop('checked'));
        });

        $('.TypeUser').on('click', function() {
            var show = $(this).val();
            var hide = $(this).data('hide');
            $('.' + show).css('display', 'block')
            $('.' + hide).css('display', 'none');
        });
    });

    $(document).ready(function() {
                $('#textarea').summernote({
                    height: 100, // set editor height
                    minHeight: null, // set minimum height of editor
                    maxHeight: null, // set maximum height of editor
                    focus: true, // set focus to editable area after initializing summernote
                    toolbar: [
                        // Include only the options you want in the toolbar, excluding 'fontname', 'video', and 'table'
                        ['style', ['bold', 'underline']],
                        ['insert', ['link', 'picture', 'hr']], // 'video' is deliberately excluded
                        ['para', ['ul', 'ol']],
                        ['misc', ['fullscreen', 'undo', 'redo']],
                        // Any other toolbar groups and options you want to include...
                    ],
                    // Explicitly remove table and font name options by not including them in the toolbar
                });
                $('.card-body .badge').click(function() {
                    var variableValue = $(this).attr('data-variable');
                    var $textarea = $('#textarea');
                    var summernoteEditor = $textarea.summernote('code');

                    // Check if Summernote editor is focused
                    if ($('.note-editable').is(':focus')) {
                        var node = document.createElement("span");
                        node.innerHTML = variableValue;
                        $('.note-editable').append(
                            node); // This line appends the variable as a new node to the editor
                        var range = document.createRange();
                        var sel = window.getSelection();
                        range.setStartAfter(node);
                        range.collapse(true);
                        sel.removeAllRanges();
                        sel.addRange(range);
                    } else {
                        var currentContent = $textarea.summernote('code');
                        $textarea.summernote('code', currentContent + variableValue);
                    }
                });
            });
</script>
@endpush

@endsection


