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

                                        @foreach (config('translatable.locales') as $locale)
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        {{ __('Name') }} {{ __($locale) }} <span
                                                            class="required-color">*</span></label>
                                                    <input type="text" required id="modalRoleName"
                                                        name="{{ $locale }}[name]" class="form-control"
                                                        placeholder="{{ __('Name') }} {{ __($locale) }}">
                                                </div>
                                            </div>
                                        @endforeach

                                        <div class="col-md-6 mb-3">
                                            <label for="period">@lang('Required subscription period')</label>
                                            <div class="wrapper" style="position: relative; ">
                                                <input type="number" name="period" id="period" class="form-control"
                                                    min="1" required />
                                                <select name="period_type" id="period_type" class="sub-input">
                                                    <option value="day">@lang('day')</option>
                                                    <option value="week">@lang('week')</option>
                                                    <option value="month">@lang('month')</option>
                                                    <option value="year">@lang('year')</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="price"> @lang('the amount')</label><br />
                                            <div class="wrapper" style="position: relative; ">

                                                <input type="text" name="price" id="price" class="form-control"
                                                    required min="0" />
                                                <span class="sub-input">SAR
                                                </span>
                                            </div>

                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <p>@lang('status')</p>
                                            <input type="radio" id="active" name="status" value="1" checked
                                                required>
                                            <label for="active">@lang('active')</label>
                                            <br />
                                            <input type="radio" id="inactive" name="status" value="0">
                                            <label for="inactive">@lang('inactive')</label>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <p>@lang('appear')</p>
                                            <input type="radio" id="show" name="is_show" value="{{ 1 }}"
                                                checked required>
                                            <label for="show">@lang('show')</label>
                                            <br />
                                            <input type="radio" id="hide" name="is_show" value="{{ 0 }}">
                                            <label for="hide">@lang('hide')</label>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <p>@lang('role name')</p>
                                            @foreach ($roles as $role)
                                                <div class="form-check">
                                                    <input type="checkbox" id="{{ $role->id }}" name="roles[]"
                                                        value="{{ $role->id }}">
                                                    <label class="form-check-label"
                                                        for="{{ $role->id }}">{{ $role->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <p>@lang('sections')</p>
                                            @foreach ($sections as $section)
                                                <div class="form-check">
                                                    <input type="checkbox" id="{{ $section->id }}" name="sections[]"
                                                        value="{{ $section->id }}">
                                                    <label class="form-check-label"
                                                        for="{{ $section->id }}">{{ $section->name }}</label>
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
