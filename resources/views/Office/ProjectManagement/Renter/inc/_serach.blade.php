<div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel1">لتسجيل  مستأجر الرجاء التحق اولا من كونه موجود من قبل</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"></button>
        </div>
        <form action="{{ route('Office.Renter.searchByIdNumber') }}" method="POST">
            @csrf

        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
                    <input type="text" name="id_number" id="nameBasic" class="form-control" placeholder="Enter ID Number" />

            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
            @lang('Cancel')
          </button>
          <button type="submit" class="btn btn-primary">@lang('Search')</button>
        </div>
    </form>

      </div>
    </div>
  </div>
