@extends('Admin.layouts.app')
@section('title', __('developers'))
@section('content')


    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6">
                    <h4 class="">
                        <a href="{{ route('Broker.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        @lang('developers')
                    </h4>
                </div>

            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">@lang('developers')</h5>
                </div>
                {{-- <div class="col-3 py-1">
                    <input id="SearchInput" class="form-control  rounded-pill mt-3" type="text"
                        placeholder="@lang('search...')">
                </div> --}}
                <div class="card-datatable table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <div class="card-header border-top rounded-0 py-2">
                            <div class="row">
                                <div class="col-6">

                                    <div class="me-5 ms-n2 pe-5">
                                        <div id="DataTables_Table_0_filter" class="dataTables_filter"><label>
                                                <input id="SearchInput" class="form-control" placeholder="@lang('search...')"
                                                    aria-controls="DataTables_Table_0"></label></div>
                                    </div>
                                </div>
                                <div class="col-6">

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

                                                <a href="{{ route('Broker.Developer.create') }}"
                                                    class="btn btn-secondary add-new btn-primary ms-2 ms-sm-0 waves-effect waves-light"
                                                    tabindex="0" aria-controls="DataTables_Table_0"
                                                    type="button"><span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i>
                                                        <span
                                                            class="d-none d-sm-inline-block">@lang('Add New Developer')</span></span></a>



                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table" id="table">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">@lang('Name')</th>
                                    <th scope="col">@lang('Email')</th>
                                    <th scope="col">@lang('phone')</th>
                                    <th scope="col">@lang('city')</th>
                                    <th scope="col">@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @forelse ($developers as $developer)
                                    <tr>
                                        <td>{{ $developer->name }}</td>
                                        <td>{{ $developer->email }}</td>
                                        <td>{{ $developer->phone }}</td>
                                        <td>{{ $developer->CityData->name }}</td>
                                        <td>

                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu" style="">



                                                    <a class="dropdown-item"
                                                        href="{{ route('Broker.Developer.edit', $developer->id) }}">@lang('Edit')</a>



                                                    <a href="javascript:void(0);"
                                                        onclick="handleDelete('{{ $developer->id }}')"
                                                        class="dropdown-item delete-btn">@lang('Delete')</a>
                                                    <form id="delete-form-{{ $developer->id }}"
                                                        action="{{ route('Broker.Developer.destroy', $developer->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>


                                                </div>
                                            </div>


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
            </div> <!-- end row -->

        </div>
        <!-- container-fluid -->
    </div>



    @push('scripts')
        <script>
            function exportToExcel() {
                var wb = XLSX.utils.table_to_book(document.getElementById('table'), {
                    sheet: "Sheet1"
                });
                XLSX.writeFile(wb, @json(__('developers')) + '.xlsx');
                alertify.success(@json(__('Download done')));
            }
        </script>
    @endpush

@endsection
