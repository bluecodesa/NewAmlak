@extends('Admin.layouts.app')
@section('title', __('invoices'))
@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">@lang('Invoice')</h4>
                        </div>

                    </div> <!-- end row -->
                </div>
                <!-- end page-title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="invoice-title">
                                            <h4 class="float-right font-16"><strong
                                                    class="badge p-1 badge-{{ $invoice->status == 'pending' ? 'danger' : 'success' }}">
                                                    {{ __(app()->getLocale() . '.' . $invoice->status) }} </strong></h4>
                                            <h3 class="m-t-0">
                                                <img src="{{ url($sitting->icon) }}" alt="logo" height="24" />
                                            </h3>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-6">
                                                <address>
                                                    <strong>@lang('From'):</strong><br>
                                                    {{ $sitting->title }} <br>
                                                    +966500334691<br>
                                                    الرياض - السعودية<br>
                                                    1010697291
                                                </address>
                                            </div>
                                            <div class="col-6 text-right">
                                                @if ($invoice->OfficeData != null)
                                                    <address>
                                                        <strong> @lang('To'):</strong><br>
                                                        {{ $invoice->OfficeData->company_name }} <br>
                                                        {{ $invoice->OfficeData->presenter_number }}<br>
                                                        {{ $invoice->OfficeData->CityData->name }}<br>
                                                        {{ $invoice->OfficeData->CRN }}
                                                    </address>
                                                @else
                                                    <address>
                                                        <strong> @lang('To'):</strong><br>
                                                        {{ $invoice->BrokerData->UserData->name }} <br>
                                                        {{ $invoice->BrokerData->mobile }}<br>
                                                        {{ $invoice->BrokerData->CityData->name }}<br>
                                                        {{ $invoice->BrokerData->broker_license }}
                                                    </address>
                                                @endif


                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="panel panel-default">
                                            <div class="p-2">
                                                <h3 class="panel-title font-20"><strong>@lang('Invoice details') </strong></h3>
                                            </div>
                                            <div class="">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <td class="text-center"><strong>@lang('service type')</strong>
                                                                </td>
                                                                <td class="text-center"><strong>@lang('amount')</strong>
                                                                </td>
                                                                <td class="text-center"><strong>@lang('quantity')</strong>
                                                                </td>
                                                                <td class="text-center"><strong>@lang('Subtotal')</strong>
                                                                </td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                                            <tr>
                                                                <td class="text-center">{{ $invoice->subscription_name }}
                                                                </td>
                                                                <td class="text-center">
                                                                    {{ number_format($invoice->amount, 2) }}
                                                                    <sub>@lang('SAR')</sub>
                                                                </td>
                                                                <td class="text-center">1</td>
                                                                <td class="text-center">
                                                                    {{ number_format($invoice->amount, 2) }}
                                                                    <sub>@lang('SAR')</sub>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td class="thick-line"></td>
                                                                <td class="thick-line"></td>
                                                                <td class="thick-line text-center">
                                                                    <strong>@lang('Subtotal')</strong>
                                                                </td>
                                                                <td class="thick-line text-right">$670.99</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="no-line"></td>
                                                                <td class="no-line"></td>
                                                                <td class="no-line text-center">
                                                                    <strong>@lang('Value added tax')</strong>
                                                                </td>
                                                                <td class="no-line text-right">44</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="no-line"></td>
                                                                <td class="no-line"></td>
                                                                <td class="no-line text-center">
                                                                    <strong>@lang('Total')</strong>
                                                                </td>
                                                                <td class="no-line text-right">
                                                                    <h4 class="m-0">
                                                                        {{ number_format($invoice->amount, 2) }}
                                                                        <sub>@lang('SAR')</sub>
                                                                    </h4>
                                                                </td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="d-print-none mo-mt-2">
                                                    <div class="float-right">
                                                        <a href="javascript:window.print()"
                                                            class="btn btn-success waves-effect waves-light"><i
                                                                class="fa fa-print"></i></a>
                                                        <a href="#"
                                                            class="btn btn-primary waves-effect waves-light">Send</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div> <!-- end row -->

                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->


            </div>
            <!-- container-fluid -->

        </div>
        <!-- content -->



    </div>
@endsection
