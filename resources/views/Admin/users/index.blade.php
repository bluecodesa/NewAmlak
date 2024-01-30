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

                                <li class="breadcrumb-item ">@lang('Types subscriptions') </li>
                                <li class="breadcrumb-item"><a href="{{ route('Admin.SubscriptionTypes.index') }}">
                                        Amlak</a></li>
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
                                        <a href="{{ route('Admin.users.create') }}" class="btn btn-success btn-sm my-2"><i
                                                class="bi bi-plus-circle"></i>
                                            Add New User</a>
                                    @endcan
                                </h4>
                                <table id="datatable-buttons"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">@lang('Name')</th>
                                            <th scope="col">@lang('Email')</th>
                                            <th scope="col">@lang('Roles')</th>
                                            <th scope="col">@lang('Permissions')</th>
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
                                                    @forelse ($user->getRoleNames() as $role)
                                                        <span class="badge badge-primary">{{ $role }}</span>
                                                    @empty
                                                    @endforelse
                                                </td>
                                                <td class="align-middle">
                                                    @foreach ($user->getAllPermissions() as $permission)
                                                        {{ $permission->name }}<br>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <form action="{{ route('Admin.users.destroy', $user->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')

                                                        <a href="{{ route('Admin.users.show', $user->id) }}"
                                                            class="btn btn-warning btn-sm"><i class="bi bi-eye"></i>
                                                            @lang('Show')</a>

                                                        @if (in_array('Super Admin', $user->getRoleNames()->toArray() ?? []))
                                                            @if (Auth::user()->hasRole('Super Admin'))
                                                                <a href="{{ route('users.edit', $user->id) }}"
                                                                    class="btn btn-primary btn-sm"><i
                                                                        class="bi bi-pencil-square"></i>
                                                                    @lang('Edit')</a>
                                                            @endif
                                                        @else
                                                            @can('edit-user')
                                                                <a href="{{ route('Admin.users.edit', $user->id) }}"
                                                                    class="btn btn-primary btn-sm"><i
                                                                        class="bi bi-pencil-square"></i>
                                                                    @lang('Edit')</a>
                                                            @endcan

                                                            @can('delete-user')
                                                                @if (Auth::user()->id != $user->id)
                                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                                        onclick="return confirm('Do you want to delete this user?');"><i
                                                                            class="bi bi-trash"></i> @lang('Delete')</button>
                                                                @endif
                                                            @endcan
                                                        @endif

                                                    </form>
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
