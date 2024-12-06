@extends('Admin.layouts.app')
@section('title', __('Projects'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">
                                @lang('Projects')</h4>
                        </div>
                        <div class="col-6">
                            <div class="card-title">
                                <a href="{{ route('Office.Project.create') }}"
                                    class="btn btn-primary waves-effect waves-light">@lang('Add New')</a>
                            </div>
                        </div>

                    </div> <!-- end row -->
                </div>
                <!-- end page-title -->

                <div class="row">

                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">

                                <div class="table-responsive b-0" data-pattern="priority-columns">
                                    <table id="datatable-buttons"
                                        class="table table-striped table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('project name')</th>
                                                <th>@lang('Developer name')</th>
                                                <th>@lang('Employee Name')</th>
                                                <th>@lang('Advisor name')</th>
                                                <th>@lang('owner name')</th>
                                                <th>@lang('city')</th>
                                                <th>@lang('location name')</th>
                                                <th>@lang('Number Properties')</th>
                                                <th>@lang('Action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($Projects as $index => $project)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $project->name ?? '' }}</td>
                                                    <td>{{ $project->DeveloperData->name ?? '' }}</td>
                                                    <td>{{ $project->EmployeeData->UserData->name ?? '' }}</td>
                                                    <td>{{ $project->AdvisorData->name ?? '' }}</td>
                                                    <td>{{ $project->OwnerData->name ?? '' }}</td>
                                                    <td>{{ $project->CityData->name ?? '' }}</td>
                                                    <td>{{ $project->location ?? '' }}</td>
                                                    <td>
                                                        {{ $project->PropertiesProject->count() }}
                                                    </td>

                                                    <td>

                                                        <a href="{{ route('Office.Project.show', $project->id) }}"
                                                            class="btn btn-outline-warning btn-sm waves-effect waves-light">@lang('Show')</a>

                                                        <a href="{{ route('Office.Project.edit', $project->id) }}"
                                                            class="btn btn-outline-info btn-sm waves-effect waves-light">@lang('Edit')</a>

                                                        <a href="javascript:void(0);"
                                                            onclick="handleDelete('{{ $project->id }}')"
                                                            class="btn btn-outline-danger btn-sm waves-effect waves-light delete-btn">@lang('Delete')</a>
                                                        <form id="delete-form-{{ $project->id }}"
                                                            action="{{ route('Office.Project.destroy', $project->id) }}"
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
            </div> <!-- end row -->

        </div>
        <!-- container-fluid -->

    </div>
@endsection
