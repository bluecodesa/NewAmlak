<!-- search-result-modal.blade.php -->

<div class="modal fade" id="searchResultModal" tabindex="-1" role="dialog" aria-labelledby="searchResultModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="searchResultModalLabel">User Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('Office.Renter.addToOffice', $user->id) }}">
                    @csrf
                    <div class="form-group">
                        <label for="id_number">ID Number</label>
                        <input type="text" id="id_number" class="form-control" value="{{ $user->id_number }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" class="form-control" value="{{ $user->name }}" disabled>
                    </div>
                    <button type="submit" class="btn btn-primary">Add as Renter</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Script to show modal on page load if user is found
    $(document).ready(function() {
        $('#searchResultModal').modal('show');
    });
</script>
