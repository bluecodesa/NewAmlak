@foreach($paymentGateways as $paymentGateway)
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="editModal{{ $paymentGateway->id }}">@lang('Edit') @lang("PayTabs")</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form action="{{ route('update-payment-gateway', ['id' => $paymentGateway->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">@lang('Name')</label>
                <input name="name" class="form-control" type="text" id="name" value="{{ old('name', $paymentGateway->name) }}">
            </div>

            <div class="form-group">
                <label>@lang('Api Key PayTabs')</label>
                <input name="api_key_paytabs" class="form-control" type="text" id="title_ar_modal" value="{{ old('api_key_paytabs', $paymentGateway->api_key_paytabs) }}">
            </div>

            <div class="form-group">
                <label>@lang('Profile Id PayTabs')</label>
                <input name="profile_id_paytabs" class="form-control" type="text" id="title_en_modal" value="{{ old('profile_id_paytabs', $paymentGateway->profile_id_paytabs) }}">
            </div>

            <div class="form-group">
                <label for="client_key">@lang('Client Key')</label>
                <input name="client_key" class="form-control" type="text" id="client_key" value="{{ old('client_key', $paymentGateway->client_key) }}">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Cancel')</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light">@lang('Save')</button>
            </div>
        </form>
    </div>
</div>
@endforeach
