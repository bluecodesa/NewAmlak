@extends('Admin.layouts.app')
@section('title', __('Edit Types subscriptions'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 ">

                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Admin.SubscriptionTypes.index') }}" class="text-muted fw-light">@lang('Types subscriptions')
                        </a> /
                        @lang('Edit Types subscriptions')
                    </h4>
                </div>

            </div>
            <!-- DataTable with Buttons -->
            <div class="card">
                @include('Admin.layouts.Inc._errors')
                <div class="card-body">
                    <form action="{{ route('Admin.SubscriptionTypes.update', $SubscriptionType->id) }}" class="row"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <input type="text" hidden required value="{{ $SubscriptionType->period_type }}"
                            name="period_type" id="period_type">
                        @foreach (config('translatable.locales') as $locale)
                            <div class="col-md-6 col-12 mb-3">

                                <label class="form-label">
                                    {{ __('Name') }} {{ __($locale) }} <span class="required-color">*</span></label>
                                <input type="text" required id="modalRoleName" name="{{ $locale }}[name]"
                                    value="{{ $SubscriptionType->translate($locale)->name }}" class="form-control"
                                    placeholder="{{ __('Name') }} {{ __($locale) }}">

                            </div>
                        @endforeach


                        <div class="col-md-4 col-12 mb-3">
                            <label for="">@lang('Required subscription period') <span class="required-color">*</span></label>
                            <div class="input-group">
                                <button class="btn btn-outline-primary btn-type-subscription dropdown-toggle waves-effect"
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    @lang($SubscriptionType->period_type)

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
                                <input type="number" name="period" min="1" value="{{ $SubscriptionType->period }}"
                                    required class="form-control" placeholder="@lang('Required subscription period')">
                            </div>
                        </div>




                        <div class="col-md-4 mb-3">
                            <label for="price">@lang('the amount') <span class="required-color">*</span></label>
                            <div class="input-group">
                                <input type="number" value="{{ $SubscriptionType->price }}" name="price"
                                    class="form-control" placeholder="@lang('the amount')" aria-label="@lang('the amount')"
                                    aria-describedby="button-addon2">
                                <button class="btn btn-outline-primary waves-effect" type="button"
                                    id="button-addon2">@lang('SAR')</button>
                            </div>
                        </div>

                        <div class="col-md-4 col-12 mb-3">
                            <label for="upgrade_rate">@lang('Discount applied')</label><br />
                            <div class="wrapper" style="position: relative; ">
                                <input type="number" name="upgrade_rate" id="upgrade_rate"
                                    value="{{ $SubscriptionType->upgrade_rate * 100 }}" placeholder="20%"
                                    class="form-control" min="0" max="100" />
                            </div>
                        </div>

                        <div class="col-md-3 col-12 mb-3">
                            <p>@lang('status')</p>

                            <div class="form-check form-check-primary">
                                <input name="status" class="form-check-input" type="radio" value="{{ 1 }}"
                                    id="active" {{ $SubscriptionType->status == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="active"> @lang('active') </label>
                            </div>

                            <div class="form-check form-check-primary mt-1">
                                <input name="status" class="form-check-input" type="radio" value="{{ 0 }}"
                                    id="inactive" {{ $SubscriptionType->status == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="inactive"> @lang('inactive') </label>
                            </div>
                        </div>

                        <div class="col-md-3 col-12 mb-3">
                            <p>@lang('appear')</p>
                            <div class="form-check form-check-primary mt-1">
                                <input name="is_show" class="form-check-input" type="radio"
                                    value="{{ 1 }}" id="show"
                                    {{ $SubscriptionType->is_show == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="show"> @lang('show') </label>
                            </div>

                            <div class="form-check form-check-primary mt-1">
                                <input name="is_show" class="form-check-input" type="radio"
                                    value="{{ 0 }}" id="hide"
                                    {{ $SubscriptionType->is_show == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="hide"> @lang('hide') </label>
                            </div>

                        </div>

                        <div class="col-md-3 col-12 mb-3">
                            <p>@lang('role name')</p>
                            @foreach ($roles as $role)
                                @php
                                    $roleId = $role->id;
                                    $roleName = $role->name;
                                    $checked = in_array($roleId, $rolesIds) ? 'checked' : '';
                                @endphp
                                <div class="form-check form-check-primary mt-1">
                                    <input type="checkbox" class="form-check-input" id="role_{{ $roleId }}"
                                        name="roles[]" value="{{ $roleId }}" {{ $checked }}>
                                    <label class="form-check-label"
                                        for="role_{{ $roleId }}">{{ $roleName }}</label>
                                </div>
                            @endforeach
                        </div>

                        <div class="col-md-3 col-12 mb-3">
                            <p>@lang('sections')</p>
                            @foreach ($sections as $section)
                                @php
                                    $sectionId = $section->id;
                                    $sectionName = $section->name;
                                    $checked = in_array($sectionId, $sectionIds) ? 'checked' : '';
                                @endphp
                                <div class="form-check form-check-primary mt-1">
                                    <input type="checkbox" class="form-check-input" id="section_{{ $sectionId }}"
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
