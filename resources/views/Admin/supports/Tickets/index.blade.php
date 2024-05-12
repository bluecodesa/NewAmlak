@extends('Admin.layouts.app')

@section('title', __('Technical Support Orders'))

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-6 py-3">
                <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                    @lang('Technical Support Orders')</h4>
            </div>
        </div>
        <!-- DataTable with Buttons -->

        <div class="card">

            <div class="row p-1 mb-1">
                <div class="col-12">
                    <h5 class="card-header">@lang('Technical Support Orders') </h5>
                </div>
                <hr>
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <div id="DataTables_Table_0_filter" class="dataTables_filter"><label>
                                    <input id="SearchInput" class="form-control"
                                        placeholder="@lang('search...')"></label></div>
                        </div>



                    </div>
                </div>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table" id="table">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">@lang('Client Name')</th>
                            <th scope="col">@lang('Ticket Number')</th>
                            <th scope="col">@lang('Ticket Type')</th>
                            <th scope="col">@lang('Ticket Address')</th>
                            <th scope="col">@lang('Ticket Status')</th>
                            <th scope="col">@lang('Create Date')</th>
                            <th scope="col">@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tickets as $ticket)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $ticket->UserData->name }}</td>
                                <!-- Assuming id is the ticket number -->
                                <td>{{ $ticket->formatted_id }}</td>
                                <!-- Assuming id is the ticket number -->
                                <td>{{ $ticket->ticketType->name }}</td>
                                <!-- Assuming type is the ticket type -->
                                <td>{{ $ticket->subject }}</td>
                                <!-- Assuming subject is the ticket address -->
                                <td>{{ __($ticket->status) }}</td>
                                <!-- Assuming status is the ticket status -->
                                <td>{{ $ticket->created_at }}</td>
                                <!-- Assuming status is the ticket status -->
                                <td>
                                    @if (Auth::user()->hasPermission('read-support-ticket-admin'))
                                        <a href="{{ route('Admin.SupportTickets.show', $ticket->id) }}"
                                            class="btn btn-outline-info btn-sm waves-effect waves-light">@lang('Show')</a>
                                    @endif
                                    @if (Auth::user()->hasPermission('delete-support-ticket-admin'))
                                        <a href="javascript:void(0);" onclick="handleDelete('{{ $ticket->id }}')"
                                            class="btn btn-outline-danger btn-sm waves-effect waves-light delete-btn">@lang('Delete')</a>
                                        <form id="delete-form-{{ $ticket->id }}"
                                            action="{{ route('Admin.SupportTickets.destroy', $ticket->id) }}"
                                            method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <td colspan="8">
                                <div class="alert alert-danger d-flex align-items-center" role="alert">
                                    <span class="alert-icon text-danger me-2">
                                        <i class="ti ti-ban ti-xs"></i>
                                    </span>
                                    @lang('No Data Found!')
                                </div>
                            </td>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal to add new record -->

        <!--/ DataTable with Buttons -->


    </div>

    <div class="content-backdrop fade"></div>
</div>


@push('scripts')
<script>
    function exportToExcel() {
        // Get the table by ID
        var table = document.getElementById('table');

        // Convert the modified table to a workbook
        var wb = XLSX.utils.table_to_book(table, {
            sheet: "Sheet1"
        });

        // Save the workbook as an Excel file
        XLSX.writeFile(wb, @json(__('Technical Support Orders')) + '.xlsx');
    }
</script>
@endpush
@endsection
