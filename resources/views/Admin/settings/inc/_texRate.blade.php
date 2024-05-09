<div class="col-md-12 ArFont">

    <div class="card-header mb-3">
        <strong class="card-title">
            @lang('Value added tax')
        </strong>
    </div>

    <form action="{{ route('Admin.update-tax', $settings) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6 col-12 mb-3">
                <label for="tax_rate">
                    <span class="required-color">*</span>
                    @lang('Value added tax rate')
                </label><br />
                <div class="wrapper" style="position: relative;">
                    <input type="number" name="tax_rate" id="tax_rate" class="form-control" required min="1"
                        max="100" placeholder="1-100" value="{{ $settings->tax_rate * 100 }}" />
                    <span class="sub-input">%</span>
                </div>
            </div>

            <div class="col-md-6 col-12 mb-3">
                <label for="trn">
                    @lang('trn')
                </label><br />
                <div class="wrapper" style="position: relative;">
                    <input type="number" name="trn" id="trn" class="form-control"
                        placeholder="@lang('trn')" value="{{ $settings->trn }}" />
                </div>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary waves-effect waves-light">@lang('Save')</button>
                <button type="reset" class="btn btn-secondary waves-effect m-l-5">@lang('Cancel')</button>
            </div>
        </div>
    </form>


</div>
