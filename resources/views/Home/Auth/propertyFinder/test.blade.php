<div class="modal fade" id="modalToggle" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">تسجيل الدخول</h3>
                </div>
                <p>للتواصل مع املاك للتطوير العقاري, يرجى إدخال ايميلك</p>
                <form id="emailForm" class="row g-3" action="{{ route("send-otp") }}" method="POST">
                    @csrf
                    <div class="col-12">
                        <label for="email" class="form-label">@lang('Email')</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="@lang('Email')" required autofocus />
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1" id="sendOtpButton">@lang('ارسال')</button>
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">@lang('Cancel')</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
