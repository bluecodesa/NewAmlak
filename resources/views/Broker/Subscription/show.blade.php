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


            <div class="card m-b-30 ">
                <div class="card-body ">
                    <div class="col-xl-12">

                            <div class="card-body">
                                <h5 class="text-uppercase mt-5">
                                    {{ Auth::user()->UserBrokerData->UserSystemInvoiceLatest->subscription_name }}
                                </h5>
                                <div class="pricing-plan mt-4 pt-2">
                                    <h1>{{ Auth::user()->UserBrokerData->UserSystemInvoiceLatest->period }}
                                        <small class="font-16">
                                            {{ __(Auth::user()->UserBrokerData->UserSystemInvoiceLatest->period_type) }}</small>
                                    </h1>
                                </div>

                                <div class=" row pricing-features mt-4">
                                    <div class="col-6">
                                        <p class="font-14 mb-2">@lang('Subscription Start')
                                            {{ $subscription->start_date }}</p>
                                        <p class="font-14 mb-2">@lang('Subscription End') {{ $subscription->end_date }}
                                        </p>
                                    </div>
                                    <div class="col-6">
                                        @if (Auth::user()->hasPermission('upgrade-subscription'))
                                            <button type="button" data-toggle="modal"
                                                data-target="#exampleModal"
                                                class="btn btn-primary">@lang('Subscription upgrade')</button>
                                        @endif
                                        <a href="{{ route('welcome') }}#pricing"
                                            class="btn btn-secondary modal-btn2 w-auto"
                                            target="_blank">@lang('Compare Plans')</a>
                                    </div>
                                </div>

                            </div>

                    </div>
                </div>
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
                                <td>{{ __($invoice->period) }} {{  __($invoice->period_type) }} </td>
                                <td>
                                    @if ($loop->last)
                                        {{ __($subscription->status) }}
                                    @else
                                        {{ __('expired') }}
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('Broker.ShowInvoice', $invoice->id) }}"
                                        class="btn btn-dark btn-sm waves-effect waves-light">@lang('view')
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

            <!--/ DataTable with Buttons -->


        </div>

        <div class="content-backdrop fade"></div>
    </div>
    @include('Broker.settings.inc._upgradePackage')

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
            }
        </script>
    @endpush
@endsection
