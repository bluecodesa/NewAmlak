@extends('Admin.layouts.app')

@section('title', __('Subscription Management'))

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        @lang('Subscription Management')</h4>
                </div>
            </div>
            <!-- DataTable with Buttons -->


            <div class="card mb-12">
                <!-- Current Plan -->
                <div class='row'>
                <div class="col-4">
                <h5 class="card-header">@lang('current subscription') </h5>
                </div>
                {{-- <div class="col-8">

                    @php
                    // Assuming you have stored user roles in the session
                    $user = auth()->user();
                            $roles = App\Models\Role::all();
                            $userRoles = $roles->filter(function ($role) use ($user) {
                                return $user->hasRole($role->name);

                            });
                                    // Retrieve the active role from the session
                                    $activeRole = session('active_role') ?? 'Switch Account'; // Default to 'Switch Account' if no role is set

                                    // Define the specific roles to show in the "Add New Account" dropdown
                                    $specificRoles = collect(['Owner','Renter']);

                                    // Get the roles that the user does not have yet
                                    $availableRoles = $specificRoles->diff($userRoles->pluck('name'));
                    @endphp
                    @if ($availableRoles->isNotEmpty())
                    <div class="mt-3">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="addAccountDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        @lang('Add New Account')
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="addAccountDropdown">
                            @foreach ($availableRoles as $role)
                                <li><a class="dropdown-item" href="#" onclick="handleRoleRedirect('{{ $role }}')">@lang($role)</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                </div> --}}

            </div>

                <div class="card-body">
                    <h4 class="mt-0 header-title">
                        <h4 class="mt-0 header-title">
                            {{ Auth::user()->UserOfficeData->UserSystemInvoiceLatest->subscription_name }}</h4>
                    </h4>

                    @if ($daysUntilEnd > 0)
                        <p class="sub-title" class="highlighter-rouge">
                            @if ($daysUntilEnd == 1)
                                <p class="sub-title" class="highlighter-rouge">1 @lang('Day Until End') </p>
                            @else
                                <p class="sub-title" class="highlighter-rouge">{{ $daysUntilEnd }} @lang('Days Until End')
                                </p>
                            @endif

                        </p>
                    @elseif($hoursUntilEnd > 0 || $minutesUntilEnd > 0)
                        <p class="sub-title" class="highlighter-rouge"> {{ $hoursUntilEnd }} @lang ('Hours Until
                            End') </p>
                    @else
                        <p class="sub-title" class="highlighter-rouge">{{ __($subscriber->status) }}</p>
                    @endif


                    <div class="progress">
                        <div id="progress-bar-{{ $subscriber->id }}" class="progress-bar" role="progressbar"
                            style="width: {{ $prec }}%;" aria-valuenow="{{ $prec }}" aria-valuemin="0"
                            aria-valuemax="100">
                            {{ $prec }}%
                        </div>
                    </div>

                    <p class="mt-1 mb-0"> @lang('Subscription End') {{ $subscriber->end_date }}</p>
                    <div class="col-12 text-center">

                        @if ($pendingPayment)
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#basicModal">@lang('Subscription upgrade')</button>
                            <a href="{{ route('welcome') }}#landingPricing"
                                class="btn btn-outline-primary  waves-effect me-2" target="_blank">@lang('Compare Plans')</a>
                        @elseif ($daysUntilEnd <= 7)
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#basicModal">@lang('Subscription upgrade')</button>
                            <a href="{{ route('welcome') }}#landingPricing"
                                class="btn btn-outline-primary  waves-effect me-2" target="_blank">@lang('Compare Plans')</a>
                        @elseif ($daysUntilEnd <= 0)
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#basicModal">@lang('Subscription upgrade')</button>
                            <p class="text-danger">{{ __($subscriber->status) }}</p>
                        @else
                            @include('Broker.inc._SubscriptionSuspend')
                        @endif
                    </div>
                </div>
                <!-- /Current Plan -->
            </div>
            <hr>
            <div class="card m-b-30 ">
                <div class="card-body ">
                    <h4 class="mt-0 header-title">
                        @lang('Record subscription history')
                    </h4>
                    <div class="table-responsive text-nowrap">
                        <table class="table" id="table">
                            <thead class="table-dark">
                                <tr>
                                    <th>@lang('Subscription Name')</th>
                                    <th>@lang('Subscription Time')</th>
                                    <th>@lang('Subscription Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices->unique('created_at') as $index => $invoice)
                                    <tr>

                                        <td> {{ $invoice->subscription_name }} </td>
                                        <td>{{ __($invoice->period) }} {{ __($invoice->period_type) }} </td>
                                        <td>
                                            @if ($loop->last)
                                                {{ __($subscription->status) }}
                                            @else
                                                {{ __('expired') }}
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('Office.ShowInvoice', $invoice->id) }}"
                                                class="btn btn-secondary add-new btn-primary btn-sm waves-effect waves-light">@lang('view')
                                                @lang('Invoice')</a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Modal to add new record -->
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

                                <th>@lang('Receipt Number')</th>
                                <th>@lang('Receipt Status')</th>
                                <th>@lang('Created Date')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">

                            @foreach ($receipts->unique('created_at') as $index => $receipt)
                                <tr>

                                    <td>
                                        {{ $receipt->receipt_id }}
                                    </td>
                                    <td><span class="badge bg-primary" style="font-size: 0.75rem; padding: 0.25em 0.5em;">
                                        {{ __($receipt->status) }}
                                    </span></td>

                                    <td>{{ $receipt->created_at->format('M j, Y, g:i A') }}</td>
                                    <td>

                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                                {{-- <a class="dropdown-item" href="{{ $receipt->receipt }}" class="btn btn-success mt-3" download>
                                                    @lang('Show')
                                                </a> --}}
                                                @if (Auth::user()->hasPermission('read-unit'))
                                                <a class="dropdown-item"
                                                    href="{{ route('Office.Receipt.show', $receipt->id) }}"
                                                    class="btn btn-outline-warning btn-sm waves-effect waves-light">@lang('Show')</a>
                                                @endif
                                                @if($receipt->status == "Under review")
                                                    @if (Auth::user()->hasPermission('read-project'))
                                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#updateReceiptModal-{{ $receipt->id }}">
                                                        @lang('Edit')
                                                    </a>
                                                    @endif
                                                 @endif
                                                 @if (Auth::user()->hasPermission('delete-project'))
                                                    @if ($receipt->status === 'Under review' || $receipt->status === 'rejected')

                                                        <a href="javascript:void(0);"
                                                            onclick="handleDelete('{{ $receipt->id }}')"
                                                            class="dropdown-item delete-btn">@lang('Delete')</a>
                                                        <form id="delete-form-{{ $receipt->id }}"
                                                            action="{{ route('Office.Receipt.delete', $receipt->id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    @endif
                                                @endif

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" id="updateReceiptModal-{{ $receipt->id }}" tabindex="-1" aria-labelledby="updateReceiptModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('Office.Receipt.update', $receipt->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="updateReceiptModalLabel">@lang('Update Receipt')</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <!-- Receipt File Input -->
                                                    <div class="mb-3">
                                                        <label for="receipt" class="form-label">@lang('Attach New Receipt (PDF/Image)')</label>
                                                        <input class="form-control" type="file" name="receipt" accept="image/*,application/pdf" required>
                                                    </div>

                                                    <!-- Optional Comment Input -->
                                                    <div class="mb-3">
                                                        <label for="comment" class="form-label">@lang('Comment')</label>
                                                        <textarea class="form-control" name="comment" rows="3">{{ $receipt->comment }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Cancel')</button>
                                                    <button type="submit" class="btn btn-primary">@lang('Update Receipt')</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <!--/ DataTable with Buttons -->


        </div>

        <div class="content-backdrop fade"></div>
    </div>
    @include('Office.settings.inc._upgradePackage')


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

        <script>
            $('.view_inv').on('click', function() {
                var url = $(this).data('url');
                //
                $.ajax({
                    type: "get",
                    url: url,
                    success: function(data) {
                        $("#ViewInvoice").empty();
                        $("#ViewInvoice").append(data);
                    },
                });
            })

            document.addEventListener("DOMContentLoaded", function() {
                var modalButton = document.getElementById('modalButton');
                if (modalButton) {
                    modalButton.click();
                }
            });
            //
            $('.subscription_type').on('change', function() {
                var url = $(this).data('url');
                $.ajax({
                    type: "get",
                    url: url,
                    success: function(data) {
                        alertify.success(@json(__('Subscription has been updated')));
                    },
                });
            });
        </script>

<script>
    function handleRoleRedirect(role) {
        if (role === 'Office-Admin') {
            redirectToCreateOffice();
        } else if (role === 'Rs-Broker') {
            redirectToCreateBroker();
        } else if (role === 'Owner' || role === 'Property-Finder') {
            redirectToCreatePropertyFinder();
        } else {
            alert('No redirection available for this role.');
        }
    }

    function redirectToCreateBroker() {
        window.location.href = "{{ route('Home.Brokers.CreateNewBroker') }}";
    }

    function redirectToCreatePropertyFinder() {
        window.location.href = "{{ route('Home.PropertyFinder.CreateNewPropertyFinder') }}";
    }

    function redirectToCreateOffice() {
        window.location.href = "{{ route('Home.Offices.CreateNewOffice') }}";
    }
</script>
    @endpush
@endsection
