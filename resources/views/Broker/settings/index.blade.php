@extends('Admin.layouts.app')

@section('title', __('Settings'))

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        @lang('Settings')</h4>
                </div>
            </div>
            <!-- DataTable with Buttons -->
            @php
                $sectionsIds = Auth::user()
                    ->UserBrokerData->UserSubscription->SubscriptionSectionData->pluck('section_id')
                    ->toArray();
            @endphp


            <div class="col-12">

                <div class="nav-align-top nav-tabs-shadow mb-4">
                    <ul class="nav nav-tabs" role="tablist">
                        @if (Auth::user()->hasPermission('update-user-profile'))
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-top-home" aria-controls="navs-top-home" aria-selected="true">
                                    @lang('profile')
                                </button>
                            </li>
                        @endif
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-top-profile" aria-controls="navs-top-profile" aria-selected="false"
                                tabindex="-1">
                                @lang('Gallary Mange')
                            </button>
                        </li>

                    </ul>
                    <div class="tab-content">
                        {{-- @if (Auth::user()->hasPermission('update-user-profile')) --}}
                        <div class="tab-pane fade active show" id="navs-top-home" role="tabpanel">
                            @include('Broker.settings.inc._GeneralSetting')
                        </div>
                        {{-- @endif --}}
                        @if ($gallery)
                            <div class="tab-pane fade" id="navs-top-profile" role="tabpanel">
                                @include('Broker.settings.inc._GalleryMange')
                            </div>
                        @else
                            <div class="col-lg-10">
                                <div class="card timeline shadow">
                                    <div class="card-header">
                                        <h5 class="card-title">@lang('لا يوجد معرض')</h5>
                                    </div>
                                    <div class="card-body">
                                        <p>@lang(' الاشتراك الحالي لا يحتوي ع المعرض ')</p>

                                        <button type="button" data-toggle="modal" data-target="#exampleModal"
                                            class="btn btn-primary">@lang('Subscription upgrade')</button>
                                    </div>
                                </div>
                            </div>
                            @include('Broker.settings.inc._upgradePackage')
                        @endif
                    </div>
                </div>
            </div>



            <!-- Modal to add new record -->



        </div>

        <div class="content-backdrop fade"></div>
    </div>



@endsection
