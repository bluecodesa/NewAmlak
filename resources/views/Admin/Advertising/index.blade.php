@extends('Admin.layouts.app')

@section('title', __('Ads'))

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 py-3">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        @lang('Ads')</h4>
                </div>
            </div>
            <!-- DataTable with Buttons -->

            <div class="card">
                <div class="row p-1 mb-1">
                    <div class="col-12">
                        <h5 class="card-header">@lang('Ads')</h5>
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
                                @if (Auth::user()->hasPermission('create-role'))
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
                                                @if (Auth::user()->hasPermission('create-sections'))
                                                <div class="btn-group">
                                                    <a href="{{ route('Admin.Advertisings.create') }}" type="button"
                                                        class="btn btn-primary">
                                                        <span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                                                                class="d-none d-sm-inline-block">@lang('Add')</span></span>
                                                    </a>
                                                </div>
                                            @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>

                <div class="table-responsive text-nowrap">
                    <table class="table" id="table">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>@lang('Name')</th>
                                <th>@lang('Content')</th>
                                <th>@lang('Client Name')</th>
                                <th>@lang('status')</th>
                                <th>@lang('Display Start Date')</th>
                                <th>@lang('Display End Date')</th>
                                <th>@lang('Ad Duration (days)')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($Ads as $index => $Ad)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $Ad->ad_name }}</td>
                                    <td>
                                        @if($Ad->content)
                                            @php
                                                $fileExtension = pathinfo($Ad->content, PATHINFO_EXTENSION);
                                            @endphp
                                            @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                                <img src="{{ asset($Ad->content) }}" alt="{{ $Ad->ad_name }}" width="100">
                                            @elseif (in_array($fileExtension, ['mp4', 'mov', 'avi', 'wmv', 'flv']))
                                                <video width="100" controls>
                                                    <source src="{{ asset($Ad->content) }}" type="video/{{ $fileExtension }}">
                                                    Your browser does not support the video tag.
                                                </video>
                                            @else
                                                <a href="{{ asset($Ad->content) }}" target="_blank">Download File</a>
                                            @endif
                                        @else
                                            <span>@lang('No Content')</span>
                                        @endif
                                    </td>
                                    <td>{{ $Ad->client_name }}</td>
                                    <td>{{ $Ad->status }}</td>
                                    <td>{{ \Carbon\Carbon::parse($Ad->show_start_date)->format('Y-m-d H:i:s') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($Ad->show_end_date)->format('Y-m-d H:i:s') }}</td>
                                    <td>{{ $Ad->ad_duration }} @lang('days')</td>
                                    <td>
                                        <a href="{{ route('Admin.Advertisings.show', $Ad->id) }}" class="btn btn-info btn-sm">
                                            <i class="ti ti-eye"></i> @lang('View')
                                        </a>
                                        <a href="{{ route('Admin.Advertisings.edit', $Ad->id) }}" class="btn btn-warning btn-sm">
                                            <i class="ti ti-edit"></i> @lang('Edit')
                                        </a>
                                        <form action="{{ route('Admin.Advertisings.destroy', $Ad->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                <i class="ti ti-trash"></i> @lang('Delete')
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                                            <span class="alert-icon text-danger me-2">
                                                <i class="ti ti-ban ti-xs"></i>
                                            </span>
                                            @lang('No Data Found!')
                                        </div>
                                    </td>
                                </tr>
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
                XLSX.writeFile(wb, @json(__('Ads')) + '.xlsx');

                alertify.success(@json(__('Download done')));
            }
        </script>
    @endpush
@endsection
