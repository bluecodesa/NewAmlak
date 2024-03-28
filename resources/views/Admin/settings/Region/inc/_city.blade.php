<option disabled selected value="">@lang('city')</option>
@foreach ($cities as $city)
    <option value="{{ $city->id }}" data-url="{{ route('Broker.Broker.GetDistrictsByCity', $city->id) }}">
        {{ $city->name }}</option>
@endforeach
