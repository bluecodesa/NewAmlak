@extends('Admin.layouts.app')
@section('title', __('Subscribers'))
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
                                        @lang('Subscribers')</h4>
                                </div>
                                <div class="col-md-6" style="text-align: end">
                                    <a href="{{ route('Admin.Subscribers.create') }}"
                                        class="btn btn-primary col-3 p-1 m-1 waves-effect waves-light" data-toggle="modal" data-target="#addSubscriberModal">
                                        @lang('Add New Subscriber')
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div> <!-- end row -->
                </div>
                <!-- end page-title -->

                <div class="row">

                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">

                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('Subscriber Name')</th>
                                            <th>@lang('Subscription Type')</th>
                                            <th>@lang('Subscription Time')</th>
                                            <th>@lang('Subscription Status')</th>
                                            <th>@lang('Number of Clients')</th>
                                            <th>@lang('Subscriber City')</th>
                                            <th>@lang('Subscription Start')</th>
                                            <th>@lang('Subscription End')</th>
                                            <th>@lang('Action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($brokers as $brokerSubscriber)
                                        <tr>
                                            <td>{{ $brokerSubscriber->id }}</td>
                                            <td>{{ $brokerSubscriber->name }}</td>
                                            <td>{{ $brokerSubscriber->subscription_type }}</td>
                                            <td>{{ $brokerSubscriber->subscription_time }}</td>
                                            <td>{{ $brokerSubscriber->subscription_status }}</td>
                                            <td>{{ $brokerSubscriber->number_of_clients }}</td>
                                            <td>{{ $brokerSubscriber->subscriber_city }}</td>
                                            <td>{{ $brokerSubscriber->subscription_start }}</td>
                                            <td>{{ $brokerSubscriber->subscription_end }}</td>
                                            <td>
                                                <a href="{{ route('admin.broker-subscribers.edit', $brokerSubscriber->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                <form action="{{ route('admin.broker-subscribers.destroy', $brokerSubscriber->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>


                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div>
        <!-- container-fluid -->

    </div>

    <!-- Add New Subscriber Modal -->
<div class="modal fade" id="addSubscriberModal" tabindex="-1" role="dialog" aria-labelledby="addSubscriberModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addSubscriberModalLabel">@lang('Add New Subscriber')</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="card-deck">
                <!-- Add New Office Card -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">@lang('Office')</h5>
                        {{-- <p class="card-text">Add a new office subscriber.</p> --}}
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addOfficeModal">@lang('Add Office')</button>
                    </div>
                </div>
                <!-- Add New Broker Card -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">@lang('Broker')</h5>
                        {{-- <p class="card-text">Add a new broker subscriber.</p> --}}
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addBrokerModal">@lang('Add Broker')</button>
                    </div>
                </div>
            </div>
        </div>


        </div>

    </div>
</div>
</div>

<!-- Add New Broker Modal -->
<div class="modal fade" id="addBrokerModal" tabindex="-1" role="dialog" aria-labelledby="addBrokerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBrokerModalLabel">@lang('Add Broker')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add Broker Form -->
                <form action="{{ route('Admin.Subscribers.store') }}" method="POST">
                    @csrf
                    <div class="mb-3 row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start">@lang('الاسم رباعي')</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="license_number" class="col-md-4 col-form-label text-md-end text-start">@lang('رقم رخصة فال')</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="license_number" name="license_number">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-md-4 col-form-label text-md-end text-start">@lang('البريد الالكتروني')</label>
                        <div class="col-md-6">
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="mobile" class="col-md-4 col-form-label text-md-end text-start">@lang('رقم الجوال (واتس اب)')</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="mobile" name="mobile">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="city" class="col-md-4 col-form-label text-md-end text-start">@lang('المدينة')</label>
                        <div class="col-md-6">
                        <select class="form-control" id="city" required name="city">
                            <option value="">إختر</option>
                            @foreach ($cities as $city)
                        <option value="{{ $city->name }}" @if (old('city') == $city->name) {{ 'selected' }} @endif>
                            {{ $city->name }}
                        </option>
                        @endforeach
                        </select>
                    </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="password" class="col-md-4 col-form-label text-md-end text-start">@lang('كلمة المرور')</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="confirm_password" class="col-md-4 col-form-label text-md-end text-start">@lang('تأكيد كلمة المرور')</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="subscription" class="col-md-4 col-form-label text-md-end text-start">@lang(' نوع الاشتراك')</label>
                        <div class="col-md-6">
                        <select class="form-control" id="subscription_type" name="subscription_type">
                        @foreach ($subscriptionTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->period }} {{ $type->period_type }} - {{ $type->price }} - {{ $type->status }}</option>
                        @endforeach
                        </select>
                        </div>
                    </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="id_number" class="col-md-4 col-form-label text-md-end text-start">@lang('رقم الهوية')</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="id_number" name="id_number">
                        </div>
                    </div>
                    <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">@lang('save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<!--Office  -->
<div class="modal fade" id="addOfficeModal" tabindex="-1" role="dialog" aria-labelledby="addBrokerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                <div class="row  w-100 text-center">
                    <div class="col-12">
                        <h5 class="modal-title" id="exampleModalLongTitle" style="font-weight:700">سجل معنا في
                            أملاك</h5>

                    </div>
                    <div class="col-12">
                        <p style="font-size: 12px">سجل البيانات أدناه في أملاك</p>

                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
                <div class="modal-body">

                    <section class="signup-step-container">
                        <div class="container">
                            <div class="row d-flex justify-content-center">
                                <div class="col-md-12">
                                    <div class="wizard">
                                        <div class="wizard-inner">
                                            <div class="connecting-line"></div>
                                            <ul class="nav nav-tabs" role="tablist" hidden="">
                                                <li role="presentation" class="">
                                                    <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" aria-expanded="true"><span class="round-tab">1 </span> <i>Step
                                                            1</i></a>
                                                </li>
                                                <li role="presentation" class="active">
                                                    <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" aria-expanded="false" class="active show" aria-selected="true"><span class="round-tab">2</span> <i>Step
                                                            2</i></a>
                                                </li>

                                            </ul>
                                        </div>


                                        <div class="tab-content" id="main_form">
                                            <div class="tab-pane" role="tabpanel" id="step1">
                                                <p style="text-align: center;font-weight: 900; margin-bottom: 25px;">من فضلك
                                                    اختر نوع الحساب المراد التسجيل فيه</p>
                                                <div class="row account_row">
                                                    <div class="col-sm-12 col-md-6 account_type next-step">
                                                        <div class="img-smm">
                                                            <img src="https://dev.tryamlak.com/HOME_PAGE/images/new/building-_5_.png" class="img-fluid">
                                                        </div>
                                                        <p>مكتب</p>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 account_type">
                                                        <div class="img-smm-y">
                                                            <img src="https://dev.tryamlak.com/HOME_PAGE/images/new/real-estate-agent.png " class="img-fluid">
                                                        </div>
                                                        <p>مسوق عقاري</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane active show" role="tabpanel" id="step2">

                                                <form id="register" enctype="multipart/form-data" method="POST" action="https://dev.tryamlak.com/reg/new">
                                                    <input type="hidden" name="_token" value="OhjvBWzd9K3AZBbAlOZhzdf6r52u133U1yUWWcaj">

                                                    <div class="row">
                                                        <div class="col-6 mb-4 ">
                                                            <label for="CR_number">رقم السجل التجاري</label>
                                                            <span class="not_required">(اختياري)</span>
                                                            <input type="text" class="form-control" placeholder="ادخل رقم السجل التجاري" id="CR_number" name="CRN" value="">
                                                        </div>
                                                        <div class="col-6 mb-4">
                                                            <label for="Company_name">اسم الشركة <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" placeholder="ادخل اسم الشركة" id="company_name" name="Company_name" value="">
                                                        </div>

                                                        <div class="col-6 mb-4">
                                                            <label for="contract">شعار الشركة</label>
                                                            <span class="not_required">(اختياري)</span>

                                                            <input type="file" class="form-control" id="company_logo" name="company_logo" accept="image/png, image/jpg, image/jpeg">
                                                            <input type="hidden" name="fromWhere" id="fromWhere" value="home_page">
                                                        </div>
                                                        <div class="col-6 mb-4">
                                                            <label for="presenter_email">البريد الالكتروني للشركة <span class="text-danger">*</span></label>

                                                            <input type="email" class="form-control" id="presenter_email" value="" name="presenter_email" required="" placeholder="ادخل البريد الالكتروني">
                                                        </div>
                                                        <div class="col-6 mb-4">
                                                            <label for="presenter_name">اسم ممثل الشركة <span class="text-danger">*</span></label>

                                                            <input type="text" class="form-control" id="presenter_name" name="presenter_name" value="" required="" placeholder="ادخل اسم الممثل">
                                                        </div>

                                                        <div class="col-6 mb-4">
                                                            <label for="presenter_number">رقم ممثل الشركة (واتس اب)<span class="text-danger">*</span></label>
                                                            <div style="position:relative">

                                                                <input type="tel" class="form-control" id="presenter_number" minlength="9" maxlength="9" pattern="[0-9]*" oninvalid="setCustomValidity('Please enter 9 numbers.')" onchange="try{setCustomValidity('')}catch(e){}" placeholder="599123456" name="presenter_number" required="" value="">

                                                                <span style="    position: absolute;left: -1px;top: 0;background-color: #e9ecef;height: 100%;display: flex; align-items: center;  justify-content: center;border-top-left-radius: 5px;border-bottom-left-radius: 5px;padding: 0px 20px;border: 1px solid #ced4da; border-top-left-radius: 14px;border-bottom-left-radius: 14px;">966+</span>
                                                            </div>
                                                        </div>



                                                        <div class="col-6 mb-4">
                                                            <label for="city">المدينة <span class="text-danger">*</span></label>
                                                            <!-- <input type="text" class="form-control" placeholder="ادخل اسم المدينة" id="city" name="city" />-->
                                                            <select class="form-control" id="city" required="" name="city">
                                                                <option value="">إختر</option>
                                                                <option value="مدينة الرياض">
                                                                    مدينة
                                                                    الرياض
                                                                </option>


                                                            </select>
                                                        </div>
                                                        <div class="col-6 mb-2">
                                                            <label for="package">نوع الاشتراك <span class="text-danger">*</span></label>
                                                            <select type="package" class="form-control" id="package" name="package" required="">
                                                            </select>
                                                        </div>
                                                        <div class="col-6 mb-4">
                                                            <label for="password">كلمة المرور <span class="text-danger">*</span></label>

                                                            <input type="password" class="form-control" id="password" name="password" required="" placeholder="ادخل كلمة المرور">
                                                        </div>
                                                        <div class="col-6 mb-4">
                                                            <label for="password_confirmation">تاكيد كلمة المرور <span class="text-danger">*</span></label>
                                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required="" placeholder="ادخل كلمة المرور">
                                                        </div>



                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Cancel')</button>
                                                            <button type="submit" class="btn btn-primary waves-effect waves-light">@lang('save')</button>
                                                        </div>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
        </div>

    </div>
</div>
@endsection
