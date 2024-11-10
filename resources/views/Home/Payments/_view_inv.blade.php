
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
                        {{ Auth::user()->UserBrokerData->UserSystemInvoicePending->invoice_ID ?? Auth::user()->UserOfficeData->UserSystemInvoicePending->invoice_ID ?? '' }}
                        )</p>
                        @php
                        if(auth()->user()->UserBrokerData){
                            $invoice = Auth::user()->UserBrokerData->UserSystemInvoicePending;

                        }elseif(Auth::user()->UserOfficeData){
                            $invoice = Auth::user()->UserOfficeData->UserSystemInvoicePending;
                        }
                        @endphp
                        @if($invoice)
                        <td>
                            <a href="{{ route('Office.ShowInvoice', $invoice->id) }}"
                                class="btn btn-secondary add-new btn-primary btn-sm waves-effect waves-light">@lang('view')
                                @lang('Invoice')</a>
                        </td>
                        @endif
                </div>
                {{-- <div class="row text-center">
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




                </div> --}}
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
                        {{-- <form action="{{ route('Payment.store') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="btn btn-success btn-lg btn-block waves-effect waves-light">
                                اكمل الدفع اون لاين
                                </button>
                        </form> --}}

                        <div class="row">
                            <div class="col-4">
                                <form action="{{ route('Payment.store') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-lg btn-block waves-effect waves-light">
                                        اكمل الدفع اون لاين
                                    </button>
                                </form>
                            </div>
                            <div class="col-8">

                                    <div class="accordion-item card">
                                        <button
                                            type="button"
                                            class="btn btn-primary btn-lg btn-block waves-effect waves-light"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#accordionIcon-1"
                                            aria-controls="accordionIcon-1">
                                            اكمل الدفع عن طريق حواله بنكيه
                                        </button>
                                        <div id="accordionIcon-1" class="accordion-collapse collapse" data-bs-parent="#accordionIcon">
                                            <div class="accordion-body">
                                                <form action="{{ route('Receipt.store') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <label for="formFileMultiple" class="form-label">@lang('Attach the receipt')</label>
                                                    <div class="input-group">
                                                    <input class="form-control" type="file" name="receipt" required
                                                        id="projectMasterplan" accept="image/*,application/pdf">
                                                        <button class="btn btn-outline-primary waves-effect" type="button" id="button-addon3"><i class="ti ti-refresh"></i></button>
                                                    </div>
                                                    <div class="col-12" style="text-align: center;">
                                                        <button class="btn btn-primary col-4 waves-effect waves-light" id="submit_button"
                                                            type="submit">@lang('save')</button>
                                                    </div>
                                            </form>

                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
