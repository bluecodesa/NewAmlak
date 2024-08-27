<div class="alert alert-success"><span class="required-color">{{ $message }}</span></div>
<p>@lang('Name'): {{ $user->name }}</p>
<p>@lang('ID Number'): {{ $user->id_number }}</p>
<form id="addAsOwnerForm" action="{{ route('Broker.Owner.addAsOwner', $user->id) }}" method="POST">
    @csrf
    <input type="hidden" name="id_number" value="{{ $user->id_number }}">
    <button type="submit" class="btn btn-primary">@lang('Add as Owner')</button>
</form>
