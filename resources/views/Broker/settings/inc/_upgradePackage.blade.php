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



<div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="{{ route('UpgradeSubscription') }}" method="post">
            @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel1">@lang('Subscription upgrade')</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"></button>
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
            <div class="row d-flex justify-content-center">
            @forelse ($UserSubscriptionTypes as $type)
            @if ($type->id != Auth::user()->UserBrokerData->UserSubscription->subscription_type_id)

            <div class="col-lg-4 col-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center" @if ($type->id == Auth::user()->UserBrokerData->UserSubscription->subscription_type_id) border-primary @else border-secondary @endif"
                    style="cursor:pointer;">
                  <div class="badge rounded-pill p-2 bg-label-danger mb-2">
                    <i class="ti ti-briefcase ti-sm"></i>
                  </div>
                  {{-- <h5 class="card-title mb-2">97.8k</h5>
                  <small>Orders</small> --}}
                  <label>

                            {{ $type->name }}
                            <p class="card-text">

                                {{ $type->period }} {{ __($type->period_type) }}
                                <br>
                                <del style="font-weight: 400;">{{ $type->price }}</del>
                                <b
                                    style="font-weight: 900;">{{ $type->price - $type->price * $type->upgrade_rate }}</b>

                                <sup>@lang('SAR')</sup>

                            </p>
                            <input type="radio" class="subscription_type" name="subscription_type"
                                value="{{ $type->id }}">
                </label>
                </div>
            </div>
        </div>

            @endif
            @empty
                <p>@lang('No subscription types available')</p>
            @endforelse
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
            @lang('close')
          </button>
          <button type="submit" class="btn btn-primary">@lang('Subscription upgrade')</button>
        </div>
    </form>
    </div>
</div>


  </div>
