@extends('Admin.layouts.app')

@section('title', __('View Ticket'))

@section('content')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-6">
                <h4 class="">
                    <a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                    <a href="{{ route('Admin.SupportTickets.index') }}" class="text-muted fw-light">@lang('Tickets Support')</a> /
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
                                        <span>{{ $ticket->content }}</span>
                                    </li>
                                    <li class="mb-2 pt-1">
                                        <span class="fw-medium me-1">@lang('Create Date'):</span>
                                        <span>{{ $ticket->created_at }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm-6">

                                @if (Auth::user()->hasPermission('close-support-ticket-admin'))
                                    @if ($ticket->status !== 'Closed')
                                    <a href="javascript:void(0);"
                                                        onclick="handleClose('{{ $ticket->id }}')"
                                                        class="btn btn-sm btn-danger">@lang('Close Ticket')</a>
                                        <form id="close-form-{{ $ticket->id }}"
                                             action="{{ route('Admin.closeTicket', $ticket->id) }}"
                                             style="display: none;" method="POST">
                                            @csrf
                                            {{-- <button type="submit" class="btn btn-sm btn-danger">@lang('Close Ticket')</button> --}}
                                        </form>
                                    @endif
                                @endif

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
                <div class="col-12 col-lg-8 mb-4 mb-xl-0">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="mt-4 small text-uppercase text-muted">@lang('Comments')</h5>
                            <div class="demo-inline-spacing mt-3">
                                <div class="list-group">
                                    @if($ticketResponses && $ticketResponses->isNotEmpty())
                                        @foreach ($ticketResponses as $response)
                                        <div class="list-group-item list-group-item-action d-flex align-items-center cursor-pointer">
                                            <img src="{{ optional($response->UserData)->avatar ?: 'https://www.svgrepo.com/show/29852/user.svg' }}"
                                                 alt="{{ optional($response->UserData)->name ?? 'Default Name' }}" class="rounded-circle me-3 w-px-50" />
                                            <div class="w-100">
                                                <div class="d-flex justify-content-between">
                                                    <div class="user-info">
                                                        <h6 class="mb-1">{{ $response->response }}</h6>
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
                <div class="col-12 col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="mt-4 small text-uppercase text-muted">@lang('Add your comment')</h5>
                    <div class="demo-inline-spacing mt-3">
                        <div class="list-group">

                    <!-- Form to add response -->
                    @if (Auth::user()->hasPermission('update-support-ticket-admin'))
                        <div class="mt-4">
                            <h5>@lang('Add your comment')</h5>
                            <form action="{{ route('Admin.SupportTickets.addResponse', $ticket->id) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="response" class="form-label">@lang('comment')</label>
                                    <textarea class="form-control" id="response" name="response" rows="5"
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
</script>
@endpush


@endsection


{{-- <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-6">
                <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                    <a href="{{ route('Admin.SupportTickets.index') }}" class="text-muted fw-light">@lang('Tickets Support')
                        /</a>

                    @lang('View Ticket')
                </h4>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="card m-b-30 p-2">
                    @include('Admin.layouts.Inc._errors')
                    <div class="card-body">
                        <h5 class="card-title">@lang('Ticket Details')</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>@lang('Ticket Number'):</strong> {{ $formatted_id }}</p>
                                <p><strong>@lang('Ticket Type'):</strong> {{ $ticket->ticketType->name }}</p>
                                <p><strong>@lang('Ticket Address'):</strong> {{ $ticket->subject }}</p>
                                <p><strong>@lang('Description'):</strong> {{ $ticket->content }}</p>
                                <p><strong>@lang('Ticket Status'):</strong> {{ __($ticket->status) }}</p>
                                <p><strong>@lang('Create Date'):</strong> {{ $ticket->created_at }}</p>

                            </div>
                            <div class="col-md-6">
                                @if ($ticket->image)
                                    <p><strong>@lang('Ticket Image'):</strong></p>
                                    <img src="{{ asset($ticket->image) }}" alt="Ticket Image" class="img-fluid">
                                @endif
                                <!-- Add other ticket details here -->
                            </div>
                        </div>



                    </div>

                    <!-- Status and Close Button -->
                    <div class="row mt-3">
                        <div class="col-sm-6">
                            <h3 class="mt-0 header-title">@lang('Ticket Status') : <label
                                    class="badge badge-primary">{{ __($ticket->status) }}</label></h3>
                        </div>
                        <div class="col-sm-6">

                            @if (Auth::user()->hasPermission('close-support-ticket-admin'))
                                @if ($ticket->status !== 'Closed')
                                    <form action="{{ route('Admin.closeTicket', $ticket->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">@lang('Close Ticket')</button>
                                    </form>
                                @endif
                            @endif

                        </div>
                    </div>


                    <div class="mt-4">
                        <h5>@lang('Comments')</h5>
                        @foreach ($ticketResponses as $response)
                            <div class="col-lg-9 mb-9">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <img src="{{ optional($response->UserData)->avatar ?: 'https://www.svgrepo.com/show/29852/user.svg' }}"
                                                class="mr-3 rounded-circle"
                                                alt="{{ optional($response->UserData)->name ?? 'Default Name' }}"
                                                style="width: 64px; height: 64px;">
                                            <div>
                                                <h6 class="mb-0">
                                                    {{ optional($response->UserData)->name ?? 'Anonymous' }}</h6>
                                                <small
                                                    class="text-muted">{{ $response->created_at->format('Y-m-d H:i:s') }}</small>
                                            </div>
                                        </div>
                                        <p class="card-text">{{ $response->response }}</p>

                                        <div class="bg-light text-black rounded p-3 shadow-sm">
                                            @if ($response->response_attachment)
                                                <label for="response" class="form-label">@lang('Attachment')</label>
                                                <div class="d-flex align-items-center">
                                                    <span>{{ basename($response->response_attachment) }}</span>
                                                    <a href="{{ asset($response->response_attachment) }}" download
                                                        class="ms-2 text-black">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>


                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>



                    @if ($ticket->status != 'Closed')
                        <!-- Form to add response -->
                        @if (Auth::user()->hasPermission('update-support-ticket-admin'))
                            <div class="mt-4">
                                <h5>@lang('Add your comment')</h5>
                                <form action="{{ route('Admin.SupportTickets.addResponse', $ticket->id) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="response" class="form-label">@lang('comment')</label>
                                        <textarea class="form-control" id="response" name="response" rows="5"
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
                    @endif
                </div>
            </div>
        </div>


    </div>

    <div class="content-backdrop fade"></div>
</div> --}}
