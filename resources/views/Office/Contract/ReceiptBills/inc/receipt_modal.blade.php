<div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="receiptModalLabel">@lang('Receipt Voucher')</h5>
                <img src="{{ url($setting->icon) }}" alt="Logo" style="max-width: 100px; margin-bottom: 20px;">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @if(!empty($receipt))
            <div class="modal-body" id="receiptModalBody">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>@lang('Voucher Number'):</strong> {{ $receipt->voucher_number }}</p>
                        <p><strong>@lang('Payment Date'):</strong> {{ $receipt->payment_date }}</p>
                        <p><strong>Account Name:</strong> {{ $receipt->ContractData->office->UserData->name ?? 'N/A' }}</p>
                        <p><strong>Prop Parent:</strong> {{ $receipt->contract->property->parent ?? 'N/A' }}</p>
                        <p><strong>#Property:</strong> {{ $receipt->contract->property->name ?? 'N/A' }}</p>
                        <p><strong>Note:</strong> {{ $receipt->notes }}</p>
                        <p><strong>#Code:</strong> {{ $receipt->contract->code ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Issue Date:</strong> {{ $receipt->release_date }}</p>
                        <p><strong>@lang('Beneficiary Name'):</strong> {{ $receipt->ContractData->renter->UserData->name ?? 'N/A' }}</p>
                        <p><strong>Pay Method:</strong> {{ $receipt->payment_method }}</p>
                        <p><strong>Total:</strong> {{ $receipt->total_price }} SR</p>
                        <p><strong>Mobile:</strong> {{ $receipt->mobile }}</p>
                        <p><strong>#Ejar/REF:</strong> {{ $receipt->reference_number }}</p>
                        <p><strong>Transid:</strong> {{ $receipt->transaction_number }}</p>
                    </div>
                </div>
                <h5 class="mt-4">Installments:</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>@lang('Installment Number')</th>
                            <th>@lang('price')</th>
                            <th>@lang('status')</th>
                            <th>@lang('Contract Start Date')</th>
                            <th>@lang('end Contract End Date')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($receipt->installments as $installment)
                            <tr>
                                <td>{{ $installment->Installment_number }}</td>
                                <td>{{ $installment->price }}</td>
                                <td>{{ __($installment->status) }}</td>
                                <td>{{ $installment->start_date }}</td>
                                <td>{{ $installment->end_date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <h5 class="mt-4">Total: {{ $receipt->total_price }} SR</h5>
            </div>            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="printReceipt()">Print</button>
                <a href="{{ route('Office.Receipt.download', $receipt->id) }}" class="btn btn-success">Download</a>
            </div>
            @else
            <div class="modal-body" id="receiptModalBody">
            </div>
            @endif
            
        </div>
    </div>
</div>

<script>
    function printReceipt() {
        var originalContent = document.body.innerHTML;
        var printContent = document.getElementById('receiptModalBody').innerHTML;
        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
        window.location.reload(); // Refresh to restore the original page
    }
</script>