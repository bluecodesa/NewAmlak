@extends('Admin.layouts.app')
@section('title', __('Edit'))
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
                                        @lang('Edit')</h4>
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
                                <form action="{{ route('Admin.Region.update', $Region->id) }}" method="POST"
                                    class="row">
                                    @csrf
                                    @method('PUT')
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                {{ __('Name') }} <span class="required-color">*</span></label>
                                            <input type="text" value="{{ $Region->name }}" required id="modalRoleName"
                                                name="name" class="form-control" placeholder="{{ __('Name') }}">
                                        </div>
                                    </div>

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
