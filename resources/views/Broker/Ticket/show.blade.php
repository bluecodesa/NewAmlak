@extends('Admin.layouts.app')
@section('title', __('View Ticket'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 ">

                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Broker.Tickets.index') }}" class="text-muted fw-light">@lang('Tickets')
                        </a> /
                        @lang('View Ticket')
                    </h4>
                </div>
            </div>
            <!-- DataTable with Buttons -->

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
                      {{-- <div class="d-flex justify-content-center">
                        <a
                          href="javascript:;"
                          class="btn btn-primary me-3"
                          data-bs-target="#editUser"
                          data-bs-toggle="modal"
                          >Edit</a
                        >
                        <a href="javascript:;" class="btn btn-label-danger suspend-user">Suspended</a>
                      </div> --}}
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

        <div class="content-backdrop fade"></div>
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
                    var model = $(this).val();
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
