@extends('Admin.layouts.app')
@section('title', __('Add New Section'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 py-3 mb-1">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Admin.Sections.index') }}" class="text-muted fw-light">@lang('sections')
                        </a> /
                        @lang('Add New Section')
                    </h4>
                </div>

            </div>
            <!-- DataTable with Buttons -->
            <div class="card">
                @include('Admin.layouts.Inc._errors')
                <div class="card-body">
                    <form action="{{ route('Admin.Sections.store') }}" method="POST" class="row">
                        @csrf
                        @method('post')
                        @foreach (config('translatable.locales') as $locale)
                            <div class="col-md-6 col-12 mb-3">

                                <label class="form-label">
                                    {{ __('Name') }} {{ __($locale) }} <span class="required-color">*</span></label>
                                <input type="text" required id="modalRoleName" name="{{ $locale }}[name]"
                                    class="form-control" placeholder="{{ __('Name') }} {{ __($locale) }}">
                            </div>

                            <div class="col-md-6 col-12 mb-3">

                                <label class="form-label">
                                    {{ __('Description') }} {{ __($locale) }}</label>
                                <textarea rows="1" id="{{ $locale }}Description" name="{{ $locale }}[description]"
                                    class="form-control" placeholder="{{ __('Description') }} {{ __($locale) }}"></textarea>
                            </div>
                        @endforeach
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                {{ __('save') }}
                            </button>

                        </div>
                    </form>
                </div>
            </div>
            <!-- Modal to add new record -->

            <!--/ DataTable with Buttons -->


        </div>

        <div class="content-backdrop fade"></div>
    </div>


@endsection
