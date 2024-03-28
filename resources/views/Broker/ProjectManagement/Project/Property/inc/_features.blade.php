<option disabled value="">@lang('features')</option>
@foreach ($features as $feature)
    <option value="{{ $feature->id }}">
        {{ $feature->name }}</option>
@endforeach
