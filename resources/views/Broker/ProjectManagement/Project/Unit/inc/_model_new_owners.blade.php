{{-- <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0"> @lang('Add New Owner') </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" style="text-align:right;">
                <form action="{{ route('Broker.Unit.SaveNewOwners') }}" method="POST" id="OwnerForm" class="row">
                    @csrf
                    @method('post')
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">
                                {{ __('Name') }} <span class="required-color">*</span></label>
                            <input type="text" required id="modalRoleName" name="name" class="form-control"
                                placeholder="{{ __('Name') }}">
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"> @lang('Email') <span class="required-color">*</span></label>
                            <input type="email" required name="email" class="form-control"
                                placeholder="@lang('Email')">
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="mb-3">

                            <label for="phone">@lang('phone')<span class="text-danger">*</span></label>
                            <div style="position:relative">

                                <input type="tel" class="form-control" id="phone" minlength="9" maxlength="9"
                                    pattern="[0-9]*" oninvalid="setCustomValidity('Please enter 9 numbers.')"
                                    onchange="try{setCustomValidity('')}catch(e){}" placeholder="599123456"
                                    name="phone" required="" value="">

                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label>@lang('Region') <span class="required-color">*</span> </label>
                        <select class="form-control Region_id" required>
                            <option disabled selected value="">@lang('Region')</option>
                            @foreach ($Regions as $Region)
                                <option value="{{ $Region->id }}"
                                    data-url="{{ route('Broker.Broker.GetCitiesByRegion', $Region->id) }}">
                                    {{ $Region->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label>@lang('city') <span class="required-color">*</span> </label>
                        <select class="form-control CityDiv" name="city_id" required>

                        </select>
                    </div>


                    <div class="col-12">
                        <button type="submit" class="btn btn-primary me-1">

                            {{ __('save') }}
                        </button>

                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div> --}}



<!-- Add New Add New owner Modal Modal -->
<div class="modal fade" id="addNewCCModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center">
                    <h3 class="mb-2">@lang('Add New Owner')</h3>
                </div>
                <form action="{{ route('Broker.Unit.SaveNewOwners') }}" method="POST" id="OwnerForm" class="row">
                    @csrf
                    @method('post')
                    <div class="col-md-6 col-12 mb-3">

                        <label class="form-label">
                            {{ __('Name') }} <span class="required-color">*</span></label>
                        <input type="text" required id="modalRoleName" name="name" class="form-control"
                            placeholder="{{ __('Name') }}">

                    </div>


                    <div class="col-md-6 col-12 mb-3">

                        <label class="form-label"> @lang('Email') <span class="required-color">*</span></label>
                        <input type="email" required name="email" class="form-control"
                            placeholder="@lang('Email')">

                    </div>


                    <div class="col-md-4 col-12 mb-3">


                        <label for="phone">@lang('phone')<span class="text-danger">*</span></label>
                        <div style="position:relative">

                            <input type="tel" class="form-control" id="phone" minlength="9" maxlength="9"
                                pattern="[0-9]*" oninvalid="setCustomValidity('Please enter 9 numbers.')"
                                onchange="try{setCustomValidity('')}catch(e){}" placeholder="599123456" name="phone"
                                required="" value="">

                        </div>

                    </div>

                    <div class="col-md-4 col-12 mb-3">
                        <label>@lang('Region') <span class="required-color">*</span> </label>
                        <select class="form-select Region_id" required>
                            <option disabled selected value="">@lang('Region')</option>
                            @foreach ($Regions as $Region)
                                <option value="{{ $Region->id }}"
                                    data-url="{{ route('Broker.Broker.GetCitiesByRegion', $Region->id) }}">
                                    {{ $Region->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 col-12 mb-3">
                        <label>@lang('city') <span class="required-color">*</span> </label>
                        <select class="form-select CityDiv" name="city_id" required>

                        </select>
                    </div>

                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">@lang('save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--/ Add New owner Modal -->
