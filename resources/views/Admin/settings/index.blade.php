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
<<<<<<< HEAD
                                                aria-controls="v-pills-home" aria-selected="true">
                                                @lang('Website setting')</button>
                                            <button class="nav-link" id="v-pills-profile-tab" data-toggle="pill"
                                                data-target="#v-pills-profile" type="button" role="tab"
                                                aria-controls="v-pills-profile" aria-selected="false">
                                                @lang('PayTabs')</button>
                                            <button class="nav-link" id="v-pills-messages-tab" data-toggle="pill"
                                                data-target="#v-pills-messages" type="button" role="tab"
                                                aria-controls="v-pills-messages" aria-selected="false">
                                                @lang('Notification mange')</button>
                                            <button class="nav-link" id="v-pills-settings-tab" data-toggle="pill"
                                                data-target="#v-pills-settings" type="button" role="tab"
                                                aria-controls="v-pills-settings"
                                                aria-selected="false">@lang('Gallary mange')</button>
=======
                                                aria-controls="v-pills-home" aria-selected="true">     @lang('Website Setting')</button>
                                            <button class="nav-link" id="v-pills-profile-tab" data-toggle="pill"
                                                data-target="#v-pills-profile" type="button" role="tab"
                                                aria-controls="v-pills-profile" aria-selected="false"> @lang('PayTabs')</button>
                                            <button class="nav-link" id="v-pills-messages-tab" data-toggle="pill"
                                                data-target="#v-pills-messages" type="button" role="tab"
                                                aria-controls="v-pills-messages" aria-selected="false"> @lang('Notification Mange')</button>
                                            <button class="nav-link" id="v-pills-settings-tab" data-toggle="pill"
                                                data-target="#v-pills-settings" type="button" role="tab"
                                                aria-controls="v-pills-settings" aria-selected="false">@lang('Gallary Mange')</button>
>>>>>>> 3ca7a3adf786b3cbe2a748ee5111e1fb7739a354
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <div class="tab-content" id="v-pills-tabContent">
                                            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                                aria-labelledby="v-pills-home-tab">

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card m-b-30">
                                                            <div class="card-body">
<<<<<<< HEAD
                                                                <form action="" class="row" method="POST"
                                                                    enctype="multipart/form-data">
=======
                                                                <form action="" method="POST" enctype="multipart/form-data" class="row">
>>>>>>> 3ca7a3adf786b3cbe2a748ee5111e1fb7739a354
                                                                    @csrf
                                                                    @method('PUT')

                                                                    <div class="form-group col-md-6">
                                                                        <label for="title_ar">@lang('Website name ar')</label>
<<<<<<< HEAD

                                                                        <input name="title_ar" class="form-control"
                                                                            type="text" id="title_ar"
                                                                            value="{{ $settings->title ?? '' }}">
                                                                    </div>

                                                                    <div class="form-group col-md-6">
                                                                        <label for="title_en">@lang('Website name en')</label>

                                                                        <input name="title_en" class="form-control"
                                                                            type="text" id="title_en"
                                                                            value="{{ $settings->title ?? '' }}">
=======
                                                                     <input name="title_ar" class="form-control" type="text" id="title_ar" value="{{ $settings->title ?? '' }}">
                                                                    </div>


                                                                    <div class="form-group col-md-6">
                                                                        <label for="title_en" >@lang('Website name en')</label>

                                                                            <input name="title_en" class="form-control" type="text" id="title_en" value="{{ $settings->title ?? '' }}">
>>>>>>> 3ca7a3adf786b3cbe2a748ee5111e1fb7739a354

                                                                    </div>

                                                                    <div class="form-group col-md-6">
                                                                        <label for="url">@lang('URL')</label>

<<<<<<< HEAD
                                                                        <input name="url" class="form-control"
                                                                            type="url"
                                                                            value="{{ $settings->url ?? '' }}"
                                                                            id="url">
=======
                                                                            <input name="url" class="form-control" type="url" value="{{ $settings->url ?? '' }}" id="url">
>>>>>>> 3ca7a3adf786b3cbe2a748ee5111e1fb7739a354

                                                                    </div>


                                                                    <div class="form-group col-md-6">
<<<<<<< HEAD
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
                                                                        <div class="col-sm-8">
                                                                            <input name="color" class="form-control"
                                                                                type="color"
                                                                                value="{{ $settings->color ?? '#30419b' }}"
                                                                                id="color">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-12">
                                                                            <button type="submit"
                                                                                class="btn btn-primary waves-effect waves-light">@lang('save')</button>
                                                                            <button type="reset"
                                                                                class="btn btn-secondary waves-effect m-l-5">@lang('Cancel')</button>
                                                                        </div>
=======
                                                                        <label for="logo" >@lang('Logo')</label>

                                                                            @if(isset($settings) && $settings->icon)
                                                                            <img src="{{ asset($settings->icon) }}" alt="Current Logo" width="100px">
                                                                        @else
                                                                            <p>No logo uploaded yet.</p>
                                                                        @endif
                                                                            <input name="icon" class="form-control" type="file" id="logo" accept="image/png, image/jpg, image/jpeg">

                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="color">@lang('Color')</label>
                                                                            <input name="color" class="form-control" type="color" value="{{ $settings->color ?? '#30419b' }}" id="color">

                                                                    </div>

                                                                    <div class="col-12">
                                                                          <button type="submit" class="btn btn-primary waves-effect waves-light">@lang('save')</button>
                                                                            <button type="reset" class="btn btn-secondary waves-effect m-l-5">@lang('Cancel')</button>

>>>>>>> 3ca7a3adf786b3cbe2a748ee5111e1fb7739a354
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div> <!-- end col -->
                                                </div> <!-- end row -->

                                            </div>
                                            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                                aria-labelledby="v-pills-profile-tab">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card m-b-30">
                                                            <div class="card-body">
<<<<<<< HEAD
                                                                <form action="" method="POST"
                                                                    enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')

                                                                    <div class="form-group row">
                                                                        <label for="title_ar"
                                                                            class="col-sm-2 col-form-label">@lang('Api Key')</label>
                                                                        <div class="col-sm-8">
                                                                            <input name="title_ar" class="form-control"
                                                                                type="text" id="title_ar"
                                                                                value="{{ $settings->title ?? '' }}">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                        <label for="title_en"
                                                                            class="col-sm-2 col-form-label">@lang('Website name en')</label>
                                                                        <div class="col-sm-8">
                                                                            <input name="title_en" class="form-control"
                                                                                type="text" id="title_en">
                                                                        </div>
                                                                    </div>


                                                                    <button type="submit"
                                                                        class="btn btn-primary waves-effect waves-light">@lang('save')</button>
                                                                    <button type="reset"
                                                                        class="btn btn-secondary waves-effect m-l-5">@lang('Cancel')</button>
                                                            </div>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                                                aria-labelledby="v-pills-messages-tab">...</div>
=======
                                                                <form action="" method="POST" enctype="multipart/form-data" class="row">
                                                                    @csrf
                                                                    @method('PUT')

                                                                    <div class="form-group col-md-6">
                                                                        <label>@lang('Api Key PayTabs')</label>
                                                                            <input name="title_ar" class="form-control" type="text" id="title_ar"
                                                                         value="{{ $settings->title ?? '' }}">
                                                                    </div>

                                                                    <div class="form-group col-md-6">
                                                                        <label>@lang('Profile Id PayTabs')</label>

                                                                            <input name="title_en" class="form-control" type="text" id="title_en">

                                                                    </div>


                                                                    <div class="col-12">
                                                                        <button type="submit" class="btn btn-primary waves-effect waves-light">@lang('save')</button>
                                                                          <button type="reset" class="btn btn-secondary waves-effect m-l-5">@lang('Cancel')</button>

                                                                  </div>
                                                                 </form>
                                                    </div>
                                                </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                                                aria-labelledby="v-pills-messages-tab">


                                                <div class="col-md-12 ArFont">
                                                    <div class="card timeline shadow">
                                                        <div class="card-header">
                                                            <strong class="card-title">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="22.799" height="23.999" viewBox="0 0 22.799 23.999" class="side-icons">
                                                                    <g id="Group_5933" data-name="Group 5933" transform="translate(-1366.08 -701.979)">
                                                                        <g id="Setting" transform="translate(1366.08 701.979)">
                                                                            <path id="Path" d="M22.475,14.844a2.762,2.762,0,0,0-.993-.948,1.856,1.856,0,0,1-.76-.768,2.186,2.186,0,0,1,.785-3,2.433,2.433,0,0,0,.907-3.4l-.822-1.416A2.535,2.535,0,0,0,18.147,4.4a2.368,2.368,0,0,1-3.09-.828,1.855,1.855,0,0,1-.282-1.056,2.134,2.134,0,0,0-.331-1.272A2.583,2.583,0,0,0,12.26,0H10.531A2.633,2.633,0,0,0,8.361,1.248,2.142,2.142,0,0,0,8.017,2.52a1.855,1.855,0,0,1-.282,1.056A2.356,2.356,0,0,1,4.657,4.4,2.549,2.549,0,0,0,1.2,5.316L.377,6.732a2.453,2.453,0,0,0,.907,3.4,2.2,2.2,0,0,1,.8,3,1.961,1.961,0,0,1-.773.768,2.542,2.542,0,0,0-.981.948A2.394,2.394,0,0,0,.353,17.3l.846,1.44a2.56,2.56,0,0,0,2.183,1.248,2.593,2.593,0,0,0,1.3-.36,1.9,1.9,0,0,1,1.079-.276,2.271,2.271,0,0,1,2.256,2.184A2.484,2.484,0,0,0,10.568,24h1.668a2.481,2.481,0,0,0,2.538-2.46,2.29,2.29,0,0,1,2.269-2.184,1.956,1.956,0,0,1,1.079.276,2.517,2.517,0,0,0,3.47-.888l.858-1.44a2.422,2.422,0,0,0,.025-2.46" transform="translate(0)" fill="var(--side_icon_secondary)"></path>
                                                                        </g>
                                                                        <path id="Path-2" data-name="Path" d="M3.483,6.78A3.424,3.424,0,0,1,0,3.4,3.434,3.434,0,0,1,3.483,0a3.39,3.39,0,1,1,0,6.78" transform="translate(1374.012 710.595)" fill="var(--side_icon_primary)"></path>
                                                                    </g>
                                                                </svg>
                                                                إدارة التنبيهات
                                                            </strong>
                                                        </div>
                                                        <div class="card-body">
                                                            <form action="https://dev.tryamlak.com/setting/office_alerts" method="POST">
                                                                <input type="hidden" name="_token" value="maa0MrfN842lbNeVMPrsPBzVNR7F6FtyJ2Bd6grz">                            <input type="hidden" name="_method" value="POST">                            <div id="dataTable-1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"><div class="row"><div class="col-sm-12 col-md-6"><div class="dataTables_length" id="dataTable-1_length"><label> <select name="dataTable-1_length" aria-controls="dataTable-1" class="custom-select custom-select-sm form-control form-control-sm"><option value="16">16</option><option value="32">32</option><option value="64">64</option><option value="-1">All</option></select> </label></div></div><div class="col-sm-12 col-md-6"><div id="dataTable-1_filter" class="dataTables_filter"><label><input type="search" class="form-control form-control-sm" placeholder="بحث" aria-controls="dataTable-1"></label></div></div></div><div class="row"><div class="col-sm-12"><table class="table datatables dataTable no-footer" id="dataTable-1" role="grid" aria-describedby="dataTable-1_info">
                                                                    <thead>
                                                                        <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="dataTable-1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="الاشعار: activate to sort column descending">الاشعار</th><th class="sorting" tabindex="0" aria-controls="dataTable-1" rowspan="1" colspan="1" aria-label="Whatsapp: activate to sort column ascending">Whatsapp</th><th class="sorting" tabindex="0" aria-controls="dataTable-1" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Email</th><th class="sorting" tabindex="0" aria-controls="dataTable-1" rowspan="1" colspan="1" aria-label="SMS: activate to sort column ascending">SMS</th></tr>
                                                                    </thead>
                                                                                                    <tbody>




                                                        <tr role="row" class="odd">
                                                                                <td class="sorting_1"> استحقاق موعد دفعة إيجار جديدة</td>
                                                                                <td>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <input type="checkbox" id="whatsapp" name="whatsapp_5" checked="">

                                                                                <input hidden="" name="rs_offices_id" value="312">
                                                                                <input hidden="" name="alert_id" value="5">
                                                                            </td>

                                                                            <td>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <input type="checkbox" id="email" name="email_5" checked="">


                                                                        </td>
                                                                        <td>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <input type="checkbox" id="email" onclick="return false;" name="sms_5">

                                                                    </td>

                                                                </tr><tr role="row" class="even">
                                                                                <td class="sorting_1">اضافة مستأجر جديد</td>
                                                                                <td>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <input type="checkbox" id="whatsapp" name="whatsapp_4" checked="">

                                                                                <input hidden="" name="rs_offices_id" value="312">
                                                                                <input hidden="" name="alert_id" value="4">
                                                                            </td>

                                                                            <td>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <input type="checkbox" id="email" name="email_4" checked="">


                                                                        </td>
                                                                        <td>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <input type="checkbox" id="email" onclick="return false;" name="sms_4">

                                                                    </td>

                                                                </tr><tr role="row" class="odd">
                                                                                <td class="sorting_1">سداد دفعة إيجار</td>
                                                                                <td>
                                                                                <input type="checkbox" id="whatsapp" name="whatsapp_6" checked="">
                                                                                <input hidden="" name="rs_offices_id" value="">
                                                                                <input hidden="" name="alert_id" value="">
                                                                            </td>

                                                                            <td>

                                                                             <input type="checkbox" id="email" name="email_6" checked="">


                                                                        </td>
                                                                        <td>
                                                                     <input type="checkbox" id="email" onclick="return false;" name="sms_6">

                                                                    </td>

                                                                </tr>
                                                            </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-5"><div class="dataTables_info" id="dataTable-1_info" role="status" aria-live="polite"></div></div><div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers" id="dataTable-1_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="dataTable-1_previous"><a href="#" aria-controls="dataTable-1" data-dt-idx="0" tabindex="0" class="page-link">&lt;</a></li><li class="paginate_button page-item active"><a href="#" aria-controls="dataTable-1" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item next disabled" id="dataTable-1_next"><a href="#" aria-controls="dataTable-1" data-dt-idx="2" tabindex="0" class="page-link">&gt;</a></li></ul></div></div></div></div>
                                                    <button type="submit" class="btn btn-new-def">@lang("save")</button>
                                                </form>
                                            </div>
                                        </div> <!-- / .card-body -->
                                    </div>


                                            </div>
>>>>>>> 3ca7a3adf786b3cbe2a748ee5111e1fb7739a354
                                            <div class="tab-pane fade" id="v-pills-settings" role="tabpanel"
                                                aria-labelledby="v-pills-settings-tab">...</div>
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
@endsection
