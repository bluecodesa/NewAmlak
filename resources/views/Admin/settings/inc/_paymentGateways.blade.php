<div class="page-title-box">
    <div class="card m-b-30">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">
                        @lang('PayTabs')</h4>
                </div>
                <div class="col-md-6" style="text-align: end">
                    @if (Auth::user()->hasPermission('create-payment-gateway'))
                        <a href="#" class="btn btn-primary col-3 p-1 m-1 waves-effect waves-light"
                            data-toggle="modal" data-target="#addNewPaymentModal">
                            <i class="bi bi-plus-circle"></i>
                            @lang('Add New Payment')
                        </a>
                    @endif
                </div>
            </div>
        </div>

    </div> <!-- end row -->
</div>
<div class="row">
    @foreach ($paymentGateways as $paymentGateway)
        <div class="col-md-6">
            <div class="card m-b-30">
                <div class="form-group col-md-12">
                    <div class="card payment" style="width: 18rem;" data-toggle="modal" data-target="#exampleModal">
                        <div class="payment-img-container">
                            <img class="card-img-top" height="100" src="{{ asset($paymentGateway->image) }}"
                                alt="Card image cap">
                        </div>
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
                                            id="customradio1" {{ $paymentGateway->status == 1 ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="customradio1">@lang('Enable')</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="status" value="0"
                                            id="customradio2" {{ $paymentGateway->status == 0 ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="customradio2">@lang('Disable')</label>
                                    </div>
                                    <button type="button" class="btn btn-primary waves-effect waves-light"
                                        data-toggle="modal" data-target="#editModal{{ $paymentGateway->id }}">
                                        @lang('Edit')
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
