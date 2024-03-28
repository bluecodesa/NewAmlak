@extends('Admin.layouts.app')
@section('title', __('districts'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-sm-6">
                                    <h4 class="page-title">
                                        @lang('districts')</h4>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('Admin.District.index') }}">@lang('districts')</a></li>
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('Admin.home') }}">@lang('dashboard')</a></li>
                                    </ol>
                                </div>
                                <div class="col-md-6" style="text-align: end">
                                    <a href="{{ route('Admin.District.create') }}"
                                        class="btn btn-primary col-3 p-1 m-1 waves-effect waves-light">
                                        @lang('Add New District')
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div> <!-- end row -->
                </div>
                <!-- end page-title -->

                <div class="row">

                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <table id="datatable-buttons"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('Name')</th>
                                            <th>@lang('city')</th>
                                            <th>@lang('Action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>



                                        @foreach ($districts as $index => $district)
                                            <tr>
                                                <th>{{ $index + 1 }}</th>
                                                <td>{{ $district->name }} </td>
                                                <td>{{ $district->CityData->name ?? '' }} </td>
                                                <td>
                                                    <a href="{{ route('Admin.District.edit', $district->id) }}"
                                                        class="btn btn-outline-info btn-sm waves-effect waves-light">@lang('Edit')</a>
                                                    <a href="javascript:void(0);"
                                                        onclick="handleDelete('{{ $district->id }}')"
                                                        class="btn btn-outline-danger btn-sm waves-effect waves-light delete-btn">
                                                        @lang('Delete')
                                                    </a>
                                                    <form id="delete-form-{{ $district->id }}"
                                                        action="{{ route('Admin.District.destroy', $district->id) }}"
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
                    </div> <!-- end col -->
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div>
        <!-- container-fluid -->

    </div>

@endsection
