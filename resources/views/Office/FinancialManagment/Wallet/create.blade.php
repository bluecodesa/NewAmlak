@extends('Admin.layouts.app')
@section('title', __('Add New Wallet'))
@section('content')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-6 ">
                <h4 class="">
                    <a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                    <a href="{{ route('Office.Wallet.index') }}" class="text-muted fw-light">@lang('Wallets')</a> /
                    @lang('Add New Wallet')
                </h4>
            </div>
        </div>
        <!-- DataTable with Buttons -->
        <div class="card">
            @include('Admin.layouts.Inc._errors')
            <div class="card-body">
                <form action="{{ route('Office.Wallet.store') }}" method="POST" class="row">
                    @csrf
                    @method('post')

                    <div class="col-md-6 col-12 mb-3">
                        <label class="form-label">{{ __('Name') }} <span class="required-color">*</span></label>
                        <input type="text" required name="name" class="form-control" placeholder="{{ __('Name') }}">
                    </div>

                    <div class="col-md-6 col-12 mb-3">
                        <label class="form-label">{{ __('Initial Balance') }}</label>
                        <input type="number" name="initial_balance" class="form-control" placeholder="{{ __('Initial Balance') }}">
                    </div>

                    <div class="col-md-6 col-12 mb-3">
                        <label class="form-label">{{ __('Is Default') }}</label>
                        <select name="is_default" class="form-control">
                            <option value="0">{{ __('No') }}</option>
                            <option value="1">{{ __('Yes') }}</option>
                        </select>
                    </div>

                    <div class="col-md-6 col-12 mb-3">
                        <label class="form-label">{{ __('Wallet Type') }} <span class="required-color">*</span></label>
                        <select name="wallet_type_id" class="form-control" id="wallet_type_id" onchange="toggleBankFields()">
                            @foreach($walletTypes as $walletType)
                                <option value="{{ $walletType->id }}">{{ $walletType->name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <!-- Bank Fields in the same row -->
                    <div class="col-12" id="bankFields" style="display: none;">
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label">{{ __('Bank Name') }}</label>
                            <input type="text" name="bank_name" class="form-control" placeholder="{{ __('Bank Name') }}">
                        </div>

                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label">{{ __('Bank Account') }}</label>
                            <input type="text" name="bank_account" class="form-control" placeholder="{{ __('Bank Account') }}">
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary me-1">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <!--/ DataTable with Buttons -->
    </div>

    <div class="content-backdrop fade"></div>
</div>

@push('scripts')
<script>
    function toggleBankFields() {
        var walletTypeId = document.getElementById('wallet_type_id').value;
        var bankFields = document.getElementById('bankFields');
        if (walletTypeId == 2) {
            bankFields.style.display = 'block';
        } else {
            bankFields.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        toggleBankFields();
    });
</script>
@endpush

@endsection
