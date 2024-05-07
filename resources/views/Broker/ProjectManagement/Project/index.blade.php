@extends('Admin.layouts.app')
@section('title', __('Projects'))
@section('content')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-6 py-3 mb-3">
                <h4 class="">
                    <a href="{{ route('Broker.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                    @lang('Projects')</h4>
            </div>

        </div>

        <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">@lang('Projects')</h5>
                </div>
                {{-- <div class="col-3 py-1">
                    <input id="SearchInput" class="form-control  rounded-pill mt-3" type="text"
                        placeholder="@lang('search...')">
                </div> --}}
                <div class="card-datatable table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <div class="card-header d-flex border-top rounded-0 flex-wrap py-2">
                            <div class="me-5 ms-n2 pe-5">
                                <div id="DataTables_Table_0_filter" class="dataTables_filter"><label>
                                    <input id="SearchInput" class="form-control" placeholder="@lang('search...')" aria-controls="DataTables_Table_0"></label></div>
                            </div>
                            <div class="d-flex justify-content-start justify-content-md-end align-items-baseline">
                                <div class="dt-action-buttons d-flex flex-column align-items-start align-items-md-center justify-content-sm-center mb-3 mb-md-0 pt-0 gap-4 gap-sm-0 flex-sm-row">
                                    <div
                                        class="dt-buttons btn-group flex-wrap d-flex">
                                        <div class="btn-group">
                                            <button onclick="exportToExcel()" class="btn btn-success buttons-collection  btn-label-secondary me-3 waves-effect waves-light" tabindex="0" aria-controls="DataTables_Table_0" type="button" aria-haspopup="dialog" aria-expanded="false"><span>
                                                <i class="ti ti-download me-1 ti-xs"></i>Export</span></button>
                                            </div>
                                            {{-- <button class="btn btn-secondary add-new btn-primary ms-2 ms-sm-0 waves-effect waves-light" tabindex="0" aria-controls="DataTables_Table_0" type="button"><span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i>
                                                <span class="d-none d-sm-inline-block">@lang('Add')</span></span></button> --}}

                                                <div class="btn-group">
                                                    <button
                                                      type="button"
                                                      class="btn btn-primary dropdown-toggle"
                                                      data-bs-toggle="dropdown"
                                                      aria-expanded="false">
                                                      <span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">@lang('Add')</span></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        @if (Auth::user()->hasPermission('create-project'))
                                                        <li><a class="dropdown-item" href="{{ route('Broker.Project.create') }}">@lang('Add New Project')</a></li>
                                                      @endif
                                                      @if (Auth::user()->hasPermission('create-building'))
                                                        <li><a class="dropdown-item" href="{{ route('Broker.Property.create') }}">@lang('Add new property')</a></li>
                                                        @endif
                                                        @if (Auth::user()->hasPermission('create-unit'))

                                                        <li><a class="dropdown-item" href="{{ route('Broker.Unit.create') }}">@lang('Add unit')</a></li>
                                                        @endif
                                                    </ul>
                                                  </div>
                                            </div>
                            </div>
                        </div>
                    </div>
                <table class="table" id="table">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>@lang('project name')</th>
                            <th>@lang('city')</th>
                            <th>@lang('Number Properties')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($Projects as $index => $project)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $project->name ?? '' }}</td>
                            <td>{{ $project->CityData->name ?? '' }}</td>
                            <td> {{ $project->PropertiesProject->count() }} </td>
                            <td>

                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu" style="">
                                        <a class="dropdown-item"
                                        href="{{ route('Broker.Project.show', $project->id) }}">@lang('Show')</a>
                                        @if (Auth::user()->hasPermission('read-project'))
                                          <a class="dropdown-item"
                                                href="{{ route('Broker.Project.edit', $project->id) }}">@lang('Edit')</a>
                                        @endif
                                        @if (Auth::user()->hasPermission('delete-project'))
                                        <a href="javascript:void(0);"
                                                onclick="handleDelete('{{ $project->id }}')"
                                                class="dropdown-item delete-btn">@lang('Delete')</a>
                                            <form id="delete-form-{{ $project->id }}"
                                                action="{{ route('Broker.Project.destroy', $project->id) }}"
                                                method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endif

                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
            </div> <!-- end row -->

        </div>
        <!-- container-fluid -->
</div>


    {{-- @if ($pendingPayment)
        @include('Home.Payments.pending_payment')
@endif --}}




{{-- <div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Filter</h5>
        <div class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0">
            <div class="col-md-4 product_status"><select id="ProductStatus" class="form-select text-capitalize"><option value="">Status</option><option value="Scheduled">Scheduled</option><option value="Publish">Publish</option><option value="Inactive">Inactive</option></select></div>
            <div class="col-md-4 product_category"><select id="ProductCategory" class="form-select text-capitalize"><option value="">Category</option><option value="Household">Household</option><option value="Office">Office</option><option value="Electronics">Electronics</option><option value="Shoes">Shoes</option><option value="Accessories">Accessories</option><option value="Game">Game</option></select></div>
            <div class="col-md-4 product_stock"><select id="ProductStock" class="form-select text-capitalize"><option value=""> Stock </option><option value="Out_of_Stock">Out of Stock</option><option value="In_Stock">In Stock</option></select></div>
        </div>
    </div>
    <div class="card-datatable table-responsive">
        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
            <div class="card-header d-flex border-top rounded-0 flex-wrap py-2">
                <div class="me-5 ms-n2 pe-5">
                    <div id="DataTables_Table_0_filter" class="dataTables_filter">
                        <label>
                            <input type="Search" id="SearchInput" class="form-control" placeholder="Search..." aria-controls="DataTables_Table_0">

                        </label>
                    </div>
                </div>
                <div class="d-flex justify-content-start justify-content-md-end align-items-baseline">
                    <div class="dt-action-buttons d-flex flex-column align-items-start align-items-md-center justify-content-sm-center mb-3 mb-md-0 pt-0 gap-4 gap-sm-0 flex-sm-row">
                        <div class="dataTables_length mt-2 mt-sm-0 mt-md-3 me-2" id="DataTables_Table_0_length"><label><select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class="form-select"><option value="7">7</option><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="70">70</option><option value="100">100</option></select></label></div>
                        <div
                            class="dt-buttons btn-group flex-wrap d-flex">
                            <div class="btn-group">
                                <button onclick="exportToExcel()" class="btn btn-success buttons-collection dropdown-toggle btn-label-secondary me-3 waves-effect waves-light" tabindex="0" aria-controls="DataTables_Table_0" type="button" aria-haspopup="dialog" aria-expanded="false"><span>
                                    <i class="ti ti-download me-1 ti-xs"></i>Export</span></button></div>
                            <a href ="{{ route('Broker.Project.create') }}" class="btn btn-secondary add-new btn-primary ms-2 ms-sm-0 waves-effect waves-light" tabindex="0" aria-controls="DataTables_Table_0" type="button"><span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i>
                                <span class="d-none d-sm-inline-block">@lang('Add New Project')</span></span></a>
                                <a href ="{{ route('Broker.Project.create') }}" class="btn btn-secondary add-new btn-primary ms-2 ms-sm-0 waves-effect waves-light" tabindex="0" aria-controls="DataTables_Table_0" type="button"><span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i>
                                    <span class="d-none d-sm-inline-block">@lang('Add new property')</span></span></a>
                                    <a href ="{{ route('Broker.Project.create') }}" class="btn btn-secondary add-new btn-primary ms-2 ms-sm-0 waves-effect waves-light" tabindex="0" aria-controls="DataTables_Table_0" type="button"><span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i>
                                        <span class="d-none d-sm-inline-block">@lang('Add unit')</span></span></a>
                        </div>
                        <div class="btn-group">
                            <button
                              type="button"
                              class="btn btn-primary dropdown-toggle"
                              data-bs-toggle="dropdown"
                              aria-expanded="false">
                              @lang('Add')
                            </button>
                            <ul class="dropdown-menu">
                                @if (Auth::user()->hasPermission('create-project'))
                                <li><a class="dropdown-item" href="{{ route('Broker.Project.create') }}">@lang('Add New Project')</a></li>
                              @endif
                              @if (Auth::user()->hasPermission('create-building'))
                                <li><a class="dropdown-item" href="{{ route('Broker.Property.create') }}">@lang('Add new property')</a></li>
                                @endif
                                @if (Auth::user()->hasPermission('create-unit'))

                                <li><a class="dropdown-item" href="{{ route('Broker.Unit.create') }}">@lang('Add unit')</a></li>
                                @endif
                            </ul>
                          </div>
                </div>
            </div>
        </div>
        <table class="datatables-products table dataTable no-footer dtr-column" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 1336px;">
            <thead class="border-top">
                <tr>

                    <th>#</th>
                    <th class="control sorting_disabled dtr-hidden" rowspan="1" colspan="1" style="width: 0px; display: none;" aria-label=""></th>
                    <th class="sorting_disabled dt-checkboxes-cell dt-checkboxes-select-all" rowspan="1" colspan="1" style="width: 18px;" data-col="1" aria-label=""><input type="checkbox" class="form-check-input"></th>
                    <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 407px;" aria-label="product: activate to sort column descending"
                        aria-sort="ascending">@lang('project name')</th>
                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 124px;" aria-label="category: activate to sort column ascending">@lang('city')</th>
                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 44px;" aria-label="sku: activate to sort column ascending">@lang('Number Properties')</th>

                    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 98px;" aria-label="Actions">@lang('Action')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($Projects as $index => $project)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="  control" tabindex="0" style="display: none;"></td>
                    <td class="  dt-checkboxes-cell"><input type="checkbox" class="dt-checkboxes form-check-input"></td>
                    <td class="sorting_1">
                        <h6 class="text-body text-nowrap mb-0">{{ $project->name ?? '' }}</h6>
                    </td>
                    <td><span class="text-truncate d-flex align-items-center">{{ $project->CityData->name ?? '' }}</span>
                    </td>
                    <td><span class="badge bg-label-info" text-capitalized="">{{ $project->PropertiesProject->count() }}</span></td>
                    <td>
                        <div class="d-inline-block text-nowrap">
                            @if (Auth::user()->hasPermission('read-project'))
                            <a href="{{ route('Broker.Project.edit', $project->id) }}" class="btn btn-sm btn-icon"><i class="ti ti-edit"></i></a>
                            @endif
                            @if (Auth::user()->hasPermission('delete-project'))
                            <a href="javascript:void(0);" onclick="handleDelete('{{ $project->id }}')" class="btn btn-sm btn-icon delete-record"><i class="ti ti-trash"></i></a>

                        <form id="delete-form-{{ $project->id }}"
                            action="{{ route('Broker.Project.destroy', $project->id) }}"
                            method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                            @endif
                            <button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical me-2"></i></button>
                            <div class="dropdown-menu dropdown-menu-end m-0">
                                <a href="{{ route('Broker.Project.show', $project->id) }}" class="dropdown-item">@lang('view')</a>
                            </div>
                    </div>
                    </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div> --}}



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

@push('scripts')
<script>
    function exportToExcel() {
        var wb = XLSX.utils.table_to_book(document.getElementById('table'), {
            sheet: "Sheet1"
        });
        XLSX.writeFile(wb, @json(__('Projects')) + '.xlsx');
    }
</script>

<script>
    function exportToExcel2() {
        var wb = XLSX.utils.table_to_book(document.getElementById('DataTables_Table_0'), {
            sheet: "Sheet1"
        });
        XLSX.writeFile(wb, @json(__('Record Deleted subscriptionTypes')) + '.xlsx');
    }
</script>
@endpush

@endsection
