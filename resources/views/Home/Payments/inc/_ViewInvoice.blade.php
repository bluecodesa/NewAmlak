<div class="alert alert-primary mb-0 text-center">
    <h4> الفاتورة </h4>

    {{-- {{ Auth::user()->UserBrokerData->UserSystemInvoicePaid ?? '' !== '' ? 'تجديد إشتراك' : 'اشتراك جديد' }} --}}


    <p>(رقم الفاتورة -
        {{ Auth::user()->UserBrokerData->UserSystemInvoicePending->invoice_ID ?? Auth::user()->UserOfficeData->UserSystemInvoicePending->invoice_ID }}
    )</p>

    <td>
        @php
        if(auth()->user->UserBrokerData){
            $invoice = Auth::user()->UserBrokerData->UserSystemInvoicePending;

        }else{
            $invoice = Auth::user()->UserOfficeData->UserSystemInvoicePending;

        }

        @endphp
        <a href="{{ route('Office.ShowInvoice', $invoice->id) }}"
            class="btn btn-secondary add-new btn-primary btn-sm waves-effect waves-light">@lang('view')
            @lang('Invoice')</a>

    </td>
</div>
{{-- <div class="row text-center">
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

    </div>

</div> --}}
<div class="card">
    <div class="card-body">
        <table class="table mb-2">
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
        {{-- <form action="{{ route('Payment.store') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success btn-lg btn-block waves-effect waves-light">
                اكمل الدفع اون لاين</button>
        </form> --}}

        <div class="row m-2">
            <div class="col-4">
                <form action="{{ route('Payment.store') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light">
                        اكمل الدفع اون لاين
                    </button>
                </form>
            </div>
            <div class="col-8">

                    <div class="accordion-item card">
                        <button
                            type="button"
                            class="btn btn-success btn-lg btn-block waves-effect waves-light"
                            data-bs-toggle="collapse"
                            data-bs-target="#accordionIcon-1"
                            aria-controls="accordionIcon-1">
                            اكمل الدفع عن طريق حواله بنكيه
                        </button>
                        <div id="accordionIcon-1" class="accordion-collapse collapse m-2" data-bs-parent="#accordionIcon">
                            <div class="accordion-body">
                                <form action="{{ route('Receipt.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input class="" type="text" name="invoice_id" hidden value="{{ $invoice->id ? '' }}">
                                    <label for="formFileMultiple" class="form-label">@lang('Attach the receipt')</label>
                                    <div class="input-group">
                                    <input class="form-control" type="file" name="receipt" required
                                        id="projectMasterplan" accept="image/*,application/pdf">
                                        <button class="btn btn-outline-primary waves-effect" type="button" id="button-addon3"><i class="ti ti-refresh"></i></button>
                                    </div>
                                    <div class="col-12 m-2" style="text-align: center;">
                                        <button class="btn btn-primary col-4 waves-effect waves-light" id="submit_button"
                                            type="submit">@lang('send')</button>
                                    </div>
                            </form>

                            </div>
                        </div>
                    </div>
            </div>
        </div>


    </div>
</div>
