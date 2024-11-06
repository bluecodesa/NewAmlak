<div class="modal fade" id="basicModal7" tabindex="-1" aria-hidden="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">
                <div class="modal-header text-center">
                    <h5 class="modal-title mt-0"> @lang('Hello and welcome') : {{ Auth::user()->name }} </h5>
                </div>
                <div class="modal-body text-center">
                    <h5>@lang('Your account is suspended')</h5>
                    @lang('Sorry, your account has been suspended. Please contact technical support')
                    <br>
                    <a href="{{ route('Office.Tickets.index') }}"
                        class="btn btn-outline-primary mt-1 waves-effect waves-light"
                        role="button">@lang('technical support')</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div>
