@forelse ($allItems as $index => $unit)
   

    <!-- Upcoming Webinar -->
    <div class="col-md-6 col-xl-4 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="rounded-3 text-center mb-3 pt-4">
                    @php
                    $isGalleryUnit = isset($unit->isGalleryUnit) && $unit->isGalleryUnit;
                    $isGalleryProject = isset($unit->isGalleryProject) && $unit->isGalleryProject;
                    $isGalleryProperty = isset($unit->isGalleryProperty) && $unit->isGalleryProperty;
                @endphp
                    @if ($isGalleryUnit && $unit->UnitImages->isNotEmpty())
                    <img class="" src="{{ url($unit->UnitImages->first()->image) }}" alt="Card unit image" width="100%" height="200" />
                @elseif ($isGalleryProject && $unit->ProjectImages->isNotEmpty())
                    <img class="" src="{{ url($unit->ProjectImages->first()->image) }}" alt="Card project image" width="100%" height="200" />
                @elseif ($isGalleryProperty && $unit->PropertyImages->isNotEmpty())
                    <img class="" src="{{ url($unit->PropertyImages->first()->image) }}" alt="Card property image" width="100%" height="200" />
                @else
                    <img class="" src="{{ url('Offices/Projects/default.svg') }}" alt="Card default image" width="100%" height="200" />
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
                <h5 class="mb-2 pb-1">{{ $unit->ad_name ?? $unit->name }}</h5>
                <p class="card-text">{{ __('Occupancy') }}: {{ __($unit->status) }} </p>
                <p class="card-text">{{ __('Ad type') }}: {{ __($unit->type) ?? '' }}</p>
                <p class="card-text">{{ __('city') }}: {{ $unit->CityData->name ?? '' }}</p>
                <p class="card-text">{{ __('Show in Gallery') }}:
                    {{ $unit->show_gallery == 1 ? __('Show') : __('hide') }}</p>

                <div class="row mb-3 g-3">
                    <div class="col-6">
                        <div class="d-flex">
                            <div class="avatar flex-shrink-0 me-2">
                                <button type="button" data-bs-toggle="modal"
                                    data-bs-target="#addNewCCModal_{{ $unit->id }}">


                                    <span class="avatar-initial rounded bg-label-primary"><i
                                            class="ti ti-share ti-md"></i></span>
                                </button>
                            </div>

                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex">
                            <div class="avatar flex-shrink-0 me-2">
                                <span class="avatar-initial rounded bg-label-primary"><i class="ti ti-eye ti-md"> </i>
                                    {{ $numberOfVisitorsForEachUnit[$unit->id] ?? 0 }} </span>
                            </div>

                        </div>
                    </div>
                </div>

                @php
                $isUnit = isset($unit->isGalleryUnit) && $unit->isGalleryUnit;
                $isProject = isset($unit->isGalleryProject) && $unit->isGalleryProject;
                $isProperty = isset($unit->isGalleryProperty) && $unit->isGalleryProperty;
        
                if ($isUnit) {
                    $showRoute = route('Office.Unit.show', $unit->id);
                    $editRoute = route('Office.Unit.edit', $unit->id);
                    $deleteRoute = route('Office.Unit.destroy', $unit->id);
                } elseif ($isProject) {
                    $showRoute = route('Office.Project.show', $unit->id);
                    $editRoute = route('Office.Project.edit', $unit->id);
                    $deleteRoute = route('Office.Project.destroy', $unit->id);
                } elseif ($isProperty) {
                    $showRoute = route('Office.Property.show', $unit->id);
                    $editRoute = route('Office.Property.edit', $unit->id);
                    $deleteRoute = route('Office.Property.destroy', $unit->id);
                } else {
                    $showRoute = '#';
                    $editRoute = '#';
                    $deleteRoute = '#';
                }
            @endphp

                <div class="justify-content-center">
                    @if (Auth::user()->hasPermission('read-unit'))
                    <a href="{{ $showRoute }}" class="btn btn-secondary">
                        <i class="ti ti-eye"></i>
                    </a>
                @endif
                @if (Auth::user()->hasPermission('update-unit'))
                    <a href="{{ $editRoute }}" class="btn btn-primary">
                        <i class="ti ti-highlight"></i>
                    </a>
                @endif
                @if (Auth::user()->hasPermission('delete-unit'))
                    <a href="javascript:void(0);" onclick="handleDelete('{{ $unit->id }}')" class="btn btn-danger">
                        <i class="ti ti-trash"></i>
                    </a>
                    <form id="delete-form-{{ $unit->id }}" action="{{ $deleteRoute }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                @endif



                </div>
            </div>
        </div>
    </div>
    <!--/ Upcoming Webinar -->
@empty
    <div class="alert alert-danger d-flex align-items-center" role="alert">
        <span class="alert-icon text-danger me-2">
            <i class="ti ti-ban ti-xs"></i>
        </span>
        @lang('No Data Found!')
    </div>
@endforelse
{{-- @include('Office.Gallary.inc._shareGallery') --}}
