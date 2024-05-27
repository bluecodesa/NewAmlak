@extends('Admin.layouts.app')
@section('title', __('Add New Type subscription'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 ">

                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Admin.SubscriptionTypes.index') }}" class="text-muted fw-light">@lang('Types subscriptions')
                        </a> /
                        @lang('Add New Type subscription')
                    </h4>
                </div>

            </div>
            <!-- DataTable with Buttons -->
            <div class="card">
                @include('Admin.layouts.Inc._errors')
                <div class="card-body">
                    <form action="{{ route('Admin.SubscriptionTypes.store') }}" class="row" method="POST">
                        @csrf

                        <input type="text" hidden required value="day" name="period_type" id="period_type">

                        @foreach (config('translatable.locales') as $locale)
                            <div class="col-md-6 col-12 mb-3">
                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ __('Name') }} {{ __($locale) }} <span
                                            class="required-color">*</span></label>
                                    <input type="text" required id="modalRoleName" name="{{ $locale }}[name]"
                                        class="form-control" placeholder="{{ __('Name') }} {{ __($locale) }}">
                                </div>
                            </div>
                        @endforeach
                        <div class="col-md-4 col-12 mb-3">
                            <label for="" class="form-label">@lang('Required subscription period') <span
                                    class="required-color">*</span></label>
                            <div class="input-group">
                                <button class="btn btn-outline-primary btn-type-subscription dropdown-toggle waves-effect"
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    @lang('day')
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" data-tarnslat="@lang('day')" data-value="day"
                                            href="javascript:void(0);">@lang('day')</a></li>

                                    <li><a class="dropdown-item" data-value="week" data-tarnslat="@lang('week')"
                                            href="javascript:void(0);">@lang('week')</a></li>

                                    <li><a class="dropdown-item" data-value="month" data-tarnslat="@lang('month')"
                                            href="javascript:void(0);">@lang('month')</a></li>
                                    <li><a class="dropdown-item" data-value="year" data-tarnslat="@lang('year')"
                                            href="javascript:void(0);">@lang('year')</a></li>
                                </ul>
                                <input type="text" name="period" required class="form-control"
                                    placeholder="@lang('Required subscription period')" aria-label="@lang('Required subscription period')">
                            </div>
                        </div>


                        <div class="col-md-4 mb-3">
                            <label for="price" class="form-label">@lang('the amount') <span
                                    class="required-color">*</span></label>
                            <div class="input-group">
                                <input type="number" name="price" class="form-control" placeholder="@lang('the amount')"
                                    aria-label="@lang('the amount')" aria-describedby="button-addon2" required>
                                <button class="btn btn-outline-primary waves-effect" type="button"
                                    id="button-addon2">@lang('SAR')</button>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="upgrade_rate" class="form-label">@lang('Discount applied')</label><br />
                            <div class="wrapper" style="position: relative; ">
                                <input type="text" name="upgrade_rate" id="upgrade_rate" placeholder="20%"
                                    class="form-control" min="0" max="100" />
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <p>@lang('status')</p>
                            <div class="form-check form-check-primary">
                                <input name="status" class="form-check-input" type="radio" value="{{ 1 }}"
                                    id="active" checked="">
                                <label class="form-check-label" for="active"> @lang('active') </label>
                            </div>

                            <div class="form-check form-check-primary mb-3">
                                <input name="status" class="form-check-input" type="radio" value="{{ 0 }}"
                                    id="inactive" checked="">
                                <label class="form-check-label" for="inactive"> @lang('inactive') </label>
                            </div>

                        </div>

                        <div class="col-md-3 mb-3">
                            <p>@lang('appear')</p>
                            <div class="form-check form-check-primary mt-1">
                                <input name="is_show" class="form-check-input" type="radio"
                                    value="{{ 1 }}" id="show" checked="">
                                <label class="form-check-label" for="show"> @lang('show') </label>
                            </div>

                            <div class="form-check form-check-primary mt-1">
                                <input name="is_show" class="form-check-input" type="radio"
                                    value="{{ 0 }}" id="hide" checked="">
                                <label class="form-check-label" for="hide"> @lang('hide') </label>
                            </div>

                        </div>

                        <div class="col-md-3 mb-3">
                            <p>@lang('role name')</p>
                            @foreach ($roles as $index => $role)
                                @php
                                    $roleId = $role->id;
                                    $roleName = $role->name;
                                    $checked = $index === 0 ? 'checked' : '';
                                @endphp
                                <div class="form-check form-check-primary mt-1">
                                    <input type="checkbox" id="role_{{ $roleId }}" name="roles[]"
                                        class="form-check-input" value="{{ $roleId }}" {{ $checked }}>
                                    <label class="form-check-label"
                                        for="role_{{ $roleId }}">{{ $roleName }}</label>
                                </div>
                            @endforeach
                        </div>

                        <div class="col-md-3 mb-3">
                            <p>@lang('sections')</p>
                            @foreach ($sections as $section)
                                @php
                                    $sectionId = $section->id;
                                    $sectionName = $section->name;
                                    $checked = '';
                                @endphp
                                <div class="form-check form-check-primary mt-1">
                                    <input class="form-check-input" type="checkbox" id="section_{{ $sectionId }}"
                                        name="sections[]" value="{{ $sectionId }}" {{ $checked }}>
                                    <label class="form-check-label"
                                        for="section_{{ $sectionId }}">{{ $sectionName }}</label>
                                </div>
                            @endforeach
                        </div>

                        <div class="col-12">
                            <button class="btn btn-primary waves-effect waves-light"
                                type="submit">@lang('save')</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Modal to add new record -->

            <!--/ DataTable with Buttons -->


        </div>

        <div class="content-backdrop fade"></div>
    </div>
    @push('scripts')
        <script>
            window.onload = function() {
                document.querySelector('h2#flush-headingFive button').click();
            }
        </script>

        <script>
            $(document).ready(function() {
                $('.dropdown-item').on('click', function() {
                    var value = $(this).data('value');
                    var tarnslat = $(this).data('tarnslat');
                    $('#period_type').val(value);

                    $('.btn-type-subscription').text(tarnslat);
                });
            });
        </script>
    @endpush

@endsection
