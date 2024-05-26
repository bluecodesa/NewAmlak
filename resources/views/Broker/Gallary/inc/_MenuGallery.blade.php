<div class="table-responsive text-nowrap shadow-none bg-transparent">
    <table class="table" id="table">
        <thead class="table-dark">
            <tr>

                <th>@lang('Residential number')</th>
                <th>@lang('Occupancy')</th>
                <th>@lang('Ad type')</th>
                <th>@lang('city')</th>
                <th>@lang('Show in Gallery')</th>
                <th>@lang('views')</th>
                <th>@lang('Share')</th>
                <th>@lang('Action')</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($units as $index => $unit)
                <tr>

                    <td>{{ $unit->number_unit ?? '' }}</td>
                    <td>{{ __($unit->status) }}</td>
                    <td>{{ __($unit->type) ?? '' }} </td>
                    <td>
                        {{ $unit->CityData->name ?? '' }}
                    </td>
                    <td> {{ $unit->show_gallery == 1 ? __('Show') : __('hide') }}
                    </td>
                    <td> {{ $numberOfVisitorsForEachUnit[$unit->id] ?? 0 }}</td>

                    <td>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#addNewCCModal_{{ $unit->id }}"
                            class="btn btn-primary waves-effect waves-light btn-sm">
                            @lang('Share')
                        </button>
                    </td>
                    <td>

                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu" style="">

                                @if (Auth::user()->hasPermission('update-unit'))
                                    <a class="dropdown-item"
                                        href="{{ route('Broker.Unit.edit', $unit->id) }}">@lang('Edit')</a>
                                @endif

                                @if (Auth::user()->hasPermission('read-unit'))
                                    <a class="dropdown-item" href="{{ route('Broker.Unit.show', $unit->id) }}"
                                        target="_blank">@lang('Show')</a>
                                @endif

                                @if (Auth::user()->hasPermission('delete-unit'))
                                    <a href="javascript:void(0);" onclick="handleDelete('{{ $unit->id }}')"
                                        class="dropdown-item delete-btn">@lang('Delete')</a>
                                    <form id="delete-form-{{ $unit->id }}"
                                        action="{{ route('Broker.Unit.destroy', $unit->id) }}" method="POST"
                                        style="display: none;">
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
