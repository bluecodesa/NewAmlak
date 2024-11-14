@extends('Admin.layouts.app')

@section('title', __('Real Estate Requests'))

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 py-3">
                    <h4 class=""><a href="{{ route('Office.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        @lang('Real Estate Requests')</h4>
                </div>
            </div>
            <!-- DataTable with Buttons -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <hr>
            <div class="card">

                <div class="row p-1 mb-1">
                    <div class="col-12">
                        <h5 class="card-header">@lang('Real Estate Requests') </h5>
                    </div>

                    <div class="col-12">
                        <hr>
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
                                <th>@lang('Request Number')</th>
                                <th>@lang('Client Name')</th>
                                {{-- <th>@lang('Property type')</th> --}}
                                <th>@lang('city / district')</th>
                                <th>@lang('status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($requests as $index => $client)
                                <tr>


                                    <td>{{ $client->realEstateRequest->number_of_requests ?? '' }}</td>
                                    <td> {{ $client->user->name }}</td>
                                    <td>{{ $client->realEstateRequest->city->name }} / {{ $client->realEstateRequest->district->name ?? '' }}</td>
                                    <td>
                                        {{ __($client->interestType->name) }}

                                        {{-- @foreach ($client->requestStatuses as $status)
                                            @if ($status->request_status_id)
                                                {{ __($status->interestType->name) }}<br>
                                            @endif
                                        @endforeach --}}
                                    </td>

                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                                @if (Auth::user()->hasPermission('update-owner'))
                                                    <a class="dropdown-item"
                                                        href="{{ route('Office.RealEstateRequest.show', $client->realEstateRequest->id) }}">@lang('Show')</a>
                                                @endif

                                                @if(
                                                    isset($client->realEstateRequest) &&
                                                    isset($client->realEstateRequest->user) &&
                                                    isset($client->realEstateRequest->user->UserRenterData) &&
                                                    isset($client->realEstateRequest->user->UserRenterData->OfficeRenterData)
                                                )

                                                @else
                                                <form action="{{ route('Office.Renter.addAsRenter', $client->user_id ) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <a type="submit" class="dropdown-item">
                                                        @lang('Add as Renter')
                                                    </a>
                                                </form>
                                                @endif
                                            </div>
                                        </div>



                                    </td>

                                    {{-- <td>
                                        @if (Auth::user()->hasPermission('update-requests-interest'))
                                            <form method="POST"
                                                action="{{ route('Broker.Interest.status.update', $client->id) }}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $client->id }}">
                                                <select class="form-control select-input w-auto" name="status"
                                                    onchange="this.form.submit()">
                                                    @foreach ($interestsTypes as $interestsType)
                                                        <option value="{{ $interestsType->id }}"
                                                            {{ $client->status == $interestsType->id ? 'selected' : '' }}>
                                                            {{ __($interestsType->name) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="submit-from" hidden=""></button>
                                            </form>
                                        @endif


                                    </td> --}}

                                    {{-- <td>
                                        <a class="share btn btn-outline-secondary btn-sm waves-effect waves-light"
                                            target="_blank" data-toggle="modal"
                                            data-target="#shareLinkUnit{{ $client->id }}"
                                            href="tel:+{{ $client->key_phone }}{{ $client->whatsapp }}"
                                            onclick="document.querySelector('#shareLinkUnit{{ $client->id }} ul.share-tabs.nav.nav-tabs li:first-child a').click()">
                                            @lang('مكالمة')</a>
                                        <a href="https://web.whatsapp.com/send?phone=+{{ $client->key_phone }}{{ $client->whatsapp }}"
                                            class="btn btn-outline-warning btn-sm waves-effect waves-light"
                                            target="_blank">@lang('محادثة(شات)')</a>


                                    </td> --}}
                                </tr>
                            @empty
                                <td colspan="6">
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
                XLSX.writeFile(wb, @json(__('Roles')) + '.xlsx');
                alertify.success(@json(__('Download done')));
            }
        </script>
    @endpush
@endsection
