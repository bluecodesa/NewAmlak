
  <div class="wrapper-page" style="width: 50%;">
      <div class="card card-pages shadow-none">
        <div class="modal-header border-0">
            <h4 class="modal-title w-100 text-center" id="exampleModalLongTitle">أهلا ومرحبا
                </h4>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <h5> @lang('pending')!</h5>
            <p>@lang('Please complete the subscription payment to be able to activate your account and use the system')</p>

            <form action="" method="POST" id="payForm">
                @csrf
                <div class="form-row">
                    <p>@lang('Current subscription')</p>

                    <div class="col-md-12 mb-3 d-flex justify-content-around flex-wrap gap-2"
                    style="align-items: center;">

                        <label>
                            <div class="card text-center border border-primary" style="cursor:pointer">
                                <div class="card-body">
                                    <p class="card-text"><br>@lang('SAR')</p>
                                </div>
                                <div class="card-footer text-muted">
                                 <input type="radio" onchange="handleChangexHere()" name="subscription_type" value="" price="" >
                                </div>
                            </div>
                        </label>

                        <input hidden type="text" name="total" id="total" class="form-control">
                        <input hidden name="is_renewed" value="">
                    </div>
                    <div class="d-flex justify-content-around w-100 mb-3">
                        <a href=""  class="btn btn-primary" target="_blank">قارن بين الخطط</a>
                    </div>
                </div>
            </form>
            <div class="row justify-content-around">
                <a href="" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary">

                <span class="item-text pay-btn-change text-white">@lang('Payment By') @lang('SAR')</span>
                </a>
                <a href="" class="btn btn-primary">
                    <span class="item-text">@lang('support')</span>
                </a>
            </div>
        </div>
      </div>
  </div>

