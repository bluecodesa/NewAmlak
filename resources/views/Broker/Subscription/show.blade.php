@extends('Admin.layouts.app')
@section('title', __('Tickets'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">
                                @lang('Subscription Management')</h4>

                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item"><a
                                        href="{{ route('Broker.ShowSubscription') }}">@lang('Subscription Management')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('Broker.home') }}">@lang('dashboard')</a></li>
                            </ol>
                        </div>

                    </div> <!-- end row -->
                </div>
                <!-- end page-title -->

                <div class="row">

                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="col-xl-12">
                                    <div class="card m-b-30">
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


                                <h4 class="mt-0 header-title">
                                    @lang('Record subscription history')


                                </h4>
                                <div class="table-responsive b-0" data-pattern="priority-columns">
                                    <table id="datatable-buttons" class="table  table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>

                                                <th>@lang('Subscription Name')</th>
                                                <th>@lang('Subscription Time')</th>
                                                <th>@lang('Subscription Status')</th>
                                                <th>@lang('Action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($invoices->unique('created_at') as $index => $invoice)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td> {{ $invoice->subscription_name }} </td>
                                                    <td>{{ __($invoice->period_type) }} </td>
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
                    </div> <!-- end col -->
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div>
        <!-- container-fluid -->

        @include('Broker.settings.inc._upgradePackage')

    </div>


@endsection
