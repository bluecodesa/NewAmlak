<div class="modal fade" id="addNewBankAccountModal_{{ $bankAccount->id }}" tabindex="-1" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">@lang('Edit') @lang('PayTabs')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('Admin.update-bank-account', ['id' => $bankAccount->id]) }}" method="POST"
                    enctype="multipart/form-data" class="row">
                    @csrf
                    @method('PUT')

                    <div class="col-12 mb-3">
                        <label class="form-label">{{ __('Name') }} <span class="required-color">*</span></label>
                        <input name="name" class="form-control" type="text" id="name"
                            value="{{ old('name', $bankAccount->name) }}" required>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label"> @lang('Account Number') <span class="required-color">*</span></label>
                        <input name="account_number" required class="form-control" type="text" id="account_number"
                            value="{{ old('account_number', $bankAccount->account_number) }}">
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label"> @lang('International Account Number') <span class="required-color">*</span></label>
                        <input name="international_account_number" required class="form-control" type="text" id="international_account_number"
                            value="{{ old('international_account_number', $bankAccount->international_account_number) }}">
                    </div>

                    <div class="col-12 mb-3">
                        <label for="id_number">@lang('id number')</label>
                        <input name="id_number" class="form-control" type="text" id="id_number"
                            value="{{ old('id_number', $bankAccount->id_number) }}">
                    </div>

                    <div class="col-12 mb-3">
                        <label for="status">@lang('Status')</label>
                        <select name="status" type="package" class="form-select">
                            <option value="1" {{ $bankAccount->status == 1 ? 'selected' : '' }}>
                                @lang('Enable')</option>
                            <option value="0" {{ $bankAccount->status == 0 ? 'selected' : '' }}>
                                @lang('Disable')</option>
                        </select>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="formFile" class="form-label">@lang('No logo uploaded yet.')</label>
                        <input class="form-control" name="image" type="file" id="formFile">
                    </div>
                    <div class="col-12 text-center">
                        @if (isset($bankAccount) && $bankAccount->image)
                            <div class="avatar avatar-xl">
                                <img src="{{ asset($bankAccount->image) }}" alt="Avatar" class="rounded-circle">
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
