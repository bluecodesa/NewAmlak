<div class="col-md-12 ArFont">
    <div class="card timeline shadow">
        <div class="card-header">
            <strong class="card-title">
                @lang('Mange of invoices')
            </strong>
        </div>
        <div class="card-body">
            <form action="{{ route('Admin.update-tax', $setting) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="tax_rate">
                            <span class="required-color">*</span>
                            @lang('Value added tax rate')
                        </label><br />
                        <div class="wrapper" style="position: relative;">
                            <input type="number" name="tax_rate" id="tax_rate" class="form-control" required
                                min="1" max="100" placeholder="1-100"
                                value="{{ $settings->tax_rate * 100 }}" />
                            <span class="sub-input">%</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit"
                            class="btn btn-primary waves-effect waves-light">@lang('Save')</button>
                        <button type="reset" class="btn btn-secondary waves-effect m-l-5">@lang('Cancel')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
