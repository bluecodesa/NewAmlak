<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>أملاك</title>
        <meta content="Responsive admin theme build on top of Bootstrap 4" name="description" />
        <meta content="Themesdesign" name="author" />
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">

    </head>

    <body>

        <!-- Begin page -->
        <div class="accountbg"></div>
        <div class="home-btn d-none d-sm-block">
                <a href="index.html" class="text-white"><i class="fas fa-home h2"></i></a>
            </div>
        <div class="wrapper-page">
                <div class="card card-pages shadow-none">

                    <div class="card-body">
                        <div class="text-center m-t-0 m-b-15">
                                <a href="index.html" class="logo logo-admin"><img src="assets/images/logo-dark.png" alt="" height="24"></a>
                        </div>
                        <h5 class="font-18 text-center">التسجيل</h5>

                            <form class="form-horizontal m-t-30" id="register" enctype="multipart/form-data" method="POST" action="{{ route('offices.create') }}">
                                @csrf

                                <input type="hidden" name="user_id" value="{{ auth()->check() ? auth()->user()->id : '' }}">

                                <div class="form-group">
                                        <div class="col-12">
                                                <label>رقم السجل التجاري (اختياري)</label>
                                                <input type="text" class="form-control @error('commercial_registry') is-invalid @enderror" id="commercial_registry" name="commercial_registry" placeholder="ادخل رقم السجل التجاري"  value="{{ old('commercial_registry') }}" required autocomplete="commercial_registry" autofocus>

                                                @error('commercial_registry')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                        </div>
                                    </div>

                            <div class="form-group">
                                <div class="col-12">
                                      <label >اسم الشركة *</label>
                                      <input type="text" class="form-control" id="company_name" name="company_name" placeholder="ادخل اسم الشركة" required>
                                 </div>
                            </div>

                            <div class="form-group">
                                <div class="col-12">
                                    <label for="company_logo">شعار الشركة (اختياري)</label>
                                    <input type="file" class="form-control-file" id="company_logo" name="company_logo">
                               </div>
                            </div>

      <!-- Company Email -->
      <div class="form-group">
        <label for="company_email">البريد الالكتروني للشركة *</label>
        <input type="email" class="form-control" id="company_email" name="company_email" placeholder="ادخل البريد الالكتروني" required>
    </div>

    <!-- Representative Name -->
    <div class="form-group">
        <label for="representative_name">اسم ممثل الشركة *</label>
        <input type="text" class="form-control" id="representative_name" name="representative_name" placeholder="ادخل اسم الممثل" required>
    </div>

    <!-- Representative WhatsApp Number -->
    <div class="form-group">
        <label for="representative_whatsapp">رقم ممثل الشركة (واتس اب) *</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">966+</span>
            </div>
            <input type="tel" class="form-control" id="representative_whatsapp" name="representative_whatsapp" placeholder="599123456" required>
        </div>
    </div>

    <!-- City -->
<!-- Blade File -->
<div class="col-6 mb-4">
<label for="city">المدينة <span class="text-danger">*</span></label>
<select class="form-control" id="city" required name="city">
<option value="">إختر</option>
{{-- @foreach($cities as $city)
<option value="{{ $city->name }}" @if (old('city') == $city->name) {{ 'selected' }} @endif>
    {{ $city->name }}
</option>
@endforeach --}}
</select>
</div>


    <!-- Subscription Type -->
    <div class="form-group">
        <label for="subscription_type">نوع الاشتراك *</label>
        <select class="form-control" id="subscription_type" name="subscription_type">
            {{-- @foreach($subscriptionTypes as $type)
                <option value="{{ $type->id }}">{{ $type->period }} {{ $type->period_type }} - {{ $type->price }} - {{ $type->status }}</option>
            @endforeach --}}
        </select>
    </div>

    <!-- Password -->
    <div class="form-group">
        <label for="password">كلمة المرور *</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="ادخل كلمة المرور" required>
    </div>

    <!-- Confirm Password -->
    <div class="form-group">
        <label for="confirm_password">تاكيد كلمة المرور *</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="ادخل كلمة المرور" required>
    </div>


                            <div class="form-group">
                                <div class="col-12">
                                        <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                <label class="custom-control-label font-weight-normal" for="customCheck1">I accept <a href="#" class="text-primary">Terms and Conditions</a></label>
                                            </div>
                                </div>
                            </div>

                            <div class="form-group text-center m-t-20">
                                <div class="col-12">
                                    <button class="btn btn-primary btn-block btn-lg waves-effect waves-light" type="submit">Register</button>
                                </div>
                            </div>

                            <div class="form-group mb-0 row">
                                    <div class="col-12 m-t-10 text-center">
                                        <a href="pages-login.html" class="text-muted">Already have account?</a>
                                    </div>
                                </div>
                        </form>
                    </div>

                </div>
            </div>
        <!-- END wrapper -->

        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/metismenu.min.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/waves.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>

    </body>

</html>
