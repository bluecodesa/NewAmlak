@extends('Admin.layouts.app')
@section('title', __('Edit Section'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-sm-6">
                                    <h4 class="page-title">
                                        @lang('Edit Section')</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            @include('Admin.layouts.Inc._errors')
                            <div class="card-body">
                                <form action="{{ route('Admin.update-broker-subscribers', $broker->id) }}" method="POST">
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
                                        <label for="name" class="col-md-4 col-form-label text-md-end text-start">@lang('الاسم رباعي')</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $broker->name) }}">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="license_number" class="col-md-4 col-form-label text-md-end text-start">@lang('رقم رخصة فال')</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="license_number" name="license_number" value="{{ old('license_number', $broker->license_number) }}">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="email" class="col-md-4 col-form-label text-md-end text-start">@lang('البريد الالكتروني')</label>
                                        <div class="col-md-6">
                                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $broker->email) }}">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="mobile" class="col-md-4 col-form-label text-md-end text-start">@lang('رقم الجوال (واتس اب)')</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="mobile" name="mobile" value="{{ old('mobile', $broker->mobile) }}">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="city" class="col-md-4 col-form-label text-md-end text-start">@lang('المدينة')</label>
                                        <div class="col-md-6">
                                            <select class="form-control" id="city" required name="city">
                                                <option value="">إختر</option>
                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->name }}" {{ old('city', $broker->city) == $city->name ? 'selected' : '' }}>
                                                        {{ $city->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="password" class="col-md-4 col-form-label text-md-end text-start">@lang('كلمة المرور')</label>
                                        <div class="col-md-6">
                                            <input type="password" class="form-control" id="password" name="password">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="password_confirmation" class="col-md-4 col-form-label text-md-end text-start">@lang('تأكيد كلمة المرور')</label>
                                        <div class="col-md-6">
                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="subscription" class="col-md-4 col-form-label text-md-end text-start">@lang(' نوع الاشتراك')</label>
                                        <div class="col-md-6">
                                            <select class="form-control" id="subscription_type" name="subscription_type">
                                                <option value="">إختر</option>
                                                @foreach ($subscriptionTypes as $type)
                                                    <option value="{{ $type->id }}" {{ old('subscription_type', $broker->subscription_type) == $type->id ? 'selected' : '' }}>
                                                        {{ $type->period }} {{ $type->period_type }} - {{ $type->price }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="id_number" class="col-md-4 col-form-label text-md-end text-start">@lang('رقم الهوية')</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="id_number" name="id_number" value="{{ old('id_number', $broker->id_number) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary">@lang('save')</button>
                                        <a href="{{ route('Admin.Subscribers.index') }}" class="btn btn-secondary">@lang('Cancel')</a>

                                    </div>
                                </form>


                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div>
        <!-- container-fluid -->

    </div>
@endsection
