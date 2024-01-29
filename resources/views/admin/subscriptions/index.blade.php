@extends('layouts.app')
@section('title')
    انواع الاشتراكات

@stop
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

    <div class="content">

        <div class="col-md-12 col-lg-12 mb-4">
            <div class="card timeline shadow">
                <div class="card-header">
                    <strong class="card-title"> انواع الاشتراكات</strong>
                </div>
                <div class="card-body">
                    <div class="filter">
                        <form action="{{ route('SubscriptionTypes.index') }}" method="GET" id="subscriptionsForm">
                            <div class="row">
                                <div class="w-auto"><span>حالة الاشتراك</span>
                                    <select
                                        class="form-control select-input  @if ($status_filter != 'all') checked @endif "
                                        id="status_filter" required name="status_filter">

                                        <option value="all" @if ($status_filter == 'all') {{ 'selected' }} @endif>
                                            كل الحالات</option>
                                        <option value="1" @if ($status_filter == 1) {{ 'selected' }} @endif>
                                            فعال
                                        </option>
                                        <option value="0" @if ($status_filter == 0) {{ 'selected' }} @endif>
                                            غير فعال
                                        </option>
                                    </select>
                                </div>
                                <div class="w-auto">
                                    <span>مدة الاشتراك</span>
                                    <select
                                    class="form-control form-control-sm"  @if ($period_filter != 'all') checked @endif "
                                        id="period_filter" required name="period_filter">
                                        <option value="all" @if ($period_filter == 'all') {{ 'selected' }} @endif>
                                            اختر </option>
                                        <option value="day" @if ($period_filter == 'day') {{ 'selected' }} @endif>
                                            يوم
                                        </option>
                                        <option value="week" @if ($period_filter == 'week') {{ 'selected' }} @endif>
                                            اسبوع
                                        </option>

                                        <option value="month" @if ($period_filter == 'month') {{ 'selected' }} @endif>
                                            شهر
                                        </option>
                                        <option value="year"
                                            @if ($period_filter == 'year') {{ 'selected' }} @endif>
                                            سنة
                                        </option>
                                    </select>
                                </div>
                                <div class="w-auto">
                                    <span>السعر</span>

                                    <select
                                        class="form-control select-input  @if ($price_filter != 'all') checked @endif "
                                        id="price_filter" required name="price_filter">

                                        <option value="all"
                                            @if ($price_filter == 'all') {{ 'selected' }} @endif>
                                            اختر </option>

                                        @foreach ($prices as $price)
                                            <option value="{{ $price }}"
                                                @if ($price_filter == $price) {{ 'selected' }} @endif>
                                                {{ $price }} ريال فيما اقل
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="w-auto d-flex filter-btns-container">
                                    <button type="submit" class="w-auto btn btn-new-light btn-sm mb-2">تصفية</button>
                                    <?php $filter_counter = 0;
                                    if ($period_filter != 'all') {
                                        $filter_counter++;
                                    }
                                    if ($price_filter != 'all') {
                                        $filter_counter++;
                                    }
                                    if ($status_filter != 'all') {
                                        $filter_counter++;
                                    }

                                    ?>

                                    @if ($filter_counter > 0)
                                        <a href="{{ route('SubscriptionTypes.index') }}" class="clear-filter"
                                            style="margin-bottom: 0!important;">إلغاء التصفية ({{ $filter_counter }})</a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="primary-btns">
                        <div class="delete-custom">
                            <a class="dropdown-dots btn btn-danger btn-sm" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                    <path
                                        d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                </svg>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item"data-toggle="modal" data-target="#exampleModal2">حذف المحدد</a>
                            </div>
                        </div>

                        <a href="{{ route('SubscriptionTypes.create') }}"class="btn btn-dark btn-sm add"
                            style="margin-left:22px;margin-bottom:30px">
                            <span class="item-text">اضافة نوع اشتراك </span>
                        </a>

                        <button id="exporttable" class="btn btn-new-light btn-sm mb-2">
                            <svg class="img-fluid svg-icon" fill="var(--primary)" viewBox="0 0 32 32" version="1.1"
                                xmlns="http://www.w3.org/2000/svg">

                                <g id="SVGRepo_bgCarrier" stroke-width="0" />

                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />

                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M28.183 29.668h-26v-20h8.050l2.023-1.948-0.052-0.052h-10.021c-1.105 0-2 0.896-2 2v20c0 1.105 0.895 2 2 2h26c1.105 0 2-0.895 2-2v-15.646l-2 1.909v13.737zM8.442 21.668l2.015-0c1.402-7.953 8.329-14 16.684-14 0.351 0 0.683 0.003 1.019 0.005l-3.664 3.664c-0.39 0.39-0.39 1.024 0 1.414 0.195 0.196 0.452 0.293 0.708 0.293s0.511-0.098 0.706-0.293l5.907-6.063-5.907-6.064c-0.39-0.391-1.023-0.391-1.414 0-0.39 0.391-0.39 1.024 0 1.414l3.631 3.63c-0.314-0-0.624-0.002-0.944-0.002-9.47 0-17.299 6.936-18.741 16.001z" />
                                </g>

                            </svg>
                            تصدير</button>
                    </div>

                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefaultAll"
                                        name="deleteChecked" value="" onclick="checkAllDel()">
                                </th>
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
                            <?php $i = 0; ?>
                            @foreach ($subscriptions as $sub)
                                <tr>
                                    <td>{{-- {{ $item['sub_id'] }} --}}
                                        <input class="form-check-input" type="checkbox" id="flexCheckDefault"
                                            name="deleteChecked" value="{{ $sub->id }}">
                                    </td>
                                    <td>{{ ++$i }}</td>
                                    <td>
                                        @if ($sub->price > 0)
                                            <span class="badge badge-pill badge-warning"
                                                style="background-color: #add0e87d;color: #497AAC;">

                                                {{ $sub->period }}
                                                @if ($sub->period_type == 'week')
                                                    اسابيع
                                                @elseif ($sub->period_type == 'month')
                                                    شهور
                                                @elseif ($sub->period_type == 'year')
                                                    سنة
                                                @elseif ($sub->period_type == 'day')
                                                    يوم
                                                @endif
                                            </span>
                                        @else
                                            <span class="badge badge-pill badge-warning">


                                                {{ $sub->period }}
                                                @if ($sub->period_type == 'week')
                                                    اسابيع
                                                @elseif ($sub->period_type == 'month')
                                                    شهور
                                                @elseif ($sub->period_type == 'year')
                                                    سنة
                                                @elseif ($sub->period_type == 'day')
                                                    يوم
                                                @endif
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
                                        @if($sub->hasRole('Broker'))
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
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                                    <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                                </svg>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="{{ route('SubscriptionTypes.edit', $sub->id) }}">تعديل</a>
                                                <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal1" data-id="{{ $sub->id }}"
                                                    onclick="document.querySelector('a.contnue_delete').dataset['id'] = this.dataset['id']">حذف</a>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- /.card-body -->
            </div> <!-- / .card -->
        </div> <!-- / .col-md-6 -->
        <!-- Striped rows -->
    </div> <!-- .row-->




    <div class="admin modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModal1Label"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-body">
                    <p>هل أنت متأكد من حذف نوع الاشتراك؟</p>
                    <div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="button" class="btn btn-primary"><a data-id="55" class="contnue_delete"
                                href="" onclick="this.href='/delete/type/'+this.dataset['id'];"
                                style="color: #fff;
                text-decoration: none;">نعم</a></button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="admin modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModal2Label"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-body">
                    <p>هل أنت متأكد من حذف نوع الاشتراك/الاشتراكات؟</p>

                    <div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="button" class="btn btn-primary" onclick="checkSelectedDevDel()"
                            style="color: #fff;">نعم</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('other-scripts')
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


        $("#exporttable").click(function(e) {
            var table = $("#dataTable-1");
            if (table && table.length) {
                $(table).table2excel({
                    exclude: ".noExl",
                    name: "Excel",
                    filename: "file" +
                        ".xls",
                    fileext: ".xls",
                    exclude_img: true,
                    // exclude_links: true,
                    exclude_inputs: true,
                    preserveColors: false
                });
            }
        });

        window.onload = function() {
            document.querySelector('h2#flush-headingOne button').click();
        }

        function checkSelectedDevDel() {

            let items = document.querySelectorAll('input#flexCheckDefault');
            let checked = [];
            for (let i = 0; i < items.length; i++) {
                if (items[i].checked)
                    checked.push(items[i].value);
            }
            if (checked.length > 0) {
                var url = "";
                url = url.replace(':array', checked);
                location.href = url;
            }
        }

        function checkAllDel() {

            let checked = document.querySelector('input#flexCheckDefaultAll').checked;

            let checks = document.querySelectorAll('input#flexCheckDefault');
            for (let i = 0; i < checks.length; i++) {

                checks[i].checked = checked;
            }

        }
    </script>
@endpush
