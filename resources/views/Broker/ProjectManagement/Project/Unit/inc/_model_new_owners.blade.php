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
                        <label class="form-label">@lang('Region') <span class="required-color">*</span> </label>
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
                        <label class="form-label">@lang('city') <span class="required-color">*</span> </label>
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
                    <input type="text" name="key_phone" hidden value="996" id="key_phone">
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



                    <div class="col-md-6 col-12 mb-3">
                        <label class="form-label">@lang('Region') <span class="required-color">*</span> </label>
                        <select class="form-select Region_id" required>
                            <option disabled selected value="">@lang('Region')</option>
                            @foreach ($Regions as $Region)
                                <option value="{{ $Region->id }}"
                                    data-url="{{ route('Broker.Broker.GetCitiesByRegion', $Region->id) }}">
                                    {{ $Region->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 col-12 mb-3">
                        <label class="form-label">@lang('city') <span class="required-color">*</span> </label>
                        <select class="form-select CityDiv" name="city_id" required>

                        </select>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="color" class="form-label">@lang('phone') <span
                                class="required-color">*</span></label>
                        <div class="input-group">
                            <input type="text" placeholder="123456789" name="phone" value=""
                                class="form-control" maxlength="9" pattern="\d{1,9}"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 9);"
                                aria-label="Text input with dropdown button">
                            <button class="btn btn-outline-primary dropdown-toggle waves-effect" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                996
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" style="">
                                <li><a class="dropdown-item" data-key="971" href="javascript:void(0);">971</a></li>
                                <li><a class="dropdown-item" data-key="996" href="javascript:void(0);">996</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">@lang('save')</button>
                    </div>
                </form>
            </div>
        </div>


    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.dropdown-item').on('click', function() {
                var key = $(this).data('key');
                $('#key_phone').val(key);
                $(this).closest('.input-group').find('.btn.dropdown-toggle').text(key);
            });
        });
    </script>
@endpush
<!--/ Add New owner Modal -->
