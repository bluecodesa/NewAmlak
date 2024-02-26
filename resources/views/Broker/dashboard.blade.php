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


                <div class="row">

                        <div class="col-sm-6 col-xl-3">
                            <div class="card">
                                <div class="card-heading p-4">
                                    <div class="mini-stat-icon float-right">
                                        <i class="fas fa-users bg-primary  text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-16">عدد الملاك</h5>
                                    </div>
                                    <h3 class="mt-4">43,225</h3>
                              </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xl-3">
                            <div class="card">
                                <div class="card-heading p-4">
                                    <div class="mini-stat-icon float-right">
                                        <i class="mdi mdi-briefcase-check bg-success text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-16">الفواتير المدفوعه</h5>
                                    </div>
                                    <h3 class="mt-4">$73,265</h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xl-3">
                            <div class="card">
                                <div class="card-heading p-4">
                                    <div class="mini-stat-icon float-right">
                                        <i class="mdi mdi-tag-text-outline bg-warning text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-16">عدد الوحدات</h5>
                                    </div>
                                    <h3 class="mt-4">447</h3>
                                </div>
                            </div>
                        </div>

                         <div class="col-sm-6 col-xl-3">
                            <div class="card">
                                <div class="card-heading p-4">
                                    <div class="mini-stat-icon float-right">
                                        <i class="mdi mdi-tag-text-outline bg-warning text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-16">عدد المشاريع</h5>
                                    </div>
                                    <h3 class="mt-4">447</h3>
                             </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xl-3">
                            <div class="card">
                                <div class="card-heading p-4">
                                    <div class="mini-stat-icon float-right">
                                        <i class="mdi mdi-buffer bg-danger text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-16"> طلبات الاهتمام </h5>
                                    </div>
                                    <h3 class="mt-4">86%</h3>
                               </div>
                            </div>
                        </div>

                         <div class="col-sm-6 col-xl-3">
                            <div class="card">
                                <div class="card-heading p-4">
                                    <div class="mini-stat-icon float-right">
                                        <i class="mdi mdi-buffer bg-danger text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-16"> المعرض</h5>
                                    </div>
                                    <h3 class="mt-4">86%</h3>
                               </div>
                            </div>
                        </div>

                    </div>


                <!-- Striped rows -->
               <div class="row">
                        <div class="col-xl-8">
                            <div class="card m-b-30">
                                <div class="card-body">

                                    <h4 class="mt-0 header-title mb-4">اجمالي الايجارات</h4>

                                    <div id="morris-area-example" class="morris-charts morris-chart-height"></div>

                                </div>
                            </div>
                        </div>
                        <!-- end col -->

                        <div class="col-xl-4">
                            <div class="card m-b-30">
                                <div class="card-body">
                                    <h4 class="mt-0 header-title mb-4">العقارات حسب النوع</h4>
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
                                    <div id="morris-donut-example" class="morris-charts morris-chart-height"></div>

                                </div>
                            </div>
                        </div>
                        <!-- end col -->
                    </div> <!-- Striped rows -->

                </div>
<!--نهاية الاحصائيات-->

        </div>
    </div>
</div>


@endsection



