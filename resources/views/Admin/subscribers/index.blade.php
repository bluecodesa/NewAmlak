@extends('Admin.layouts.app')

@section('title', __('Subscribers'))

@section('content')



    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-12">

                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Admin.Subscribers.index') }}" class="text-muted fw-light">@lang('Subscriber management') </a> /
                        @lang('Subscribers')
                    </h4>
                </div>

            </div>
            <div class="nav-align-top nav-tabs-shadow mb-4">

                <div class="tab-content">
                  <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">
                        {{-- header --}}
                        <div class="row p-1 mb-1">

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <div id="DataTables_Table_0_filter" class="dataTables_filter"><label>
                                                <input id="SearchInput" class="form-control" placeholder="@lang('search...')"
                                                    aria-controls="DataTables_Table_0"></label></div>
                                    </div>

                                    <div class="col-6">
                                        <div class="d-flex justify-content-start justify-content-md-end align-items-baseline">
                                            <div
                                                class="dt-action-buttons d-flex flex-column align-items-start align-items-md-center justify-content-sm-center mb-3 mb-md-0 pt-0 gap-4 gap-sm-0 flex-sm-row">
                                                <div class="dt-buttons btn-group flex-wrap d-flex">
                                                    <div class="btn-group">
                                                        <button onclick="exportToExcel()"
                                                            class="btn btn-outline-primary btn-sm waves-effect me-2"
                                                            type="button"><span><i
                                                                    class="ti ti-download me-1 ti-xs"></i>Export</span></button>
                                                    </div>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-primary dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                                                                    class="d-none d-sm-inline-block">@lang('Add')</span></span>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            @if (Auth::user()->hasPermission('create-SubscriptionTypes'))
                                                                <li><a class="dropdown-item"
                                                                        href="{{ route('Admin.Subscribers.create') }}">@lang('Add')
                                                                        @lang('Office')</a>
                                                                </li>

                                                                <li><a class="dropdown-item"
                                                                        href="{{ route('Admin.Subscribers.CreateBroker') }}">@lang('Add')
                                                                        @lang('Broker')</a>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>


                        </div>

                        {{-- table --}}
                        <div class="table-responsive text-nowrap">
                            <table class="table" id="table">
                                <thead class="table-dark">
                                    <tr>
                                        {{-- <th>#</th> --}}
                                        <th>@lang('Customer ID')</th>
                                        <th>@lang('Subscriber Name')</th>
                                        {{-- <th>@lang('Email')</th> --}}
                                        <th>@lang('phone')</th>
                                        <th>@lang('Account Type')</th>
                                        <th>@lang('Subscription Start')</th>
                                        <th>@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0 sortable">

                                    @forelse ($subscribers as $index => $subscriber)
                                        <tr>
                                            {{-- <td>{{ $index + 1 }}</td> --}}


                                            <td>
                                                    {{ $subscriber->customer_id ?? '-' }}

                                            </td>

                                            <td>
                                                {{ $subscriber->name ?? '' }}
                                                <br>
                                                <span class="text-warning" style="font-size: smaller;">
                                                    {{ $subscriber->email ?? '' }}
                                                </span>
                                            </td>
                                            {{-- <td>
                                                {{ $subscriber->email ?? '' }}
                                             </td> --}}
                                            <td>
                                                    {{ $subscriber->full_phone ?? '' }}
                                            </td>
                                            <td class="align-middle">
                                                @foreach ($subscriber->roles as $role)
                                                    <span class="badge bg-primary" style="font-size: 0.75rem; padding: 0.25em 0.5em;">
                                                        {{ __($role->name) ?? '' }}
                                                    </span>
                                                    @if (!$loop->last)
                                                        ,
                                                    @endif
                                                @endforeach
                                            </td>
                                            

                                            <td>
                                                <span style="font-size: smaller;" >
                                                {{ $subscriber->created_at }}
                                                </span>
                                            </td>
                                            {{-- <td>{{ $subscriber->end_date }}</td> --}}
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ti ti-dots-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu" style="">
                                                        @if (Auth::user()->hasPermission('log-in-as-user'))
                                                                <a class="dropdown-item"
                                                                    href="{{ route('Admin.Subscribers.LoginByUser', $subscriber->id) }}">@lang('login')</a>
                                                        @endif

                                                        @if (Auth::user()->hasPermission('suspend-user-subscriber'))
                                                            @if ($subscriber->is_suspend)
                                                                <form
                                                                    action="{{ route('Admin.Subscribers.SuspendSubscription', $subscriber->id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <input type="text" hidden value="{{ 0 }}"
                                                                        name="is_suspend">
                                                                    <button class="dropdown-item">@lang('re active')</button>
                                                                </form>
                                                            @else
                                                                <form
                                                                    action="{{ route('Admin.Subscribers.SuspendSubscription', $subscriber->id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <input type="text" hidden value="{{ 1 }}"
                                                                        name="is_suspend">
                                                                    <button class="dropdown-item">@lang('suspend')</button>
                                                                </form>
                                                            @endif
                                                        @endif


                                                        @if (Auth::user()->hasPermission('read-subscriber-file'))
                                                            <a class="dropdown-item"
                                                                href="{{ route('Admin.Subscribers.show', $subscriber->id) }}">@lang('Show')</a>
                                                        @endif

                                                        @if (Auth::user()->hasPermission('delete-subscriber'))
                                                            <a href="javascript:void(0);"
                                                                onclick="handleDelete('{{ $subscriber->id }}')"
                                                                class="dropdown-item delete-btn">@lang('Delete')</a>
                                                            <form id="delete-form-{{ $subscriber->id }}"
                                                                action="{{ route('Admin.Subscribers.destroy', $subscriber->id) }}"
                                                                method="POST" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        @endif

                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <td colspan="7">
                                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                                <span class="alert-icon text-danger me-2">
                                                    <i class="ti ti-ban ti-xs"></i>
                                                </span>
                                                @lang('No Data Found!')
                                            </div>
                                        </td>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{ $subscribers->links() }}
                    </div>


                </div>
              </div>

        </div>
        <div class="content-backdrop fade"></div>
    </div>


    @push('scripts')
        <script>
            function exportToExcel() {
                var wb = XLSX.utils.table_to_book(document.getElementById('table'), {
                    sheet: "Sheet1"
                });
                XLSX.writeFile(wb, @json(__('Subscribers')) + '.xlsx');
                alertify.success(@json(__('Download done')));
            }
        </script>
    @endpush
@endsection
