{{-- <div class="modal fade" id="basicModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('UpgradeSubscription') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('Subscription upgrade')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    @if (Auth::check())
                        @if (Auth::user()->is_broker)
                            <h4 class="card-title  w-100 text-center">@lang('Welcome')
                                {{ Auth::user()->name }}</h4>
                        @elseif (Auth::user()->is_office)
                            <h4 class="card-title  w-100 text-center">@lang('Welcome')
                                {{ Auth::user()->company_name }}</h4>
                        @endif
                    @endif

                    <h6>@lang('Get an extra discount on upgrading your subscription')</h6>

                    <p>@lang('Choose the subscription that suits you') </p>
                    <div class="row">

                        @forelse ($UserSubscriptionTypes as $type)
                            @if ($type->id != Auth::user()->UserBrokerData->UserSubscription->subscription_type_id)
                                <div class="col text-dark">
                                    <label>
                                        <div class=" text-center border @if ($type->id == Auth::user()->UserBrokerData->UserSubscription->subscription_type_id) border-primary @else border-secondary @endif"
                                            style="cursor:pointer;">
                                            <div class="card-body text-black">
                                                {{ $type->name }}
                                                <p class="card-text">

                                                    {{ $type->period }} {{ __($type->period_type) }}
                                                    <br>
                                                    <del style="font-weight: 400;">{{ $type->price }}</del>
                                                    <b
                                                        style="font-weight: 900;">{{ $type->price - $type->price * $type->upgrade_rate }}</b>

                                                    <sup>@lang('SAR')</sup>

                                                </p>
                                            </div>
                                            <div class="card-footer text-muted">
                                                <input type="radio" class="subscription_type" name="subscription_type"
                                                    value="{{ $type->id }}">
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            @endif
                        @empty
                            <p>@lang('No subscription types available')</p>
                        @endforelse
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('close')</button>
                    <button type="submit" class="btn btn-primary">@lang('Subscription upgrade')</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}


<div class="modal fade" id="basicModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-pricing">
        <div class="modal-content p-2 p-md-5">
            <form action="{{ route('UpgradeSubscription') }}" method="post">
                @csrf
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <h5 class="modal-title text-center" id="exampleModalLabel">@lang('Subscription upgrade')</h5>
                    @if (Auth::check())
                        @if (Auth::user()->is_office)
                            <h2 class="text-center mb-2">@lang('Welcome') {{ Auth::user()->name }}</h2>
                        @elseif (Auth::user()->is_office)
                            <h2 class="text-center mb-2">@lang('Welcome') {{ Auth::user()->company_name }}</h2>
                        @endif
                    @endif
                    <h6 class="text-center">@lang('Get an extra discount on upgrading your subscription')</h6>
                    <p class="text-center">@lang('Choose the subscription that suits you')</p>

                    <div class="row mx-0 gy-3 d-flex justify-content-center">
                        @forelse ($UserSubscriptionTypes as $type)
                            @if ($type->id != Auth::user()->UserOfficeData->UserSubscription->subscription_type_id)
                                <div class="col-xl-3 col-md-3 mb-md-0 mb-4">
                                    <label class="form-check custom-option custom-option-icon h-100">
                                        <div class="card border-primary border shadow-none h-100 @if ($type->id == Auth::user()->UserOfficeData->UserSubscription->subscription_type_id) border-primary @else border-secondary @endif">
                                            <div class="card-body position-relative">
                                                <div class="position-absolute end-0 me-4 top-0 mt-4"></div>
                                                <h3 class="card-title text-center text-capitalize mb-1">{{ $type->name }}</h3>
                                                <div class="text-center h-px-100 mb-2">
                                                    <div class="d-flex justify-content-center">
                                                        <sup class="h6 pricing-currency mt-3 mb-0 me-1 text-primary">@lang('SAR')</sup>
                                                        <h1 class="display-4 mb-0 text-primary">{{ $type->price - $type->price * $type->upgrade_rate }}</h1>
                                                        <sub class="h6 pricing-duration mt-auto mb-2 text-muted fw-normal">/{{ $type->period }} {{ __($type->period_type) }}</sub>
                                                    </div>
                                                    <del><small class="price-yearly price-yearly-toggle text-muted">@lang('SAR') {{ $type->price }}</small></del>
                                                </div>
                                                <ul class="list-group ps-3 my-4">
                                                    @foreach ($type->sections as $section)
                                                        <li class="mb-2">{{ $section->name }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="modal-footer justify-content-center">
                                                <input type="radio" class="subscription_type form-check-input" name="subscription_type" value="{{ $type->id }}" id="subscription{{ $type->id }}" required>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            @endif
                        @empty
                            <p>@lang('No subscription types available')</p>
                        @endforelse
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('close')</button>
                        <button type="submit" class="btn btn-primary">@lang('Subscription upgrade')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

