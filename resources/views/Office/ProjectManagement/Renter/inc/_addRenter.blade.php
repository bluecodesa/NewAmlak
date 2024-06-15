@if ($user = App\Models\User::where('id_number', $search_id_number)->first())
    <form action="{{ route('Office.Renter.addToOffice', $user->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success">Add as Renter</button>
    </form>
@else
    <a href="{{ route('Office.Renter.create') }}" class="btn btn-primary">Register</a>
@endif
