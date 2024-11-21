


<!-- Add New Add New owner Modal Modal -->
<div class="modal fade" id="addNewCCModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center">
                    <h3 class="mb-2">@lang('Add New Owner')</h3>
                </div>
                <form action="{{ route('Office.Unit.SaveNewOwners') }}" method="POST" id="OwnerForm" class="row">
                    @csrf
                    @method('post')
                    <input type="text" hidden name="key_phone" value="966" id="key_phone">
                    <input type="text" hidden name="full_phone" id="full_phone" value="966">
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
                        <select class="form-select RegionOwner" required>
                            <option disabled selected value="">@lang('Region')</option>
                            @foreach ($Regions as $Region)
                                <option value="{{ $Region->id }}"
                                    data-url="{{ route('Office.Office.GetCitiesByRegion', $Region->id) }}">
                                    {{ $Region->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 col-12 mb-3">
                        <label class="form-label">@lang('city') <span class="required-color">*</span> </label>
                        <select class="form-select CityOwner" name="city_id" required>

                        </select>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="color" class="form-label">@lang('phone') <span
                                class="required-color">*</span></label>
                        <div class="input-group">
                            <input type="text" placeholder="123456789" name="phone" id="phone" value=""
                                class="form-control" maxlength="9" pattern="\d{1,9}" oninput="updateFullPhone(this)"
                                aria-label="Text input with dropdown button">
                            {{-- <button class="btn btn-outline-primary dropdown-toggle waves-effect" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                966
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" style="">
                                <li><a class="dropdown-item" data-key="971" href="javascript:void(0);">971</a></li>
                                <li><a class="dropdown-item" data-key="966" href="javascript:void(0);">966</a></li>
                            </ul> --}}

                            <button class="btn btn-outline-primary dropdown-toggle waves-effect"
                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ config('translatable.phones')[0] }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @foreach (config('translatable.phones') as $phone)
                                <li>
                                <a class="dropdown-item" data-key="{{ $phone }}" href="javascript:void(0);">
                                    {{ $phone }}+
                                </a>
                                </li>
                                @endforeach
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
        function updateFullPhone(input) {
            input.value = input.value.replace(/[^0-9]/g, '').slice(0, 9);
            var key_phone = $('#key_phone').val();
            var fullPhone = key_phone + input.value;
            document.getElementById('full_phone').value = fullPhone;
        }
        $(document).ready(function() {
            $('.dropdown-item').on('click', function() {
                var key = $(this).data('key');
                var phone = $('#phone').val();
                $('#key_phone').val(key);
                $('#full_phone').val(key + phone);
                $(this).closest('.input-group').find('.btn.dropdown-toggle').text(key);
            });
        });
        //


        $('.RegionOwner').on('change', function() {
            var selectedOption = $(this).find(':selected');
            var url = selectedOption.data('url');
            $.ajax({
                type: "get",
                url: url,
                beforeSend: function() {
                    $('.CityOwner').fadeOut('fast');
                },
                success: function(data) {
                    $('.CityOwner').fadeOut('fast', function() {
                        $(this).empty().append(data);
                        $(this).fadeIn('fast');
                    });
                },
            });
        });
    </script>
@endpush
<!--/ Add New owner Modal -->
