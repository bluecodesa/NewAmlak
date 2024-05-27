<div class="modal fade" id="addNewPaymentModal_{{ $paymentGateway->id }}" tabindex="-1" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">@lang('Edit') @lang('PayTabs')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('Admin.update-payment-gateway', ['id' => $paymentGateway->id]) }}" method="POST"
                    enctype="multipart/form-data" class="row">
                    @csrf
                    @method('PUT')

                    <div class="col-12 mb-3">
                        <label class="form-label">{{ __('Name') }} <span class="required-color">*</span></label>
                        <input name="name" class="form-control" type="text" id="name"
                            value="{{ old('name', $paymentGateway->name) }}" required>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label"> @lang('Api Key PayTabs') <span class="required-color">*</span></label>
                        <input name="api_key" required class="form-control" type="text" id="api_key_paytabs"
                            value="{{ old('api_key', $paymentGateway->api_key) }}">
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label"> @lang('Profile Id PayTabs') <span class="required-color">*</span></label>
                        <input name="profile_id" required class="form-control" type="text" id="profile_id_paytabs"
                            value="{{ old('profile_id', $paymentGateway->profile_id) }}">
                    </div>

                    <div class="col-12 mb-3">
                        <label for="client_key">@lang('Client Key')</label>
                        <input name="client_key" class="form-control" type="text" id="client_key"
                            value="{{ old('client_key', $paymentGateway->client_key) }}">
                    </div>

                    <div class="col-12 mb-3">
                        <label for="status">@lang('Status')</label>
                        <select name="status" type="package" class="form-select">
                            <option value="1" {{ $paymentGateway->status == 1 ? 'selected' : '' }}>
                                @lang('Enable')</option>
                            <option value="0" {{ $paymentGateway->status == 0 ? 'selected' : '' }}>
                                @lang('Disable')</option>
                        </select>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="formFile" class="form-label">@lang('No logo uploaded yet.')</label>
                        <input class="form-control" name="image" type="file" id="formFile">
                    </div>
                    <div class="col-12 text-center">
                        @if (isset($paymentGateway) && $paymentGateway->image)
                            <div class="avatar avatar-xl">
                                <img src="{{ asset($paymentGateway->image) }}" alt="Avatar" class="rounded-circle">
                            </div>
                        @endif
                    </div>
                    <hr>
                    <div class="col-12 mb-3">
                        <button type="submit"
                            class="btn btn-primary waves-effect waves-light">@lang('save')</button>

                        <button  type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-secondary"
                            data-dismiss="modal">@lang('Cancel')</button>

                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
