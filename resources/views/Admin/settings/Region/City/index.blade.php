@extends('Admin.layouts.app')
@section('title', __('Cities'))
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
                                        @lang('Cities')</h4>
                                </div>
                                <div class="col-md-6" style="text-align: end">
                                    <a href="{{ route('Admin.City.create') }}"
                                        class="btn btn-primary col-3 p-1 m-1 waves-effect waves-light">
                                        @lang('Add New')
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
                                            <th>@lang('Region')</th>
                                            <th>@lang('Action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($Cities as $index=> $City)
                                            <tr>
                                                <th>{{ $index + 1 }}</th>
                                                <td>{{ $City->name }} </td>
                                                <td>{{ $City->RegionData->name ?? '' }} </td>



                                                <td>
                                                    <a href="{{ route('Admin.City.edit', $City->id) }}"
                                                        class="btn btn-outline-info btn-sm waves-effect waves-light">@lang('Edit')</a>
                                                    <a href="javascript:void(0);"
                                                        onclick="handleDelete('{{ $City->id }}')"
                                                        class="btn btn-outline-danger btn-sm waves-effect waves-light delete-btn">
                                                        @lang('Delete')
                                                    </a>
                                                    <form id="delete-form-{{ $City->id }}"
                                                        action="{{ route('Admin.City.destroy', $City->id) }}" method="POST"
                                                        style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>

                                                </td>
                                            </tr>
                                        @empty
                                            <td colspan="3">
                                                <span class="text-danger">
                                                    <strong>No Role Found!</strong>
                                                </span>
                                            </td>
                                        @endforelse
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
