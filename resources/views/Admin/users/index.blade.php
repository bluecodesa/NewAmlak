@extends('Admin.layouts.app')
@section('title', __('User management'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">
                                @lang('User management')</h4>

                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item"><a href="{{ route('Admin.users.index') }}">@lang('User management')</a>
                                </li>
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

                                <h4 class="mt-0 header-title">
                                    @can('create-user')
                                        <a href="{{ route('Admin.users.create') }}" class="btn btn-primary btn-sm"><i
                                                class="bi bi-plus-circle"></i>
                                            @lang('Add New Admin') </a>
                                    @endcan
                                </h4>
                                <div class="table-responsive b-0" data-pattern="priority-columns">
                                    <table id="datatable-buttons" class="table  table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">@lang('Name')</th>
                                                <th scope="col">@lang('Email')</th>
                                                <th scope="col">@lang('Roles')</th>
                                                <th scope="col">@lang('sections')</th>
                                                <th scope="col">@lang('Action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($users as $user)
                                                <tr>
                                                    <th scope="row">{{ $loop->iteration }}</th>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>
                                                        {{ app()->getLocale() == 'ar' ? $user->roles[0]->name_ar : $user->roles[0]->name ?? '' }}

                                                    </td>
                                                    <td class="align-middle">
                                                        @foreach ($user->getAllPermissions()->unique('section_id') as $permission)
                                                            <span
                                                                class="badge badge-primary">{{ $permission->SectionDate->name ?? '' }}</span>
                                                            @if (!$loop->last)
                                                                ,
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>

                                                        <a href="{{ route('Admin.users.show', $user->id) }}"
                                                            class="btn btn-outline-warning btn-sm waves-effect waves-light"><i
                                                                class="bi bi-eye"></i>
                                                            @lang('Show')</a>

                                                        @if (in_array('Super Admin', $user->getRoleNames()->toArray() ?? []))
                                                            @if (Auth::user()->hasRole('Super Admin'))
                                                                <a href="{{ route('users.edit', $user->id) }}"
                                                                    class="btn btn-primary btn-sm"><i
                                                                        class="bi bi-pencil-square"></i>
                                                                    @lang('Edit')</a>
                                                            @endif
                                                        @else
                                                            @can('delete-user')
                                                                <a href="{{ route('Admin.users.edit', $user->id) }}"
                                                                    class="btn btn-outline-info btn-sm waves-effect waves-light">@lang('Edit')</a>
                                                                <a href="javascript:void(0);"
                                                                    onclick="handleDelete('{{ $user->id }}')"
                                                                    class="btn btn-outline-danger btn-sm waves-effect waves-light delete-btn">
                                                                    @lang('Delete')
                                                                </a>
                                                                <form id="delete-form-{{ $user->id }}"
                                                                    action="{{ route('Admin.users.destroy', $user->id) }}"
                                                                    method="POST" style="display: none;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>
                                                            @endcan
                                                        @endif


                                                    </td>
                                                </tr>
                                            @empty
                                                <td colspan="5">
                                                    <span class="text-danger">
                                                        <strong>No User Found!</strong>
                                                    </span>
                                                </td>
                                            @endforelse
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
