@extends('Admin.layouts.app')
@section('title', __('Edit') . ' ' . __('Terms'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-12 ">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <span class="text-muted fw-light"> @lang('Settings') / @lang('Privacy') & @lang('Terms') /
                            {{ __('Edit') . ' ' . __('Terms') }}</span>

                    </h4>
                </div>

            </div>
            <!-- DataTable with Buttons -->
            <div class="card">
                @include('Admin.layouts.Inc._errors')
                <div class="card-body">

                    <form action="{{ route('Admin.UpdateTerms') }}" method="post" class="row">
                        @csrf
                        @foreach (config('translatable.locales') as $locale)
                            <div class="col-12 mb-3">
                                <label for="form-label mb-2">@lang('Terms') {{ __($locale) }}</label>
                                <textarea class="form-control textarea" name="{{ $locale }}[terms]" cols="100" rows="100" placeholder="">{!! $setting->translate($locale)->terms !!}</textarea>
                            </div>
                        @endforeach

                        <div class="col-12">

                            <button type="submit"
                                class="btn btn-primary waves-effect waves-light m-t-20">@lang('save')</button>
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
                $('.textarea').summernote({
                    height: 400, // set editor height
                    minHeight: null, // set minimum height of editor
                    maxHeight: null, // set maximum height of editor
                    focus: true, // set focus to editable area after initializing summernote
                    toolbar: [
                        // Include only the options you want in the toolbar, excluding 'fontname', 'video', and 'table'
                        ['style', ['bold', 'underline']],
                        ['insert', ['link', 'picture', 'hr']], // 'video' is deliberately excluded
                        ['para', ['ul', 'ol']],
                        ['misc', ['fullscreen', 'undo', 'redo']],
                        // Any other toolbar groups and options you want to include...
                    ],
                });

            });
        </script>
    @endpush
@endsection
