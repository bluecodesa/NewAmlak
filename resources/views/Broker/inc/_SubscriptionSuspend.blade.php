<div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0"> @lang('Hello and welcome') : {{ Auth::user()->name }} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <h5>@lang('Your account is suspended')</h5>
                @lang('Sorry, your account has been suspended. Please contact technical support')
                <br>
                <button type="button" class="btn btn-outline-primary mt-1 waves-effect waves-light"> @lang('technical support')
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
