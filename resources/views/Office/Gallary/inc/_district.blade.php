<option disabled selected value="">@lang('district')</option>
@foreach ($districts as $district)
    @if (in_array($district->id, $districtsIds))
        <option value="{{ $district->id }}">
            {{ $district->name }}</option>
    @endif
@endforeach
