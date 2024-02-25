@extends('Admin.layouts.app')
@section('title', __('Settings'))
@section('content')

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
                                <li class="breadcrumb-item"><a href="{{ route('Admin.settings.index') }}">Amlak</a></li>
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

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card m-b-30">
                                                            <div class="card-body">
                                                                <form
                                                                    action="{{ route('Admin.settings.update', $settings->id) }}"
                                                                    method="POST" enctype="multipart/form-data"
                                                                    class="row">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    @foreach (config('translatable.locales') as $locale)
                                                                        <div class="form-group col-md-6">
                                                                            <label for="title_ar">{{ __('Website Name') }}
                                                                                {{ __($locale) }} </label>
                                                                            <input name="{{ $locale }}[title]"
                                                                                class="form-control" type="text"
                                                                                id="title_{{ $locale }}"
                                                                                value="{{ $settings->translate($locale)->title ?? '' }}"
                                                                                placeholder="{{ __('Website Name') }} {{ __($locale) }}">
                                                                        </div>
                                                                    @endforeach
                                                                    <div class="form-group col-md-6">
                                                                        <label for="url">@lang('URL')</label>

                                                                        <input name="url" class="form-control"
                                                                            type="url"
                                                                            value="{{ $settings->facebook ?? '' }}"
                                                                            id="url">

                                                                    </div>


                                                                    <div class="form-group col-md-6">
                                                                        <label for="logo">@lang('Logo')</label>
                                                                        @if (isset($settings) && $settings->icon)
                                                                            <img src="{{ asset($settings->icon) }}"
                                                                                alt="Current Logo" width="100px">
                                                                        @else
                                                                            <p>No logo uploaded yet.</p>
                                                                        @endif
                                                                        <input name="icon" class="form-control"
                                                                            type="file" id="logo"
                                                                            accept="image/png, image/jpg, image/jpeg">
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="color">@lang('Color')</label>
                                                                        <input name="color" class="form-control"
                                                                            type="color"
                                                                            value="{{ $settings->color ?? '#30419b' }}"
                                                                            id="color">
                                                                    </div>

                                                                    <div class="col-12">
                                                                        <button type="submit"
                                                                            class="btn btn-primary waves-effect waves-light">@lang('save')</button>
                                                                        <button type="reset"
                                                                            class="btn btn-secondary waves-effect m-l-5">@lang('Cancel')</button>

                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div> <!-- end col -->
                                                </div> <!-- end row -->
                                                <!--  اعدادات المنصه -->

                                            </div>



                                            <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                                                aria-labelledby="v-pills-messages-tab">

                                                <div class="col-md-12 ArFont">
                                                    <div class="card timeline shadow">
                                                        <div class="card-header">
                                                            <strong class="card-title">

                                                                إدارة التنبيهات
                                                            </strong>
                                                        </div>
                                                        <div class="card-body">
                                                            <form action="" method="POST">
                                                                <input type="hidden" name="_token" value="">
                                                                <input type="hidden" name="_method" value="POST">
                                                                <div id="dataTable-1_wrapper"
                                                                    class="dataTables_wrapper dt-bootstrap4 no-footer">
                                                                    <div class="row">
                                                                        <div class="col-sm-12 col-md-6">
                                                                            <div class="dataTables_length"
                                                                                id="dataTable-1_length">
                                                                                <label>
                                                                                    <select name="dataTable-1_length"
                                                                                        aria-controls="dataTable-1"
                                                                                        class="custom-select custom-select-sm form-control form-control-sm">
                                                                                        <option value="16">16</option>
                                                                                        <option value="32">32</option>
                                                                                        <option value="64">64</option>
                                                                                        <option value="-1">All</option>
                                                                                    </select>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-12 col-md-6">
                                                                            <div id="dataTable-1_filter"
                                                                                class="dataTables_filter">
                                                                                <label>
                                                                                    <input type="search"
                                                                                        class="form-control form-control-sm"
                                                                                        placeholder="بحث"
                                                                                        aria-controls="dataTable-1">
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!--table-->
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <table
                                                                                class="table datatables dataTable no-footer"
                                                                                id="dataTable-1" role="grid"
                                                                                aria-describedby="dataTable-1_info">
                                                                                <thead>
                                                                                    <tr role="row">
                                                                                        <th class="sorting_asc"
                                                                                            tabindex="0"
                                                                                            aria-controls="dataTable-1"
                                                                                            rowspan="1" colspan="1"
                                                                                            aria-sort="ascending"
                                                                                            aria-label="الاشعار: activate to sort column descending">
                                                                                            الاشعار</th>
                                                                                        <th class="sorting" tabindex="0"
                                                                                            aria-controls="dataTable-1"
                                                                                            rowspan="1" colspan="1"
                                                                                            aria-label="Whatsapp: activate to sort column ascending">
                                                                                            Whatsapp</th>
                                                                                        <th class="sorting" tabindex="0"
                                                                                            aria-controls="dataTable-1"
                                                                                            rowspan="1" colspan="1"
                                                                                            aria-label="Email: activate to sort column ascending">
                                                                                            Email</th>
                                                                                        <th class="sorting" tabindex="0"
                                                                                            aria-controls="dataTable-1"
                                                                                            rowspan="1" colspan="1"
                                                                                            aria-label="SMS: activate to sort column ascending">
                                                                                            SMS</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr role="row" class="odd">
                                                                                        <td class="sorting_1"> استحقاق موعد
                                                                                            دفعة إيجار جديدة</td>
                                                                                        <td> <input type="checkbox"
                                                                                                id="whatsapp"
                                                                                                name="whatsapp">
                                                                                            <input hidden=""
                                                                                                name="rs_offices_id"
                                                                                                value="">
                                                                                            <input hidden=""
                                                                                                name="alert_id"
                                                                                                value="">
                                                                                        </td>
                                                                                        <td>
                                                                                            <input type="checkbox"
                                                                                                id="email"
                                                                                                name="email">
                                                                                        </td>
                                                                                        <td>

                                                                                            <input type="checkbox"
                                                                                                id="email"
                                                                                                name="sms">
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr role="row" class="even">
                                                                                        <td class="sorting_1">اضافة مستأجر
                                                                                            جديد</td>
                                                                                        <td>
                                                                                            <input type="checkbox"
                                                                                                id="whatsapp"
                                                                                                name="whatsapp">
                                                                                            <input hidden=""
                                                                                                name="rs_offices_id"
                                                                                                value="">
                                                                                            <input hidden=""
                                                                                                name="alert_id"
                                                                                                value="">
                                                                                        </td>
                                                                                        <td>
                                                                                            <input type="checkbox"
                                                                                                id="email"
                                                                                                name="email">
                                                                                        </td>

                                                                                        <td>
                                                                                            <input type="checkbox"
                                                                                                id="email"
                                                                                                name="sms">
                                                                                        </td>

                                                                                    </tr>
                                                                                    <tr role="row" class="odd">
                                                                                        <td class="sorting_1">سداد دفعة
                                                                                            إيجار</td>
                                                                                        <td>
                                                                                            <input type="checkbox"
                                                                                                id="whatsapp"
                                                                                                name="whatsapp">
                                                                                            <input hidden=""
                                                                                                name="rs_offices_id"
                                                                                                value="">
                                                                                            <input hidden=""
                                                                                                name="alert_id"
                                                                                                value="">
                                                                                        </td>

                                                                                        <td>
                                                                                            <input type="checkbox"
                                                                                                id="email"
                                                                                                name="email">
                                                                                        </td>
                                                                                        <td>
                                                                                            <input type="checkbox"
                                                                                                id="email"
                                                                                                name="sms">
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-12 col-md-5">
                                                                            <div class="dataTables_info"
                                                                                id="dataTable-1_info" role="status"
                                                                                aria-live="polite"></div>
                                                                        </div>
                                                                        <div class="col-sm-12 col-md-7">
                                                                            <div class="dataTables_paginate paging_simple_numbers"
                                                                                id="dataTable-1_paginate">
                                                                                <ul class="pagination">
                                                                                    <li class="paginate_button page-item previous disabled"
                                                                                        id="dataTable-1_previous"><a
                                                                                            href="#"
                                                                                            aria-controls="dataTable-1"
                                                                                            data-dt-idx="0" tabindex="0"
                                                                                            class="page-link">&lt;</a></li>
                                                                                    <li
                                                                                        class="paginate_button page-item active">
                                                                                        <a href="#"
                                                                                            aria-controls="dataTable-1"
                                                                                            data-dt-idx="1" tabindex="0"
                                                                                            class="page-link">1</a>
                                                                                    </li>
                                                                                    <li class="paginate_button page-item next disabled"
                                                                                        id="dataTable-1_next"><a
                                                                                            href="#"
                                                                                            aria-controls="dataTable-1"
                                                                                            data-dt-idx="2" tabindex="0"
                                                                                            class="page-link">&gt;</a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button type="submit"
                                                                    class="btn btn-primary waves-effect waves-light">@lang('save')</button>
                                                                <button type="reset"
                                                                    class="btn btn-secondary waves-effect m-l-5">@lang('Cancel')</button>
                                                            </form>
                                                        </div>
                                                    </div> <!-- / .card-body -->
                                                </div>
                                                <!-- نهايه التنبيهات-->
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-settings" role="tabpanel"
                                                aria-labelledby="v-pills-settings-tab">
                                            </div>


                                            <!-- بوابات الدفع -->
                                            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                                aria-labelledby="v-pills-profile-tab">

                                                <!-- card paytabs -->

                                                <div class="page-title-box">
                                                    <div class="card m-b-30">
                                                        <div class="card-body">
                                                            <div class="row align-items-center">
                                                                <div class="col-sm-6">
                                                                    <h4 class="page-title">
                                                                        @lang('PayTabs')</h4>
                                                                </div>
                                                                <div class="col-md-6" style="text-align: end">
                                                                    @can('create-payment')
                                                                        <a href="#"
                                                                            class="btn btn-primary col-3 p-1 m-1 waves-effect waves-light"
                                                                            data-toggle="modal"
                                                                            data-target="#addNewPaymentModal">
                                                                            <i class="bi bi-plus-circle"></i>
                                                                            @lang('Add New Payment')
                                                                        </a>
                                                                    @endcan
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div> <!-- end row -->
                                                </div>
                                                <div class="row">
                                                    @foreach ($paymentGateways as $paymentGateway)
                                                        <div class="col-md-6">
                                                            <div class="card m-b-30">
                                                                <div class="form-group col-md-12">
                                                                    <div class="card payment" style="width: 18rem;"
                                                                        data-toggle="modal" data-target="#exampleModal">
                                                                        <div class="payment-img-container">
                                                                            <img class="card-img-top"
                                                                                src="{{ asset($paymentGateway->image) }}"
                                                                                alt="Card image cap">
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <form
                                                                                action="{{ route('Admin.payment-gateways.edit', ['id' => $paymentGateway->id]) }}"
                                                                                method="GET"
                                                                                enctype="multipart/form-data">
                                                                                @csrf
                                                                                @method('PUT')

                                                                                <div class="form-group">
                                                                                    <label>@lang('Api Key PayTabs')</label>
                                                                                    <input name="api_key"
                                                                                        class="form-control"
                                                                                        type="password" id="title_ar"
                                                                                        value="{{ $paymentGateway->api_key ?? '' }}"
                                                                                        disabled>
                                                                                </div>

                                                                                <div class="form-group">
                                                                                    <label>@lang('Profile Id PayTabs')</label>
                                                                                    <input name="profile_id"
                                                                                        class="form-control"
                                                                                        type="password" id="title_en"
                                                                                        value="{{ $paymentGateway->profile_id ?? '' }}"
                                                                                        disabled>
                                                                                </div>

                                                                                <div>
                                                                                    <div class="form-check mb-2">
                                                                                        <input class="form-check-input"
                                                                                            type="radio" name="status"
                                                                                            value="1"
                                                                                            id="customradio1"
                                                                                            {{ $paymentGateway->status == 1 ? 'checked' : '' }}
                                                                                            disabled>
                                                                                        <label class="form-check-label"
                                                                                            for="customradio1">@lang('Enable')</label>
                                                                                    </div>
                                                                                    <div class="form-check mb-2">
                                                                                        <input class="form-check-input"
                                                                                            type="radio" name="status"
                                                                                            value="0"
                                                                                            id="customradio2"
                                                                                            {{ $paymentGateway->status == 0 ? 'checked' : '' }}
                                                                                            disabled>
                                                                                        <label class="form-check-label"
                                                                                            for="customradio2">@lang('Disable')</label>
                                                                                    </div>
                                                                                    <button type="button"
                                                                                        class="btn btn-primary waves-effect waves-light"
                                                                                        data-toggle="modal"
                                                                                        data-target="#editModal{{ $paymentGateway->id }}">
                                                                                        @lang('Edit')
                                                                                    </button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>




                                                <!-- end card paytabs -->


                                            </div>

                                            <div class="tab-pane fade" id="v-pills-HomePage" role="tabpanel"
                                                aria-labelledby="v-pills-HomePage-tab">

                                                <!-- card paytabs -->

                                                <div class="page-title-box">
                                                    <div class="card m-b-30">
                                                        <div class="card-body">
                                                            <h6>
                                                                @lang('Enable Landing Page')
                                                            </h6>
                                                            <div class="col-12">
                                                                <input type="checkbox"
                                                                    data-url="{{ route('Admin.Setting.ChangeActiveHomePage') }}"
                                                                    class="toggleHomePage"
                                                                    {{ $settings->active_home_page == 1 ? 'checked' : '' }}
                                                                    data-toggle="toggle" data-onstyle="primary">
                                                            </div>

                                                        </div>

                                                    </div> <!-- end row -->
                                                </div>


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
    </div>
    <!-- container-fluid -->
    </div>



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
