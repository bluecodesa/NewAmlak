@extends('Admin.layouts.app')
@section('title', __('invoices'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-sm-6">
                                    <h4 class="page-title">
                                        @lang('invoices')</h4>
                                </div>

                            </div>
                        </div>

                    </div> <!-- end row -->
                </div>
                <!-- end page-title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="table-responsive b-0" data-pattern="priority-columns">
                                    <table id="datatable-buttons"
                                        class="table table-striped table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('Subscriber Name')</th>
                                                <th>@lang('Subscription Type')</th>
                                                <th>@lang('Subscription Time')</th>
                                                <th>@lang('Subscription Status')</th>
                                                <th>@lang('amount')</th>
                                                <th>@lang('Created Date')</th>
                                                <th>@lang('Action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($invoices as $index => $invoice)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $invoice->OfficeData->UserData->name ?? '' }}</td>
                                                    <td>
                                                        {{ __($invoice->subscription_type) }}
                                                    </td>
                                                    <td>{{ $invoice->period . ' ' . __('ar.' . $invoice->period_type) }}
                                                    </td>
                                                    <td>{{ __($invoice->status) }}</td>

                                                    <td>{{ number_format($invoice->amount, 2) }}
                                                        <sup>@lang('SAR')</sup>
                                                    </td>
                                                    <td>{{ $invoice->created_at->format('M j, Y, g:i A') }}</td>

                                                    <td>
                                                        <a href="{{ route('Admin.SystemInvoice.show', $invoice->id) }}"
                                                            class="btn btn-dark btn-sm waves-effect waves-light">@lang('view')</a>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->


            </div>
            <!-- container-fluid -->

        </div>

    </div>


    </div>
@endsection
