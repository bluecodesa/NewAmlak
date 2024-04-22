<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('Subscription upgrade')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if (Auth::check())
                        @if (Auth::user()->is_broker)
                            <h4 class="card-title  w-100 text-center">@lang('Welcome')
                                {{ Auth::user()->name }}</h4>
                        @elseif (Auth::user()->is_office)
                            <h4 class="card-title  w-100 text-center">@lang('Welcome')
                                {{ Auth::user()->company_name }}</h4>
                        @endif
                    @endif

                    <div class="row text-center">

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
                                                    <br> {{ $type->price }} <sup>@lang('SAR')</sup>
                                                </p>
                                            </div>
                                            <div class="card-footer text-muted">
                                                <input type="radio" class="subscription_type"
                                                    data-url="{{ route('Broker.UpdateSubscription', $type->id) }}"
                                                    name="subscription_type" value="{{ $type->id }}"
                                                    price="{{ $type->price }}">
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
