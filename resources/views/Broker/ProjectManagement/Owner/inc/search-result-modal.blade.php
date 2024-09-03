<div class="alert alert-success"><span class="required-color">{{ $message }}</span></div>
<p>@lang('Name'): {{ $user->name }}</p>
<p>@lang('ID Number'): {{ $user->id_number }}</p>
@if($user->UserBrokerData)
<p>@lang('City'): {{ $user->UserBrokerData->CityData->name }}</p>
@elseif($user->UserOfficeData)
<p>@lang('City'): {{ $user->UserOfficeData->CityData->name }}</p>
@elseif ($user->UserOwnerData)
<p>@lang('Cityr'): {{ $user->UserOwnerData->CityData->name }}</p>
@elseif ($user->UserRenterData)
<p>@lang('City'): {{ $user->UserRenterData->CityData->name }}</p>
@elseif ($user->UserEmployeeData)
<p>@lang('City'): {{ $user->UserEmployeeData->CityData->name }}</p>
@endif

<form id="addAsOwnerForm" action="{{ route('Broker.Owner.addAsOwner', $user->id) }}" method="POST">
    @csrf
    <input type="hidden" name="id_number" value="{{ $user->id_number }}">
    <button type="submit" class="btn btn-primary">@lang('Add as Owner')</button>
</form>
