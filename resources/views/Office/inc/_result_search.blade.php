<div class="alert alert-success"><span class="required-color">{{ $message }}</span></div>
<p>Name: {{ $user->name }}</p>
<p>Email: {{ $user->email }}</p>
<p>Phone: {{ $user->full_phone }}</p>
@if($user->is_owner)
<a  href="{{ route('Office.Owner.show', $user->UserOwnerData->id) }}"  class="btn btn-primary">@lang('Show')</a>

@elseif($user->is_renter)
<a  href="{{ route('Office.Renter.show' ,$user->UserRenterData->id) }}"  class="btn btn-primary">@lang('Show')</a>
@endif
