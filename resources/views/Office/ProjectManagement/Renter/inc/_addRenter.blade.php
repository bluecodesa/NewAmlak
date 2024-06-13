
@if (session('found_user'))
    <h2>Add {{ session('found_user')->name }} as Renter</h2>
    <form action="{{ route('Office.Renter.store') }}" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{ session('found_user')->id }}">
        <button type="submit">Add as Renter</button>
    </form>
@else
    <p>No user found.</p>
@endif
