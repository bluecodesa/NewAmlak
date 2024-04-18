@extends('Admin.layouts.app')
@section('title', __('invoices'))
@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">@lang('Invoice')</h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item"><a
                                        href="{{ route('Admin.SystemInvoice.show', $invoice->id) }}">@lang('Invoice')</a>
                                </li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('Admin.SystemInvoice.index') }}">@lang('invoices')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('Admin.home') }}">@lang('dashboard')</a></li>
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
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-4 text-left">
                                                <img src="{{ url($sitting->icon) }}"
                                                    style="border: 1px solid; border-radius: 10px;" width="190"
                                                    alt="">
                                            </div>

                                            <div class="col-4 text-center">
                                                <h1>فاتورة ضربية</h1>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <h5>الرقم التسلسلي</h5>
                                                        <b> {{ $invoice->invoice_ID }} </b>
                                                    </div>
                                                    <div class="col-6">
                                                        <h5>التاريخ</h5>
                                                        <b> {{ $invoice->created_at->format('H:m:i - Y/m/d') }} </b>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-4 text-right">
                                                {{ \QrCode::size(200)->style('dot')->eye('circle')->color(0, 0, 255)->margin(1)->generate(route('Admin.SystemInvoice.show', $invoice->id)) }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-12 border-success p-1">
                                                <h2 style="font-weight: bolder;">معلومات البائع</h2>
                                                <div class="row" style="padding: 0px 10px;">
                                                    <div class="col-6">
                                                        <div class="row p-2">
                                                            <div class="col-6"
                                                                style="border-right: 2px solid; height: 55px;">
                                                                <b>
                                                                    أسم البائع </b>
                                                                <br>
                                                                <span class="text-success" style="font-size: 13px;">
                                                                    {{ $sitting->title }}</span>
                                                            </div>

                                                            <div class="col-6"
                                                                style="border-right: 2px solid; height: 55px;">
                                                                <b>
                                                                    عنوان البائع </b>
                                                                <br>

                                                                <span class="text-success" style="font-size: 13px;">
                                                                    الرياض - السعودية
                                                                </span>
                                                            </div>


                                                        </div>
                                                    </div>

                                                    <div class="col-6">

                                                        <div class="row p-2">
                                                            <div class="col-6"
                                                                style="border-right: 2px solid; height: 55px;">
                                                                <b>
                                                                    رقم تسجيل ضريبة القيمه المضافة للبائع
                                                                </b>
                                                                <br>
                                                                <span class="text-success" style="font-size: 13px;">
                                                                    {{ $sitting->trn }}</span>
                                                            </div>

                                                            <div class="col-6"
                                                                style="border-right: 2px solid; height: 55px;">
                                                                <b>
                                                                    رقم السجل التجاري
                                                                </b>
                                                                <br>

                                                                <span class="text-success" style="font-size: 13px;">
                                                                    {{ $sitting->crn }}
                                                                </span>
                                                            </div>


                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <hr style="border: 2px solid #28C76F !important;">

                                        @php
                                            if ($invoice->OfficeData != null) {
                                                $name = $invoice->OfficeData->company_name;
                                                $presenter_number = $invoice->OfficeData->presenter_number;
                                                $city = $invoice->OfficeData->CityData->name;
                                                $CRN = $invoice->OfficeData->CRN;
                                            } else {
                                                $name = $invoice->BrokerData->UserData->name;
                                                $presenter_number = $invoice->BrokerData->mobile;
                                                $city = $invoice->BrokerData->CityData->name;
                                                $CRN = $invoice->BrokerData->broker_license;
                                            }
                                        @endphp
                                        <div class="row">
                                            <div class="col-12 border-success p-1">
                                                <h2 style="font-weight: bolder;"> معلومات المشتري </h2>
                                                <div class="row" style="padding: 0px 10px;">
                                                    <div class="col-6">
                                                        <div class="row p-2">
                                                            <div class="col-6"
                                                                style="border-right: 2px solid; height: 55px;">
                                                                <b>
                                                                    اسم المشتري
                                                                </b>
                                                                <br>
                                                                <span class="text-success" style="font-size: 13px;">
                                                                    {{ $name }}</span>
                                                            </div>

                                                            <div class="col-6"
                                                                style="border-right: 2px solid; height: 55px;">
                                                                <b>
                                                                    عنوان المشتري </b>
                                                                <br>

                                                                <span class="text-success" style="font-size: 13px;">
                                                                    {{ $city }}
                                                                </span>
                                                            </div>


                                                        </div>
                                                    </div>

                                                    <div class="col-6">

                                                        <div class="row p-2">
                                                            <div class="col-6"
                                                                style="border-right: 2px solid; height: 55px;">
                                                                <b>
                                                                    رقم السجل التجاري
                                                                </b>
                                                                <br>
                                                                <span class="text-success" style="font-size: 13px;">
                                                                    {{ $CRN }}
                                                                </span>
                                                            </div>

                                                            <div class="col-6"
                                                                style="border-right: 2px solid; height: 55px;">
                                                                <b>
                                                                    رقم تسجيل ضريبة القيمه المضافة للمشتري
                                                                </b>
                                                                <br>

                                                                <span class="text-success" style="font-size: 13px;">
                                                                    {{ $presenter_number }}
                                                                </span>
                                                            </div>


                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <hr style="border: 2px solid #28C76F !important;">
                                        <div class="row">
                                            <div class="col-3">
                                                <table class="table border-success">
                                                    <thead>
                                                        <tr>
                                                            <th>المنتج</th>
                                                            <th>سعر الوحدة</th>
                                                            <th>الكمية </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>{{ $invoice->subscription_name }}
                                                            </td>
                                                            <td> {{ $invoice->amount }} </td>
                                                            <td> 1 </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-3">

                                                <table class="table border-info">
                                                    <thead>
                                                        <tr>
                                                            <th>المجموع الفرعي بدون ضريبة </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>

                                                            <td> {{ $invoice->amount - $invoice->amount * $sitting->tax_rate }}
                                                                <sup class="text-body"><small>ر.س</small></sup>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="col-3">

                                                <table class="table border-success">
                                                    <thead>
                                                        <tr>
                                                            <th>نسبة الضريبة </th>
                                                            <th>قيمة الضريبة </th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td> {{ $sitting->tax_rate * 100 }}% </td>

                                                            <td> {{ $invoice->amount * $sitting->tax_rate }} <sup
                                                                    class="text-body"><small>ر.س</small></sup>
                                                            </td>

                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="col-3">

                                                <table class="table border-info">
                                                    <thead>
                                                        <tr>
                                                            <th>عمولة {{ $sitting->title }} </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>

                                                            <td> 0 <sup class="text-body"><small>ر.س</small></sup>
                                                            </td>

                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>



                                    </div>
                                </div>

                                <div class="col-12 border-info p-1">
                                    <div class="row">
                                        <div class="col-6">
                                            <span class="bolder">
                                                المجموع </span>
                                        </div>

                                        <div class="col-6">
                                            <span>
                                                {{ $invoice->amount - $invoice->amount * $sitting->tax_rate }} <sup
                                                    class="text-body"><small>ر.س</small></sup>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="col-12 border-success p-1">
                                    <div class="row">
                                        <div class="col-6">
                                            <span class="bolder">
                                                ضريبة القيمة المضافة ( {{ $sitting->tax_rate * 100 }}% )
                                            </span>
                                        </div>

                                        <div class="col-6">
                                            <span>
                                                {{ $invoice->amount * $sitting->tax_rate }} <sup
                                                    class="text-body"><small>ر.س</small></sup>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="col-12 border-info p-1">
                                    <div class="row">
                                        <div class="col-6">
                                            <span class="bolder">
                                                المجموع مع الضريبة ( {{ $sitting->tax_rate * 100 }}% ) + عمولة
                                                {{ $sitting->title }} (
                                                0% )
                                            </span>
                                        </div>

                                        <div class="col-6">
                                            <span>
                                                {{ $invoice->amount }} <sup class="text-body"><small>ر.س</small></sup>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->


            </div>
            <!-- container-fluid -->

        </div>
        <!-- content -->



    </div>
@endsection
