<div id="pendingPaymentModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="pendingPaymentModalLabel" aria-hidden="true" class="pop-up" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered home-expire-soon" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h4 class="modal-title w-100 text-center" id="exampleModalLongTitle">أهلا ومرحبا{{ $user->name }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <h5>@lang('pending')!</h5>
                @if ($pendingPayment)
                    <p>@lang('Please complete the subscription payment to be able to activate your account and use the system')</p>
                @else
                    <p>@lang('Please Renew the subscription payment to be able to activate your account and use the system')</p>
                @endif

                <form action="" method="POST" id="payForm">
                    @csrf
                    <div class="form-row">
                        <p>@lang('Current subscription')</p>

                        <div class="col-md-12 mb-3 d-flex justify-content-around flex-wrap gap-2" style="align-items: center;">
                            @foreach ($brokerSubscriptionTypes as $type)
                                <label>
                                    <div class="card text-center @if ($type->id == $subscription->id) border border-primary @else border border-secondary @endif" style="cursor:pointer; max-width: 18rem;">
                                        <div class="card-body">
                                            <!-- Display subscription details -->
                                            <p class="card-text">
                                                {{ $type->period }} {{ $type->period_type }}
                                                <br> {{ $type->price }} @lang('SAR')
                                            </p>
                                        </div>
                                        <div class="card-footer text-muted">
                                            <!-- Radio button for subscription selection -->
                                            <input type="radio" onchange="handleChangexHere()"
                                                period="{{ $type->period . '  ' . $type->period_type }}"
                                                id="subscription_type" name="subscription_type"
                                                value="{{ $type->id }}" price={{ $type->price }}
                                                @if ($type->id == $subscription->subscription_type_id) {{ 'checked' }} @endif>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        <!-- Hidden input fields -->
                        <input hidden type="text" name="total" id="total" class="form-control" />
                        <input hidden name="is_renewed" value="{{ $subscription->is_renewed }}" />
                    </div>

                    <div class="d-flex justify-content-around w-100 mb-3">
                        <a href="" class="btn btn-primary" target="_blank">@lang('Compare Plans')</a>
                    </div>
                </form>

                <div class="row justify-content-around">
                    <a href="" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary">
                        <span class="item-text pay-btn-change text-white">@lang('Payment By') @lang('SAR')</span>
                    </a>
                    <a href="" class="btn btn-primary">
                        <span class="item-text">@lang('support')</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
