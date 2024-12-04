<!-- Modal -->
<div class="modal fade" id="PaymentVoucher" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">@lang('Payment Voucher')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('Office.create-payment-voucher') }}" method="POST" class="row"
                    enctype="multipart/form-data">
                    @csrf
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <input type="hidden" name="contract_id" value="{{ $contract->id }}" class="form-control" />

                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label for="bondNumber" class="form-label">@lang('Voucher Number')</label>
                            <input type="text" id="bondNumber" name="voucher_number" class="form-control" placeholder="يحدد اليا" readonly disabled />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="releaseDate" class="form-label">@lang('Release Date')</label>
                            <input type="text" id="releaseDate" name="release_date" class="form-control" value="{{ now()->format('Y-m-d H:i') }}" readonly />
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label for="paymentDate" class="form-label">@lang('Payment Date')</label>
                            <input type="date" id="paymentDate" name="payment_date" class="form-control" value="{{ now()->format('Y-m-d') }}" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="projectName" class="form-label">@lang('Project')</label>
                            <input type="text" id="projectName" class="form-control" value="{{ $contract->project->name ?? '' }}" readonly disabled />
                            <input type="hidden" name="project_id" value="{{ $contract->project->id ?? '' }}">
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label for="propertyName" class="form-label">@lang('property')</label>
                            <input type="text" id="propertyName" class="form-control" value="{{ $contract->property->name ?? '' }}" readonly disabled />
                            <input type="hidden" name="property_id" value="{{ $contract->property->id ?? '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="unitName" class="form-label">@lang('Unit')</label>
                            <input type="text" id="unitName" class="form-control" value="{{ $contract->unit->number_unit ?? '' }}" readonly disabled />
                            <input type="hidden" name="unit_id" value="{{ $contract->unit->id ?? '' }}">
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label for="renterName" class="form-label">@lang('Beneficiary Name')</label>
                            <input type="text" id="renterName" class="form-control" value="{{ $contract->owner->UserData->name ?? '' }}" readonly disabled />
                            <input type="hidden" name="owner_id" value="{{ $contract->owner->id ?? '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="paymentMethod" class="form-label">@lang('Pay Method')</label>
                            <select id="paymentMethod" name="payment_method" class="form-select">
                                <option value="cash">@lang('Cash')</option>
                                <!-- Add other payment methods here if available -->
                            </select>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label for="wallet" class="form-label">@lang('Select Wallet')</label>
                            <select id="wallet" name="wallet_id" class="form-select">
                                <option disabled selected>@lang('Select Wallet')</option>
                                @foreach ($wallets as $wallet)
                                    <option value="{{ $wallet->id }}">{{ $wallet->name }} - {{ $wallet->walletType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-12 mb-3">
                            <label for="installment" class="form-label">@lang('Select Installment')</label>
                            <select id="installment2" name="installments[]" class="form-select" multiple>
                                <option disabled>@lang('Installment')</option>
                                @foreach ($contract->installments as $installment)
                                @if ($installment->status === 'collected')
                                <option value="{{ $installment->id }}" data-price2="{{ $installment->price}}">{{ $installment->Installment_number }} - {{ $installment->start_date }}</option>
                                @endif
                            @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="totalValue" class="form-label">@lang('Total Value (SAR)')</label>
                            <input type="text" id="totalValue2" name="total_price" class="form-control" readonly />
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label for="reference_number" class="form-label">@lang('Reference Number')</label>
                            <input type="text"  name="reference_number" class="form-control"  />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="transaction_number" class="form-label">@lang('Transaction Number')</label>
                            <input type="text" name="transaction_number" class="form-control" readonly />
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label for="mobile" class="form-label">@lang('Mobile')</label>
                            <input type="text" id="mobile" class="form-control" value="{{ $contract->renter->UserData->full_phone ?? '' }}" readonly />
                            <input type="text" id="mobile" hidden name="mobile" class="form-control" value="{{ $contract->renter->UserData->full_phone ?? '' }}" />

                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-12 mb-3">
                            <label for="notes" class="form-label">@lang('Notes')</label>
                            <textarea id="notes" name="notes" class="form-control" rows="3" placeholder="@lang('Enter notes')"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">@lang('close')</button>
                        <button type="submit" id="ReceiptSave" class="btn btn-primary">@lang('save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
   document.addEventListener('DOMContentLoaded', function() {
    var installmentSelect2 = document.getElementById('installment2');
    var totalValue2 = document.getElementById('totalValue2');

    installmentSelect2.addEventListener('change', function() {
        var total2 = 0;
        for (var i = 0; i < installmentSelect2.options.length; i++) {
            if (installmentSelect2.options[i].selected) {
                total2 += parseFloat(installmentSelect2.options[i].getAttribute('data-price2'));
            }
        }
        totalValue2.value = total2.toFixed(2);
    });
});

</script>
