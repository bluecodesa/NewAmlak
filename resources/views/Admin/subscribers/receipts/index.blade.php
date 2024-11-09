@extends('Admin.layouts.app')

@section('title', __('Receipts'))

@section('content')



    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 py-3">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        @lang('Receipts')</h4>
                </div>

            </div>
            <!-- DataTable with Buttons -->

            <div class="card">
                <div class="row p-1 mb-1">
                    <div class="col-12">
                        <h5 class="card-header">@lang('Receipts') </h5>
                    </div>
                    <hr>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <div id="DataTables_Table_0_filter" class="dataTables_filter"><label>
                                        <input id="SearchInput" class="form-control" placeholder="@lang('search...')"
                                            aria-controls="DataTables_Table_0"></label></div>
                            </div>

                            <div class="col-6">
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

                                <th>@lang('Subscriber Name')</th>
                                <th>@lang('Receipt Number')</th>
                                <th>@lang('Receipt Status')</th>
                                <th>@lang('Created Date')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">

                            @foreach ($receipts->unique('created_at') as $index => $receipt)
                                <tr>

                                    <td>{{ $receipt->OfficeData->UserData->name ?? ($receipt->BrokerData->UserData->name ?? '') }}
                                    </td>
                                    <td>
                                        {{ $receipt->receipt_id }}
                                    </td>
                                    <td>{{ __($receipt->status) }}</td>

                                    <td>{{ $receipt->created_at->format('M j, Y, g:i A') }}</td>
                                    <td>
                                        @if (Auth::user()->hasPermission('read-invoice-details'))
                                            <a href="{{ route('Admin.Receipt.show', $receipt->id) }}"
                                                class="btn btn-dark btn-sm waves-effect waves-light">@lang('view')</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                {{ $receipts->links() }}
            </div>
            <!-- Modal to add new record -->

            <!--/ DataTable with Buttons -->


        </div>

        <div class="content-backdrop fade"></div>
    </div>


    <div class="modal animate__animated animate__zoomIn" id="largeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">@lang('Add New Subscriber')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 text-center">
                            <a href="{{ route('Admin.Subscribers.create') }}" class="btn btn-primary">@lang('Office')</a>
                        </div>
                        <div class="col-6 text-center">
                            <a href="{{ route('Admin.Subscribers.CreateBroker') }}"
                                class="btn btn-primary">@lang('Broker')</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function exportToExcel() {
                var wb = XLSX.utils.table_to_book(document.getElementById('table'), {
                    sheet: "Sheet1"
                });
                XLSX.writeFile(wb, @json(__('Receipts')) + '.xlsx');
                alertify.success(@json(__('Download done')));
            }
        </script>
    @endpush
@endsection
