@foreach ($receipts as $receipt)
<div class="modal fade" id="receiptModal{{$receipt->id }}" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" id="receiptModalHeader">
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
                        <p><strong>@lang('Account Name'):</strong> {{ $receipt->ContractData->office->UserData->name ?? 'N/A' }}</p>
                        <p><strong>@lang('Unit'):</strong> {{ $receipt->ContractData->unit->number_unit ?? 'N/A' }}</p>
                        <p><strong>@lang('Note'):</strong> {{ $receipt->notes }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>@lang('Release Date')</strong> {{ $receipt->release_date }}</p>
                        <p><strong>@lang('Beneficiary Name'):</strong> {{ $receipt->ContractData->renter->UserData->name ?? 'N/A' }}</p>
                        <p><strong>@lang('Pay Method'):</strong> {{ $receipt->payment_method }}</p>
                        <p><strong>@lang('total')</strong> {{ $receipt->total_price }} SR</p>
                        <p><strong>@lang('mobile')</strong> {{ $receipt->mobile }}</p>
                        <p><strong>@lang('#Ejar/REF:'):</strong> {{ $receipt->reference_number }}</p>
                        <p><strong>@lang('Transaction Id'):</strong> {{ $receipt->transaction_number }}</p>
                    </div>
                </div>
                <h5 class="mt-4">@lang('Installments'):</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>@lang('Installment Number')</th>
                            <th>@lang('price')</th>
                            <th>@lang('status')</th>
                            <th>@lang('Contract Start Date')</th>
                            <th>@lang('Contract End Date')</th>
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
@endforeach

<script>
    function printReceipt() {
        var originalContent = document.body.innerHTML;
        var printContent = document.getElementById('receiptModalBody','receiptModalHeader').innerHTML;
        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
        window.location.reload(); // Refresh to restore the original page
    }
</script>
