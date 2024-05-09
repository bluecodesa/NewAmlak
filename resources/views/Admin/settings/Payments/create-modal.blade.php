{{-- <div class="modal fade" id="addNewPaymentModal" tabindex="-1" role="dialog" aria-labelledby="addNewPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewPaymentModalLabel">@lang('Add New Payment')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('Admin.create-payment-gateway') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">

                          <label class="form-label">  @lang('Name') <span
                               class="required-color">*</span></label>
                        <input name="name" class="form-control" type="text" id="name" required>
                    </div>

                    <div class="form-group">

                        <label class="form-label">@lang('Api Key PayTabs') <span
                            class="required-color">*</span></label>
                        <input name="api_key" class="form-control" type="text" id="api_key" required>
                    </div>

                    <div class="form-group">

                        <label class="form-label">@lang('Profile Id PayTabs') <span
                            class="required-color">*</span></label>
                        <input name="profile_id" class="form-control" type="text" id="profile_id" required  maxlength="9"  pattern="[0-9]*" inputmode="numeric">
                    </div>

                    <div class="form-group">
                        <label for="client_key">@lang('Client Key')</label>
                        <input name="client_key" class="form-control" type="text" id="client_key">
                    </div>


                    <div class="form-group">
                        <label for="image">@lang('Payment Image')</label>
                        <input type="file" name="image" class="form-control-file" id="image">
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">@lang('save')</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Cancel')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> --}}

<div class="modal fade" id="addNewPaymentModal" tabindex="-1" style="display: block;" aria-modal="true" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label">Name</label>
                        <input type="text" id="nameBasic" class="form-control" placeholder="Enter Name">
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col mb-0">
                        <label for="emailBasic" class="form-label">Email</label>
                        <input type="email" id="emailBasic" class="form-control" placeholder="xxxx@xxx.xx">
                    </div>
                    <div class="col mb-0">
                        <label for="dobBasic" class="form-label">DOB</label>
                        <input type="date" id="dobBasic" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="button" class="btn btn-primary waves-effect waves-light">Save changes</button>
            </div>
        </div>
    </div>
</div>
