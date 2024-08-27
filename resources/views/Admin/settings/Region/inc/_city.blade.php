<option disabled selected value="">@lang('city')</option>

@foreach ($cities as $city)
    @if ($city->DistrictsCity->count() > 0)
        <option value="{{ $city->id }}"
            data-url="{{
                Auth::user()->is_owner ? route('Owner.GetDistrictsCity', $city->id) : (
                Auth::user()->is_employee ? route('Employee.Employee.GetDistrictsByCity', $city->id) : (
                Auth::user()->is_broker ? route('Broker.Broker.GetDistrictsByCity', $city->id) :
                route('Office.Office.GetDistrictsByCity', $city->id)
            )) }}">
            {{ $city->name }}
        </option>
    @endif
@endforeach
