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
                    <th>@lang('#')</th>
                    <th>@lang('Subscriber Name')</th>
                    <th>@lang('Email')</th>
                    <th>@lang('id number')</th>
                    <th>@lang('role name')</th>
                    <th>@lang('Subscription Start')</th>
                    <th>@lang('Action')</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0 sortable">

                @forelse ($clients as $index => $client)
                    <tr>
                        <td></td>
                        <td>{{ $client->name }}</td>
                        <td>{{ $client->email }}</td>
                        <td>{{ $client->id_number }}</td>
                        <td>{{ __($client->roles->pluck('name')->implode(', ')) }}</td>
                        <td>{{ $client->created_at }}</td>

                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu" style="">
                                    @if (Auth::user()->hasPermission('log-in-as-user'))
                                            <a class="dropdown-item"
                                                href="{{ route('Admin.Subscribers.LoginByUser', $client->id) }}">@lang('login')</a>

                                    @endif

                                    @if (Auth::user()->hasPermission('read-subscriber-file'))
                                        <a class="dropdown-item"
                                            href="{{ route('Admin.Subscribers.show', $subscriber->id) }}">@lang('Show')</a>
                                    @endif
                                    @if (Auth::user()->hasPermission('delete-users'))
                                    <a href="javascript:void(0);"
                                        onclick="handleDelete('{{ $client->id }}')"
                                        class="dropdown-item delete-btn">@lang('Delete')</a>
                                    <form id="delete-form-{{ $client->id }}"
                                        action="{{ route('Admin.delete-client', $client->id) }}"
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