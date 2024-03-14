<option disabled selected value="">@lang('owner name')</option>
@foreach ($owners as $owner)
    <option value="{{ $owner->id }}">
        {{ $owner->name }}</option>
@endforeach
