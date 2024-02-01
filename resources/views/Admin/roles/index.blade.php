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
                                <div class="col-md-6" style="text-align: end">
                                    @can('create-role')
                                        <a href="{{ route('Admin.roles.create') }}"
                                            class="btn btn-primary col-3 p-1 m-1 waves-effect waves-light"><i
                                                class="bi bi-plus-circle"></i> @lang('Add New Role')</a>
                                    @endcan
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
                                                    <form action="{{ route('Admin.roles.destroy', $role->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')

                                                        <a href="{{ route('Admin.roles.show', $role->id) }}"
                                                            class="btn btn-warning btn-sm"><i class="bi bi-eye"></i>
                                                            @lang('Show')</a>

                                                        @if ($role->name != 'Super Admin')
                                                            @can('edit-role')
                                                                <a href="{{ route('Admin.roles.edit', $role->id) }}"
                                                                    class="btn btn-primary btn-sm"><i
                                                                        class="bi bi-pencil-square"></i>
                                                                    @lang('Edit')</a>
                                                            @endcan

                                                            @can('delete-role')
                                                                @if ($role->name != Auth::user()->hasRole($role->name))
                                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                                        onclick="return confirm('Do you want to delete this role?');"><i
                                                                            class="bi bi-trash"></i> @lang('Delete')</button>
                                                                @endif
                                                            @endcan
                                                        @endif

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
