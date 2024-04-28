@extends('Admin.layouts.app')
@section('title', __('sections'))
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
                                        @lang('sections')</h4>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('Admin.Sections.index') }}">@lang('sections')</a></li>
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('Admin.home') }}">@lang('dashboard')</a></li>
                                    </ol>
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


                                @if (Auth::user()->hasPermission('create-sections'))
                                    <div class="col-md-6">
                                        <a href="{{ route('Admin.Sections.create') }}"
                                            class="btn btn-primary col-3 p-1 m-1 waves-effect waves-light">
                                            @lang('Add New Section')
                                        </a>
                                    </div>
                                @endif
                                <table id="datatable-buttons"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('Name')</th>
                                            <th>@lang('Action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($sections as $index=> $section)
                                            <tr>
                                                <th>{{ $index + 1 }}</th>
                                                <td>{{ $section->name }} </td>
                                                <td>
                                                    @if (Auth::user()->hasPermission('update-sections'))
                                                        <a href="{{ route('Admin.Sections.edit', $section->id) }}"
                                                            class="btn btn-outline-info btn-sm waves-effect waves-light">@lang('Edit')</a>
                                                    @endif
                                                    @if (Auth::user()->hasPermission('delete-sections'))
                                                        <a href="javascript:void(0);"
                                                            onclick="handleDelete('{{ $section->id }}')"
                                                            class="btn btn-outline-danger btn-sm waves-effect waves-light delete-btn">
                                                            @lang('Delete')
                                                        </a>
                                                        <form id="delete-form-{{ $section->id }}"
                                                            action="{{ route('Admin.Sections.destroy', $section->id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    @endif
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
