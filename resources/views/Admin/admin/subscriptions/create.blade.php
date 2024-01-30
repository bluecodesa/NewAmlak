@extends('Admin.layouts.app')
@section('title', __('New subscription type'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">
                                @lang('Types subscriptions')</h4>

                        </div>
                        <div class="col-sm-6">

                            <ol class="breadcrumb float-right">

                                <li class="breadcrumb-item ">@lang('Types subscriptions') </li>
                                <li class="breadcrumb-item"><a href="{{ route('Admin.SubscriptionTypes.index') }}">
                                        {{ $sitting->title }} </a></li>
                            </ol>
                        </div>
                    </div> <!-- end row -->
                </div>
                <!-- end page-title -->

                <div class="row">
                    <div class="col-12">


                        <div class="card m-b-30">
                            <div class="card-body">
                                @include('Admin.layouts.Inc._errors')
                                <form action="{{ route('Admin.SubscriptionTypes.store') }}" method="POST">
                                    @csrf
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="period">مدة الاشتراك المطلوب</label>
                                            <div class="wrapper" style="position: relative; ">
                                                <input type="number" name="period" id="period" class="form-control"
                                                    min="1" required />
                                                <select name="period_type" id="period_type"
                                                    style="position: absolute;left: 1px;top: 0;
                                            background-color: #e5dfdf;height: 100%;line-height: 2;
                                            border-top-left-radius: 5px;border-bottom-left-radius: 5px;
                                            padding: 0px 20px;border: 1px solid #ced4da; ">
                                                    <option value="day">يوم</option>
                                                    <option value="week">اسبوع</option>
                                                    <option value="month">شهر</option>
                                                    <option value="year">سنة</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="price"> المبلغ</label><br />
                                            <div class="wrapper" style="position: relative; ">

                                                <input type="text" name="price" id="price" class="form-control"
                                                    required min="0" />
                                                <span
                                                    style="position: absolute;left: 1px;top: 0;
                                        background-color: #e5dfdf;height: 100%;line-height: 2;
                                        border-top-left-radius: 5px;border-bottom-left-radius: 5px;
                                        padding: 0px 20px;border: 1px solid #ced4da; ">SAR
                                                </span>
                                            </div>

                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <p>الحالة</p>
                                            <input type="radio" id="active" name="status" value="1" checked
                                                required>
                                            <label for="active">فعال</label>

                                            <br />
                                            <input type="radio" id="inactive" name="status" value="0">

                                            <label for="inactive">غير فعال</label>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <p>نوع الحساب</p>
                                            @foreach ($roles as $role)
                                                <div class="form-check">
                                                    <input type="checkbox" id="{{ $role->name }}" name="roles[]"
                                                        value="{{ $role->name }}">
                                                    <label class="form-check-label"
                                                        for="{{ $role->name }}">{{ $role->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>

                                        <button class="btn
                                            btn-primary"
                                            type="submit">حفظ</button>
                                </form>

                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div>
        <!-- container-fluid -->

    </div>
    @push('scripts')
        <script>
            window.onload = function() {
                document.querySelector('h2#flush-headingFive button').click();
            }
        </script>
    @endpush
@endsection
