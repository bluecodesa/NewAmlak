<option disabled selected value="">@lang('districts')</option>
@foreach ($districts as $district)
    <option value="{{ $district->id }}">
        {{ $district->name }}</option>
@endforeach
