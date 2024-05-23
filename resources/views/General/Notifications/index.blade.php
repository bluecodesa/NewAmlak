@extends('Admin.layouts.app')

@section('title', __('Notifications'))

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        @lang('Notifications')</h4>
                </div>
            </div>
            <!-- DataTable with Buttons -->

            <div class="card">

                <div class="row p-3">
                    <div class="col-lg-4">
                        <div class="form-group mb-0">
                            <input type="text" id="searchInput" class="form-control rounded"
                                placeholder="@lang('Search Your notifications..')">
                        </div>
                    </div>
                    {{--
                    <div class="col-lg-8">
                        <div class="btn-toolbar float-lg-right" role="toolbar">
                            <div class="btn-group mo-mb-2">
                                <button type="button" class="btn btn-primary waves-light waves-effect"><i
                                        class="fa fa-inbox"></i></button>
                                <button type="button" class="btn btn-primary waves-light waves-effect"><i
                                        class="fas fa-bookmark"></i></button>
                                <button type="button" class="btn btn-primary waves-light waves-effect"><i
                                        class="far fa-bookmark"></i></button>
                            </div>


                        </div>
                    </div> --}}

                </div>

                <div class="col-12">
                    <div class="demo-inline-spacing mt-3">
                        <div class="list-group" style="padding-left: 6px;">
                            @forelse (Auth::user()->notifications as $noty)
                                <a href="{{ $noty->data['url'] }}"
                                    class="list-group-item mb-1 list-group-item-action flex-column align-items-start {{ $noty['read_at'] == null ? 'active' : '' }} ">
                                    <div class="d-flex justify-content-between w-100">
                                        <h5 class="mb-1">{{ __($noty->data['type_noty']) }}</h5>
                                        <small>{{ $noty->created_at->format('M d, Y') }}</small>
                                    </div>
                                    <p class="mb-1">
                                        {{ $noty->data['msg'] }}
                                    </p>
                                    <small>
                                        {{ $noty->created_at->format('g:i A') }}
                                    </small>
                                </a>
                            @empty
                                <div class="alert alert-danger d-flex align-items-center" role="alert">
                                    <span class="alert-icon text-danger me-2">
                                        <i class="ti ti-ban ti-xs"></i>
                                    </span>
                                    @lang('No Data Found!')
                                </div>
                            @endforelse

                        </div>
                    </div>
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
                $('#searchInput').on('keyup', function() {
                    var searchText = $(this).val().toLowerCase();
                    $('.list-group-item').each(function() {
                        var itemText = $(this).text().toLowerCase();
                        if (itemText.includes(searchText)) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
