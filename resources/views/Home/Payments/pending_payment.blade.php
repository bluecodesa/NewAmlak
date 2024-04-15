<button id="modalButton" type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal"
    data-target=".bs-example-modal-center"></button>

<div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0"> @lang('subscription') : @lang(Auth::user()->UserBrokerData->UserSubscriptionPending->status ?? 'pending') </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
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
                @if ($pendingPayment)
                    <p class="card-text"> {{ __('status.expired') }} </p>
                @else
                    <p class="card-text"> {{ __('status.pending') }} </p>
                @endif


                <p>@lang('Choose the subscription system that suits you')</p>
                <div class="col-12">
                    <div class="row text-center">
                        @forelse ($UserSubscriptionTypes as $type)
                            <div class="col text-dark">
                                <label>
                                    <div class=" text-center border @if ($type->id == Auth::user()->UserBrokerData->UserSubscriptionPending->subscription_type_id) border-primary @else border-secondary @endif"
                                        style="cursor:pointer;">
                                        <div class="card-body text-black">
                                            {{ $type->name }}
                                            <p class="card-text">
                                                {{ $type->period }} {{ __('ar.' . $type->period_type) }}
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

                    </div>
                </div>
                <hr>
                <div class="row justify-content-around">
                    <button type="button" class="btn btn-primary waves-effect waves-light view_inv" data-toggle="modal"
                        data-target=".bs-example-modal-lg" data-url="{{ route('Broker.ViewInvoice') }}">اكمال
                        الدفع</button>
                    <a href="{{ route('Broker.Tickets.index') }}" class="btn btn-outline-warning">@lang('technical support')</a>
                </div>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
