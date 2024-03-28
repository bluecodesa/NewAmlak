@extends('Admin.layouts.app')
@section('title', __('Gallary'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">
                                @lang('Gallary')</h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item active"><a
                                        href="{{ route('Broker.Gallery.index') }}">@lang('Gallary')</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('Broker.home') }}">@lang('dashboard')</a></li>
                            </ol>
                        </div>


                    </div> <!-- end row -->
                </div>
                <!-- end page-title -->

                <div class="row">

                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">


                                <!--Gallery cover-->
                                @include('Broker.Gallary.inc._GalleryCover')

                                <!--End of gallery cover-->

                                <!--Filter-->
                               @include('Broker.Gallary.inc._FilterGallery')
                                <!--End of filter-->

                                    <div class="col-xl-12">
                                        <div class="card m-b-30">
                                            <div class="card-body">

                                    <ul class="nav nav-pills nav-justified" role="tablist">
                                        <li class="nav-item waves-effect waves-light">
                                            <a id="v-pills-menu-tab" class="nav-link active" data-toggle="tab" href="#home-1" role="tab" data-target="#v-pills-menu" aria-controls="v-pills-menu">
                                                <span class="d-none d-md-block">@lang('Menu')</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
                                            </a>
                                        </li>
                                        <li class="nav-item waves-effect waves-light">
                                            <a id="v-pills-List-tab" class="nav-link" aria-controls="v-pills-List" data-target="#v-pills-List" data-toggle="tab" href="#profile-1" role="tab">
                                                <span class="d-none d-md-block">@lang('List')</span><span class="d-block d-md-none"><i class="mdi mdi-account h5"></i></span>
                                            </a>
                                        </li>

                                    </ul>
                                            </div>
                                        </div>
                                    </div>


                                <div class="col-12">
                                    <div class="tab-content" id="v-pills-tabContent">


                                    <!--Menu Gallery-->
                                    @include('Broker.Gallary.inc._MenuGallery')

                                    <!--End Menu-->

                                    <!--List Gallery-->

                                    @include('Broker.Gallary.inc._ListGallery')

                                    <!--End list-->
                                    </div>

                                </div>
                            </div>


                                            <!-- share -->




                                        <!--end share -->


                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div>
        <!-- container-fluid -->

    </div>


    {{-- @if ($pendingPayment)
        @include('Home.Payments.pending_payment')
@endif --}}



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show the modal when the page is fully loaded
            var modal = document.getElementById('pendingPaymentModal');
            if (modal) {
                modal.classList.add('show');
                modal.style.display = 'block';
                modal.removeAttribute('aria-hidden');
            }
        });
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var editImageLink = document.getElementById('editImageLink');
        var imageEditFormContainer = document.getElementById('imageEditFormContainer');

        editImageLink.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent the default link behavior
            imageEditFormContainer.style.display = 'block'; // Show the form container
        });
    });
</script>


@endsection
