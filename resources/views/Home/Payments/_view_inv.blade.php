
    <div class="modal fade bs-example-modal-lg" id="basicModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myLargeModalLabel"> @lang('Invoice Data') </h5>
                <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"></button>
            </div>
            <div class="modal-body" id="ViewInvoice">

                <div class="alert alert-primary mb-0 text-center">
                    <h4> الفاتورة </h4>
                    {{-- ( {{ Auth::user()->UserBrokerData->UserSystemInvoicePaid ?? '' !== '' ? 'تجديد إشتراك' : 'اشتراك جديد' }}) --}}
                    <p>(رقم الفاتورة -
                        {{ Auth::user()->UserBrokerData->UserSystemInvoicePending->invoice_ID ?? '' }}
                        )</p>
                </div>
                <div class="row text-center">
                    <div class="col-6">
                        <h5>الي</h5>
                        <p>{{ Auth::user()->name }}</p>
                        <p class="phone"> {{ auth()->user()->phone ?? __('phone') }} </p>
                        <p class="location">
                            {{ Auth::user()->UserBrokerData->CityData->name ?? (Auth::user()->UserOfficeData->CityData->name ?? '') }}
                        </p>
                        <p class="id">
                            {{ Auth::user()->UserBrokerData->broker_license ?? (Auth::user()->UserOfficeData->CRN ?? '') }}
                        </p>
                    </div>
                    <div class="col-6">
                        <h5>من</h5>
                        <p>{{ $sitting->title }}</p>
                        <p class="phone">{{ $sitting->phone }}</p>
                        <p class="location">الرياض - السعودية</p>
                        <p class="id"> @lang('crn') : {{ $sitting->crn }}</p>
                    </div>




                </div>
                <div class="card">
                    <div class="card-body">
                        <table class="table mb-0">
                            <tbody>
                                <tr>
                                    <th>@lang('subscription')</th>
                                    <td>

                                        {{ Auth::user()->UserOfficeData->UserSubscriptionPending->SubscriptionTypeData->name ?? (Auth::user()->UserBrokerData->UserSubscriptionPending->SubscriptionTypeData->name ?? '') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('period')</th>
                                    <td>
                                        @if (isset(Auth::user()->UserOfficeData->UserSystemInvoicePending))
                                            {{ Auth::user()->UserOfficeData->UserSystemInvoicePending->period . ' ' . __(Auth::user()->UserOfficeData->UserSystemInvoicePending->period_type) }}
                                        @elseif(isset(Auth::user()->UserBrokerData->UserSystemInvoicePending))
                                            {{ Auth::user()->UserBrokerData->UserSystemInvoicePending->period . ' ' . __(Auth::user()->UserBrokerData->UserSystemInvoicePending->period_type) }}
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>@lang('Invoice Status')</th>
                                    <td>
                                        @if (isset(Auth::user()->UserOfficeData->UserSystemInvoicePending))
                                            {{ __('_' . Auth::user()->UserOfficeData->UserSystemInvoicePending->status) }}
                                        @elseif(isset(Auth::user()->UserOfficeData->UserSystemInvoicePending))
                                            {{ __('_' . Auth::user()->UserBrokerData->UserSystemInvoicePending->status) }}
                                        @endif
                                    </td>
                                </tr>


                                <tr>
                                    <th>@lang('total')</th>
                                    <td>
                                        @if (isset(Auth::user()->UserOfficeData->UserSystemInvoicePending))
                                            {{ Auth::user()->UserOfficeData->UserSystemInvoicePending->amount }}
                                            <sub>@lang('SAR')</sub>
                                        @elseif(isset(Auth::user()->UserBrokerData->UserSystemInvoicePending))
                                            {{ Auth::user()->UserBrokerData->UserSystemInvoicePending->amount }}
                                            <sub>@lang('SAR')</sub>
                                        @endif

                                    </td>
                                </tr>

                            </tbody>
                        </table>
                        <hr>
                        <form action="{{ route('Payment.store') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="btn btn-success btn-lg btn-block waves-effect waves-light">أكمل
                                الدفع</button>
                        </form>


                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
