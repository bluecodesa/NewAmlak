@extends('Admin.layouts.app')
@section('title', __('Add New Property Using'))
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
                                        @lang('Add New Service')</h4>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item"><a href="{{ route('Admin.Service.create') }}">@lang('Add New Service')</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('Admin.Service.index') }}">@lang('services')</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('Admin.home') }}">@lang('dashboard')</a></li>
                                    </ol>
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
                                <form action="{{ route('Admin.Service.store') }}" method="POST" class="row">
                                    @csrf
                                    @method('post')

                                    @foreach (config('translatable.locales') as $locale)
                                        <div class="col-md-6">
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

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary me-1">

                                            {{ __('save') }}
                                        </button>

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