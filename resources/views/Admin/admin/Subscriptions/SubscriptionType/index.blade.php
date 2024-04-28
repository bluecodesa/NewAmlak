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
                                <li class="breadcrumb-item"><a
                                        href="{{ route('Admin.SubscriptionTypes.index') }}">@lang('Types subscriptions')</a></li>
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
                                <form action="{{ route('Admin.SubscriptionTypes.index') }}" method="GET"
                                    id="subscriptionsForm">
                                    <div class="row">
                                        <div class="w-auto col-4">
                                            <span>@lang('Subscription Status')</span>
                                            <select class="form-control form-control-sm" id="status_filter"
                                                name="status_filter">
                                                <option value="all" {{ $status_filter == 'all' ? 'selected' : '' }}>
                                                    @lang('All')</option>
                                                <option value="1" {{ $status_filter == 1 ? 'selected' : '' }}>@lang('active')
                                                </option>
                                                <option value="0" {{ $status_filter == 0 ? 'selected' : '' }}> @lang('inactive')
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
                                            <span>@lang('price')</span>
                                            <select class="form-control form-control-sm" id="price_filter"
                                                name="price_filter">
                                                <option value="all" {{ $price_filter == 'all' ? 'selected' : '' }}>@lang('All')
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
                                                $filter_counter =
                                                    ($period_filter != 'all') +
                                                    ($price_filter != 'all') +
                                                    ($status_filter != 'all');
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
                                        @lang('Add New Type subscription')
                                    </a>
                                </h4>

                                <div class="col-md-12">
                                    <div class="table-responsive b-0" data-pattern="priority-columns">
                                        <table id="datatable-buttons" class="table  table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>@lang('Name')</th>
                                                    <th>@lang('Subscription Time')</th>
                                                    <th>@lang('Subscription Type')</th>
                                                    <th> @lang('role name') </th>
                                                    <th>@lang('price')</th>
                                                    <th>@lang('status')</th>
                                                    <th class="noExl"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($subscriptions as $index => $sub)
                                                    {{-- <td> @foreach ($sub->sections as $section)
                                                    <li>{{ $section->name }}</li>
                                                @endforeach</td> --}}
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $sub->name }}</td>
                                                        <td>
                                                            @if ($sub->price > 0)
                                                                <span class="badge badge-pill badge-warning"
                                                                    style="background-color: #add0e87d;color: #497AAC;">
                                                                    {{ $sub->period }} {{ __($sub->period_type) }}
                                                                </span>
                                                            @else
                                                                <span class="badge badge-pill badge-warning">
                                                                    {{ $sub->period }} {{ __($sub->period_type) }}
                                                                </span>
                                                            @endif

                                                        </td>

                                                        <td>
                                                            @if ($sub->price > 0)
                                                                <span class="badge badge-pill badge-warning"
                                                                    style="background-color: #add0e87d;color: #497AAC;">@lang('paid')</span>
                                                            @else
                                                                <span
                                                                    class="badge badge-pill badge-warning">@lang('free')</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @foreach ($sub->RolesData as $role)
                                                                {{ $role->RoleData->name ?? '' }}
                                                                @if (!$loop->last)
                                                                    ,
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td>{{ $sub->price }} <sup>@lang('SAR')</sup> </td>

                                                        <td>{{ $sub->status == 1 ? __('active') : __('inactive') }}</td>

                                                        <td>

                                                            <a href="{{ route('Admin.SubscriptionTypes.edit', $sub->id) }}"
                                                                class="btn btn-outline-info btn-sm waves-effect waves-light">@lang('Edit')</a>
                                                            <a href="javascript:void(0);"
                                                                onclick="handleDelete('{{ $sub->id }}')"
                                                                class="btn btn-outline-danger btn-sm waves-effect waves-light delete-btn">
                                                                @lang('Delete')
                                                            </a>
                                                            <form id="delete-form-{{ $sub->id }}"
                                                                action="{{ route('Admin.SubscriptionTypes.destroy', $sub->id) }}"
                                                                method="POST" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>

                                                        </td>



                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

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
