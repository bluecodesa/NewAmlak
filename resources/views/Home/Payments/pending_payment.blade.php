<div class="modal fade bs-example-modal-center2" id="basicModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-pricing">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h5 class="modal-title mt-0">
                    @if(Auth::user()->UserBrokerData)
                        @lang('subscription'): @lang(Auth::user()->UserBrokerData->UserSubscriptionPending->status ?? 'pending')
                    @elseif(Auth::user()->UserOfficeData)
                        @lang('subscription'): @lang(Auth::user()->UserOfficeData->UserSubscriptionPending->status ?? 'pending')
                    @endif
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                @if (Auth::check())
                    @if (Auth::user()->is_broker)
                        <h4 class="card-title w-100 text-center">@lang('Welcome') {{ Auth::user()->name }}</h4>
                    @elseif (Auth::user()->is_office)
                        <h4 class="card-title w-100 text-center">@lang('Welcome') {{ Auth::user()->name }}</h4>
                    @endif
                @endif

                @if ($pendingPayment)
                    <p class="card-text">{{ __('Please renew your subscription to activate your account') }}</p>
                @else
                    <p class="card-text">{{ __('Please renew your subscription to activate your account') }}</p>
                @endif

                <p>@lang('Choose the subscription system that suits you')</p>
                <div class="col-12">
                    <div class="row mx-0 gy-3 d-flex justify-content-center">
                        @forelse ($UserSubscriptionTypes as $type)
                            <div class="col-xl-3 col-md-3 mb-md-0 mb-4">
                                <label class="form-check custom-option custom-option-icon h-100">
                                    <div class="card border-primary border shadow-none h-100 @if (Auth::user()->UserBrokerData && $type->id == Auth::user()->UserBrokerData->UserSubscription->subscription_type_id)
                                         border-primary @elseif (Auth::user()->UserOfficeData && $type->id == Auth::user()->UserOfficeData->UserSubscription->subscription_type_id) border-primary @else border-secondary @endif">
                                        <div class="card-body position-relative">
                                            <div class="position-absolute end-0 me-4 top-0 mt-4"></div>
                                            <h3 class="card-title text-center text-capitalize mb-1">{{ $type->name }}</h3>
                                            <div class="text-center h-px-100 mb-2">
                                                <div class="d-flex justify-content-center">
                                                    <sup class="h6 pricing-currency mt-3 mb-0 me-1 text-primary">@lang('SAR')</sup>
                                                    @php
                                                    $discounted_price = $type->price; // السعر الأساسي كقيمة افتراضية

                                                    if ($type->discount_type == 'incentive') {
                                                        $publish_discount = 0;
                                                        $views_discount = 0;

                                                        if ($type->ads_count != 0) {
                                                            $publish_discount = ($numOfAds / $type->ads_count) * $type->ads_discount; // خصم النشر
                                                        }

                                                        if ($type->views_count != 0) {
                                                            $views_discount = ($numOfViews / $type->views_count) * $type->views_discount; // خصم المشاهدات
                                                        }

                                                        $total_discount = $publish_discount + $views_discount; // إجمالي الخصم
                                                        $discounted_price = $type->price - ($type->price * $total_discount); // السعر بعد الخصم
                                                            $discounted_price = $discounted_price < 0 ? 0 : $discounted_price; // إذا كان بالسالب يتم تعيين 0
                                                        } elseif ($type->discount_type == 'fixed') {
                                                            $discounted_price = $type->price - ($type->price * $type->upgrade_rate); // خصم الـ fixed
                                                        }
                                                    @endphp
                                                        <h1 class="display-4 mb-0 text-primary">{{ $discounted_price }}</h1>
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
                                            {{-- <input type="radio" class="subscription_type form-check-input" required
                                                   data-url="{{ Auth::user()->is_broker ? route('Broker.UpdateSubscription', $type->id) : route('Office.UpdateSubscription', $type->id) }}"
                                                   name="subscription_type" value="{{ $type->id }}"
                                                   id="subscription{{ $type->id }}"
                                                   @if ($type->id == optional($subscription)->subscription_type_id) checked @endif> --}}
                                                   <input type="radio"
                                                    class="subscription_type form-check-input"
                                                    required
                                                    data-url="{{ Auth::user()->is_broker ? route('Broker.UpdateSubscription', ['id' => $type->id, 'discounted_price' => $discounted_price ?? $type->price]) : route('Office.UpdateSubscription', ['id' => $type->id, 'discounted_price' => $discounted_price ?? $type->price]) }}"
                                                    name="subscription_type"
                                                    value="{{ $type->id }}"
                                                    id="subscription{{ $type->id }}"
                                                    @if(
                                                        (Auth::user()->UserBrokerData && Auth::user()->UserBrokerData->UserSubscriptionPending && Auth::user()->UserBrokerData->UserSubscriptionPending->status === 'pending' && $type->id == optional($subscription)->subscription_type_id) ||
                                                        (Auth::user()->UserOfficeData && Auth::user()->UserOfficeData->UserSubscriptionPending && Auth::user()->UserOfficeData->UserSubscriptionPending->status === 'pending' && $type->id == optional($subscription)->subscription_type_id)
                                                    )
                                                        checked
                                                    @endif>
                                            {{-- <input type="text" name="discounted_price" id="" hidden value="{{ $discounted_price }}"> --}}
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
                <div class="col-12">
                    {{-- @if(Auth::user()->UserBrokerData)
                    <button type="button" class="btn btn-primary waves-effect waves-light view_inv" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg" data-url="{{ route('Broker.ViewInvoice') }}">اكمال الدفع</button>
                    <a href="{{ route('Broker.Tickets.index') }}" class="btn btn-outline-warning">@lang('technical support')</a>
                    @elseif(Auth::user()->UserOfficeData)
                    <button type="button" class="btn btn-primary waves-effect waves-light view_inv" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg" data-url="{{ route('Office.ViewInvoice') }}">اكمال الدفع</button>
                    <a href="{{ route('Broker.Tickets.index') }}" class="btn btn-outline-warning">@lang('technical support')</a>
                    @endif --}}
                    @if(Auth::user()->UserBrokerData)
                    <button type="button" id="completePaymentButton" class="btn btn-primary waves-effect waves-light view_inv"
                            data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg"
                            data-url="{{ route('Broker.ViewInvoice') }}" disabled>
                        اكمال الدفع
                    </button>
                    <a href="{{ route('Broker.Tickets.index') }}" class="btn btn-outline-warning">@lang('technical support')</a>
                @elseif(Auth::user()->UserOfficeData)
                    <button type="button" id="completePaymentButton" class="btn btn-primary waves-effect waves-light view_inv"
                            data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg"
                            data-url="{{ route('Office.ViewInvoice') }}" disabled>
                        اكمال الدفع
                    </button>
                    <a href="{{ route('Office.Tickets.index') }}" class="btn btn-outline-warning">@lang('technical support')</a>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const subscriptionRadios = document.querySelectorAll('input[name="subscription_type"]');
        const completePaymentButton = document.getElementById('completePaymentButton');

        // Function to check if any radio is checked
        function updateButtonState() {
            const isChecked = Array.from(subscriptionRadios).some(radio => radio.checked);
            completePaymentButton.disabled = !isChecked;
        }

        // Add event listeners to all radio buttons
        subscriptionRadios.forEach(radio => {
            radio.addEventListener('change', updateButtonState);
        });

        // Check the button state on page load
        updateButtonState();
    });

    $('.subscription_type').on('change', function() {
    var url = $(this).data('url'); // الرابط المُعدل مع قيمة discounted_price

    console.log("Request URL:", url); // تأكد من عرض الرابط كاملاً في console

    $.ajax({
        type: "GET",
        url: url,
        success: function(data) {
            alertify.success(@json(__('Subscription has been updated')));
        },
        error: function(xhr) {
            console.error("Error:", xhr);
            alertify.error(@json(__('An error occurred while updating the subscription')));
        }
    });
});

</script>
