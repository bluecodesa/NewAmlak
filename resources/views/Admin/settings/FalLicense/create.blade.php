@extends('Admin.layouts.app')
@section('title', __('Add New'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 ">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Admin.FalLicense.index') }}" class="text-muted fw-light">@lang('Fal License')
                        </a> /
                        @lang('Add New')
                    </h4>
                </div>

            </div>
            <!-- DataTable with Buttons -->
            <div class="card">
                @include('Admin.layouts.Inc._errors')
                <div class="card-body">
                    <form action="{{ route('Admin.FalLicense.store') }}" method="POST" class="row">
                        @csrf
                        @method('post')
                        @foreach (config('translatable.locales') as $locale)
                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">
                                    {{ __('Name') }} {{ __($locale) }} <span class="required-color">*</span>
                                </label>
                                <input type="text" required id="modalRoleName" name="{{ $locale }}[name]"
                                    class="form-control" placeholder="{{ __('Name') }} {{ __($locale) }}">
                            </div>
                        @endforeach
                        
                        <!-- Add the gallery checkbox here -->
                      
                        <div class="col-md-2 mb-3">
                            <p>@lang('For Gallery')</p>
                            <input class="form-check-input" type="checkbox" id="forGallery" name="for_gallery" value="1">
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
