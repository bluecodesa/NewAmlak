
<div class="modal fade bs-example-modal-center2" id="basicModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-pricing">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h5 class="modal-title mt-0"> @lang('subscription') : @lang(Auth::user()->UserBrokerData->UserSubscriptionPending->status ?? 'pending') </h5>
                <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"></button>

                @if (Auth::check())
                    @if (Auth::user()->is_broker)
                        <h4 class="card-title  w-100 text-center">@lang('Welcome')
                            {{ Auth::user()->name }}</h4>
                    @elseif (Auth::user()->is_office)
                        <h4 class="card-title  w-100 text-center">@lang('Welcome')
                            {{ Auth::user()->company_name }}</h4>
                    @endif
                @endif


                @if ($pendingPayment)
                    <p class="card-text"> {{ __('Please renew your subscription to activate your account') }} </p>
                @else
                    <p class="card-text"> {{ __('Please renew your subscription to activate your account') }} </p>
                @endif


                <p>@lang('Choose the subscription system that suits you')</p>
                <div class="col-12">
                    {{-- <div class="row text-center">
                        @forelse ($UserSubscriptionTypes as $type)
                            <div class="col text-dark">
                                <label>
                                    <div class=" text-center border @if ($type->id == Auth::user()->UserBrokerData->UserSubscriptionPending->subscription_type_id) border-primary @else border-secondary @endif"
                                        style="cursor:pointer;">
                                        <div class="card-body text-black">
                                            {{ $type->name }}
                                            <p class="card-text">
                                                {{ $type->period }} {{ __($type->period_type) }}
                                                <br> {{ $type->price }} <sup>@lang('SAR')</sup>
                                            </p>
                                        </div>
                                        <div class="card-footer text-muted">
                                            <input type="radio" class="subscription_type"
                                                data-url="{{ route('Broker.UpdateSubscription', $type->id) }}"
                                                name="subscription_type" value="{{ $type->id }}"
                                                price="{{ $type->price }}"
                                                @if ($type->id == optional($subscription)->subscription_type_id) checked @endif>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        @empty
                            <p>@lang('No subscription types available')</p>
                        @endforelse

                    </div> --}}
                    <div class="row mx-0 gy-3 d-flex justify-content-center">

                        <!-- Pro -->
                        @forelse ($UserSubscriptionTypes as $type)

                        <div class="col-xl-3 col-md-3 mb-md-0 mb-4">
                          <div class="card border-primary border shadow-none h-100 @if ($type->id == Auth::user()->UserBrokerData->UserSubscription->subscription_type_id) border-primary @else border-secondary @endif">

                            <div class="card-body position-relative">
                              <div class="position-absolute end-0 me-4 top-0 mt-4">
                                {{-- <span class="badge bg-label-primary">{{ $type->period }} {{ __($type->period_type) }}</span> --}}
                              </div>

                              <h3 class="card-title text-center text-capitalize mb-1"> {{ $type->name }}
                              </h3>
                              <p class="text-center">{{ $type->period }} {{ __($type->period_type) }}</p>
                              <div class="text-center h-px-100 mb-2">
                                <div class="d-flex justify-content-center">
                                  <sup class="h6 pricing-currency mt-3 mb-0 me-1 text-primary">@lang('SAR')</sup>
                                  <h1 class="price-toggle price-yearly display-4 text-primary mb-0">{{ $type->price - $type->price * $type->upgrade_rate }}</h1>
                                  <h1 class="price-toggle price-monthly display-4 text-primary mb-0 d-none"></h1>
                                  {{-- <sub class="h6 text-muted pricing-duration mt-auto mb-2 fw-normal">/month</sub> --}}
                                </div>
                                <del><span class="price-yearly price-yearly-toggle text-muted">{{ $type->price }}</span></del>
                              </div>

                              <ul class="list-group ps-3 my-4">
                                  @foreach ($type->sections as $section)
                                      <li class="mb-2">{{ $section->name }}</li>
                                  @endforeach
                              </ul>

                              {{-- <button type="button" class="btn btn-primary d-grid w-100 mt-3" data-bs-dismiss="modal">
                                Upgrade
                              </button> --}}

                            </div>
                            <div class="modal-footer justify-content-center">

                                <input type="radio" class="subscription_type"
                                data-url="{{ route('Broker.UpdateSubscription', $type->id) }}"
                                name="subscription_type" value="{{ $type->id }}"
                                price="{{ $type->price }}"
                                @if ($type->id == optional($subscription)->subscription_type_id) checked @endif>
                            </div>
                          </div>
                        </div>
                        @empty
                        <p>@lang('No subscription types available')</p>
                    @endforelse

                </div>
                <hr>
                <div class="col-12">
                    <button type="button" class="btn btn-primary waves-effect waves-light view_inv" data-bs-toggle="modal"
                        data-bs-target=".bs-example-modal-lg" data-url="{{ route('Broker.ViewInvoice') }}">اكمال
                        الدفع</button>
                    <a href="{{ route('Broker.Tickets.index') }}" class="btn btn-outline-warning">@lang('technical support')</a>
                </div>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
</div>
