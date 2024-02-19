@extends('Admin.layouts.app')
@section('title', __('Notifications'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">@lang('Notifications')</h4>
                        </div>
                    </div>
                    <!-- end row -->
                </div>
                <!-- end page-title -->

                <div class="row">
                    <div class="col-12">
                        <!-- Left sidebar -->

                        <!-- End Left sidebar -->

                        <!-- Right Sidebar -->
                        <div class=" col-12 mb-3">

                            <div class="card">

                                <div class="row p-3">
                                    <div class="col-lg-4">
                                        <form role="search" class="email-inbox">
                                            <div class="form-group mb-0">
                                                <input type="text" id="searchInput" class="form-control rounded"
                                                    placeholder="@lang('Search Your notifications..')">
                                                <button type="submit"><i class="fa fa-search"></i></button>
                                            </div>
                                        </form>
                                    </div>

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
                                    </div>

                                </div>

                                <ul class="message-list p-2">
                                    @foreach (Auth::user()->notifications as $noty)
                                        <li class=" {{ $noty['read_at'] == null ? 'unread' : '' }} ">
                                            <div class="col-mail col-mail-1">
                                                <a href="#" class="title">
                                                    <img class="mr-3 rounded-circle float-left mt-2"
                                                        src="assets/images/users/user-1.jpg" alt="" height="40">
                                                    <h6 class="mb-0"> {{ __($noty->data['type_noty']) }} </h6>
                                                    <p class="text-muted mt-1 mb-0">
                                                        {{ $noty->created_at->format('M d, Y') }}</p>
                                                </a>

                                            </div>
                                            <div class="col-mail col-mail-2">

                                                <a href="{{ $noty->data['url'] }}" class="subject">

                                                    <p class="text-muted mt-1 mb-0"> <span class="teaser">
                                                            {{ $noty->data['msg'] }}
                                                        </span></p>
                                                </a>
                                                <div class="date">

                                                    <a href="">
                                                        <i class="mdi mdi-link-variant mr-2 font-16 "></i>
                                                        {{ $noty->created_at->format('g:i A') }}
                                                    </a>

                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                    <!-- end 1 -->
                                </ul>

                            </div>
                            <!-- card -->



                        </div>
                        <!-- end Col-9 -->

                    </div>

                </div>
                <!-- End row -->

            </div>
            <!-- container-fluid -->

        </div>
        <!-- content -->


    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                // Trigger search on input change
                $('#searchInput').on('keyup', function() {
                    var searchText = $(this).val().toLowerCase();
                    $('.message-list li').each(function() {
                        var typeNoty = $(this).find('.title h6').text().toLowerCase();
                        var message = $(this).find('.subject .teaser').text().toLowerCase();

                        if (typeNoty.includes(searchText) || message.includes(searchText)) {
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
