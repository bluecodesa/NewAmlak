@extends('Admin.layouts.app')

@section('title', __('dashboard'))

@section('content')

<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Dashboard</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Stexo</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end page-title -->


            <!-- الاحصائيات-->
            <div class="alert custom bg-success" role="alert" >
                <div class="row align-items-center">
                    <div class="col-sm-12 col-md-1 d-flex justify-content-center">
                        <div class="img-containerx">
                            <svg class="svg-inline--fa fa-house" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="house" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">

                            </svg>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-11">
                        <div class="row">
                            <div class="col">
                                <span></span>
                            </div>
                        </div>
                        <div class="row justify-content-between align-items-center">
                            <div class="col-md-8">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="31" aria-valuemin="0" aria-valuemax="31" style="width:100%; background-color: #007bff;">100%</div>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <a href="javascript:void(0)" onclick="document.querySelector('#exampleModalCenterbtn').click();" class="w-auto btn btn-primary modal-btn2">ترقية</a>
                                <a href="" class="btn btn-secondary modal-btn2 w-auto " target="_blank">قارن بين الخطط</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p class="m-0">

                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-12">


                <div class="row ArFont">
                    <div class="row mt-1 align-items-center home-all-container">
                        <div class="dash-item card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3 col-md-3 p-0">
                                        <div class="img-container" style="background: rgba(93,164,211,0.07 )">
                                            <img class="img-fluid" src="{{ asset('dashboard/assets/icons/visitors.svg') }}"
                                                alt="" srcset="">
                                        </div>
                                    </div>
                                    <div class="col-9 col-md-9 p-0">
                                        <a {{-- href="{{ route('Visitors.index') }}" --}}>
                                            <span class="h3"></span>
                                        </a>
                                        <p style="margin-bottom:0px"> عدد الملاك </p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="dash-item card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3 col-md-3  p-0">
                                        <div class="img-container"
                                            style="background: rgba(93,164,211,0.07 )
                                            ">
                                            <img class="img-fluid" src="{{ asset('dashboard/assets/icons/renters.svg') }}"
                                                alt="" srcset="">
                                        </div>
                                    </div>
                                    <div class="col-9 col-md-9  p-0">
                                        <a {{-- href="{{ route('Renter.index') }}" --}}> <span class="h3"></span></a>
                                        <p style="margin-bottom:0px">عدد المسـتأجرين</p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="dash-item card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3 col-md-3 p-0">
                                        <div class="img-container" style="background: rgba(93,164,211,0.07 )">
                                            <img class="img-fluid" src="{{ asset('dashboard/assets/icons/visitors.svg') }}"
                                                alt="" srcset="">
                                        </div>
                                    </div>
                                    <div class="col-9 col-md-9 p-0">
                                        <a {{-- href="{{ route('Visitors.index') }}" --}}>
                                            <span class="h3"></span>
                                        </a>
                                        <p style="margin-bottom:0px">طلبات الصيانة</p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="dash-item card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3 col-md-3 p-0">
                                        <div class="img-container" style="background: rgba(93,164,211,0.07 )">
                                            <img class="img-fluid" src="{{ asset('dashboard/assets/icons/visitors.svg') }}"
                                                alt="" srcset="">
                                        </div>
                                    </div>
                                    <div class="col-9 col-md-9 p-0">
                                        <a {{-- href="{{ route('Visitors.index') }}" --}}>
                                            <span class="h3"></span>
                                        </a>
                                        <p style="margin-bottom:0px">شكاوى</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="dash-item card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3 col-md-3 p-0">
                                        <div class="img-container" style="background: rgba(254,153,53,0.06 )">
                                            <img class="img-fluid" src="{{ asset('dashboard/assets/icons/contract.svg') }}"
                                                alt="" srcset="">
                                        </div>
                                    </div>
                                    <div class="col-9 col-md-9 p-0">
                                        <a {{-- href="{{ route('ContractsEndThisMonth') }}" --}}> <span class="h3"></span></a>
                                        <p style="margin-bottom:0px"> عقود تنتهي هذا الشهر</p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="dash-item card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3 col-md-3 p-0">
                                        <div class="img-container"
                                            style="background: rgba(17,233,145,0.08 )
                                            ">
                                            <img class="img-fluid" src="{{ asset('dashboard/assets/icons/pay-day.svg') }}"
                                                alt="" srcset="">
                                        </div>
                                    </div>
                                    <div class="col-9 col-md-9 p-0">
                                        <a {{-- href="{{ route('PaymentThisMonth') }}" --}}>
                                            <span class="h3"></span>
                                        </a>
                                        <p style="margin-bottom:0px"> دفعات الإيجار هذا الشهر </p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="dash-item card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3 col-md-3 p-0">
                                        <div class="img-container"
                                            style="background: rgba(239,46,15,0.05 )
                                            ">
                                            <img class="img-fluid" src="{{ asset('dashboard/assets/icons/not.svg') }}"
                                                alt="" srcset="">
                                        </div>
                                    </div>
                                    <div class="col-9 col-md-9 p-0">
                                        <a {{-- href="{{ route('PaymentNotCollect') }}" --}}>
                                            <span class="h3"></span>
                                        </a>
                                        <p style="margin-bottom:0px">دفعات ايجار متأخرة</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="dash-item card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3 col-md-3 p-0">
                                        <div class="img-container"
                                            style="background: rgba(239,46,15,0.05 )
                                            ">
                                            <img class="img-fluid" src="{{ asset('dashboard/assets/icons/not.svg') }}"
                                                alt="" srcset="">
                                        </div>
                                    </div>
                                    <div class="col-9 col-md-9 p-0">
                                        <a {{-- href="{{ route('PaymentNotCollect') }}"> --}}>
                                            <span class="h3"></span>
                                        </a>
                                        <p style="margin-bottom:0px">أقساط شراء متأخرة</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="dash-item card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3 col-md-3 p-0">
                                        <div class="img-container"
                                            style="background: rgba(28,154,78,0.07 )
                                            ">
                                            <img class="img-fluid" src="{{ asset('dashboard/assets/icons/paid.svg') }}"
                                                alt="" srcset="">
                                        </div>
                                    </div>
                                    <div class="col-9 col-md-9 p-0">
                                        <a {{-- href="{{ route('PaymentsPirod.show', 'COLLECTED') }}" --}}>
                                            <span class="h3"></span>
                                        </a>
                                        <p style="margin-bottom:0px"> فواتير مدفوعة </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="dash-item card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3 col-md-3 p-0">
                                        <div class="img-container"
                                            style="background: rgba(93,164,211,0.09 )
                                            ">
                                            <img class="img-fluid" src="{{ asset('dashboard/assets/icons/notpaid.svg') }}"
                                                alt="" srcset="">
                                        </div>
                                    </div>
                                    <div class="col-9 col-md-9 p-0">
                                        <a {{-- href="{{ route('PaymentsPirod.show', 'NOT_COLLECTED') }}" --}}>
                                            <span class="h3"></span>
                                        </a>
                                        <p style="margin-bottom:0px">فواتير مستحقة</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="dash-item card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3 col-md-3 p-0">
                                        <div class="img-container"
                                            style="background: rgba(93,164,211,0.09 )
                                            ">
                                            <img class="img-fluid" src="{{ asset('dashboard/assets/icons/notpaid.svg') }}"
                                                alt="" srcset="">
                                        </div>
                                    </div>
                                    <div class="col-9 col-md-9 p-0">
                                        <a {{-- href="{{ route('PaymentsPirod.show', 'NOT_COLLECTED') }}" --}}>
                                            <span class="h3"></span>
                                        </a>
                                        <p style="margin-bottom:0px">إيصالات قيد المراجعة</p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="dash-item card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3 col-md-3 p-0">
                                        <div class="img-container"
                                            style="background: rgba(93,164,211,0.09 )
                                            ">
                                            <img class="img-fluid" src="{{ asset('dashboard/assets/icons/notpaid.svg') }}"
                                                alt="" srcset="">
                                        </div>
                                    </div>
                                    <div class="col-9 col-md-9 p-0">
                                        <a {{-- href="{{ route('PaymentsPirod.show', 'NOT_COLLECTED') }}" --}}>
                                            <span class="h3"></span>
                                        </a>
                                        <p style="margin-bottom:0px">طلبات الاهتمام</p>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                <!-- Striped rows -->
                <div class="col-md-12 col-lg-12 ArFont">
                    <div class="card border-0">
                        <div class="card-header" style="background-color: #fff">
                            <strong class="card-title">اجمالي الاجارات</strong>
                        </div>
                        <div class="card-body my-n2" style="overflow-x: scroll;">
                            <canvas class="canvas" id="myChart"></canvas>
                        </div>
                    </div>
                </div> <!-- Striped rows -->
                <!-- Recent Activity -->
                <div class="col-md-12 col-lg-6 ArFont mt-5">
                    <div class="card timeline border-0">
                        <div class="card-header" style="background-color: #fff">
                            <strong class="card-title">العقارات حسب النوع</strong>

                        </div>
                        <div class="card-body" data-simplebar>
                            <div class="row mb-4">
                                <div class="col-6">

                                    <p style="margin-bottom: 0">%<span
                                            class="span-akkar"></span></p>
                                    <span>عقارات سكنية</span>
                                </div>
                                <div class="col-6">
                                    <p style="margin-bottom: 0">%<span
                                            class="span-akkar"></span></p>
                                    <span>عقارات تجارية</span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6  m-auto">

                                <canvas id="myChart2"></canvas>
                            </div>

                        </div> <!-- / .card-body -->
                    </div> <!-- / .card -->
                </div>

                <div class="col-md-12 col-lg-6 ArFont mt-5">

                    <div class="card timeline border-0">
                        <div class="card-header" style="background-color: #fff">
                            <strong class="card-title">الوحدات حسب الحالة</strong>

                        </div>
                        <div class="card-body" data-simplebar>
                            <div class="row mb-4">
                                <div class="col-6">

                                    <p style="margin-bottom: 0">%<span
                                            class="span-akkar"></span></p>
                                    <span>وحدات شاغرة</span>
                                </div>
                                <div class="col-6">
                                    <p style="margin-bottom: 0">%<span
                                            class="span-akkar"></span></p>
                                    <span>وحدات مؤجرة</span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 m-auto">
                                <canvas id="myChart3"></canvas>
                            </div>
                        </div> <!-- / .card-body -->
                    </div> <!-- / .card -->
                </div>
<!--نهاية الاحصائيات-->

        </div>
    </div>
</div>


@endsection



