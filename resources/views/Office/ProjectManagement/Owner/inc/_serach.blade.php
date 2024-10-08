<!-- Modal -->
<div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">برجاء ادخال رقم هوية المالك</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="searchForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <input type="number" name="id_number" id="idNumberInput" class="form-control" placeholder="Enter ID Number" pattern="\d*" required />
                            <div id="idNumberError" class="text-danger mt-2"></div>
                        </div>
                    </div>
                    <div id="searchResults"></div> <!-- Results will be loaded here via AJAX -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">@lang('Cancel')</button>
                    <button type="button" id="searchBtn" class="btn btn-primary">@lang('Search')</button>
                </div>
            </form>
        </div>
    </div>
</div>
