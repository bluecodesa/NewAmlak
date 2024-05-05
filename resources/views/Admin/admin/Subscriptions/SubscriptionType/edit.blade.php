@extends('Admin.layouts.app')
@section('title', __('Edit Types subscriptions'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 py-3 mb-1">

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
                        @foreach (config('translatable.locales') as $locale)
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ __('Name') }} {{ __($locale) }} <span
                                            class="required-color">*</span></label>
                                    <input type="text" required id="modalRoleName" name="{{ $locale }}[name]"
                                        value="{{ $SubscriptionType->translate($locale)->name }}" class="form-control"
                                        placeholder="{{ __('Name') }} {{ __($locale) }}">
                                </div>
                            </div>
                        @endforeach
                        @php
                            $days = ['day', 'week', 'month', 'year'];
                        @endphp
                        <div class="col-md-4 mb-3">
                            <div class="row">
                                <div class="col"> <label for="period"> @lang('Required subscription period') <span
                                            class="required-color">*</span></label>
                                    <input type="number" name="period" value="{{ $SubscriptionType->period }}"
                                        id="period" class="form-control" min="1" required />
                                </div>
                                <div class="col-6">
                                    <label for="period"></label>
                                    <select name="period_type" id="period_type" required class="sub-input form-select">
                                        @foreach ($days as $type)
                                            <option value="{{ $type }}"
                                                {{ $SubscriptionType->period_type == $type ? 'selected' : '' }}>
                                                @lang($type)</option>
                                        @endforeach

                                    </select>
                                </div>

                            </div>

                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="price"> @lang('the amount')</label><br />
                            <div class="wrapper" style="position: relative; ">

                                <input type="text" name="price" value="{{ $SubscriptionType->price }}" id="price"
                                    class="form-control" required min="0" />
                                <span class="sub-input">@lang('SAR')
                                </span>
                            </div>

                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="upgrade_rate">@lang('Discount applied')</label><br />
                            <div class="wrapper" style="position: relative; ">
                                <input type="text" name="upgrade_rate" id="upgrade_rate"
                                    value="{{ $SubscriptionType->upgrade_rate * 100 }}" placeholder="20%"
                                    class="form-control" min="0" max="100" />
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
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

                        <div class="col-md-3 mb-3">
                            <p>@lang('appear')</p>
                            <div class="form-check form-check-primary mt-1">
                                <input name="is_show" class="form-check-input" type="radio" value="{{ 1 }}"
                                    id="show" {{ $SubscriptionType->is_show == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="show"> @lang('show') </label>
                            </div>

                            <div class="form-check form-check-primary mt-1">
                                <input name="is_show" class="form-check-input" type="radio" value="{{ 0 }}"
                                    id="hide" {{ $SubscriptionType->is_show == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="hide"> @lang('hide') </label>
                            </div>

                        </div>

                        <div class="col-md-3 mb-3">
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

                        <div class="col-md-3 mb-3">
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


                        <button class="btn
                                btn-primary"
                            type="submit">@lang('save')</button>
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
    @endpush

@endsection
