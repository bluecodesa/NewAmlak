@extends('Admin.layouts.app')
@section('title', __('Add New Partner Success'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-12 ">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Admin.PartnerSuccess.index') }}" class="text-muted fw-light">@lang('Partners Success')
                        </a> /
                        @lang('Add New Partner Success')
                    </h4>
                </div>

            </div>
            <!-- DataTable with Buttons -->
            <div class="card">
                @include('Admin.layouts.Inc._errors')
                <div class="card-body">

                    <form action="{{ route('Admin.PartnerSuccess.store') }}" class="row" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label">@lang('Name')</label>
                            <input  class="form-control" type="text" id="name" name="name" required>
                        </div>
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label">
                                @lang('Image')</label>
                            <input class="form-control" type="file" id="image" name="image" accept="image/*" required>
                            <small>@lang('image size must be 460*460')</small>
                        </div>
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
