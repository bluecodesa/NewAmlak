@extends('Admin.layouts.app')

@section('title', __('owners'))

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        @lang('owners')</h4>
                </div>
            </div>
            <!-- DataTable with Buttons -->

            <div class="card">

                <div class="row p-1 mb-1">
                    <div class="col-12">
                        <h5 class="card-header">@lang('owners') </h5>
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
                                            @if (Auth::user()->hasPermission('create-owner'))
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                                                @lang('Add New Owner')
                                            </button>
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
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Email')</th>
                                <th scope="col">@lang('phone')</th>
                                <th scope="col">@lang('city')</th>
                                {{-- <th scope="col">@lang('Office')</th> --}}
                                <th scope="col">@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($owners as $owner)
                                <tr>

                                    <td>{{ $owner->name }}</td>
                                    <td>{{ $owner->email }}</td>
                                    <td>{{ $owner->UserData->full_phone }}</td>
                                    <td>{{ $owner->CityData->name ?? '-' }}</td>
                                    {{-- <td>{{ $owner->OfficeData->name }}</td> --}}
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                                @if (Auth::user()->hasPermission('update-owner'))
                                                    <a class="dropdown-item"
                                                        href="{{ route('Office.Owner.show', $owner->id) }}">@lang('Show')</a>
                                                @endif


                                                @if (Auth::user()->hasPermission('delete-owner'))
                                                    <a href="javascript:void(0);"
                                                        onclick="handleDelete('{{ $owner->id }}')"
                                                        class="dropdown-item delete-btn">@lang('Delete')</a>
                                                    <form id="delete-form-{{ $owner->id }}"
                                                        action="{{ route('Office.Owner.destroy', $owner->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                @endif

                                            </div>
                                        </div>



                                    </td>
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
            <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel1"> برجاء ادخال رقم هوية المالك
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        @include('Admin.layouts.Inc._errors')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col mb-3">
                                    <input type="text" name="id_number" id="idNumberInput" minlength="1" maxlength="10" class="form-control" placeholder="Enter ID Number" />
                                    <div class="invalid-feedback" id="idNumberError"></div>
                                </div>
                            </div>
                            <div id="searchResults"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                                @lang('Cancel')
                            </button>
                            <button type="button" class="btn btn-primary" id="searchBtn">@lang('Search')</button>
                        </div>
                    </div>
                </div>
            </div>

            @include('Office.ProjectManagement.Owner.inc._serach')


        </div>

        <div class="content-backdrop fade"></div>
    </div>


    @push('scripts')
        <script>
            function exportToExcel() {
                var table = document.getElementById('table');


                var wb = XLSX.utils.table_to_book(table, {
                    sheet: "Sheet1"
                });

                XLSX.writeFile(wb, @json(__('owners')) + '.xlsx');
                alertify.success(@json(__('Download done')));
            }
        </script>

        <script>
                $(document).ready(function () {
                $('#searchBtn').click(function (e) {
                    e.preventDefault();
                    var idNumber = $('#idNumberInput').val();

                    $.ajax({
                        url: '{{ route('Office.Owner.searchByIdNumber') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id_number: idNumber
                        },
                        success: function (response) {
                            $('#idNumberInput').removeClass('is-invalid');
                            $('#idNumberError').text('');
                            $('#searchResults').html(response.html); // Inject the result content into the modal
                        },
                        error: function (xhr) {
                            var errors = xhr.responseJSON.errors;
                            if (errors.id_number) {
                                $('#idNumberInput').addClass('is-invalid');
                                $('#idNumberError').text(errors.id_number[0]);
                            } else {
                                $('#searchResults').html('<div class="alert alert-danger">Error: ' + xhr.responseText + '</div>');
                            }
                        }
                    });
                });
            });

        </script>
    @endpush
@endsection
