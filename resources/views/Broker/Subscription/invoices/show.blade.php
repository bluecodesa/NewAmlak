@extends('Admin.layouts.app')
@section('title', __('Invoice'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 ">

                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Broker.ShowSubscription') }}" class="text-muted fw-light">@lang('Subscription Management')
                        </a> /
                        @lang('Invoice')
                    </h4>
                </div>
            </div>

            <div class="row">
                <div class="col-12" id="myDiv">
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

                                            <span
                                                class="badge badge-{{ $invoice->status == 'pending' ? 'danger' : 'success' }}">
                                                {{ __('_' . $invoice->status) }}</span>
                                            <div class="row">
                                                <div class="col-6">
                                                    <h5>الرقم التسلسلي</h5>
                                                    <b> {{ $invoice->invoice_ID }} </b>
                                                </div>
                                                <div class="col-6">
                                                    <h5>التاريخ</h5>
                                                    <b> {{ $invoice->created_at->format('h:i:m - Y/m/d') }} </b>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4 text-end">
                                            {{ \QrCode::size(200)->style('dot')->eye('circle')->color(40, 199, 111)->margin(1)->generate(route('Admin.SystemInvoice.show', $invoice->id)) }}


                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-12 border-success">
                                            <h2 style="font-weight: bolder;">معلومات البائع</h2>
                                            <div class="row" style="padding: 0px 10px;">
                                                <div class="col-6">
                                                    <div class="row p-2">
                                                        <div class="col-6" style="border-right: 2px solid; height: 55px;">
                                                            <b>
                                                                أسم البائع </b>
                                                            <br>
                                                            <span class="text-success" style="font-size: 13px;">
                                                                {{ $sitting->title }}</span>
                                                        </div>

                                                        <div class="col-6" style="border-right: 2px solid; height: 55px;">
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
                                                        <div class="col-6" style="border-right: 2px solid; height: 55px;">
                                                            <b>
                                                                رقم تسجيل ضريبة القيمه المضافة للبائع
                                                            </b>
                                                            <br>
                                                            <span class="text-success" style="font-size: 13px;">
                                                                {{ $sitting->trn }}</span>
                                                        </div>

                                                        <div class="col-6" style="border-right: 2px solid; height: 55px;">
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
                                    <hr style="border: 2px solid #2F3C49 !important;">

                                    @php
                                        if ($invoice->OfficeData != null) {
                                            $name = $invoice->OfficeData->company_name ?? '-';
                                            $presenter_number = $invoice->OfficeData->presenter_number ?? '-';
                                            $city = $invoice->OfficeData->CityData->name ?? '-';
                                            $CRN = $invoice->OfficeData->CRN ?? '-';
                                        } else {
                                            $name = $invoice->BrokerData->UserData->name ?? '-';
                                            $presenter_number = $invoice->BrokerData->mobile ?? '-';
                                            $city = $invoice->BrokerData->CityData->name ?? '-';
                                            $CRN = $invoice->BrokerData->broker_license ?? '-';
                                        }
                                    @endphp
                                    <div class="row">
                                        <div class="col-12 border-success p-1">
                                            <h2 style="font-weight: bolder;"> معلومات المشتري </h2>
                                            <div class="row" style="padding: 0px 10px;">
                                                <div class="col-6">
                                                    <div class="row p-2">
                                                        <div class="col-6" style="border-right: 2px solid; height: 55px;">
                                                            <b>
                                                                اسم المشتري
                                                            </b>
                                                            <br>
                                                            <span class="text-success" style="font-size: 13px;">
                                                                {{ $name }}</span>
                                                        </div>

                                                        <div class="col-6" style="border-right: 2px solid; height: 55px;">
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
                                                        <div class="col-6" style="border-right: 2px solid; height: 55px;">
                                                            <b>
                                                                رقم السجل التجاري
                                                            </b>
                                                            <br>
                                                            <span class="text-success" style="font-size: 13px;">
                                                                {{ $CRN }}
                                                            </span>
                                                        </div>

                                                        <div class="col-6" style="border-right: 2px solid; height: 55px;">
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
                                    <hr style="border: 2px solid #2F3C49 !important;">
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
                                                            @if ($invoice->discount != null)
                                                                <small style="display: block;">خصم
                                                                    ({{ $invoice->discount * 100 }}%)</small>
                                                            @endif
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
                                                        <th> المجموع شامل الضريبة </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>

                                                        <td> {{ $invoice->amount }} <sup
                                                                class="text-body"><small>ر.س</small></sup>
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
                                            المجموع مع الضريبة ( {{ $sitting->tax_rate * 100 }}% )
                                        </span>
                                    </div>

                                    <div class="col-6">
                                        <span>
                                            {{ $invoice->amount }} <sup class="text-body"><small>ر.س</small></sup>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>

                            <div class="col-12 border-info p-1">
                                <div class="row">
                                    <div class="col-6">
                                        <span class="bolder">
                                            وقت اصدار الفاتورة
                                        </span>
                                    </div>

                                    <div class="col-6">
                                        <span>
                                            {{ $invoice->updated_at->format('h:i:m - Y/m/d') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div> <!-- end col -->
                <br>
                <div class="col-12 text-center mt-1 mb-1">
                    <button id="btnPrint" class="btn btn-outline-primary waves-effect">
                        طباعة الفاتورة </button>
                </div>
            </div> <!-- end row -->


        </div>

        <div class="content-backdrop fade"></div>
    </div>
    @push('scripts')
        <script>
            $('#btnPrint').on('click', function() {
                $('#myDiv').printThis({
                    debug: false, // show the iframe for debugging
                    importCSS: true, // import parent page css
                    importStyle: true, // import style tags
                    printContainer: true, // print outer container/$.selector
                    loadCSS: "", // path to additional css file - use an array [] for multiple
                    pageTitle: "", // add title to print page
                    removeInline: false, // remove inline styles from print elements
                    removeInlineSelector: "*", // custom selectors to filter inline styles. removeInline must be true
                    printDelay: 500, // variable print delay
                    header: null, // prefix to html
                    footer: null, // postfix to html
                    base: false, // preserve the BASE tag or accept a string for the URL
                    formValues: true, // preserve input/form values
                    canvas: false, // copy canvas content
                    doctypeString: '...', // enter a different doctype for older markup
                    removeScripts: false, // remove script tags from print content
                    copyTagClasses: true, // copy classes from the html & body tag
                    copyTagStyles: true, // copy styles from html & body tag (for CSS Variables)
                    beforePrintEvent: null, // function for printEvent in iframe
                    beforePrint: null, // function called before iframe is filled
                    afterPrint: null
                });
            })
        </script>
    @endpush

@endsection
