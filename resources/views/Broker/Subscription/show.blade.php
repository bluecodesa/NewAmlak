@extends('Admin.layouts.app')
@section('title', __('Subscribers'))
@section('content')


<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">
            <div class="page-title-box">
                    <div class="row align-items-center">

                        <div class="col-sm-6">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item"><a href="{{ route('Broker.ShowSubscription') }}">@lang('Subscription Management')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('Broker.home') }}">@lang('dashboard')</a></li>
                            </ol>
                        </div>

                    </div> <!-- end row -->
            </div>
                <!-- end page-title -->
            <div class="row">
                <div class="col-12">
                    <div class="card pricing-box mt-4">
                        <div class="pricing-icon">
                            @lang('Subscription Type')
                        </div>
                        <div class="pricing-content">
                            <div class="text-center">
                                <h5 class="text-uppercase mt-5">   {{ $subscription->SubscriptionTypeData->name}}
                                </h5>
                                <div class="pricing-plan mt-4 pt-2">
                                    <h1>{{ $subscription->SubscriptionTypeData->period }} <small class="font-16">
                                        {{ __('ar.' . $subscription->SubscriptionTypeData->period_type) }}</small></h1>
                                </div>
                                <div class="pricing-border mt-5"></div>
                            </div>
                            <div class=" row pricing-features mt-4">
                                <div class="col-6">
                                <p class="font-14 mb-2">@lang('Subscription Start') {{ $subscription->start_date }}</p>
                                <p class="font-14 mb-2">@lang('Subscription End') {{ $subscription->end_date }}</p>
                            </div>
                            <div class="col-6">
                                <a href="javascript:void(0)" onclick="handleRenewClick()" class="w-auto btn btn-primary modal-btn2">@lang('Renew')</a>


                            <a href="{{ route('welcome') }}#pricing"
                                class="btn btn-secondary modal-btn2 w-auto" target="_blank">@lang('Compare Plans')</a>
                            </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="col-sm-6">
                                <h4 class="page-title">
                                    @lang('سجل تاريخ الاشتراك')
                                </h4>
                            </div>
                            <div class="table-responsive b-0" data-pattern="priority-columns">
                                <table id="datatable-buttons"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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


                                        @foreach ($invoices as $index => $invoice)
                                        <tr>

                                            <td>{{ 1 }}</td>
                                            <td> {{  $invoice->subscription_name }} </td>
                                            <td>{{ __('ar.' . $invoice->period_type) }} </td>
                                           <td>
                                              @if($loop->last)
                                                                {{ __($subscription->status) }}
                                                            @else
                                                                {{ __('expired') }}
                                                            @endif
                                           </td>

                                           <td>
                                            <a href="{{ route('Broker.ShowInvoice', $invoice->id) }}"
                                                class="btn btn-dark btn-sm waves-effect waves-light">@lang('view')</a>

                                        </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div id="paymentModalContent" style="display: none;">
        @include('Broker.Subscription.Payment.payment')
    </div>


@endsection


<script>
    function handleRenewClick() {
        // Get the content of the hidden div
        var modalContent = document.getElementById('paymentModalContent').innerHTML;
        // Set the content in the modal
        document.getElementById('myModal').innerHTML = modalContent;
        // Open the modal
        openModal();
    }

    function openModal() {
        // Display the modal
        var modal = document.getElementById('myModal');
        modal.style.display = "block";
    }

    // Close the modal when the user clicks anywhere outside of it
    window.onclick = function(event) {
        var modal = document.getElementById('myModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
