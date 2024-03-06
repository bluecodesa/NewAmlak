@extends('Admin.layouts.app')
@section('title', __('Settings'))
@section('content')
    <style>
        .nav-pills .nav-link {
            background-color: transparent;
            border: 2px solid silver;
            margin-bottom: 4px;
            border-radius: 10px;
        }
    </style>
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">@lang('Settings')</h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item">@lang('Settings')</li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('Admin.settings.index') }}">@lang('dashboard')</a></li>
                            </ol>
                        </div>
                    </div> <!-- end row -->
                </div>
                <!-- end page-title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                            aria-orientation="vertical">
                                            <button class="nav-link active" id="v-pills-home-tab" data-toggle="pill"
                                                data-target="#v-pills-home" type="button" role="tab"
                                                aria-controls="v-pills-home" aria-selected="true">
                                                @lang('Website Setting')</button>
                                            <button class="nav-link" id="v-pills-profile-tab" data-toggle="pill"
                                                data-target="#v-pills-profile" type="button" role="tab"
                                                aria-controls="v-pills-profile" aria-selected="false">
                                                @lang('PayTabs')</button>
                                            <button class="nav-link" id="v-pills-tax-tab" data-toggle="pill"
                                                data-target="#v-pills-tax" type="button" role="tab"
                                                aria-controls="v-pills-tax" aria-selected="false">
                                                @lang('Mange of invoices')</button>
                                            <button class="nav-link" id="v-pills-messages-tab" data-toggle="pill"
                                                data-target="#v-pills-messages" type="button" role="tab"
                                                aria-controls="v-pills-messages" aria-selected="false">
                                                @lang('Notification Mange')</button>
                                            <button class="nav-link" id="v-pills-settings-tab" data-toggle="pill"
                                                data-target="#v-pills-settings" type="button" role="tab"
                                                aria-controls="v-pills-settings"
                                                aria-selected="false">@lang('Gallary Mange')</button>

                                            <button class="nav-link" id="v-pills-HomePage-tab" data-toggle="pill"
                                                data-target="#v-pills-HomePage" type="button" role="tab"
                                                aria-controls="v-pills-HomePage"
                                                aria-selected="false">@lang('Domain settings')</button>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <!--  اعدادات المنصه -->
                                        <div class="tab-content" id="v-pills-tabContent">
                                            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                                aria-labelledby="v-pills-home-tab">
                                                @include('Admin.settings.inc._GeneralSetting')
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                                                aria-labelledby="v-pills-messages-tab">
                                                @include('Admin.settings.inc._NotificationsManagement')
                                                <!-- نهايه التنبيهات-->
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-settings" role="tabpanel"
                                                aria-labelledby="v-pills-settings-tab">
                                            </div>
                                            <!-- tax rate-->
                                            <div class="tab-pane fade" id="v-pills-tax" role="tabpanel"
                                                aria-labelledby="v-pills-tax-tab">
                                                @include('Admin.settings.inc._UpdateTax')
                                            </div>
                                            <!-- بوابات الدفع -->
                                            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                                aria-labelledby="v-pills-profile-tab">
                                                @include('Admin.settings.inc._paymentGateways')
                                            </div>

                                            <div class="tab-pane fade" id="v-pills-HomePage" role="tabpanel"
                                                aria-labelledby="v-pills-HomePage-tab">
                                                @include('Admin.settings.inc._LandingPage')
                                            </div>


                                            <!-- بوابات الدفع -->
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->


            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- end container-fluid -->

    <!-- container-fluid -->

    <!-- Modal for Add New Payment -->
    @include('Admin.settings.Payments.create-modal')


    <!-- Modal structure update the payment  -->
    @foreach ($paymentGateways as $paymentGateway)
        @include('Admin.settings.Payments.edit-modal', ['paymentGateway' => $paymentGateway])
    @endforeach

    <script>
        $(document).ready(function() {
            $('#editModal').on('show.bs.modal', function(event) {
                // Triggered when the modal is about to be shown
                var button = $(event.relatedTarget); // Button that triggered the modal
                var title_ar = button.data('title-ar'); // Extract info from data-* attributes
                var title_en = button.data('title-en');

                // Set the input values in the modal
                $('#title_ar_modal').val(title_ar);
                $('#title_en_modal').val(title_en);
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#color').change(function() {
                var color = $(this).val();
                $('#left-side-menu').css('background-color', color);
            });
        });
        //

        $(document).ready(function() {
            $('.toggleHomePage').change(function() {
                var url = $(this).data('url');
                if (this.checked) {
                    var active_home_page = 1
                } else {
                    var active_home_page = 0
                }
                $.ajax({
                    url: url,
                    method: "get",
                    data: {
                        active_home_page: active_home_page,
                    },
                    success: function(data) {
                        if (active_home_page == 0) {
                            alertify.success(@json(__('Home page has been suspended')));
                        } else {
                            alertify.success(@json(__('home page has been activated')));
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });
        });
    </script>




@endsection
