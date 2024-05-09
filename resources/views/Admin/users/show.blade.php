@extends('Admin.layouts.app')
@section('title', __('Users'))

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 py-3">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        @lang('Users') / {{ $user->name }} </h4>
                </div>

            </div>

            <div class="row">
                <!-- User Sidebar -->
                <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                    <!-- User Card -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="user-avatar-section">
                                <div class="d-flex align-items-center flex-column">
                                    <img class="img-fluid rounded mb-3 pt-1 mt-4" src="{{ $user->getAvatar() }}"
                                        height="100" width="100" alt="{{ $user->name }}">
                                    <div class="user-info text-center">
                                        <h4 class="mb-2"> {{ $user->name }}</h4>
                                        <span class="badge bg-label-secondary mt-1">
                                            {{ app()->getLocale() == 'ar' ? $user->roles[0]->name_ar ?? '' : $user->roles[0]->name ?? '' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <p class="mt-4 small text-uppercase text-muted">@lang('Details')</p>
                            <div class="info-container">
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <span class="fw-medium me-1">@lang('Name'): </span>
                                        <span>{{ $user->name }}</span>
                                    </li>
                                    <li class="mb-2 pt-1">
                                        <span class="fw-medium me-1">@lang('Email') :</span>
                                        <span>{{ $user->email }}</span>
                                    </li>

                                </ul>

                            </div>
                        </div>
                    </div>
                    <!-- /User Card -->
                </div>
                <!--/ User Sidebar -->

                <!-- User Content -->
                <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                    <div class="nav-align-top nav-tabs-shadow mb-4">
                        <ul class="nav nav-tabs nav-fill" role="tablist">

                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-justified-profile" aria-controls="navs-justified-profile"
                                    aria-selected="false" tabindex="-1">
                                    @lang('sections')
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-justified-messages" aria-controls="navs-justified-messages"
                                    aria-selected="true">
                                    @lang('Permissions')
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content">

                            <div class="tab-pane fade active show" id="navs-justified-profile" role="tabpanel">
                                @foreach ($user->getAllPermissions()->unique('section_id') as $permission)
                                    <span class="badge bg-info">{{ $permission->SectionDate->name ?? '' }}</span>
                                    @if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </div>
                            <div class="tab-pane fade" id="navs-justified-messages" role="tabpanel">
                                <table class="table" id="table">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>@lang('Name')</th>
                                            <th>@lang('Model')</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        @forelse ($user->getAllPermissions() as $index=> $permission)
                                            <tr>
                                                <td>{{ app()->getLocale() == 'ar' ? $permission->name_ar : $permission->name }}
                                                </td>
                                                <td>{{ $permission->SectionDate->name ?? '' }}</td>
                                            </tr>
                                        @empty
                                            <td colspan="3">
                                                <span class="text-danger">
                                                    <strong>No Role Found!</strong>
                                                </span>
                                            </td>
                                        @endforelse

                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
                <!--/ User Content -->
            </div>


        </div>

        <div class="content-backdrop fade"></div>
    </div>


    @push('scripts')
        <script>
            function exportToExcel() {
                // Get the table by ID
                var table = document.getElementById('table');

                // Remove the last <td> from each row
                var rows = table.rows;
                for (var i = 0; i < rows.length; i++) {
                    rows[i].deleteCell(-1); // Deletes the last cell (-1) from each row
                }

                // Convert the modified table to a workbook
                var wb = XLSX.utils.table_to_book(table, {
                    sheet: "Sheet1"
                });

                // Save the workbook as an Excel file
                XLSX.writeFile(wb, @json(__('sections')) + '.xlsx');
            }
        </script>
    @endpush
@endsection
