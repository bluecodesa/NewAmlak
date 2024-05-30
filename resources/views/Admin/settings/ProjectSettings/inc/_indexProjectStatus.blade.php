


                <div class="row p-1 mb-1">
                    <div class="col-12">
                        <h5 class="card-header">@lang('Project status') </h5>
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
                                                    class="btn btn-success buttons-collection  btn-label-secondary me-3 waves-effect waves-light"
                                                    tabindex="0" aria-controls="DataTables_Table_0" type="button"
                                                    aria-haspopup="dialog" aria-expanded="false"><span>
                                                        <i class="ti ti-download me-1 ti-xs"></i>Export</span></button>
                                            </div>
                                            @if (Auth::user()->hasPermission('create-support-ticket-type'))
                                                <div class="btn-group">
                                                    <a href="{{ route('Admin.ProjectSettings.create') }}"
                                                        class="btn btn-primary">
                                                        <span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                                                                class="d-none d-sm-inline-block">@lang('Add New Project Status')</span></span>
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
                                {{-- <th>#</th> --}}
                                <th>@lang('Name')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($projectStatus as  $projectStatu)
                            <tr>
                                {{-- <th>{{ $index + 1 }}</th> --}}
                                <td>{{  $projectStatu->name }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu" style="">
                                            @if (Auth::user()->hasPermission('update-support-ticket-type'))
                                                <a class="dropdown-item"
                                                    href="{{ route('Admin.ProjectSettings.edit', $projectStatu->id) }}">@lang('Edit')</a>
                                            @endif
                    
                                                <a href="javascript:void(0);"
                                                onclick="handleDelete('{{ $projectStatu->id }}')"
                                                class="dropdown-item delete-btn">@lang('Delete')</a>
                                            <form id="delete-form-{{ $projectStatu->id }}"
                                                action="{{ route('Admin.ProjectSettings.destroy', $projectStatu->id) }}"
                                                method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <td colspan="3">
                                <span class="text-danger">
                                    <strong>@lang('No Data Found!')</strong>
                                </span>
                            </td>
                            @endforelse


                        </tbody>
                    </table>
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
                XLSX.writeFile(wb, @json(__('Tickets')) + '.xlsx');
                alertify.success(@json(__('Download done')));
            }
        </script>
    @endpush
