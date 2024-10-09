<div class="table-responsive text-nowrap shadow-none bg-transparent">
    <table class="table" id="table">
        <thead class="table-dark">
            <tr>

                <th>@lang('ad name') / @lang('Name')</th>
                <th>@lang('Type')</th>
                <th>@lang('Occupancy')</th>
                <th>@lang('Ad type')</th>
                <th>@lang('city')</th>
                <th>@lang('Show in Gallery')</th>
                <th>@lang('Ad Status')</th>
                <th>@lang('views')</th>
                <th>@lang('Action')</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($allItems as $index => $unit)
            @php
            $isGalleryUnit = isset($unit->isGalleryUnit) && $unit->isGalleryUnit;
            $isGalleryProject = isset($unit->isGalleryProject) && $unit->isGalleryProject;
            $isGalleryProperty = isset($unit->isGalleryProperty) && $unit->isGalleryProperty;
            @endphp
                <tr>

                    <td>{{ $unit->ad_name ?? $unit->name }}</td>
                    <td >
                        <button type="button"
                        class="btn btn-primary waves-effect waves-light btn-sm">
                        @if ($isGalleryUnit)
                        @lang('Unit')
                        @elseif ($isGalleryProject)
                        @lang('Project')
                        @elseif ($isGalleryProperty)
                        @lang('property')
                        @endif
                        </button>
                    </td>
                    <td>{{ __($unit->status) ?? '-' }}</td>
                    <td>{{ __($unit->type) ?? '-' }} </td>
                    <td>
                        {{ $unit->CityData->name ?? '-' }}
                    </td>
                    <td>{{ $unit->show_gallery == 1 || $unit->show_in_gallery == 1 ? __('show') : __('hide') }}</td>
                    <td> {{ __($unit->ad_license_status)}}
                    </td>
                    <td> {{ $numberOfVisitorsForEachUnit[$unit->id] ?? 0 }}</td>

                    {{-- <td>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#addNewCCModal_{{ $unit->id }}"
                            class="btn btn-primary waves-effect waves-light btn-sm">
                            @lang('Share')
                        </button>
                    </td> --}}
                    <td>

                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu" style="">
                                @php

                                    if ($isGalleryUnit) {
                                        $editRoute = route('Office.Unit.edit', $unit->id);
                                        $showRoute = route('Office.Unit.show', $unit->id);
                                        $deleteRoute = route('Office.Unit.destroy', $unit->id);
                                    } elseif ($isGalleryProject) {
                                        $editRoute = route('Office.Project.edit', $unit->id);
                                        $showRoute = route('Office.Project.show', $unit->id);
                                        $deleteRoute = route('Office.Project.destroy', $unit->id);
                                    } elseif ($isGalleryProperty) {
                                        $editRoute = route('Office.Property.edit', $unit->id);
                                        $showRoute = route('Office.Property.show', $unit->id);
                                        $deleteRoute = route('Office.Property.destroy', $unit->id);
                                    } else {
                                        $editRoute = '#';
                                        $showRoute = '#';
                                        $deleteRoute = '#';
                                    }
                                @endphp

                                @if (Auth::user()->hasPermission('update-unit'))
                                    <a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#addNewCCModal_{{ $unit->id }}">@lang('Share')</a>
                                @endif

                                @if (Auth::user()->hasPermission('update-unit'))
                                    <a class="dropdown-item" href="{{ $editRoute }}">@lang('Edit')</a>
                                @endif

                                @if (Auth::user()->hasPermission('read-unit'))
                                    <a class="dropdown-item" href="{{ $showRoute }}" target="_blank">@lang('Show')</a>
                                @endif

                                @if (Auth::user()->hasPermission('delete-unit'))
                                    <a href="javascript:void(0);" onclick="handleDelete('{{ $unit->id }}')" class="dropdown-item delete-btn">@lang('Delete')</a>
                                    <form id="delete-form-{{ $unit->id }}" action="{{ $deleteRoute }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endif
                            </div>
                        </div>
                    </td>

                </tr>
            @empty
                <td colspan="9">
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
