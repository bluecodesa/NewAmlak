@extends('Admin.layouts.app')
@section('title', __('Gallary'))
@section('content')

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">
                                @lang('Requests for interest')</h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item active"><a
                                        href="{{ route('Broker.Gallary.showInterests') }}">@lang('Requests for interest')</a>
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
                                <div class="row" style="align-items: end;">
                                    <div class="w-auto  p-0 ml-2">
                                        <span>الحالة</span>
                                        <select class="w-100 form-control select-input  " id="status_filter" required="" name="status_filter" style="width:95%!important" onchange="reloadInterests()">
                                            <option value="all" selected="">
                                                اختر</option>
                                            <option value="عميل جديد">
                                                عميل جديد</option>
                                            <option value="جاري التواصل">
                                                جاري التواصل</option>
                                            <option value="تم الاتفاق">
                                                تم الاتفاق</option>
                                            <option value="عميل غير مهتم">
                                                عميل غير مهتم</option>
                                        </select>
                                    </div>
                                    <div class="w-auto  p-0 ml-2">
                                        <span>المشروع</span>
                                        <select class="form-control select-input  " id="prj_filter" required="" name="prj_filter" style="width:95%!important" onchange="reloadInterests()">
                                            <option value="all" selected="">
                                                اختر
                                            </option>
                                            <option value="">
                                            </option>
                                        </select>
                                    </div>
                                    <div class="w-auto  p-0 ml-2">
                                        <span>العقار</span>
                                        <select class="form-control select-input" id="prop_filter" required="" name="prop_filter" style="width:95%!important" onchange="reloadInterests()">
                                            <option value="all" selected="">
                                                اختر </option>
                                             <option value="">
                                            </option>
                                        </select>
                                    </div>

                                    <div class="w-auto  p-0 ml-2">
                                        <span>الوحدة</span>
                                        <select class="form-control select-input" id="unit_filter" required="" name="unit_filter" style="width:95%!important" onchange="reloadInterests()">
                                            <option value="all" selected="">
                                                اختر
                                            </option>
                                            <option value="">
                                            </option>
                                        </select>
                                    </div>

                                    <div class="w-auto  p-0 ml-2">
                                        <span>اسم العميل</span>
                                        <select class="form-control select-input" id="client_filter" required="" name="client_filter" style="width:95%!important" onchange="reloadInterests()">
                                            <option value="all" selected="">
                                                اختر
                                            </option>
                                            <option value="">
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                    <div class="table-responsive b-0" data-pattern="priority-columns">
                                        <table id="datatable-buttons"
                                            class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>@lang('Residential number')</th>
                                                    <th>@lang('property')</th>
                                                    <th>@lang('اسم العميل')</th>
                                                    <th>@lang('phone')</th>
                                                    <th>@lang('status')</th>
                                                    <th>@lang('Action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($gallrays as $index => $gallary)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $gallary->number_unit ?? '' }}</td>
                                                        <td>{{  $gallary->PropertyData->name ?? __('nothing') }}</td>
                                                        <td> </td>
                                                        <td>
                                                        </td>
                                                        <td>
                                                            <form method="POST" action="https://dev.tryamlak.com/unit/interest/status">

                                                                <input type="hidden" name="_token" value="">
                                                                 <input name="id" value="" hidden="">
                                                                <select class="form-control select-input w-auto" name="status" onchange="chengeStatus(this)">
                                                                    <option value="عميل جديد">
                                                                        عميل جديد</option>
                                                                    <option value="جاري التواصل">
                                                                        جاري التواصل</option>
                                                                    <option value="تم الاتفاق">
                                                                        تم الاتفاق</option>
                                                                    <option value="عميل غير مهتم" >
                                                                        عميل غير مهتم</option>
                                                                </select>
                                                                <button type="submit" class="submit-from" hidden=""></button>
                                                            </form>
                                                        </td>

                                                        <td>
                                                            <a class="share btn btn-outline-secondary btn-sm waves-effect waves-light" data-toggle="modal" data-target="#shareLinkUnit{{ $gallary->id }}"
                                                                href="" onclick="document.querySelector('#shareLinkUnit{{ $gallary->id }} ul.share-tabs.nav.nav-tabs li:first-child a').click()">
                                                                @lang('مكالمة')</a>

                                                            <a href="{{ route('Broker.Gallery.show', $gallary->id) }}"
                                                                class="btn btn-outline-warning btn-sm waves-effect waves-light">@lang('محادثة(شات)')</a>

                                                            <a href="{{ route('Broker.Gallery.edit', $gallary->id) }}"
                                                                class="btn btn-outline-info btn-sm waves-effect waves-light">@lang(' اضافة كا مالك ')</a>


                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>


                        </div> <!-- /.card-body -->

                    </div> <!-- / .card -->
                     </div>

            </div> <!-- / .card -->

        </div>
    </div>
</div> <!-- .row-->


@endsection
