<div class="row align-items-center">
    <div class="col-sm-6">
        <h4 class="page-title">
            @lang('PayTabs')</h4>
    </div>
    <div class="col-md-6" style="text-align: end">
        @if (Auth::user()->hasPermission('create-payment-gateway'))
            <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                data-bs-target="#addNewPaymentModal">
                @lang('Add New Payment')
            </button>
        @endif
    </div>
</div>
<div class="row">
    @foreach ($paymentGateways as $paymentGateway)
        <div class="col-md-6 col-xl-4">
            <div class="card mb-3">
                <img class="card-img-top" height="150" width="150"
                src="{{ optional($paymentGateway)->image ? asset($paymentGateway->image) : asset('PaymentGateway/payment_default.png') }}"
                alt="Payment Gateway Image">
                <div class="card-body">
                    <form action="{{ route('Admin.payment-gateways.edit', ['id' => $paymentGateway->id]) }}"
                        method="GET" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>@lang('Api Key PayTabs')</label>
                            <input name="api_key" class="form-control" type="password" id="title_ar"
                                value="{{ $paymentGateway->api_key ?? '' }}" disabled>
                        </div>

                        <div class="form-group">
                            <label>@lang('Profile Id PayTabs')</label>
                            <input name="profile_id" class="form-control" type="password" id="title_en"
                                value="{{ $paymentGateway->profile_id ?? '' }}" disabled>
                        </div>

                        <div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="status" value="1"
                                    id="customradio1" {{ $paymentGateway->status == 1 ? 'checked' : '' }} disabled>
                                <label class="form-check-label" for="customradio1">@lang('Enable')</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="status" value="0"
                                    id="customradio2" {{ $paymentGateway->status == 0 ? 'checked' : '' }} disabled>
                                <label class="form-check-label" for="customradio2">@lang('Disable')</label>
                            </div>
                            <button type="button" class="btn btn-primary waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target="#addNewPaymentModal_{{ $paymentGateway->id }}">
                                @lang('Edit')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
{{-- ** --}}
<div class="row align-items-center">
    <div class="col-sm-6">
        <h4 class="page-title">
            @lang('Bank Accounts')</h4>
    </div>
    <div class="col-md-6" style="text-align: end">
        @if (Auth::user()->hasPermission('create-payment-gateway'))
            <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                data-bs-target="#addNewBankAccountModal">
                @lang('Add New Bank Account')
            </button>
        @endif
    </div>
</div>
<div class="row">
    @foreach ($bankAccounts as $bankAccount)
        <div class="col-md-6 col-xl-4">
            <div class="card mb-3">
                <img class="card-img-top" height="150" width="150"
                src="{{ optional($bankAccount)->image ? asset($bankAccount->image) : asset('PaymentGateway/payment_default.png') }}"
                alt="Payment Gateway Image">
                <div class="card-body">
                    <form action="{{ route('Admin.payment-gateways.edit', ['id' => $bankAccount->id]) }}"
                        method="GET" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>@lang('Account Number')</label>
                            <input name="account_number" class="form-control" type="password" id="title_ar"
                                value="{{ $bankAccount->account_number ?? '' }}" disabled>
                        </div>

                        <div class="form-group">
                            <label>@lang('International Account Number')</label>
                            <input name="international_account_number" class="form-control" type="password" id="title_ar"
                                value="{{ $bankAccount->international_account_number ?? '' }}" disabled>
                        </div>

                        <div class="form-group">
                            <label>@lang('id number')</label>
                            <input name="id_number" class="form-control" type="password" id="title_en"
                                value="{{ $bankAccount->id_number ?? '' }}" disabled>
                        </div>

                        <div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="status" value="1"
                                    id="customradio1" {{ $bankAccount->status == 1 ? 'checked' : '' }} disabled>
                                <label class="form-check-label" for="customradio1">@lang('Enable')</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="status" value="0"
                                    id="customradio2" {{ $bankAccount->status == 0 ? 'checked' : '' }} disabled>
                                <label class="form-check-label" for="customradio2">@lang('Disable')</label>
                            </div>
                            <button type="button" class="btn btn-primary waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target="#addNewBankAccountModal_{{ $bankAccount->id }}">
                                @lang('Edit')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>


