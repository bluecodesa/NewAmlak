<!doctype html>

<html lang="{{ LaravelLocalization::getCurrentLocale() }}"
    class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
    dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}" data-theme="theme-default"
    data-assets-path="{{ url('HOME_PAGE') }}/" data-template="vertical-menu-template-starter">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

      <title>{{ $sitting->title }} @lang('register')</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('HOME_PAGE/img/favicon/favicon.ico')}}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
      rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('HOME_PAGE/vendor/fonts/fontawesome.css')}}" />
    <link rel="stylesheet" href="{{ asset('HOME_PAGE/vendor/fonts/tabler-icons.css')}}" />
    <link rel="stylesheet" href="{{ asset('HOME_PAGE/vendor/fonts/flag-icons.css')}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('HOME_PAGE/vendor/css/rtl/core.css" class="template-customizer-core-css')}}" />
    <link rel="stylesheet" href="{{ asset('HOME_PAGE/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css')}}" />
    <link rel="stylesheet" href="{{ asset('HOME_PAGE/css/demo.css')}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('HOME_PAGE/vendor/libs/node-waves/node-waves.css')}}" />
    <link rel="stylesheet" href="{{ asset('HOME_PAGE/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" href="{{ asset('HOME_PAGE/vendor/libs/typeahead-js/typeahead.css')}}" />
    <!-- Vendor -->
    <link rel="stylesheet" href="{{ asset('HOME_PAGE/vendor/libs/@form-validation/form-validation.css')}}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('HOME_PAGE/vendor/css/pages/page-auth.css')}}" />

    <!-- Helpers -->
    <script src="{{ asset('HOME_PAGE/vendor/js/helpers.js')}}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('HOME_PAGE/vendor/js/template-customizer.js')}}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('HOME_PAGE/js/config.js')}}"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
          <!-- Register Card -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center mb-4 mt-2">
                <a href="index.html" class="app-brand-link gap-2">
                  <span class="app-brand-logo demo">
                    <a href="{{ route('welcome') }}" class="logo logo-admin"><img src="{{ url($sitting->icon) }}"
                        alt="" height="50"></a>
                  </span>
                </a>
              </div>
              <!-- /Logo -->
              <h4 class="mb-1 pt-2 text-center">سجل الأن</h4>

              <form id="formAuthentication" class="mb-3" action="index.html" method="GET">
                @csrf

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
                            <label class="form-label" for="name"> @lang('Broker name')<span class="text-danger">*</span></label>

                            <input type="text" class="form-control" id="name" name="name" required autofocus>

                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="license_number"> @lang('license number')<span class="text-danger">*</span></label>

                            <input type="text" class="form-control" id="license_number" name="license_number"
                                required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-6">
                            <label class="form-label" for="email">@lang('Email')<span class="text-danger">*</span></label>

                            <input type="email" class="form-control" id="email" name="email">

                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="mobile">@lang('Mobile Whats app')<span class="text-danger">*</span></label>
                            <div style="position:relative">

                                <input type="tel" class="form-control" id="mobile" minlength="9" maxlength="9"
                                    pattern="[0-9]*" oninvalid="setCustomValidity('Please enter 9 numbers.')"
                                    onchange="try{setCustomValidity('')}catch(e){}" placeholder="599123456"
                                    name="mobile" required="" value="">

                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">

                        <div class="form-group col-md-4">
                            <label class="form-label" >@lang('Region') <span class="text-danger">*</span></label>
                            <select class="form-control" id="Region_id" name="region_id" required>
                                <option disabled selected value="">@lang('Region')</option>
                                @foreach ($Regions as $Region)
                                    <option value="{{ $Region->id }}"
                                        data-url="{{ route('Home.Region.show', $Region->id) }}">
                                        {{ $Region->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="form-label" >@lang('city') <span class="text-danger">*</span> </label>
                            <select class="form-control" name="city_id" id="CityDiv" required>
                            </select>
                        </div>

                        <div class="col-md-4 col-12 mb-3">
                            <label class="form-label" for="package"> @lang('Subscription Type') <span class="text-danger">*</span></label>
                            <select type="package" class="form-select" name="subscription_type_id" required="">
                                <option value="" selected disabled> @lang('Subscription Type') </option>
                                @foreach ($subscriptionTypes as $subscriptionType)
                                    <option value="{{ $subscriptionType->id }}">
                                        {{ $subscriptionType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">

                        <div class="col-md-6">
                            {{-- <label for="password"> @lang('password') <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" required> --}}
                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password">@lang('password') <span class="text-danger">*</span></label>
                                <div class="input-group input-group-merge">
                                  <input
                                    type="password"
                                    id="password"
                                    class="form-control"
                                    name="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="password" required />
                                  <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                              </div>

                        </div>

                        <div class="col-md-6">
                            {{-- <label for="password_confirmation"> @lang('Confirm Password') <span
                                    class="text-danger">*</span></label> <input type="password" class="form-control"
                                id="password_confirmation" name="password_confirmation" required> --}}

                                <div class="mb-3 form-password-toggle">
                                    <label class="form-label" for="password">@lang('Confirm Password') <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                      <input
                                        type="password"
                                        id="password_confirmation"
                                        class="form-control"
                                        name="password_confirmation"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" required />
                                      <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                    </div>
                                  </div>
                        </div>
                    </div>


                    <div class="mb-3 row">
                        <div class="col-md-4 mb-6">
                            <label class="form-label" for="broker_logo">@lang('Broker logo')</label>
                            <span class="not_required">(@lang('optional'))</span>
                            <input type="file" class="form-control d-none" id="broker_logo" name="broker_logo"
                                accept="image/png, image/jpg, image/jpeg">
                            <img id="broker_logo_preview" src="https://www.svgrepo.com/show/29852/user.svg"
                                class="d-flex mr-3 rounded-circle" height="64" style="cursor: pointer;" />

                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="id_number" class="col-form-label">@lang('id number')</label>
                            <input type="text" class="form-control" id="id_number" name="id_number">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"></div>
                        <div class="col-md-8">
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">@lang('Cancel')</button>

                            <button type="submit" class="btn btn-primary">@lang('Submit')</button>
                        </div>
                    </div>

              </form>


              <div class="divider my-4">
                <div class="divider-text"></div>
              </div>

              <div class="d-flex justify-content-center">
                <div class="form-group mb-0 row">
                    <div class="col-12 m-t-10 text-center">
                        @lang('By registering') @lang('you accept our')
                        <a href="{{ asset($termsAndConditionsUrl) }}" target="_blank" download>
                            @lang('Conditions') &amp; @lang('Terms')
                        </a>
                        <a href="{{ asset($privacyPolicyUrl) }}" target="_blank" download>
                            @lang('and') @lang('our privacy policy')
                        </a>
                    </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Register Card -->
        </div>
      </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="{{ asset('HOME_PAGE/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{ asset('HOME_PAGE/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{ asset('HOME_PAGE/vendor/js/bootstrap.js')}}"></script>
    <script src="{{ asset('HOME_PAGE/vendor/libs/node-waves/node-waves.js')}}"></script>
    <script src="{{ asset('HOME_PAGE/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{ asset('HOME_PAGE/vendor/libs/hammer/hammer.js')}}"></script>
    <script src="{{ asset('HOME_PAGE/vendor/libs/i18n/i18n.js')}}"></script>
    <script src="{{ asset('HOME_PAGE/vendor/libs/typeahead-js/typeahead.js')}}"></script>
    <script src="{{ asset('HOME_PAGE/vendor/js/menu.js')}}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('HOME_PAGE/vendor/libs/@form-validation/popular.js')}}"></script>
    <script src="{{ asset('HOME_PAGE/vendor/libs/@form-validation/bootstrap5.js')}}"></script>
    <script src="{{ asset('HOME_PAGE/vendor/libs/@form-validation/auto-focus.js')}}"></script>

    <!-- Main JS -->
    <script src="{{ asset('HOME_PAGE/js/main.js')}}"></script>

    <!-- Page JS -->
    <script src="{{ asset('HOME_PAGE/js/pages-auth.js')}}"></script>
  </body>
</html>
