<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body">
                <form action="{{ route('Admin.settings.update', $settings->id) }}" method="POST"
                    enctype="multipart/form-data" class="row">
                    @csrf
                    @method('PUT')
                    @foreach (config('translatable.locales') as $locale)
                        <div class="form-group col-md-6">
                            <label for="title_ar">{{ __('Website Name') }}
                                {{ __($locale) }} </label>
                            <input name="{{ $locale }}[title]" class="form-control" type="text"
                                id="title_{{ $locale }}" value="{{ $settings->translate($locale)->title ?? '' }}"
                                placeholder="{{ __('Website Name') }} {{ __($locale) }}">
                        </div>
                    @endforeach

                    <div class="form-group col-md-6">
                        <label for="url">@lang('Email')</label>

                        <input name="email" class="form-control" type="email"
                            value="{{ $settings->email ?? '' }}" id="url">

                    </div>
                    <div class="form-group col-md-6">
                        <label for="logo">@lang('Logo')</label>
                        @if (isset($settings) && $settings->icon)
                            <img src="{{ asset($settings->icon) }}" alt="Current Logo" width="100px">
                        @else
                            <p>No logo uploaded yet.</p>
                        @endif
                        <input name="icon" class="form-control" type="file" id="logo"
                            accept="image/png, image/jpg, image/jpeg">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="url">@lang('Facebook')</label>

                        <input name="facebook" class="form-control" type="url"
                            value="{{ $settings->facebook ?? '' }}" id="url">

                    </div>
                    <div class="form-group col-md-6">
                        <label for="url">@lang('twitter')</label>

                        <input name="twitter" class="form-control" type="url"
                            value="{{ $settings->twitter ?? '' }}" id="url">

                    </div>

                    <div class="form-group col-md-6">
                        <label for="privacy_pdf">@lang('our privacy policy')</label>
                        @if (isset($settings) && $settings->privacy_pdf)
                            <p>{{ $settings->privacy_pdf }}</p>
                        @else
                            <p>No pdf uploaded yet.</p>
                        @endif
                        <input name="privacy_pdf" class="form-control" type="file" id="privacy_pdf" accept=".pdf">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="terms_pdf"> @lang('Conditions')
                            @lang('and') @lang('Terms')</label>
                        @if (isset($settings) && $settings->terms_pdf)
                            <p>{{ $settings->terms_pdf }}</p>
                        @else
                            <p>No pdf uploaded yet.</p>
                        @endif
                        <input name="terms_pdf" class="form-control" type="file" id="terms_pdf" accept=".pdf">
                    </div>


                    <div class="form-group col-md-4">
                        <label for="color">@lang('Color')</label>
                        <input name="color" class="form-control" type="color"
                            value="{{ $settings->color ?? '#30419b' }}" id="color">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="color">@lang('phone')</label>
                        <input name="phone" class="form-control" type="number" placeholder="@lang('phone')"
                            value="{{ $settings->phone }}" id="number">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="crn">@lang('crn')</label>
                        <input name="crn" class="form-control" type="number" placeholder="@lang('crn')"
                            value="{{ $settings->crn }}" id="crn">
                    </div>

                    <div class="col-12">
                        <button type="submit"
                            class="btn btn-primary waves-effect waves-light">@lang('save')</button>
                        <button type="reset" class="btn btn-secondary waves-effect m-l-5">@lang('Cancel')</button>

                    </div>
                </form>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
<!--  اعدادات المنصه -->
