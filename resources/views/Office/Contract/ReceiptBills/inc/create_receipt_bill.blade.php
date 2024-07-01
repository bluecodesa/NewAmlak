<!-- Modal -->
<div class="modal fade" id="largeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">@lang('Receipt Bill')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6 mb-3">
                        <label for="bondNumber" class="form-label">@lang('Bond Number')</label>
                        <input type="text" id="bondNumber" class="form-control" value="001000001" readonly disabled />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="releaseDate" class="form-label">@lang('Release Date')</label>
                        <input type="text" id="releaseDate" class="form-control" value="{{ now()->format('Y-m-d H:i') }}" readonly />
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-6 mb-3">
                        <label for="paymentDate" class="form-label">@lang('Payment Date')</label>
                        <input type="date" id="paymentDate" class="form-control" value="{{ now()->format('Y-m-d') }}" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="projectName" class="form-label">@lang('Project')</label>
                        <input type="text" id="projectName" class="form-control" value="{{ $contract->project->name ?? '' }}" readonly disabled />
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-6 mb-3">
                        <label for="propertyName" class="form-label">@lang('Property')</label>
                        <input type="text" id="propertyName" class="form-control" value="{{ $contract->property->name ?? '' }}" readonly disabled />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="unitName" class="form-label">@lang('Unit')</label>
                        <input type="text" id="unitName" class="form-control" value="{{ $contract->unit->number_unit ?? '' }}" readonly disabled />
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-6 mb-3">
                        <label for="renterName" class="form-label">@lang('Renter Name')</label>
                        <input type="text" id="renterName" class="form-control" value="{{ $contract->renter->UserData->name ?? '' }}" readonly disabled />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="paymentMethod" class="form-label">@lang('Payment Method')</label>
                        <select id="paymentMethod" class="form-select">
                            <option value="cash">@lang('Cash')</option>
                            <!-- Add other payment methods here if available -->
                        </select>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-6 mb-3">
                        <label for="installment" class="form-label">@lang('Select Installment')</label>
                        <select id="installment" class="form-select">
                            <option disabled selected value="">@lang('Select Installment')</option>
                            @foreach ($contract->installments as $installment)
                                <option value="{{ $installment->price }}">{{ $installment->id }} - {{ $installment->start_date }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="mobile" class="form-label">@lang('Mobile')</label>
                        <input type="text" id="mobile" class="form-control" value="{{ $contract->renter->UserData->full_phone ?? '' }}" readonly disabled />
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-12 mb-3">
                        <label for="notes" class="form-label">@lang('Notes')</label>
                        <textarea id="notes" class="form-control" rows="3" placeholder="@lang('Enter notes')"></textarea>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-6 mb-3">
                        <label for="totalValue" class="form-label">@lang('Total Value (SAR)')</label>
                        <input type="text" id="totalValue" class="form-control" readonly />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">@lang('Close')</button>
                <button type="button" class="btn btn-primary">@lang('Save changes')</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var installmentSelect = document.getElementById('installment');
        var totalValue = document.getElementById('totalValue');

        installmentSelect.addEventListener('change', function() {
            var selectedOption = installmentSelect.options[installmentSelect.selectedIndex];
            totalValue.value = selectedOption.value;
        });
    });
</script>
