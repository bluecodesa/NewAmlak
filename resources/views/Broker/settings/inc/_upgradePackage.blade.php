<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
</div>
