<!-- Modal structure update the payment  -->
<div class="modal fade" id="editModal{{ $paymentGateway->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">@lang('Edit') @lang("PayTabs")</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('Admin.update-payment-gateway', ['id' => $paymentGateway->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="form-label">{{ __('Name') }} <span class="required-color">*</span></label>
                        <input name="name" class="form-control" type="text" id="name" value="{{ old('name', $paymentGateway->name) }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label"> @lang('Api Key PayTabs') <span class="required-color">*</span></label>
                        <input name="api_key_paytabs" required class="form-control" type="text" id="api_key_paytabs" value="{{ old('api_key_paytabs', $paymentGateway->api_key_paytabs) }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label"> @lang('Profile Id PayTabs') <span class="required-color">*</span></label>
                        <input name="profile_id_paytabs" required class="form-control" type="text" id="profile_id_paytabs" value="{{ old('profile_id_paytabs', $paymentGateway->profile_id_paytabs) }}">
                    </div>

                    <div class="form-group">
                        <label for="client_key">@lang('Client Key')</label>
                        <input name="client_key" class="form-control" type="text" id="client_key" value="{{ old('client_key', $paymentGateway->client_key) }}">
                    </div>

                    <div class="form-group">
                        <label for="status">@lang('Status')</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ $paymentGateway->status == 1 ? 'selected' : '' }}>@lang('Enable')</option>
                            <option value="0" {{ $paymentGateway->status == 0 ? 'selected' : '' }}>@lang('Disable')</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="image">@lang('Payment Image')</label>
                        <input type="file" name="image" class="form-control-file" id="image">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Cancel')</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">@lang('save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
