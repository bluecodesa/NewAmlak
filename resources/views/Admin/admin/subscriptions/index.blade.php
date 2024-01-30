@extends('Admin.layouts.app')
@section('title', __('Types subscriptions'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">
                                @lang('Types subscriptions')</h4>

                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-right">

                                <li class="breadcrumb-item ">@lang('Types subscriptions') </li>
                                <li class="breadcrumb-item"><a href="{{ route('Admin.SubscriptionTypes.index') }}">
                                        Amlak</a></li>
                            </ol>
                        </div>
                    </div> <!-- end row -->
                </div>
                <!-- end page-title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <form action="{{ route('Admin.SubscriptionTypes.index') }}" method="GET"
                                    id="subscriptionsForm">
                                    <div class="row">
                                        <div class="w-auto col-4">
                                            <span>حالة الاشتراك</span>
                                            <select class="form-control form-control-sm" id="status_filter"
                                                name="status_filter">
                                                <option value="all" {{ $status_filter == 'all' ? 'selected' : '' }}>كل
                                                    الحالات</option>
                                                <option value="1" {{ $status_filter == 1 ? 'selected' : '' }}>فعال
                                                </option>
                                                <option value="0" {{ $status_filter == 0 ? 'selected' : '' }}>غير فعال
                                                </option>
                                            </select>
                                        </div>
                                        <div class="w-auto col-4">
                                            <span>مدة الاشتراك</span>
                                            <select class="form-control form-control-sm" id="period_filter"
                                                name="period_filter">
                                                <option value="all" {{ $period_filter == 'all' ? 'selected' : '' }}>اختر
                                                </option>
                                                <option value="day" {{ $period_filter == 'day' ? 'selected' : '' }}>يوم
                                                </option>
                                                <option value="week" {{ $period_filter == 'week' ? 'selected' : '' }}>
                                                    اسبوع</option>
                                                <option value="month" {{ $period_filter == 'month' ? 'selected' : '' }}>شهر
                                                </option>
                                                <option value="year" {{ $period_filter == 'year' ? 'selected' : '' }}>سنة
                                                </option>
                                            </select>
                                        </div>
                                        <div class="w-auto col-4">
                                            <span>السعر</span>
                                            <select class="form-control form-control-sm" id="price_filter"
                                                name="price_filter">
                                                <option value="all" {{ $price_filter == 'all' ? 'selected' : '' }}>اختر
                                                </option>
                                                @foreach ($prices as $price)
                                                    <option value="{{ $price }}"
                                                        {{ $price_filter == $price ? 'selected' : '' }}>
                                                        {{ $price }} ريال فيما اقل
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="w-auto text-center col-12">
                                            <button type="submit" class="w-auto btn btn-primary mt-2 btn-sm">تصفية</button>
                                            @php
                                                $filter_counter = ($period_filter != 'all') + ($price_filter != 'all') + ($status_filter != 'all');
                                            @endphp
                                            @if ($filter_counter > 0)
                                                <a href="{{ route('Admin.SubscriptionTypes.index') }}"
                                                    class="clear-filter w-auto btn btn-danger mt-2 btn-sm"
                                                    style="margin-bottom: 0!important;">إلغاء التصفية
                                                    ({{ $filter_counter }})</a>
                                            @endif
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">

                                <h4 class="mt-0 header-title">
                                    <a href="{{ route('Admin.SubscriptionTypes.create') }}" type="submit"
                                        class="btn btn-primary col-1 p-1 m-1 waves-effect waves-light">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                </h4>
                                <table id="datatable-buttons"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>

                                        <tr>
                                            <th>#</th>
                                            <th>مدة الاشتراك</th>
                                            <th>نوع الاشتراك</th>
                                            <th>نوع الحساب</th>
                                            <th> السعر</th>
                                            <th>الحالة</th>
                                            <th class="noExl"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subscriptions as $index => $sub)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    @if ($sub->price > 0)
                                                        <span class="badge badge-pill badge-warning"
                                                            style="background-color: #add0e87d;color: #497AAC;">
                                                            {{ $sub->period . ' ' . $sub->period_type }}
                                                        </span>
                                                    @else
                                                        <span class="badge badge-pill badge-warning">
                                                            {{ $sub->period . ' ' . $sub->period_type }}
                                                        </span>
                                                    @endif

                                                </td>

                                                <td>
                                                    @if ($sub->price > 0)
                                                        <span class="badge badge-pill badge-warning"
                                                            style="background-color: #add0e87d;color: #497AAC;">مدفوع</span>
                                                    @else
                                                        <span class="badge badge-pill badge-warning">مجاني</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($sub->hasRole('Broker'))
                                                        مسوق
                                                    @elseif($sub->hasRole('Rs_Admin'))
                                                        مكتب
                                                    @else
                                                        <!-- Handle other cases if necessary -->
                                                    @endif
                                                </td>

                                                <td>{{ $sub->price }}</td>

                                                <td>{{ $sub->status == 1 ? 'فعال' : 'غير فعال' }}</td>
                                                <td class="noExl">
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                                            id="dropdownMenuButton" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            <i class="fas fa-align-justify"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right"
                                                            aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item"
                                                                href="{{ route('Admin.SubscriptionTypes.edit', $sub->id) }}">تعديل</a>
                                                            <a class="dropdown-item" data-toggle="modal"
                                                                data-target="#exampleModal1" data-id="{{ $sub->id }}"
                                                                onclick="document.querySelector('a.contnue_delete').dataset['id'] = this.dataset['id']">حذف</a>
                                                        </div>
                                                    </div>
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
@endsection
@push('scripts')
    <script>
        document.querySelector('#subscriptionsForm').addEventListener('submit', function(event) {
            let flag = false;
            if (document.querySelector('select#status_filter').value != 'all' ||
                document.querySelector('select#period_filter').value != 'all' ||
                document.querySelector('select#price_filter').value != 'all'
            )
                flag = true;

            if (!flag && !document.querySelector('#subscriptionsForm a.clear-filter')) event.preventDefault();

        });
    </script>
@endpush
