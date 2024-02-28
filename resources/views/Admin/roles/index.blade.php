@extends('Admin.layouts.app')
@section('title', __('Roles'))
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
                                        @lang('Roles')</h4>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item"><a href="{{ route('Admin.roles.index') }}">@lang('Roles')</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('Admin.home') }}">@lang('dashboard')</a></li>
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
                                <div class="col-md-6" >
                                    @can('create-role')
                                        <a href="{{ route('Admin.roles.create') }}"
                                            class="btn btn-primary col-3 p-1 m-1 waves-effect waves-light"><i
                                                class="bi bi-plus-circle"></i> @lang('Add New Role')</a>
                                    @endcan
                                </div>
                                <h4 class="mt-0 header-title">

                                </h4>
                                <table id="datatable-buttons"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('Name')</th>
                                            <th>@lang('Role type')</th>
                                            <th>@lang('Action')</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($roles as $index=> $role)
                                            <tr>
                                                <th>{{ $index + 1 }}</th>
                                                <td>{{ app()->getLocale() == 'ar' ? $role->name_ar : $role->name }}
                                                </td>
                                                <td>{{ __($role->type) }}</td>
                                                <td>

                                                    <a href="{{ route('Admin.roles.show', $role->id) }}"
                                                        class="btn btn-outline-warning btn-sm waves-effect waves-light"><i
                                                            class="bi bi-eye"></i>
                                                        @lang('Show')</a>

                                                    <a href="{{ route('Admin.roles.edit', $role->id) }}"
                                                        class="btn btn-outline-info btn-sm waves-effect waves-light">@lang('Edit')</a>



                                                        @can('delete-role')
                                                        <a href="javascript:void(0);"
                                                            onclick="handleDelete('{{ $role->id }}')"
                                                            class="btn btn-outline-danger btn-sm waves-effect waves-light delete-btn">
                                                            @lang('Delete')
                                                        </a>
                                                        <form id="delete-form-{{ $role->id }}"
                                                            action="{{ route('Admin.roles.destroy', $role->id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    @endcan



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
