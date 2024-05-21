@foreach ($units as $index => $unit)
    {{-- <div class="col-md-6 col-xl-6 col-12">
    <div class="card shadow-none bg-transparent border border-primary mb-3">
      <div class="card-body">
        <h5 class="card-title">{{ __('Residential number') }}: {{ $unit->number_unit ?? '' }}</h5>
        <p class="card-text">{{ __('Occupancy') }}: {{ __($unit->status) }} </p>
        <p class="card-text">{{ __('Ad type') }}: {{ __($unit->type) ?? '' }}</p>
        <p class="card-text">{{ __('city') }}: {{ $unit->CityData->name ?? '' }}</p>
        <p class="card-text">{{ __('Show in Gallery') }}:
            {{ $unit->show_gallery == 1 ? __('Show') : __('hide') }}</p>
            <div class="btn-group" role="group" aria-label="First group">
                @if (Auth::user()->hasPermission('read-unit'))
                <a href="{{ route('Broker.Unit.show', $unit->id) }}"  class="btn btn-outline-secondary waves-effect">
                   <span>{{ $numberOfVisitorsForEachUnit[$unit->id] ?? 0 }}  <i class="ti ti-eye"></i> </span>
                </a>
                @endif
                @if (Auth::user()->hasPermission('update-unit'))
                <a href="{{ route('Broker.Unit.edit', $unit->id) }}" class="btn btn-outline-secondary waves-effect">
                  <i class="ti ti-highlight"></i>
                </a>
                @endif
                @if (Auth::user()->hasPermission('delete-unit'))
                <a href="javascript:void(0);" onclick="handleDelete('{{ $unit->id }}')" class="btn btn-outline-secondary waves-effect">
                  <i class="ti ti-trash"></i>
                </a>

                <form id="delete-form-{{ $unit->id }}"
                    action="{{ route('Broker.Unit.destroy', $unit->id) }}" method="POST"
                    style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
                @endif

                <button type="button" data-bs-toggle="modal"
                data-bs-target="#addNewCCModal_{{ $unit->id }}" class="btn btn-outline-secondary waves-effect">
                  <i class="ti ti-share"></i>
                </button>
              </div>
      </div>
    </div>
  </div> --}}

    <!-- Upcoming Webinar -->
    <div class="col-md-6 col-xl-4 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="rounded-3 text-center mb-3 pt-4">
                    @if ($unit->UnitImages->isNotEmpty())
                        <img class="" src="{{ url($unit->UnitImages->first()->image) }}" alt="Card girl image"
                            width="140" height="140" />
                    @else
                        <img class="" src="{{ url('Offices/Projects/default.svg') }}" alt="Card girl image"
                            width="140" height="140" />
                    @endif
                </div>
                <h5 class="mb-2 pb-1">{{ __('Residential number') }}: {{ $unit->number_unit ?? '' }}</h5>
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
                <div class="justify-content-center">
                    @if (Auth::user()->hasPermission('read-unit'))
                        <a href="{{ route('Broker.Unit.show', $unit->id) }}" class="btn btn-secondary">
                            <i class="ti ti-eye"></i>
                        </a>
                    @endif
                    @if (Auth::user()->hasPermission('update-unit'))
                        <a href="{{ route('Broker.Unit.edit', $unit->id) }}" class="btn btn-primary">
                            <i class="ti ti-highlight"></i>
                        </a>
                    @endif
                    @if (Auth::user()->hasPermission('delete-unit'))
                        <a href="javascript:void(0);" onclick="handleDelete('{{ $unit->id }}')"
                            class="btn btn-danger">
                            <i class="ti ti-trash"></i>
                        </a>

                        <form id="delete-form-{{ $unit->id }}"
                            action="{{ route('Broker.Unit.destroy', $unit->id) }}" method="POST"
                            style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif



                </div>
            </div>
        </div>
    </div>
    <!--/ Upcoming Webinar -->
@endforeach

{{-- @include('Broker.Gallary.inc._shareGallery') --}}
