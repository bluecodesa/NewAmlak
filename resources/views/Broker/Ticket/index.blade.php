@extends('Admin.layouts.app')

@section('title', __('Tickets List'))

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        @lang('Tickets List')</h4>
                </div>
            </div>
            <!-- DataTable with Buttons -->

            {{-- <div class="card ">
    <div class="card-body shadow-none bg-transparent">
        <div class="col-xl-12 ">
            <div class="card m-b-30 shadow-none bg-transparent">
                <h5 class="card-header mt-0">@lang('Support contact information')</h5>
                <div class="card-body shadow-none bg-transparent">
                    <h4 class="card-title font-16 mt-0">@lang('If you cannot find a solution to the problem you are facing in the help content. You can send a technical support ticket and select the relevant department from below.')</h4>

                    <div class="row">
                        <div class="col-sm-6 col-xl-3">
                            <div class="card shadow-sm">
                                <div class="card-heading p-4">
                                    <div class="mini-stat-icon float-left">
                                        <p>{{ $settings->support_email }}</p>
                                        <a href="mailto:{{ $settings->support_email }}"><i
                                                class="mdi mdi-email bg-primary text-white"></i></a>
                                        <h5 class="font-16">@lang('Technical support center')</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-3">
                            <div class="card shadow-sm">
                                <div class="card-heading p-4">
                                    <div class="mini-stat-icon float-left">
                                        <p>{{ $settings->support_phone }}</p>
                                        <a href="tel:{{ $settings->support_phone }}"><i
                                                class="mdi mdi-phone bg-primary text-white"></i></a>
                                        <h5 class="font-16">@lang('Technical support center')</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>



    </div>
   </div> --}}

            <div class="col-md-12 col-xl-12 mb-4">
                <div class="card h-100">
                    <div class="card-body">

                        {{-- <div class="row mt-5">
            <div class="col-12 text-center mb-4">
              <div class="badge bg-label-primary">@lang('Support contact information')</div>
              <h4 class="my-2">@lang('Support contact information')</h4>
              <p>@lang('If you cannot find a solution to the problem you are facing in the help content. You can send a technical support ticket and select the relevant department from below.')
            </p>
            </div>
          </div>
          <div class="row text-center justify-content-center gap-sm-0 gap-3">
            <div class="col-sm-6">
              <div class="py-3 rounded bg-faq-section text-center">
                <span class="badge bg-label-primary my-3 rounded-2 p-2">
                  <i class="ti ti-phone ti-md"></i>
                </span>
                <h4 class="mb-2"><a class="text-body" href="tel:+(966){{ $settings->support_phone }}">+ (966) {{ $settings->support_phone }}</a></h4>
                <p>@lang('Technical support center')</p>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="py-3 rounded bg-faq-section text-center">
                <span class="badge bg-label-primary my-3 rounded-2 p-2">
                  <i class="ti ti-mail ti-md"></i>
                </span>
                <h4 class="mb-2"><a class="text-body" href="mailto:{{ $settings->support_email }}">{{ $settings->support_email }}</a></h4>
                <p>@lang('Technical support center')</p>
              </div>
            </div>
          </div> --}}

                        <h4 class="mb-2 pb-1">@lang('Support contact information')</h4>
                        <p class="small">
                            @lang('If you cannot find a solution to the problem you are facing in the help content. You can send a technical support ticket and select the relevant department from below.')
                        </p>
                        <div class="row mb-3 g-3">
                            <div class="col-6">
                                <div class="d-flex">
                                    <div class="avatar flex-shrink-0 me-2">


                                        <a href="mailto:{{ $settings->support_email }}">
                                            <span class="avatar-initial rounded bg-label-primary"><i
                                                    class="ti ti-mail ti-md"></i></span></a>
                                    </div>
                                    <div>

                                        <h6 class="mb-0 text-nowrap">@lang('Technical support center')</h6>
                                        <small>{{ $settings->support_email }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex">
                                    <div class="avatar flex-shrink-0 me-2">
                                        <a href="tel:+{{ $settings->full_phone }}">

                                            <span class="avatar-initial rounded bg-label-primary"><i
                                                    class="ti ti-phone ti-md"></i></span> </a>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-nowrap">@lang('Technical support center')</h6>
                                        <small>{{ $settings->full_phone }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>


            {{--  --}}

            <div class="card">

                <div class="row p-1 mb-1">
                    <div class="col-12">
                        <h5 class="card-header">@lang('Tickets List') </h5>
                    </div>
                    <hr>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-4">
                                <div id="DataTables_Table_0_filter" class="dataTables_filter"><label>
                                        <input id="SearchInput" class="form-control" placeholder="@lang('search...')"
                                            aria-controls="DataTables_Table_0"></label></div>
                            </div>

                            <div class="col-8">
                                <div class="d-flex justify-content-start justify-content-md-end align-items-baseline">
                                    <div
                                        class="dt-action-buttons d-flex flex-column align-items-start align-items-md-center justify-content-sm-center mb-3 mb-md-0 pt-0 gap-4 gap-sm-0 flex-sm-row">
                                        <div class="dt-buttons btn-group flex-wrap d-flex">
                                            <div class="btn-group">
                                                <button onclick="exportToExcel()"
                                                    class="btn btn-outline-primary btn-sm waves-effect me-2"
                                                    type="button"><span><i
                                                            class="ti ti-download me-1 ti-xs"></i>Export</span></button>
                                            </div>
                                            @if (Auth::user()->hasPermission('create-support-ticket'))
                                                <div class="btn-group">
                                                    <a href="{{ route('Broker.Tickets.create') }}" type="button"
                                                        class="btn btn-primary">
                                                        <span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                                                                class="d-none d-sm-inline-block">@lang('Add New Ticket')</span></span>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="table-responsive text-nowrap">
                    <table class="table" id="table">
                        <thead class="table-dark">
                            <tr>

                                <th scope="col">@lang('Ticket Number')</th>
                                <th scope="col">@lang('Ticket Type')</th>
                                <th scope="col">@lang('Ticket Address')</th>
                                <th scope="col">@lang('Ticket Status')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($tickets as $ticket)
                                <tr>

                                    <td>{{ $ticket->formatted_id }}</td>
                                    <!-- Assuming id is the ticket number -->
                                    <td>{{ $ticket->ticketType->name }}</td>
                                    <!-- Assuming type is the ticket type -->
                                    <td>{{ $ticket->subject }}</td>
                                    <!-- Assuming subject is the ticket address -->
                                    <td>{{ __($ticket->status) }}</td>
                                    <!-- Assuming status is the ticket status -->
                                    <td>

                                        @if (Auth::user()->hasPermission('read-support-ticket'))
                                            <a href="{{ route('Broker.Tickets.show', $ticket->id) }}"
                                                class="btn btn-outline-info btn-sm waves-effect waves-light">@lang('Show')</a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <td colspan="5">
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
                XLSX.writeFile(wb, @json(__('Roles')) + '.xlsx');
                alertify.success(@json(__('Download done')));
            }
        </script>
    @endpush
@endsection
