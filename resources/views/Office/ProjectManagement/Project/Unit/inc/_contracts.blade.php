<div class="card">

    <div class="row p-1 mb-1">
        <div class="col-12">
            <h5 class="card-header">@lang('Contracts') </h5>
        </div>
        <div class="col-12">
            <hr>
            <div class="row">
                <div class="col-4">
                    <div id="DataTables_Table_0_filter" class="dataTables_filter"><label>
                            <input id="SearchInput" class="form-control" placeholder="@lang('search...')"
                                aria-controls="DataTables_Table_0"></label></div>
                </div>

                <div class="col-8">

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
                                @if (Auth::user()->hasPermission('add-new-contract'))
                                    <div class="btn-group">
                                        <a href="{{ route('Office.Contract.create') }}" class="btn btn-primary">
                                            <span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                                                    class="d-none d-sm-inline-block">@lang('Add New Contract')</span></span>
                                        </a>

                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table" id="table">
            <thead class="table-dark">
                <tr>
                    <th scope="col">@lang('Contract Number')</th>
                    <th scope="col">@lang('Unit')</th>
                    <th scope="col">@lang('Renter')</th>
                    <th scope="col">@lang('Total Commission')</th>
                    <th scope="col">@lang('status')</th>
                    <th scope="col">@lang('Contract validity')</th>
                    <th scope="col">@lang('Contract Start Date')</th>
                    <th scope="col">@lang('Contract End Date')</th>

                    <th scope="col">@lang('Action')</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($contracts as $contract)
                    <tr>

                        <td>{{ $contract->contract_number }}</td>
                        <td>{{ $contract->unit->number_unit }}</td>
                        <td>{{ $contract->renter->UserData->name }}</td>
                        <td>{{ $contract->total_commission }}</td>
                        <td>{{ __($contract->status) }}</td>
                        {{-- <td>{{ __($contract->contract_validity) }}</td> --}}
                        <td>
                            <span
                                        class="badge badge-pill bg-{{ $contract->contract_validity == 'active' ? 'success' : 'warning' }}"
                                        style="font-size: 13px;">
                                        {{ __($contract->contract_validity) ?? __('nothing') }}
                                    </span>
                            </td>
                        <td>{{ $contract->start_contract_date }}</td>
                        <td>{{ $contract->end_contract_date }}</td>

                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu" style="">
                                        <a class="dropdown-item"
                                            href="{{ route('Office.Contract.show', $contract->id) }}">@lang('Show')</a>
                                    @if (Auth::user()->hasPermission('edit-contract') && $contract->status != 'Executed')
                                        <a class="dropdown-item"
                                            href="{{ route('Office.Contract.edit', $contract->id) }}">@lang('Edit')</a>
                                    @endif


                                    @if (Auth::user()->hasPermission('delete-contract') && $contract->status != 'Executed' )
                                        <a href="javascript:void(0);"
                                            onclick="handleDelete('{{ $contract->id }}')"
                                            class="dropdown-item delete-btn">@lang('Delete')</a>
                                        <form id="delete-form-{{ $contract->id }}"
                                            action="{{ route('Office.Contract.destroy', $contract->id) }}"
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
                    <td colspan="8">
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
</div>