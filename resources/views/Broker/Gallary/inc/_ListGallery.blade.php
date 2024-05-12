
@foreach ($units as $index => $unit)
<div class="col-md-6 col-xl-6 col-12">
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
  </div>
@endforeach

{{-- @include('Broker.Gallary.inc._shareGallery') --}}




