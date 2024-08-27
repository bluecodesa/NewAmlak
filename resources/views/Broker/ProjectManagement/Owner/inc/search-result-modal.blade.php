<div class="alert alert-success"><span class="required-color">{{ $message }}</span></div>
<p>@lang('Name'): {{ $user->name }}</p>

<form action="{{ route('Broker.Owner.addAsOwner', $user->id) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-primary">@lang('Add as Owner')</button>
</form>
