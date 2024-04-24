<div class="alert alert-primary mb-0 text-center">
    <h4> الفاتورة </h4>

    {{-- {{ Auth::user()->UserBrokerData->UserSystemInvoicePaid ?? '' !== '' ? 'تجديد إشتراك' : 'اشتراك جديد' }} --}}

    <p>(رقم الفاتورة -
        {{ Auth::user()->UserBrokerData->UserSystemInvoicePending->invoice_ID ?? '' }}
        )</p>
</div>
<div class="row text-center">
    <div class="col-6">
        <h5>من</h5>
        <p>{{ $sitting->title }}</p>
        <p class="phone">{{ $sitting->phone }}</p>
        <p class="location">الرياض - السعودية</p>
        <p class="id"> @lang('crn') : {{ $sitting->crn }}</p>
    </div>

    <div class="col-6">
        <h5>الي</h5>
        <p>{{ Auth::user()->name }}</p>
        <p class="phone">
            {{ Auth::user()->UserBrokerData->mobile ?? (Auth::user()->UserOfficeData->presenter_number ?? auth()->user()->phone) }}
        </p>
        <p class="location">
            {{ Auth::user()->UserBrokerData->CityData->name ?? (Auth::user()->UserOfficeData->CityData->name ?? '') }}
        </p>
        {{-- <p class="id">
            {{ Auth::user()->UserBrokerData->broker_license ?? (Auth::user()->UserOfficeData->CRN ?? '') }}
        </p> --}}
    </div>

</div>
<div class="card">
    <div class="card-body">
        <table class="table mb-0">
            <tbody>
                <tr>
                    <th>@lang('subscription')</th>
                    <th>

                        {{ Auth::user()->UserOfficeData->UserSubscriptionPending->SubscriptionTypeData->name ?? (Auth::user()->UserBrokerData->UserSubscriptionPending->SubscriptionTypeData->name ?? '') }}
                    </th>
                </tr>
                <tr>
                    <th>@lang('period')</th>
                    <th>
                        @if (isset(Auth::user()->UserOfficeData->UserSystemInvoicePending))
                            {{ Auth::user()->UserOfficeData->UserSystemInvoicePending->period . ' ' . __(Auth::user()->UserOfficeData->UserSystemInvoicePending->period_type) }}
                        @elseif(isset(Auth::user()->UserBrokerData->UserSystemInvoicePending))
                            {{ Auth::user()->UserBrokerData->UserSystemInvoicePending->period . ' ' . __(Auth::user()->UserBrokerData->UserSystemInvoicePending->period_type) }}
                        @endif
                    </th>
                </tr>

                <tr>
                    <th>@lang('Invoice Status')</th>
                    <th>
                        @if (isset(Auth::user()->UserOfficeData->UserSystemInvoicePending))
                            {{ __('_' . Auth::user()->UserOfficeData->UserSystemInvoicePending->status) }}
                        @else
                            {{ __('_' . Auth::user()->UserBrokerData->UserSystemInvoicePending->status) }}
                        @endif
                    </th>
                </tr>

                <tr>
                    <th>@lang('total')</th>
                    <th>
                        @if (isset(Auth::user()->UserOfficeData->UserSystemInvoicePending))
                            {{ Auth::user()->UserOfficeData->UserSystemInvoicePending->amount }}
                            <sub>@lang('SAR')</sub>
                        @else
                            {{ Auth::user()->UserBrokerData->UserSystemInvoicePending->amount }}
                            <sub>@lang('SAR')</sub>
                        @endif

                    </th>
                </tr>

            </tbody>
        </table>
        <hr>
        <form action="{{ route('Payment.store') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success btn-lg btn-block waves-effect waves-light">أكمل
                الدفع</button>
        </form>


    </div>
</div>
