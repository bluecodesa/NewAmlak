@extends('Admin.layouts.app')
@section('title', __('owners'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">
                                @lang('owners')</h4>

                        </div>

                    </div> <!-- end row -->
                </div>
                <!-- end page-title -->

                <div class="row">

                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="table-responsive b-0" data-pattern="priority-columns">
                                    <table id="datatable-buttons" class="table  table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">@lang('Name')</th>
                                                <th scope="col">@lang('Email')</th>
                                                <th scope="col">@lang('phone')</th>
                                                <th scope="col">@lang('city')</th>
                                                <th scope="col">@lang('Office')</th>
                                                <th scope="col">@lang('Action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($owners as $owner)
                                                <tr>
                                                    <th scope="row">{{ $loop->iteration }}</th>
                                                    <td>{{ $owner->name }}</td>
                                                    <td>{{ $owner->email }}</td>
                                                    <td>{{ $owner->phone }}</td>
                                                    <td>{{ $owner->CityData->name }}</td>
                                                    <td>{{ $owner->OfficeData->company_name ?? '' }}</td>
                                                    <td>
                                                        <a href="{{ route('Admin.Owner.edit', $owner->id) }}"
                                                            class="btn btn-outline-info btn-sm waves-effect waves-light">@lang('Edit')</a>
                                                        <a href="javascript:void(0);"
                                                            onclick="handleDelete('{{ $owner->id }}')"
                                                            class="btn btn-outline-danger btn-sm waves-effect waves-light delete-btn">
                                                            @lang('Delete')
                                                        </a>
                                                        <form id="delete-form-{{ $owner->id }}"
                                                            action="{{ route('Admin.Owner.destroy', $owner->id) }}"
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
                    </div> <!-- end col -->
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div>
        <!-- container-fluid -->

    </div>
@endsection
