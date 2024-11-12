<div class="modal fade" id="addNewBankAccountModal" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">@lang('Add New Payment')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('Admin.create-bank-account') }}" method="POST" enctype="multipart/form-data"
                    class="row">
                    @csrf
                    <div class="col-12 mb-3">

                        <label class="form-label"> @lang('Bank Name') <span class="required-color">*</span></label>
                        <input name="name" class="form-control" type="text" id="name" required>
                    </div>

                    <div class="col-12 mb-3">

                        <label class="form-label">@lang('Account Number') <span class="required-color">*</span></label>
                        <input name="account_number" class="form-control" type="text" id="account_number" required>
                    </div>


                    <div class="col-12 mb-3">
                        <label for="international_account_number">@lang('International Account Number') <span class="required-color"></span></label>
                        <input name="international_account_number" class="form-control" type="text" id="international_account_number">
                    </div>

                    <div class="col-12 mb-3">

                        <label class="form-label">@lang('id number') <span class="required-color"></span></label>
                        <input name="id_number" class="form-control" type="text" id="id_number"
                             inputmode="numeric">
                    </div>




                    <div class="col-12 mb-3">
                        <label for="formFile" class="form-label">@lang('Image')</label>
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
