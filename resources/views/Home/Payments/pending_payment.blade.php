
 <div class="modal fade" id="pendingPaymentModal" tabindex="-1" role="dialog"
        aria-labelledby="scrollableModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
        <div class="card text-white bg-primary text-xs-center">
            <div class="card-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body">
                @if (Auth::check())
                    @if (Auth::user()->is_broker)
                        <h4 class="card-title text-white w-100 text-center">@lang('Welcome') {{ Auth::user()->name }}</h4>
                    @elseif (Auth::user()->is_office)
                        <h4 class="card-title text-white w-100 text-center">@lang('Welcome') {{ Auth::user()->company_name }}</h4>
                    @endif
                @endif
                <div class="card-body text-center">
                    <h5>@lang('Pending')!</h5>
                    @if ($pendingPayment)
                        <p class="card-text">@lang('Please complete the subscription payment to be able to activate your account and use the system')</p>
                    @else
                        <p class="card-text">@lang('Please renew the subscription payment to be able to activate your account and use the system')</p>
                    @endif

                    <form action="" method="POST" id="payForm">
                        @csrf
                        <div class="form-row">
                            <p>@lang('Current subscription')</p>
                            <div class="col-md-12 mb-3 d-flex justify-content-around flex-wrap gap-2 text-dark" style="align-items: center;">
                                @forelse ($UserSubscriptionTypes as $type)
                                <label>
                                    <div class="card text-center border @if ($type->id == optional($subscription)->id) border-primary @else border-secondary @endif" style="cursor:pointer; max-width: 18rem;">
                                        <div class="card-body text-black"> <!-- Added text-black class here -->
                                            <p class="card-text">
                                                {{ $type->period }} {{ __('ar.' . $type->period_type) }}
                                                <br> {{ $type->price }} <sup>@lang('SAR')</sup>
                                            </p>
                                        </div>
                                        <div class="card-footer text-muted">
                                            <input type="radio" name="subscription_type" value="{{ $type->id }}" price="{{ $type->price }}" @if ($type->id == optional($subscription)->subscription_type_id) checked @endif>
                                        </div>
                                    </div>
                                </label>

                                @empty
                                    <p>@lang('No subscription types available')</p>
                                @endforelse
                            </div>
                            <input type="hidden" name="total" id="total" class="form-control" />
                            <input type="hidden" name="is_renewed" value="{{ optional($subscription)->is_renewed }}" />
                        </div>
                        <div class="d-flex justify-content-around mb-3">
                            <a href="#" class="btn btn-outline-info">@lang('Compare Plans')</a>
                        </div>
                        <div class="row justify-content-around">
                            <a href="" class="btn btn-outline-success">@lang('Payment By SAR')</a>
                            <a href="" class="btn btn-outline-warning">@lang('Support')</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


