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
            <!-- DataTable with Buttons -->
            <div class="card">

                <div class="row p-1 mb-1">
                    <div class="col-12">
                        <h5 class="card-header">@lang('Users') </h5>
                    </div>

                </div>

                <div class="card-body">
                    <div class="mb-3 row">
                        <label for="name"
                            class="col-md-4 col-form-label text-md-end text-start"><strong>@lang('Name'):</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $user->name }}
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="email" class="col-md-4 col-form-label text-md-end text-start"><strong>
                                @lang('Email')</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $user->email }}
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="roles"
                            class="col-md-4 col-form-label text-md-end text-start"><strong>@lang('Roles')</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            <span
                                class="badge bg-dark">{{ app()->getLocale() == 'ar' ? $user->roles[0]->name_ar : $user->roles[0]->name ?? '' }}</span>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="roles"
                            class="col-md-4 col-form-label text-md-end text-start"><strong>@lang('sections')</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            @foreach ($user->getAllPermissions()->unique('section_id') as $permission)
                                <span class="badge bg-info">{{ $permission->SectionDate->name ?? '' }}</span>
                                @if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="roles"
                            class="col-md-4 col-form-label text-md-end text-start"><strong>@lang('Permissions')</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            @foreach ($user->getAllPermissions() as $permission)
                                <span
                                    class="badge bg-primary">{{ app()->getLocale() == 'ar' ? $permission->name_ar : $permission->name }}</span>
                                @if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        </div>
                    </div>

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
