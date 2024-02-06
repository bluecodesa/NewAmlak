<option disabled selected value="">@lang('city')</option>
@foreach ($cities as $city)
    <option value="{{ $city->id }}">{{ $city->name }}</option>
@endforeach
