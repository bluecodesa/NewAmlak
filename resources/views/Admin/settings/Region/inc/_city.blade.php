<option disabled selected value="">@lang('city')</option>

@foreach ($cities as $city)
    @if ($city->DistrictsCity->count() > 0)
        <option value="{{ $city->id }}" data-url="{{ route('Broker.Broker.GetDistrictsByCity', $city->id) }}">
            {{ $city->name }}</option>
    @endif
@endforeach
