<div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                                aria-labelledby="v-pills-home-tab">

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card m-b-30">
                                                            <div class="card-body">
                                                                <form
                                                                    action="{{ route('Broker.Setting.updateBroker', $broker->id) }}"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')

                                                                    @if ($errors->any())
                                                                        <div class="alert alert-danger">
                                                                            <ul>
                                                                                @foreach ($errors->all() as $error)
                                                                                    <li>{{ $error }}</li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                    @endif

                                                                    <div class="mb-3 row">
                                                                        <div class="col-md-6">
                                                                            <label for="name">
                                                                                @lang('Broker name')<span
                                                                                    class="text-danger">*</span></label>

                                                                            <input type="text" class="form-control"
                                                                                id="name" name="name"
                                                                                value="{{ $broker->UserData->name }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="license_number">
                                                                                @lang('license number')<span
                                                                                    class="text-danger">*</span></label>

                                                                            <input type="text" class="form-control"
                                                                                id="license_number" name="broker_license"
                                                                                value="{{ $broker->broker_license }}"
                                                                                required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 row">
                                                                        <div class="col-md-6">
                                                                            <label for="email">@lang('Email')<span
                                                                                    class="text-danger">*</span></label>

                                                                            <input type="email" class="form-control"
                                                                                id="email" name="email"
                                                                                value="{{ $broker->UserData->email }}">
                                                                        </div>

                                                                        <div class="col-md-6">

                                                                            <label for="mobile">@lang('Mobile Whats app')<span
                                                                                    class="text-danger">*</span></label>
                                                                            <div style="position:relative">

                                                                                <input type="tel" class="form-control"
                                                                                    id="mobile" minlength="9"
                                                                                    maxlength="9" pattern="[0-9]*"
                                                                                    oninvalid="setCustomValidity('Please enter 9 numbers.')"
                                                                                    onchange="try{setCustomValidity('')}catch(e){}"
                                                                                    placeholder="599123456" name="mobile"
                                                                                    required=""
                                                                                    value="{{ $broker->mobile }}">

                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="mb-3 row">
                                                                        <div class="col-md-4 mb-4">
                                                                            <label
                                                                                for="broker_logo">@lang('Broker logo')</label>
                                                                            <span
                                                                                class="not_required">(@lang('optional'))</span>
                                                                            <input type="file"
                                                                                class="form-control d-none"
                                                                                id="broker_logo" name="broker_logo"
                                                                                accept="image/png, image/jpg, image/jpeg">
                                                                            <img id="broker_logo_preview"
                                                                                src="{{ $broker->broker_logo ? asset($broker->broker_logo) : 'https://www.svgrepo.com/show/29852/user.svg' }}"
                                                                                class="d-flex mr-3 rounded-circle"
                                                                                height="64" style="cursor: pointer;" />
                                                                            @if ($errors->has('broker_logo'))
                                                                                <span
                                                                                    class="text-danger">{{ $errors->first('broker_logo') }}</span>
                                                                            @endif
                                                                        </div>

                                                                        <div class="form-group col-md-4">
                                                                            <label>@lang('Region') <span
                                                                                    class="text-danger">*</span></label>
                                                                            <select class="form-control" id="Region_id"
                                                                                required>
                                                                                <option selected
                                                                                    value="{{ $region->id }}">
                                                                                    {{ $region->name }}</option>
                                                                                @foreach ($Regions as $Region)
                                                                                    <option value="{{ $Region->id }}"
                                                                                        data-url="{{ route('Office.Office.GetCitiesByRegion', $Region->id) }}">
                                                                                        {{ $Region->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>

                                                                        <div class="form-group col-md-4">
                                                                            <label>@lang('city') <span
                                                                                    class="text-danger">*</span></label>
                                                                            <select class="form-control" name="city_id"
                                                                                id="CityDiv" value="" required>
                                                                                <option selected
                                                                                    value="{{ $city->id }}">
                                                                                    {{ $city->name }}</option>
                                                                            </select>
                                                                        </div>


                                                                    </div>

                                                                    <div class="mb-3 row">

                                                                        <div class="col-md-6">
                                                                            <label for="password"> @lang('password')
                                                                                <span class="text-danger">*</span></label>
                                                                            <input type="password" class="form-control"
                                                                                id="password" name="password" required>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <label for="password_confirmation">
                                                                                @lang('Confirm Password') <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="password" class="form-control"
                                                                                id="password_confirmation"
                                                                                name="password_confirmation" required>
                                                                        </div>
                                                                    </div>


                                                                    <div class="mb-3 row">
                                                                        <div class="col-md-6">
                                                                            <label for="id_number"
                                                                                class="col-form-label">@lang('id number')</label>
                                                                            <input type="text" class="form-control"
                                                                                id="id_number" name="id_number"
                                                                                value="{{ $broker->id_number }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <div class="col-md-4"></div>
                                                                        <div class="col-md-8">
                                                                            <button type="submit"
                                                                                class="btn btn-primary">@lang('save')</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div> <!-- end col -->
                                                </div> <!-- end row -->
                                                <!--  اعدادات الحساب البروفيل -->

                                            </div>
