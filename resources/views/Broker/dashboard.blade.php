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
                        <h4 class="page-title">@lang('dashboard')</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"></a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('Broker.home') }}"> @lang('dashboard')</a></li>
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
                                    <h3 class="mt-4"><?php echo $numberOfowners?></h3>
                                    <div class="progress mt-4" style="height: 4px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="text-muted mt-2 mb-0">Previous period<span class="float-right">75%</span></p>


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
                                        <h5 class="font-16"> الإشغال</h5>
                                    </div>
                                    <h3 class="mt-4">43,225</h3>
                                    <div class="progress mt-4" style="height: 4px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="text-muted mt-2 mb-0">Previous period<span class="float-right">75%</span></p>



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
                                        <h5 class="font-16">  الوحدات التجارية</h5>
                                    </div>
                                    <h3 class="mt-4">43,225</h3>
                                    <div class="progress mt-4" style="height: 4px;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="text-muted mt-2 mb-0">Previous period<span class="float-right">75%</span></p>


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
                                        <h5 class="font-16"> الوحدات السكنية </h5>
                                    </div>
                                    <h3 class="mt-4">43,225</h3>
                                    <div class="progress mt-4" style="height: 4px;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="text-muted mt-2 mb-0">Previous period<span class="float-right">75%</span></p>

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
                                    <h3 class="mt-4">43,225</h3>
                                    <div class="progress mt-4" style="height: 4px;">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="text-muted mt-2 mb-0">Previous period<span class="float-right">75%</span></p>
                                    </div>
                            </div>
                        </div>

                         <div class="col-sm-6 col-xl-3">
                            <div class="card">
                                <div class="card-heading p-4">
                                    <div class="mini-stat-icon float-right">
                                        <i class="fas fa-users bg-primary  text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-16">زوار المعرض</h5>
                                    </div>
                                    <h3 class="mt-4">43,225</h3>
                                    <div class="progress mt-4" style="height: 4px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="text-muted mt-2 mb-0">Previous period<span class="float-right">75%</span></p>
                                </div>
                            </div>
                        </div>

                    </div>


                <!-- Striped rows -->
               <div class="row">
                        <div class="col-xl-6">
                            <div class="card m-b-30">
                                <div class="card-body">

                                    <h4 class="mt-0 header-title mb-4">مؤشرات العقارات  </h4>

                                <div id="overlapping-bars" class="ct-chart ct-golden-section"><svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100%" class="ct-chart-bar" style="width: 100%; height: 100%;"><g class="ct-grids"><line x1="50" x2="50" y1="15" y2="265" class="ct-grid ct-horizontal"></line><line x1="79.83333333333333" x2="79.83333333333333" y1="15" y2="265" class="ct-grid ct-horizontal"></line><line x1="109.66666666666666" x2="109.66666666666666" y1="15" y2="265" class="ct-grid ct-horizontal"></line><line x1="139.5" x2="139.5" y1="15" y2="265" class="ct-grid ct-horizontal"></line><line x1="169.33333333333331" x2="169.33333333333331" y1="15" y2="265" class="ct-grid ct-horizontal"></line><line x1="199.16666666666666" x2="199.16666666666666" y1="15" y2="265" class="ct-grid ct-horizontal"></line><line x1="229" x2="229" y1="15" y2="265" class="ct-grid ct-horizontal"></line><line x1="258.8333333333333" x2="258.8333333333333" y1="15" y2="265" class="ct-grid ct-horizontal"></line><line x1="288.66666666666663" x2="288.66666666666663" y1="15" y2="265" class="ct-grid ct-horizontal"></line><line x1="318.5" x2="318.5" y1="15" y2="265" class="ct-grid ct-horizontal"></line><line x1="348.3333333333333" x2="348.3333333333333" y1="15" y2="265" class="ct-grid ct-horizontal"></line><line x1="378.16666666666663" x2="378.16666666666663" y1="15" y2="265" class="ct-grid ct-horizontal"></line><line y1="265" y2="265" x1="50" x2="408" class="ct-grid ct-vertical"></line><line y1="233.75" y2="233.75" x1="50" x2="408" class="ct-grid ct-vertical"></line><line y1="202.5" y2="202.5" x1="50" x2="408" class="ct-grid ct-vertical"></line><line y1="171.25" y2="171.25" x1="50" x2="408" class="ct-grid ct-vertical"></line><line y1="140" y2="140" x1="50" x2="408" class="ct-grid ct-vertical"></line><line y1="108.75" y2="108.75" x1="50" x2="408" class="ct-grid ct-vertical"></line><line y1="77.5" y2="77.5" x1="50" x2="408" class="ct-grid ct-vertical"></line><line y1="46.25" y2="46.25" x1="50" x2="408" class="ct-grid ct-vertical"></line><line y1="15" y2="15" x1="50" x2="408" class="ct-grid ct-vertical"></line></g><g><g class="ct-series ct-series-a"><line x1="59.91666666666667" x2="59.91666666666667" y1="265" y2="65" class="ct-bar" ct:value="8"></line><line x1="89.75" x2="89.75" y1="265" y2="115" class="ct-bar" ct:value="6"></line><line x1="119.58333333333333" x2="119.58333333333333" y1="265" y2="40" class="ct-bar" ct:value="9"></line><line x1="149.41666666666666" x2="149.41666666666666" y1="265" y2="190" class="ct-bar" ct:value="3"></line><line x1="179.24999999999997" x2="179.24999999999997" y1="265" y2="115" class="ct-bar" ct:value="6"></line><line x1="209.08333333333331" x2="209.08333333333331" y1="265" y2="115" class="ct-bar" ct:value="6"></line><line x1="238.91666666666666" x2="238.91666666666666" y1="265" y2="190" class="ct-bar" ct:value="3"></line><line x1="268.75" x2="268.75" y1="265" y2="165" class="ct-bar" ct:value="4"></line><line x1="298.5833333333333" x2="298.5833333333333" y1="265" y2="140" class="ct-bar" ct:value="5"></line><line x1="328.4166666666667" x2="328.4166666666667" y1="265" y2="15" class="ct-bar" ct:value="10"></line><line x1="358.25" x2="358.25" y1="265" y2="40" class="ct-bar" ct:value="9"></line><line x1="388.0833333333333" x2="388.0833333333333" y1="265" y2="90" class="ct-bar" ct:value="7"></line></g><g class="ct-series ct-series-b"><line x1="69.91666666666667" x2="69.91666666666667" y1="265" y2="115" class="ct-bar" ct:value="6"></line><line x1="99.75" x2="99.75" y1="265" y2="140" class="ct-bar" ct:value="5"></line><line x1="129.58333333333331" x2="129.58333333333331" y1="265" y2="140" class="ct-bar" ct:value="5"></line><line x1="159.41666666666666" x2="159.41666666666666" y1="265" y2="115" class="ct-bar" ct:value="6"></line><line x1="189.24999999999997" x2="189.24999999999997" y1="265" y2="165" class="ct-bar" ct:value="4"></line><line x1="219.08333333333331" x2="219.08333333333331" y1="265" y2="190" class="ct-bar" ct:value="3"></line><line x1="248.91666666666666" x2="248.91666666666666" y1="265" y2="165" class="ct-bar" ct:value="4"></line><line x1="278.75" x2="278.75" y1="265" y2="115" class="ct-bar" ct:value="6"></line><line x1="308.5833333333333" x2="308.5833333333333" y1="265" y2="165" class="ct-bar" ct:value="4"></line><line x1="338.4166666666667" x2="338.4166666666667" y1="265" y2="115" class="ct-bar" ct:value="6"></line><line x1="368.25" x2="368.25" y1="265" y2="65" class="ct-bar" ct:value="8"></line><line x1="398.0833333333333" x2="398.0833333333333" y1="265" y2="140" class="ct-bar" ct:value="5"></line></g></g><g class="ct-labels"><foreignObject style="overflow: visible;" x="50" y="270" width="29.833333333333332" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 30px; height: 20px;">Jan</span></foreignObject><foreignObject style="overflow: visible;" x="79.83333333333333" y="270" width="29.833333333333332" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 30px; height: 20px;">Feb</span></foreignObject><foreignObject style="overflow: visible;" x="109.66666666666666" y="270" width="29.833333333333336" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 30px; height: 20px;">Mar</span></foreignObject><foreignObject style="overflow: visible;" x="139.5" y="270" width="29.83333333333333" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 30px; height: 20px;">Apr</span></foreignObject><foreignObject style="overflow: visible;" x="169.33333333333331" y="270" width="29.83333333333333" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 30px; height: 20px;">Mai</span></foreignObject><foreignObject style="overflow: visible;" x="199.16666666666666" y="270" width="29.833333333333343" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 30px; height: 20px;">Jun</span></foreignObject><foreignObject style="overflow: visible;" x="229" y="270" width="29.833333333333314" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 30px; height: 20px;">Jul</span></foreignObject><foreignObject style="overflow: visible;" x="258.8333333333333" y="270" width="29.833333333333343" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 30px; height: 20px;">Aug</span></foreignObject><foreignObject style="overflow: visible;" x="288.66666666666663" y="270" width="29.833333333333343" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 30px; height: 20px;">Sep</span></foreignObject><foreignObject style="overflow: visible;" x="318.5" y="270" width="29.833333333333314" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 30px; height: 20px;">Oct</span></foreignObject><foreignObject style="overflow: visible;" x="348.3333333333333" y="270" width="29.833333333333314" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 30px; height: 20px;">Nov</span></foreignObject><foreignObject style="overflow: visible;" x="378.16666666666663" y="270" width="30" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 30px; height: 20px;">Dec</span></foreignObject><foreignObject style="overflow: visible;" y="233.75" x="10" height="31.25" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 31px; width: 30px;">0</span></foreignObject><foreignObject style="overflow: visible;" y="202.5" x="10" height="31.25" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 31px; width: 30px;">1.25</span></foreignObject><foreignObject style="overflow: visible;" y="171.25" x="10" height="31.25" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 31px; width: 30px;">2.5</span></foreignObject><foreignObject style="overflow: visible;" y="140" x="10" height="31.25" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 31px; width: 30px;">3.75</span></foreignObject><foreignObject style="overflow: visible;" y="108.75" x="10" height="31.25" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 31px; width: 30px;">5</span></foreignObject><foreignObject style="overflow: visible;" y="77.5" x="10" height="31.25" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 31px; width: 30px;">6.25</span></foreignObject><foreignObject style="overflow: visible;" y="46.25" x="10" height="31.25" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 31px; width: 30px;">7.5</span></foreignObject><foreignObject style="overflow: visible;" y="15" x="10" height="31.25" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 31px; width: 30px;">8.75</span></foreignObject><foreignObject style="overflow: visible;" y="-15" x="10" height="30" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 30px; width: 30px;">10</span></foreignObject></g></svg></div>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->

                        <div class="col-xl-6">
                            <div class="card m-b-30">
                                <div class="card-body">
                                    <h4 class="mt-0 header-title mb-4"> مؤشرات الوحدات</h4>
                                <div class="row mb-4">
                                <div class="col-6">

                                    <p style="margin-bottom: 0">%<span
                                            class="span-akkar"></span></p>
                                    <span> شاغر</span>
                                </div>
                                <div class="col-6">
                                    <p style="margin-bottom: 0">%<span
                                            class="span-akkar"></span></p>
                                    <span>مؤجر </span>
                                </div>
                            </div>
                            <div id="simple-pie" class="ct-chart ct-golden-section simple-pie-chart-chartist"><svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100%" class="ct-chart-pie" style="width: 100%; height: 100%;"><g class="ct-series ct-series-a"><path d="M266.989,283.963A145,145,0,0,0,211.5,5L211.5,150Z" class="ct-slice-pie" ct:value="7"></path></g><g class="ct-series ct-series-b"><path d="M66.5,150A145,145,0,0,0,267.456,283.768L211.5,150Z" class="ct-slice-pie" ct:value="5"></path></g><g class="ct-series ct-series-c"><path d="M211.5,5A145,145,0,0,0,66.501,150.506L211.5,150Z" class="ct-slice-pie" ct:value="4"></path></g><g><text dx="282.6069328292342" dy="135.85595165383072" text-anchor="middle" class="ct-label">44%</text><text dx="171.22115810607883" dy="210.2815468919345" text-anchor="middle" class="ct-label">31%</text><text dx="160.2347583639753" dy="98.73475836397532" text-anchor="middle" class="ct-label">25%</text></g></svg></div>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->
                </div> <!-- Striped rows -->
            </div>

            <div class="row">
                <div class="col-xl-4">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <h4 class="mt-0 header-title mb-4"> المناطق/المدن /الاحياء حسب السعر</h4>
                            <div class="friends-suggestions">
                                <a href="#" class="friends-suggestions-list">
                                    <div class="border-bottom position-relative">

                                        <div class="suggestion-icon float-right mt-2 pt-1">
                                            <i class="mdi mdi-plus"></i>
                                        </div>

                                        <div class="desc">
                                            <h5 class="font-14 mb-1 pt-2 text-dark">Ralph Ramirez</h5>
                                            <p class="text-muted">3 Friend suggest</p>
                                        </div>
                                    </div>
                                </a>

                                <a href="#" class="friends-suggestions-list">
                                    <div class="border-bottom position-relative">

                                        <div class="suggestion-icon float-right mt-2 pt-1">
                                            <i class="mdi mdi-plus"></i>
                                        </div>

                                        <div class="desc">
                                            <h5 class="font-14 mb-1 pt-2 text-dark">Patrick Beeler</h5>
                                            <p class="text-muted">17 Friend suggest</p>
                                        </div>
                                    </div>
                                </a>

                                <a href="#" class="friends-suggestions-list">
                                    <div class="border-bottom position-relative">

                                        <div class="suggestion-icon float-right mt-2 pt-1">
                                            <i class="mdi mdi-plus"></i>
                                        </div>

                                        <div class="desc">
                                            <h5 class="font-14 mb-1 pt-2 text-dark">Victor Zamora</h5>
                                            <p class="text-muted">12 Friend suggest</p>
                                        </div>
                                    </div>
                                </a>

                                <a href="#" class="friends-suggestions-list">
                                    <div class="border-bottom position-relative">

                                        <div class="suggestion-icon float-right mt-2 pt-1">
                                            <i class="mdi mdi-plus"></i>
                                        </div>

                                        <div class="desc">
                                            <h5 class="font-14 mb-1 pt-2 text-dark">Bryan Lacy</h5>
                                            <p class="text-muted">18 Friend suggest</p>
                                        </div>
                                    </div>
                                </a>

                                <a href="#" class="friends-suggestions-list">
                                    <div class="position-relative">

                                        <div class="suggestion-icon float-right mt-2 pt-1">
                                            <i class="mdi mdi-plus"></i>
                                        </div>

                                        <div class="desc">
                                            <h5 class="font-14 mb-1 pt-2 text-dark">James Sorrells</h5>
                                            <p class="text-muted mb-1">6 Friend suggest</p>
                                        </div>
                                    </div>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <h4 class="mt-0 header-title mb-4">  المناطق/المدن /الاحياء حسب نوع الاستخدام
                            </h4>
                            <div id="morris-line-example" class="morris-chart" style="height: 360px"></div>

                        </div>
                    </div>

                </div>

                <div class="col-xl-4">
                    <div class="card m-b-30">
                        <div class="card-body">

                            <h4 class="mt-0 header-title mb-4"> المناطق/المدن /الاحياء حسب حالة الإشغال</h4>
                            <ol class="activity-feed mb-0">
                                <li class="feed-item">
                                    <div class="feed-item-list">
                                        <p class="text-muted mb-1">Now</p>
                                        <p class="font-15 mt-0 mb-0">Andrei Coman magna sed porta finibus, risus posted
                                            a new article: <b class="text-primary">Forget UX Rowland</b></p>
                                    </div>
                                </li>
                                <li class="feed-item">
                                    <p class="text-muted mb-1">Yesterday</p>
                                    <p class="font-15 mt-0 mb-0">Andrei Coman posted a new article: <b
                                            class="text-primary">Designer Alex</b></p>
                                </li>
                                <li class="feed-item">
                                    <p class="text-muted mb-1">2:30PM</p>
                                    <p class="font-15 mt-0 mb-0">Zack Wetass, sed porta finibus, risus Chris Wallace
                                        Commented <b class="text-primary"> Developer Moreno</b></p>
                                </li>
                                <li class="feed-item pb-1">
                                    <p class="text-muted mb-1">12:48 PM</p>
                                    <p class="font-15 mt-0 mb-2">Zack Wetass, Chris Wallace Commented <b
                                            class="text-primary">UX Murphy</b></p>
                                </li>

                            </ol>

                        </div>
                    </div>
                </div>
            </div>

<!--نهاية الاحصائيات-->

        </div>
    </div>
</div>

  <!-- Pending Payment Modal -->

    @if ($pendingPayment)
        @include('Home.Payments.pending_payment')
    @endif

    <script></script>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var modalButton = document.getElementById('modalButton');
                if (modalButton) {
                    modalButton.click();
                }
            });
            //
            $('.subscription_type').on('change', function() {
                var url = $(this).data('url');
                $.ajax({
                    type: "get",
                    url: url,
                    success: function(data) {
                        alertify.success(@json(__('Subscription has been updated')));
                    },
                });
            });
        </script>
    @endpush

@endsection


