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
                            <h4 class="page-title">
                                @lang('Subscriber Name') /   @if ($subscriber->office_id)
                                {{ $subscriber->OfficeData->UserData->name ?? '' }}
                            @elseif ($subscriber->broker_id)
                                {{ $subscriber->BrokerData->UserData->name ?? '' }}
                            @endif     </h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item"><a href="{{ route('Admin.Subscribers.show', $subscriber->id) }}">@lang('Show')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('Admin.Subscribers.index') }}">@lang('Subscribers')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('Admin.home') }}">@lang('dashboard')</a></li>
                            </ol>
                        </div>

                    </div> <!-- end row -->
                </div>
                <!-- end page-title -->

                <div class="row">

                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="card m-b-30 text-white"
                                            style="background-color: #333; border-color: #333;border-radius: 14px;">
                                            <div class="card-body">
                                                <h3 class="card-title font-16 mt-0">
                                                    <footer class="blockquote-footer font-12">
                                                        @if ($subscriber->office_id)
                                                        {{ $subscriber->OfficeData->UserData->name ?? '' }}
                                                    @elseif ($subscriber->broker_id)
                                                        {{ $subscriber->BrokerData->UserData->name ?? '' }}
                                                    @endif     <cite title="Source Title"></cite>
                                                    </footer>
                                                </h3>
                                                <div class="row mb-2">
                                                    <div class="col-md-3">
                                                        <h6> @lang('Subscriber Name') : <span class="badge font-13 badge-primary">
                                                            @if ($subscriber->office_id)
                                                            {{ $subscriber->OfficeData->UserData->name ?? '' }}
                                                        @elseif ($subscriber->broker_id)
                                                            {{ $subscriber->BrokerData->UserData->name ?? '' }}
                                                        @endif                                                            </span> </h6>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <h6> @lang('email') : <span class="badge font-13 badge-primary">
                                                            @if ($subscriber->office_id)
                                                            {{ $subscriber->OfficeData->UserData->email ?? '' }}
                                                        @elseif ($subscriber->broker_id)
                                                            {{ $subscriber->BrokerData->UserData->email ?? '' }}
                                                        @endif                                                             </span> </h6>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <h6> @lang('Account Type') :
                                                            <span class="badge font-13 badge-primary">
                                                                @if ($subscriber->office_id)
                                                                @lang('Office')
                                                            @elseif ($subscriber->broker_id)
                                                                @lang('Broker')
                                                            @endif                                                            </span>
                                                        </h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h6> @lang('Subscriber City') : <span class="badge font-13 badge-primary">
                                                            @if ($subscriber->office_id)
                                                            {{ $subscriber->OfficeData->CityData->name ?? '' }}
                                                        @endif
                                                        @if ($subscriber->broker_id)
                                                            {{ $subscriber->BrokerData->CityData->name ?? '' }}
                                                        @endif                                                 </span> </h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h6> @lang('phone') : <span class="badge font-13 badge-primary">
                                                            @if ($subscriber->office_id)
                                                            {{ $subscriber->OfficeData->presenter_number?? '' }}
                                                        @endif
                                                        @if ($subscriber->broker_id)
                                                            {{ $subscriber->BrokerData->mobile ?? '' }}
                                                        @endif


                                                            </span> </h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h6> @lang('id number') : <span class="badge font-13 badge-primary">
                                                            @if ($subscriber->office_id)
                                                            {{ $subscriber->OfficeData->presenter_number?? '' }}
                                                        @endif
                                                        @if ($subscriber->broker_id)
                                                            {{ $subscriber->BrokerData->id_number ?? '' }}
                                                        @endif


                                                            </span> </h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h6> @lang('license number') : <span class="badge font-13 badge-primary">
                                                            @if ($subscriber->office_id)
                                                            {{ $subscriber->OfficeData->presenter_number?? '' }}
                                                        @endif
                                                        @if ($subscriber->broker_id)
                                                            {{ $subscriber->BrokerData->broker_license ?? '' }}
                                                        @endif


                                                            </span> </h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h6> @lang('Subscription Status') :
                                                            <span
                                                            class="badge badge-pill p-1 badge-{{ $subscriber->is_suspend == 1 || $subscriber->status == 'pending' ? 'danger' : 'info' }}">
                                                            {{ $subscriber->is_suspend == 1 ? __('Subscription suspend') : __($subscriber->status) }}
                                                        </span>

                                                        </h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h6> @lang('Subscription Start join') :
                                                            <span class="badge font-13 badge-primary">
                                                                {{ $subscriber->created_at->format('Y-m-d') }}

                                                                 </span>
                                                        </h6>
                                                    </div>


                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <img class="rounded mr-2" alt="User image" style="width: 100%; height: 86%;"
                                            src="@if ($subscriber->office_id)
                                                    {{ $subscriber->OfficeData->company_logo ?? 'https://www.svgrepo.com/show/29852/user.svg' }}
                                                @elseif ($subscriber->broker_id)
                                                    {{ $subscriber->BrokerData->broker_logo ?? 'https://www.svgrepo.com/show/29852/user.svg' }} {{-- Use asset helper --}}
                                                @endif" data-holder-rendered="true">
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">



                        <div class="col-xl-4 col-md-6">
                            <div class="card pricing-box mt-4">
                                <div class="pricing-icon">
                                    <i class="ti-shield bg-primary"></i>
                                </div>
                                <div class="pricing-content">
                                    <div class="text-center">
                                        <h5 class="text-uppercase mt-5">   {{ $subscriber->SubscriptionTypeData->name}}
                                        </h5>
                                        <div class="pricing-plan mt-4 pt-2">
                                            <h1>{{ $subscriber->SubscriptionTypeData->period }} <small class="font-16">
                                                {{ __('ar.' . $subscriber->SubscriptionTypeData->period_type) }}</small></h1>
                                        </div>
                                        <div class="pricing-border mt-5"></div>
                                    </div>
                                    <div class="pricing-features mt-4">
                                        <p class="font-14 mb-2">@lang('Subscription Start') {{ $subscriber->start_date }}</p>
                                        <p class="font-14 mb-2">@lang('Subscription End') {{ $subscriber->end_date }}</p>
                                     </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <div class="card pricing-box mt-4">
                                <div class="pricing-icon">
                                    <i class="ti-shield bg-primary"></i>
                                </div>
                                <div class="pricing-content">
                                    <div class="text-center">
                                        <h5 class="text-uppercase mt-5"> احصائيات
                                        </h5>
                                        <div class="pricing-plan mt-4 pt-2">
                                            <p class="font-16 mb-2">@lang('Number Of Owners') {{ $numberOfowners }}</p>
                                            <p class="font-16 mb-2">@lang('عدد الوحدات') {{ $numberOfUnits }}</p>
                                            <p class="font-16 mb-2">@lang('عدد زوار المعرض')</p>

                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6">
                            <div class="card pricing-box mt-4">
                                <div class="pricing-icon">
                                    <i class="ti-shield bg-primary"></i>
                                </div>
                                <div class="pricing-content">
                                    <div class="text-center">
                                        <h5 class="text-uppercase mt-5"> النطاق الجغرافي</h5>
                                        <div class="pricing-plan mt-4 pt-2">
                                        </div>
                                        <div class="pricing-border mt-5"></div>
                                    </div>
                                    <div class="pricing-features mt-4">
                                      </div>

                                </div>
                            </div>
                        </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
