<div class="row justify-content-center">

            <!-- DataTable with Buttons -->
            <div class="card">

                <div class="row p-1 mb-1">

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
                                            {{-- @if (Auth::user()->hasPermission('create-sections')) --}}
                                                <div class="btn-group">
                                                    <a href="{{ route('Broker.Setting.createFalLicense') }}" type="button"
                                                        class="btn btn-primary">
                                                        <span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                                                                class="d-none d-sm-inline-block">@lang('Add New')</span></span>
                                                    </a>
                                                </div>
                                            {{-- @endif --}}
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
                                {{-- <th>#</th> --}}
                                <th>@lang('Name')</th>
                                <th>@lang('License Number')</th>
                                <th>@lang('License Expiry')</th>
                                <th>@lang('status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($falLicenses as $index=> $falLicense)
                                <tr>
                                    {{-- <th>{{ $index + 1 }}</th> --}}
                                    <td>{{ $falLicense->falData->name }} </td>
                                    <td>{{ $falLicense->ad_license_number }} </td>
                                    <td>{{ $falLicense->ad_license_expiry }} </td>
                                    <td>{{ __($falLicense->ad_license_status) }} </td>


                                    <td>

                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                                {{-- @if (Auth::user()->hasPermission('update-sections')) --}}
                                                    <a class="dropdown-item"
                                                        href="{{ route('Broker.Setting.editFalLicense', $falLicense->id) }}">@lang('Edit')</a>
                                                {{-- @endif --}}

                                                {{-- @if (Auth::user()->hasPermission('delete-sections')) --}}
                                                    <a href="javascript:void(0);"
                                                        onclick="handleDelete('{{ $falLicense->id }}')"
                                                        class="dropdown-item delete-btn">@lang('Delete')</a>
                                                    <form id="delete-form-{{ $falLicense->id }}"
                                                        action="{{ route('Broker.Setting.deleteFalLicense', $falLicense->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                {{-- @endif --}}

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <td colspan="4">
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
                XLSX.writeFile(wb, @json(__('FalLicense')) + '.xlsx');
                alertify.success(@json(__('Download done')));
            }
        </script>
    @endpush
