@extends('Admin.layouts.app')
@section('title', __('Projects'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">
                                @lang('Projects')</h4>
                        </div>

                    </div> <!-- end row -->
                </div>
                <!-- end page-title -->

                <div class="row">

                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="card-title">
                                    <a href="{{ route('Office.Project.create') }}"
                                        class="btn btn-primary waves-effect waves-light">@lang('Add New')</a>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-xl-3">

                                        <div class="card m-b-30">
                                            <div class="card-body">
                                                <h4 class="card-title font-16 mt-0">Card title</h4>
                                                <h6 class="card-subtitle font-14 text-muted">Support card subtitle</h6>
                                            </div>
                                            <img class="img-fluid p-3" src="{{ url($sitting->icon) }}" alt="Card image cap">
                                            <div class="card-body">
                                                <p class="card-text">Some quick example text to build on the card title and
                                                    make
                                                    up the bulk of the card's content.</p>
                                                <a href="#" class="card-link">Card link</a>
                                                <a href="#" class="card-link">Another link</a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div>
        <!-- container-fluid -->

    </div>
@endsection
