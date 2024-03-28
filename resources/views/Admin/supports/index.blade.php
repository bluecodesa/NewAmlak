@extends('Admin.layouts.app')
@section('title', __('Technical Support Orders'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">
                                @lang('Technical Support Orders')</h4>

                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item"><a href="{{ route('Admin.SupportTickets.index') }}">@lang('Technical Support Orders')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('Broker.home') }}">@lang('dashboard')</a></li>
                            </ol>
                        </div>

                    </div> <!-- end row -->
                </div>
                <!-- end page-title -->

                <div class="row">

                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">



    
                                <div class="table-responsive b-0" data-pattern="priority-columns">
                                    <table id="datatable-buttons" class="table  table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">@lang('Ticket Number')</th>
                                                <th scope="col">@lang('Ticket Type')</th>
                                                <th scope="col">@lang('Ticket Address')</th>
                                                <th scope="col">@lang('Ticket Status')</th>
                                                <th scope="col">@lang('Action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tickets as $ticket)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $ticket->id }}</td> <!-- Assuming id is the ticket number -->
                                                <td>{{  $ticket->ticketType->name }}</td> <!-- Assuming type is the ticket type -->
                                                <td>{{ $ticket->subject }}</td> <!-- Assuming subject is the ticket address -->
                                                <td>{{ __($ticket->status) }}</td> <!-- Assuming status is the ticket status -->
                                                <td>
                                                    <a href="{{ route('Broker.Tickets.show', $ticket->id) }}"
                                                        class="btn btn-outline-info btn-sm waves-effect waves-light">@lang('Show')</a>
                                                    <a href="javascript:void(0);" onclick="handleDelete()"
                                                        class="btn btn-outline-danger btn-sm waves-effect waves-light delete-btn">
                                                        @lang('Delete')
                                                    </a>
                                                    <form id="delete-form" action="{{ route('Broker.Tickets.destroy', $ticket->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div>
        <!-- container-fluid -->

    </div>

    {{-- @if($pendingPayment)
        @include('Home.Payments.pending_payment')
@endif
 --}}


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Show the modal when the page is fully loaded
        var modal = document.getElementById('pendingPaymentModal');
        if (modal) {
            modal.classList.add('show');
            modal.style.display = 'block';
            modal.removeAttribute('aria-hidden');
        }
    });
</script>

@endsection
