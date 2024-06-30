@extends('Admin.layouts.app')
@section('title', __('Renters'))
@section('content')

    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-12">

                    <h4 class=""><a href="{{ route('Office.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Office.Renter.index') }}" class="text-muted fw-light">@lang('Renters') </a> /
                        @lang('Renter') : {{ $renter->UserData->name }}
                    </h4>
                </div>

            </div>


            <div class="nav-align-top nav-tabs-shadow mb-4">
                <ul class="nav nav-tabs nav-fill" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-justified-home" aria-controls="navs-justified-home" aria-selected="true">
                            <i class="tf-icons ti ti-home ti-xs me-1"></i> @lang('ملف المستأجر')
                            <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1"></span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-justified-gallery" aria-controls="navs-justified-gallery"
                            aria-selected="false">
                            <i class="tf-icons ti ti-bell-dollar ti-xs me-1"></i> @lang('العقود التابعة')
                            <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1"></span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-justified-profile" aria-controls="navs-justified-profile"
                            aria-selected="false">
                            <i class="tf-icons ti ti-bell-dollar ti-xs me-1"></i> @lang('الأقساط')
                            <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1"></span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-justified-messages" aria-controls="navs-justified-messages"
                            aria-selected="false">
                            <i class="tf-icons ti ti-file ti-xs me-1"></i> @lang('المدفوعات')
                            <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1"></span>
                        </button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">

                        <div class="row">
                            <!-- User Sidebar -->
                            <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">

                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="user-avatar-section">
                                            <div class="d-flex align-items-center flex-column">
                                                <img class="img-fluid rounded mb-3 pt-1 mt-4"
                                                    src="@if ($renter->user_id) {{ $renter->UserData->avatar ?? url('HOME_PAGE/img/avatars/14.png') }}
                                                 {{-- Use asset helper --}} @endif"
                                                    height="100" width="100" alt="User avatar">
                                                <div class="user-info text-center">
                                                    <h4 class="mb-2">
                                                        {{ $renter->UserData->name ?? '' }}
                                                    </h4>
                                                    <span class="badge bg-label-secondary mt-1">
                                                        @lang('Renter')
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-around flex-wrap mt-3 pt-3 pb-4 border-bottom">
                                            <div class="d-flex align-items-start me-4 mt-3 gap-2">
                                                <span class="badge bg-label-primary p-2 rounded"><i
                                                        class="ti ti-checkbox ti-sm"></i></span>
                                                <div>
                                                    <p class="mb-0 fw-medium">@lang('')</p>
                                                    <small>

                                                    </small>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-start mt-3 gap-2">
                                                <span class="badge bg-label-primary p-2 rounded"><i
                                                        class="ti ti-briefcase ti-sm"></i></span>
                                                <div>
                                                    <p class="mb-0 fw-medium"></p>
                                                    <small> </small>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="mt-4 small text-uppercase text-muted">@lang('Details')</p>
                                        <div class="info-container">
                                            <ul class="list-unstyled">
                                                <li class="mb-2">
                                                    <span class="fw-medium me-1">@lang('Renter Name'):</span>
                                                    <span>
                                                        {{ $renter->UserData->name ?? '' }}
                                                    </span>
                                                </li>
                                                <li class="mb-2 pt-1">
                                                    <span class="fw-medium me-1">@lang('Email'):</span>
                                                    <span>
                                                        {{ $renter->UserData->email ?? '' }}
                                                    </span>
                                                </li>
                                                <li class="mb-2 pt-1">
                                                    <span class="fw-medium me-1">@lang('status'):</span>
                                                    <span
                                                        class="badge bg-label-{{ $renterStatus == 'not_active' ? 'danger' : 'success' }}">
                                                        {{ __($renterStatus ?? '') }}
                                                    </span>
                                                </li>
                                                <li class="mb-2 pt-1">
                                                    <span class="fw-medium me-1">@lang('Account Type'):</span>
                                                    <span>
                                                        @lang('Renter')
                                                    </span>
                                                </li>

                                                <li class="mb-2 pt-1">
                                                    <span class="fw-medium me-1">@lang('phone') :</span>
                                                    <span>
                                                        {{ $renter->userData->full_phone ?? '' }}

                                                    </span>
                                                </li>
                                                <li class="mb-2 pt-1">
                                                    <span class="fw-medium me-1">@lang('id number') :</span>
                                                    <span>
                                                        {{ $renter->userData->id_number ?? '' }}

                                                    </span>
                                                </li>

                                                <li class="pt-1">
                                                    <span class="fw-medium me-1">@lang('Subscription Start join') :</span>
                                                    <span>
                                                        {{ $renter->created_at->format('Y-m-d') }}
                                                    </span>
                                                </li>
                                            </ul>


                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                                <div class="row">


                                    <div class="mb-4 col">
                                        <!-- Activity Timeline -->
                                        <div class="col-md-12 col-xl-12 mb-4">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <div class="bg-label-primary rounded-3 text-center mb-3 pt-4">
                                                        <img class="img-fluid"
                                                            src="{{ url('/assets/img/illustrations/girl-with-laptop.png') }}"
                                                            alt="Card girl image" width="140">
                                                    </div>
                                                    <h4 class="mb-2 pb-1">@lang('statistics')</h4>

                                                    <div class="row mb-3 g-3">
                                                        <div class="col-6">
                                                            <div class="d-flex">
                                                                <div class="avatar flex-shrink-0 me-2">
                                                                    <span
                                                                        class="avatar-initial rounded bg-label-primary"><i
                                                                            class="ti ti-users ti-md"></i></span>
                                                                </div>
                                                                <div>
                                                                    <h6 class="mb-0 text-nowrap"></h6>
                                                                    <small>@lang('Number Of Owners')</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="d-flex">
                                                                <div class="avatar flex-shrink-0 me-2">
                                                                    <span
                                                                        class="avatar-initial rounded bg-label-primary"><i
                                                                            class="ti ti-building ti-md"></i></span>
                                                                </div>
                                                                <div>
                                                                    <h6 class="mb-0 text-nowrap"></h6>
                                                                    <small>@lang('Number units')</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="d-flex">
                                                                <div class="avatar flex-shrink-0 me-2">
                                                                    <span
                                                                        class="avatar-initial rounded bg-label-primary"><i
                                                                            class="ti ti-building ti-md"></i></span>
                                                                </div>
                                                                <div>
                                                                    <h6 class="mb-0 text-nowrap"></h6>
                                                                    <small>@lang('Number properties')</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="d-flex">
                                                                <div class="avatar flex-shrink-0 me-2">
                                                                    <span
                                                                        class="avatar-initial rounded bg-label-primary"><i
                                                                            class="ti ti-building ti-md"></i></span>
                                                                </div>
                                                                <div>
                                                                    <h6 class="mb-0 text-nowrap"></h6>
                                                                    <small>@lang('Number projects')</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="javascript:void(0);"
                                                        class="btn btn-primary w-100 waves-effect waves-light">@lang('Gallery visitors')
                                                        :
                                                        0</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Activity Timeline -->
                                    </div>

                                    <div class="mb-4 col">
                                        <!-- Activity Timeline -->
                                        <div class="col-md-12 col-xl-12 mb-4">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <div class="bg-label-primary rounded-3 text-center mb-3 pt-4">
                                                        <img class="img-fluid"
                                                            src="{{ url('/assets/img/illustrations/card-website-analytics-2.png') }}"
                                                            alt="Card girl image" width="140" style="height: 159px;"
                                                            height="159">
                                                    </div>
                                                    <h4 class="mb-2 pb-1">@lang('Geographic scope')</h4>

                                                    <div class="row mb-3 g-3">
                                                        <div class="col-6">
                                                            <div class="d-flex">
                                                                <div class="avatar flex-shrink-0 me-2">
                                                                    <span
                                                                        class="avatar-initial rounded bg-label-primary"><i
                                                                            class="ti ti-building-skyscraper ti-md"></i></span>
                                                                </div>
                                                                <div>
                                                                    <h6 class="mb-0 text-nowrap">@lang('Region')</h6>
                                                                    <small>

                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="d-flex">
                                                                <div class="avatar flex-shrink-0 me-2">
                                                                    <span
                                                                        class="avatar-initial rounded bg-label-primary"><i
                                                                            class="ti ti-topology-complex ti-md"></i></span>
                                                                </div>
                                                                <div>

                                                                    <h6 class="mb-0 text-nowrap">
                                                                        @lang('city')
                                                                    </h6>
                                                                    <small>

                                                                    </small>



                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="javascript:void(0);"
                                                        class="btn btn-primary w-100 waves-effect waves-light">@lang('Show')
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Activity Timeline -->
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="tab-pane fade show " id="navs-justified-gallery" role="tabpanel">

                        <div class="row p-1 mb-1">
                            <div class="col-12">
                                <h5 class="card-header">@lang('العقود')</h5>
                            </div>
                            <div class="col-12">
                                <hr>
                                <div class="row">
                                    <div class="col-4">
                                        <div id="DataTables_Table_0_filter" class="dataTables_filter"><label>
                                                <input id="SearchInput" class="form-control"
                                                    placeholder="@lang('search...')"
                                                    aria-controls="DataTables_Table_0"></label></div>
                                    </div>
                                    <div class="col-8">
                                        <div
                                            class="d-flex justify-content-start justify-content-md-end align-items-baseline">
                                            <div
                                                class="dt-action-buttons d-flex flex-column align-items-start align-items-md-center justify-content-sm-center mb-3 mb-md-0 pt-0 gap-4 gap-sm-0 flex-sm-row">
                                                <div class="dt-buttons btn-group flex-wrap d-flex">
                                                    <div class="btn-group">
                                                        <button onclick="exportToExcel()"
                                                            class="btn btn-success buttons-collection btn-label-secondary me-3 waves-effect waves-light"
                                                            tabindex="0" aria-controls="DataTables_Table_0"
                                                            type="button" aria-haspopup="dialog"
                                                            aria-expanded="false"><span>
                                                                <i
                                                                    class="ti ti-download me-1 ti-xs"></i>Export</span></button>
                                                    </div>
                                                    {{-- @if (Auth::user()->hasPermission('create-owner'))
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                                                    @lang('Add New Renter')
                                                </button>
                                                @endif --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive text-nowrap">
                            <table class="table" id="table">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">@lang('Name')</th>
                                        <th scope="col">@lang('Email')</th>
                                        <th scope="col">@lang('phone')</th>
                                        <th scope="col">@lang('Office')</th>
                                        <th scope="col">@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    <tr>
                                        @if ($contracts)

                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ti ti-dots-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu" style="">
                                                        @if (Auth::user()->hasPermission('update-owner'))
                                                            <a class="dropdown-item"
                                                                href="{{ route('Office.Renter.show', $renter->id) }}">@lang('Show')</a>
                                                        @endif
                                                        @if (Auth::user()->hasPermission('update-owner'))
                                                            <a class="dropdown-item"
                                                                href="{{ route('Office.Renter.edit', $renter->id) }}">@lang('Edit')</a>
                                                        @endif
                                                        @if (Auth::user()->hasPermission('delete-owner'))
                                                            <a href="javascript:void(0);"
                                                                onclick="handleDelete('{{ $renter->id }}')"
                                                                class="dropdown-item delete-btn">@lang('Delete')</a>
                                                            <form id="delete-form-{{ $renter->id }}"
                                                                action="{{ route('Office.Renter.destroy', $renter->id) }}"
                                                                method="POST" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                    </tr>
                                @else
                                    <td colspan="6">
                                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                                            <span class="alert-icon text-danger me-2">
                                                <i class="ti ti-ban ti-xs"></i>
                                            </span>
                                            @lang('No Data Found!')
                                        </div>
                                    </td>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="tab-pane fade show " id="navs-justified-profile" role="tabpanel">

                        <div class="row p-1 mb-1">
                            <div class="col-12">
                                <h5 class="card-header">@lang('الاقساط')</h5>
                            </div>
                            <div class="col-12">
                                <hr>
                                <div class="row">
                                    <div class="col-4">
                                        <div id="DataTables_Table_0_filter" class="dataTables_filter"><label>
                                                <input id="SearchInput" class="form-control"
                                                    placeholder="@lang('search...')"
                                                    aria-controls="DataTables_Table_0"></label></div>
                                    </div>
                                    <div class="col-8">
                                        <div
                                            class="d-flex justify-content-start justify-content-md-end align-items-baseline">
                                            <div
                                                class="dt-action-buttons d-flex flex-column align-items-start align-items-md-center justify-content-sm-center mb-3 mb-md-0 pt-0 gap-4 gap-sm-0 flex-sm-row">
                                                <div class="dt-buttons btn-group flex-wrap d-flex">
                                                    <div class="btn-group">
                                                        <button onclick="exportToExcel()"
                                                            class="btn btn-success buttons-collection btn-label-secondary me-3 waves-effect waves-light"
                                                            tabindex="0" aria-controls="DataTables_Table_0"
                                                            type="button" aria-haspopup="dialog"
                                                            aria-expanded="false"><span>
                                                                <i
                                                                    class="ti ti-download me-1 ti-xs"></i>Export</span></button>
                                                    </div>
                                                    {{-- @if (Auth::user()->hasPermission('create-owner'))
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                                                    @lang('Add New Renter')
                                                </button>
                                                @endif --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive text-nowrap">
                            <table class="table" id="table">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">@lang('Name')</th>
                                        <th scope="col">@lang('Email')</th>
                                        <th scope="col">@lang('phone')</th>
                                        <th scope="col">@lang('Office')</th>
                                        <th scope="col">@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    <tr>
                                        @if ($contracts)

                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ti ti-dots-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu" style="">
                                                        @if (Auth::user()->hasPermission('update-owner'))
                                                            <a class="dropdown-item"
                                                                href="{{ route('Office.Renter.show', $renter->id) }}">@lang('Show')</a>
                                                        @endif
                                                        @if (Auth::user()->hasPermission('update-owner'))
                                                            <a class="dropdown-item"
                                                                href="{{ route('Office.Renter.edit', $renter->id) }}">@lang('Edit')</a>
                                                        @endif
                                                        @if (Auth::user()->hasPermission('delete-owner'))
                                                            <a href="javascript:void(0);"
                                                                onclick="handleDelete('{{ $renter->id }}')"
                                                                class="dropdown-item delete-btn">@lang('Delete')</a>
                                                            <form id="delete-form-{{ $renter->id }}"
                                                                action="{{ route('Office.Renter.destroy', $renter->id) }}"
                                                                method="POST" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                    </tr>
                                @else
                                    <td colspan="6">
                                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                                            <span class="alert-icon text-danger me-2">
                                                <i class="ti ti-ban ti-xs"></i>
                                            </span>
                                            @lang('No Data Found!')
                                        </div>
                                    </td>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="tab-pane fade show " id="navs-justified-messages" role="tabpanel">

                        <div class="row p-1 mb-1">
                            <div class="col-12">
                                <h5 class="card-header">@lang('المدفوعات')</h5>
                            </div>
                            <div class="col-12">
                                <hr>
                                <div class="row">
                                    <div class="col-4">
                                        <div id="DataTables_Table_0_filter" class="dataTables_filter"><label>
                                                <input id="SearchInput" class="form-control"
                                                    placeholder="@lang('search...')"
                                                    aria-controls="DataTables_Table_0"></label></div>
                                    </div>
                                    <div class="col-8">
                                        <div
                                            class="d-flex justify-content-start justify-content-md-end align-items-baseline">
                                            <div
                                                class="dt-action-buttons d-flex flex-column align-items-start align-items-md-center justify-content-sm-center mb-3 mb-md-0 pt-0 gap-4 gap-sm-0 flex-sm-row">
                                                <div class="dt-buttons btn-group flex-wrap d-flex">
                                                    <div class="btn-group">
                                                        <button onclick="exportToExcel()"
                                                            class="btn btn-success buttons-collection btn-label-secondary me-3 waves-effect waves-light"
                                                            tabindex="0" aria-controls="DataTables_Table_0"
                                                            type="button" aria-haspopup="dialog"
                                                            aria-expanded="false"><span>
                                                                <i
                                                                    class="ti ti-download me-1 ti-xs"></i>Export</span></button>
                                                    </div>
                                                    {{-- @if (Auth::user()->hasPermission('create-owner'))
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                                                    @lang('Add New Renter')
                                                </button>
                                                @endif --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive text-nowrap">
                            <table class="table" id="table">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">@lang('Name')</th>
                                        <th scope="col">@lang('Email')</th>
                                        <th scope="col">@lang('phone')</th>
                                        <th scope="col">@lang('Office')</th>
                                        <th scope="col">@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    <tr>
                                        @if ($contracts)

                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ti ti-dots-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu" style="">
                                                        @if (Auth::user()->hasPermission('update-owner'))
                                                            <a class="dropdown-item"
                                                                href="{{ route('Office.Renter.show', $renter->id) }}">@lang('Show')</a>
                                                        @endif
                                                        @if (Auth::user()->hasPermission('update-owner'))
                                                            <a class="dropdown-item"
                                                                href="{{ route('Office.Renter.edit', $renter->id) }}">@lang('Edit')</a>
                                                        @endif
                                                        @if (Auth::user()->hasPermission('delete-owner'))
                                                            <a href="javascript:void(0);"
                                                                onclick="handleDelete('{{ $renter->id }}')"
                                                                class="dropdown-item delete-btn">@lang('Delete')</a>
                                                            <form id="delete-form-{{ $renter->id }}"
                                                                action="{{ route('Office.Renter.destroy', $renter->id) }}"
                                                                method="POST" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                    </tr>
                                @else
                                    <td colspan="6">
                                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                                            <span class="alert-icon text-danger me-2">
                                                <i class="ti ti-ban ti-xs"></i>
                                            </span>
                                            @lang('No Data Found!')
                                        </div>
                                    </td>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>



            </div>
        </div>



    @endsection
