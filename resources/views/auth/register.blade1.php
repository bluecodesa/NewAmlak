<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل في تاون</title>
    <!-- Add Bootstrap CDN link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 600px;
            margin-top: 50px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>سجل معنا في تاون</h2>
                <p>سجل البيانات أدناه في تاون</p>
            </div>

            <div class="card-body">
                <form id="register" enctype="multipart/form-data" method="POST" action="{{ route('offices.create') }}">
                    @csrf

                    <input type="hidden" name="user_id" value="{{ auth()->check() ? auth()->user()->id : '' }}">


                    <!-- Commercial Registry Number -->


                    <div class="form-group">
                        <label for="commercial_registry">رقم السجل التجاري (اختياري)</label>
                        <input type="text" class="form-control @error('commercial_registry') is-invalid @enderror" id="commercial_registry" name="commercial_registry" placeholder="ادخل رقم السجل التجاري" value="{{ old('commercial_registry') }}" required autocomplete="commercial_registry" autofocus>

                        @error('commercial_registry')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Company Name -->
                    <div class="form-group">
                        <label for="company_name">اسم الشركة *</label>
                        <input type="text" class="form-control" id="company_name" name="company_name" placeholder="ادخل اسم الشركة" required>
                    </div>

                    <!-- Company Logo -->
                    <div class="form-group">
                        <label for="company_logo">شعار الشركة (اختياري)</label>
                        <input type="file" class="form-control-file" id="company_logo" name="company_logo">
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
                            @foreach($cities as $city)
                            <option value="{{ $city->name }}" @if (old('city')==$city->name) {{ 'selected' }} @endif>
                                {{ $city->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>


                    <!-- Subscription Type -->
                    <div class="form-group">
                        <label for="subscription_type">نوع الاشتراك *</label>
                        <select class="form-control" id="subscription_type" name="subscription_type">
                            @foreach($subscriptionTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->period }} {{ $type->period_type }} - {{ $type->price }} - {{ $type->status }}</option>
                            @endforeach
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

                    <button type="submit" class="btn btn-primary btn-block">تسجيل</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Bootstrap JS and Popper.js CDN links -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>


<!-- {{-- @extends('layouts.app') -->

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
