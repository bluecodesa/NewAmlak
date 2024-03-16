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
                                <li class="breadcrumb-item"><a href="{{ route('Admin.SubscriptionTypes.edit', $SubscriptionType->id) }}">@lang('Edit Types subscriptions')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('Admin.SubscriptionTypes.index') }}">@lang('Types subscriptions')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('Admin.home') }}">@lang('dashboard')</a></li>
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
                                <form action="{{ route('Admin.SubscriptionTypes.update', $SubscriptionType->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-row">

                                        @foreach (config('translatable.locales') as $locale)
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        {{ __('Name') }} {{ __($locale) }} <span
                                                            class="required-color">*</span></label>
                                                    <input type="text" required id="modalRoleName"
                                                        name="{{ $locale }}[name]"
                                                        value="{{ $SubscriptionType->translate($locale)->name }}"
                                                        class="form-control"
                                                        placeholder="{{ __('Name') }} {{ __($locale) }}">
                                                </div>
                                            </div>
                                        @endforeach
                                        @php
                                            $days = ['day', 'week', 'month', 'year'];
                                        @endphp
                                        <div class="col-md-6 mb-3">
                                            <label for="period">@lang('Required subscription period')</label>
                                            <div class="wrapper" style="position: relative; ">
                                                <input type="number" value="{{ $SubscriptionType->period }}" name="period"
                                                    id="period" class="form-control" min="1" required />
                                                <select name="period_type" id="period_type" class="sub-input">
                                                    @foreach ($days as $type)
                                                        <option value="{{ $type }}"
                                                            {{ $SubscriptionType->period_type == ($type) ? 'selected' : '' }}>
                                                            @lang($type)</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="price"> @lang('the amount')</label><br />
                                            <div class="wrapper" style="position: relative; ">

                                                <input type="text" name="price" value="{{ $SubscriptionType->price }}"
                                                    id="price" class="form-control" required min="0" />
                                                <span class="sub-input">@lang('SAR')
                                                </span>
                                            </div>

                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <p>@lang('status')</p>
                                            <input type="radio" id="active" name="status" value="{{ 1 }}"
                                                {{ $SubscriptionType->status == 1 ? 'checked' : '' }} required>
                                            <label for="active">@lang('active')</label>
                                            <br />
                                            <input type="radio" id="inactive" name="status" value="{{ 0 }}"
                                                {{ $SubscriptionType->status == 0 ? 'checked' : '' }}>
                                            <label for="inactive">@lang('inactive')</label>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <p>@lang('appear')</p>
                                            <input type="radio" id="show" name="is_show" value="{{ 1 }}"
                                                {{ $SubscriptionType->is_show == 1 ? 'checked' : '' }} required>
                                            <label for="show">@lang('show')</label>
                                            <br />
                                            <input type="radio" id="hide" name="is_show" value="{{ 0 }}"
                                                {{ $SubscriptionType->is_show == 0 ? 'checked' : '' }}>
                                            <label for="hide">@lang('hide')</label>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <p>@lang('role name')</p>
                                            @foreach ($roles as $role)
                                                @php
                                                    $roleId = $role->id;
                                                    $roleName = $role->name;
                                                    $checked = in_array($roleId, $rolesIds) ? 'checked' : '';
                                                @endphp
                                                <div class="form-check">
                                                    <input type="checkbox" id="role_{{ $roleId }}" name="roles[]" value="{{ $roleId }}" {{ $checked }}>
                                                    <label class="form-check-label" for="role_{{ $roleId }}">{{ $roleName }}</label>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <p>@lang('sections')</p>
                                            @foreach ($sections as $section)
                                                @php
                                                    $sectionId = $section->id;
                                                    $sectionName = $section->name;
                                                    $checked = in_array($sectionId, $sectionIds) ? 'checked' : '';
                                                @endphp
                                                <div class="form-check">
                                                    <input type="checkbox" id="section_{{ $sectionId }}" name="sections[]" value="{{ $sectionId }}" {{ $checked }}>
                                                    <label class="form-check-label" for="section_{{ $sectionId }}">{{ $sectionName }}</label>
                                                </div>
                                            @endforeach
                                        </div>


                                        <button class="btn
                                            btn-primary"
                                            type="submit">@lang('save')</button>
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
