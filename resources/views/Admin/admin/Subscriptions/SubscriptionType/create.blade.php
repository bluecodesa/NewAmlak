@extends('Admin.layouts.app')
@section('title', __('Add New Type subscription'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 py-3 mb-1">

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



                        @foreach (config('translatable.locales') as $locale)
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ __('Name') }} {{ __($locale) }} <span
                                            class="required-color">*</span></label>
                                    <input type="text" required id="modalRoleName" name="{{ $locale }}[name]"
                                        class="form-control" placeholder="{{ __('Name') }} {{ __($locale) }}">
                                </div>
                            </div>
                        @endforeach

                        <div class="col-md-4 mb-3">
                            <div class="row">
                                <div class="col"> <label for="period"> @lang('Required subscription period') <span
                                            class="required-color">*</span></label>
                                    <input type="number" name="period" id="period" class="form-control" min="1"
                                        required />
                                </div>
                                <div class="col">
                                    <label for="period"></label>
                                    <select name="period_type" required id="period_type" class="sub-input form-select">
                                        <option value="day">@lang('day')</option>
                                        <option value="week">@lang('week')</option>
                                        <option value="month">@lang('month')</option>
                                        <option value="year">@lang('year')</option>

                                    </select>
                                </div>

                            </div>

                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="price">
                                @lang('the amount') <span class="required-color">*</span></label><br />
                            <div class="wrapper" style="position: relative; ">
                                <input type="text" name="price" id="price" class="form-control" required
                                    min="0" />
                                <span class="sub-input">@lang('SAR')
                                </span>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="upgrade_rate">@lang('Discount applied')</label><br />
                            <div class="wrapper" style="position: relative; ">
                                <input type="text" name="upgrade_rate" id="upgrade_rate" placeholder="20%"
                                    class="form-control" min="0" max="100" />
                            </div>
                        </div>

                        <div class="col-md-3 mb-1">
                            <p>@lang('status')</p>
                            <div class="form-check form-check-primary">
                                <input name="status" class="form-check-input" type="radio" value="{{ 1 }}"
                                    id="active" checked="">
                                <label class="form-check-label" for="active"> @lang('active') </label>
                            </div>

                            <div class="form-check form-check-primary mt-1">
                                <input name="status" class="form-check-input" type="radio" value="{{ 0 }}"
                                    id="inactive" checked="">
                                <label class="form-check-label" for="inactive"> @lang('inactive') </label>
                            </div>

                        </div>

                        <div class="col-md-3 mb-3">
                            <p>@lang('appear')</p>
                            <div class="form-check form-check-primary mt-1">
                                <input name="is_show" class="form-check-input" type="radio" value="{{ 1 }}"
                                    id="show" checked="">
                                <label class="form-check-label" for="show"> @lang('show') </label>
                            </div>

                            <div class="form-check form-check-primary mt-1">
                                <input name="is_show" class="form-check-input" type="radio" value="{{ 0 }}"
                                    id="hide" checked="">
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
