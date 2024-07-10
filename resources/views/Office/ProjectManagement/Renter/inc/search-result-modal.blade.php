<!-- resources/views/Office/ProjectManagement/Renter/inc/_result.blade.php -->
<div class="alert alert-success"><span class="required-color">{{ $message }}</span></div>
<p>Name: {{ $user->name }}</p>
<p>Email: {{ $user->email }}</p>
<p>Phone: {{ $user->full_phone }}</p>
<form action="{{ route('Office.Renter.addAsRenter', $user->id) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-primary">@lang('Add as Renter')</button>
</form>
