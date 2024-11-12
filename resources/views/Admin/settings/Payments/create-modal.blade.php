<div class="modal fade" id="addNewPaymentModal" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">@lang('Add New Payment')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('Admin.create-payment-gateway') }}" method="POST" enctype="multipart/form-data"
                    class="row">
                    @csrf
                    <div class="col-12 mb-3">

                        <label class="form-label"> @lang('Name') <span class="required-color">*</span></label>
                        <input name="name" class="form-control" type="text" id="name" required>
                    </div>

                    <div class="col-12 mb-3">

                        <label class="form-label">@lang('Api Key PayTabs') <span class="required-color">*</span></label>
                        <input name="api_key" class="form-control" type="text" id="api_key" required>
                    </div>

                    <div class="col-12 mb-3">

                        <label class="form-label">@lang('Profile Id PayTabs') <span class="required-color">*</span></label>
                        <input name="profile_id" class="form-control" type="text" id="profile_id" required
                            maxlength="9" pattern="[0-9]*" inputmode="numeric">
                    </div>

                    <div class="col-12 mb-3">
                        <label for="client_key">@lang('Client Key') <span class="required-color">*</span></label>
                        <input name="client_key" class="form-control" type="text" id="client_key">
                    </div>


                    <div class="col-12 mb-3">
                        <label for="formFile" class="form-label">@lang('Payment Image')</label>
                        <input class="form-control" name="image" type="file" id="formFile">
                    </div>

                    <div class="col-12 mb-3">
                        <button type="submit" class="btn btn-primary">@lang('save')</button>

                        <button  type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-secondary"
                            data-dismiss="modal">@lang('Cancel')</button>
                        </div>
                </form>
            </div>

        </div>
    </div>
</div>
