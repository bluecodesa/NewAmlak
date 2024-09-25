


<div class="text-center my-4">
    <a  href="{{ route('Owner.create-unit') }}" class="btn btn-primary mx-2">
        @lang('Add unit')
    </a>
    <a href="{{ route('Owner.create-Property') }}"  class="btn btn-primary mx-2">
        @lang('Add New Property')
    </a>
</div>

      <!-- Teams Cards -->
      <div class="row g-4">

        @forelse ($allItems as $unit )

                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="card">
                <div class="card-body text-center">
                    <div class="dropdown btn-pinned">

                        @if(isset($unit->isGalleryUnit) && $unit->isGalleryUnit)
                                        @if ($unit->type == 'rent')
                                            @if ($unit->getRentPriceByType())
                                                <span class="pb-1">
                                                    {{ $unit->getRentPriceByType() }} @lang('SAR') / {{ __($unit->rent_type_show) }}
                                                </span>
                                            @endif
                                        @elseif ($unit->type == 'sale')
                                            @if ($unit->price)
                                            {{ $unit->price }} @lang('SAR')
                                            @endif
                                        @else
                                            @if ($unit->getRentPriceByType())
                                            <span class="pb-1">
                                                {{ $unit->getRentPriceByType() }} @lang('SAR') / {{ __($unit->rent_type_show) }}
                                            </span>
                                            @elseif ($unit->price)
                                            {{ $unit->price }} @lang('SAR')
                                            @endif
                                        @endif
                            @endif

                        <button
                            type="button"
                            class="btn dropdown-toggle hide-arrow p-0"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="ti ti-dots-vertical text-muted"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @if ($unit->isGalleryUnit)
                                <li><a class="dropdown-item" href="{{ route('Owner.edit-unit', $unit->id) }}">@lang('Edit')</a></li>
                                <li>
                                    <form action="{{ route('Owner.delete-unit', $unit->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item">@lang('Delete')</button>
                                    </form>
                                </li>
                            @elseif ($unit->isGalleryProperty)
                                <li><a class="dropdown-item" href="{{ route('Owner.edit-property', $unit->id) }}">@lang('Edit')</a></li>
                                <li>
                                    <form action="{{ route('Owner.delete-property', $unit->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item">@lang('Delete')</button>
                                    </form>
                                </li>
                            @elseif ($unit->isGalleryProject)

                            @endif
                        </ul>

                    </div>
                <div class="d-flex align-items-center justify-content-start">
                    <a  class="btn btn-label-secondary btn-icon d-flex align-items-center me-3"
                    data-bs-toggle="modal"
                    data-bs-target="#onboardHorizontalImageModal{{$unit->id}}"><i class="ti ti-share ti-sm"></i></a>

                </div>
                <div class="mx-auto my-3">
                    <a class="card-hover-border-default">
                        @php
                        $isGalleryUnit = isset($unit->isGalleryUnit) && $unit->isGalleryUnit;
                        $isGalleryProject = isset($unit->isGalleryProject) && $unit->isGalleryProject;
                        $isGalleryProperty = isset($unit->isGalleryProperty) && $unit->isGalleryProperty;
                    @endphp
                        <div class="image-container" style="position: relative; width: 100%; height: 200px;">
                            @if ($unit->UnitImages && $unit->UnitImages->isNotEmpty())
                                <img src="{{ url($unit->UnitImages->first()->image) }}"
                                     alt="Avatar Image" class="rounded-square" style="width: 100%; height: 100%;" />
                            @elseif ($unit->ProjectImages && $unit->ProjectImages->isNotEmpty())
                                <img src="{{ url($unit->ProjectImages->first()->image) }}"
                                     alt="Avatar Image" class="rounded-square" style="width: 100%; height: 100%;" />
                            @elseif ($unit->PropertyImages && $unit->PropertyImages->isNotEmpty())
                                <img src="{{ url($unit->PropertyImages->first()->image) }}"
                                     alt="Avatar Image" class="rounded-square" style="width: 100%; height: 100%;" />
                            @else
                                <img src="{{ url('Offices/Projects/default.svg') }}"
                                     alt="Avatar Image" class="rounded-square" style="width: 100%; height: 100%;" />
                            @endif
                            <div class="lable bg-label-primary" style="position: absolute; top: 10px; left: 10px; background: rgba(0, 0, 0, 0.5); color: white; padding: 5px; border-radius: 5px;">
                                @if ($isGalleryUnit)
                                   @lang('Unit')
                                @elseif ($isGalleryProject)
                                @lang('Project')
                                @elseif ($isGalleryProperty)
                                @lang('property')
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
                <h4 class="mb-1 card-title">{{ $unit->ad_name ?? $unit->name ?? '' }}</h4>
                <div class="d-flex align-items-center justify-content-center my-3 gap-2">

                <span class="pb-1"><i class="ti ti-map-pin"></i>{{ $unit->CityData->name ?? '' }}</span>
                </div>
                @if(isset($unit->isGalleryUnit) && $unit->isGalleryUnit)

                <div class="d-flex align-items-center justify-content-center my-3 gap-2">

                    <a href="javascript:;"><span class="badge bg-label-primary">
                            {{ __($unit->PropertyTypeData->name) ?? '' }}</span></a>
                    @if ($unit->type == 'rent')
                        <a href="javascript:;"><span
                                class="badge bg-label-warning">@lang('rent')</span></a>
                    @endif
                    @if ($unit->type == 'sale')
                        <a href="javascript:;"><span
                                class="badge bg-label-success">@lang('sale')</span></a>
                    @endif

                    @if ($unit->type == 'rent and sale')
                        <a href="javascript:;"><span
                                class="badge bg-label-info">@lang('rent and sale')</span></a>
                    @endif
                    @if ($unit->daily_rent)
                    <a href="javascript:;" class="me-1">
                        <span class="badge bg-label-secondary">متاح @lang('Daily Rent')</span></a>
                    @endif

                </div>
                <div class="d-flex align-items-center justify-content-around my-3 py-1">
                    <div>
                        <h4 class="mb-0">{{ $unit->rooms  ?? ' ' }}</h4>
                        <span>@lang('number rooms')</span>
                    </div>
                    <div>
                        <h4 class="mb-0">{{ $unit->bathrooms  ?? ' ' }}</h4>
                        <span>@lang('Number bathrooms')</span>
                    </div>
                    <div>
                        <h4 class="mb-0">{{ $unit->space  ?? ' ' }}</h4>
                        <span>@lang('Area (m²)')</span>
                    </div>
                    <div>
                        <h4 class="mb-0">{{ $unitVisitorsCount[$unit->id] ?? 0 }}</h4>
                        <span class="ti ti-eye"></span>
                    </div>
                </div>
                @endif

                @if(isset($unit->isGalleryProject) && $unit->isGalleryProject)

                <div class="d-flex align-items-center justify-content-center my-3 gap-2"
                style="text-align: center;">
                    <a href="javascript:;"><span class="badge bg-label-primary">
                            {{ __('Project') ?? '' }}</span></a>

                </div>
                <div class="d-flex align-items-center justify-content-around my-3 py-1">
                    <div>
                        <h4 class="mb-0">{{ $unit->PropertiesProject->count() ?? 0 }}</h4>
                        <span>@lang('Number Properties')</span>
                    </div>
                    <div>
                        <h4 class="mb-0">{{ $unit->UnitsProject->count() ?? 0 }}</h4>
                        <span>@lang('Number units')</span>
                    </div>

                    <div>
                        <h4 class="mb-0">{{ $unitVisitorsCount[$unit->id] ?? 0 }}</h4>
                        <span class="ti ti-eye"></span>
                    </div>
                </div>
                @endif

                @if(isset($unit->isGalleryProperty) && $unit->isGalleryProperty)

                <div class="d-flex align-items-center justify-content-center my-3 gap-2"
                style="text-align: center;">

                    <a href="javascript:;"><span class="badge bg-label-primary">
                            {{ __('property') ?? '' }}</span></a>

                </div>
                <div class="d-flex align-items-center justify-content-around my-3 py-1">
                    <div>
                        <h4 class="mb-0">{{ $unit->UnitsProperty->count() ?? 0 }}</h4>
                        <span>@lang('Number units')</span>
                    </div>

                    <div>
                        <h4 class="mb-0">{{ $unitVisitorsCount[$unit->id] ?? 0 }}</h4>
                        <span class="ti ti-eye"></span>
                    </div>
                </div>
                @endif

                <div class="d-flex align-items-center justify-content-center">
                    @if (Auth::user()->hasPermission('Show-broker-phone') || Auth::user()->hasPermission('Show-broker-phone-admin'))
                    {{-- <a href="" target="_blank" class="btn btn-primary d-flex align-items-center me-3"
                        >@lang('نشر')</a> --}}
                      @else
                      <a @disabled(true) target="_blank" class="btn btn-primary d-flex align-items-center me-3"
                        ><i class="ti-xs me-1 ti ti-phone me-1"></i>@lang('تواصل')</a>
                    @endif

                  </div>

                </div>
            </div>
            </div>


        @empty
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <span class="alert-icon text-danger me-2">
                <i class="ti ti-ban ti-xs"></i>
            </span>
            @lang('No Data Found!')
        </div>

        @endforelse


      </div>
      <!--/ Teams Cards -->
