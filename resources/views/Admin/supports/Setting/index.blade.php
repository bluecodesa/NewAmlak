@extends('Admin.layouts.app')

@section('title', __('Support contact information'))

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-12">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <span class="text-muted fw-light"> @lang('Settings') / @lang('technical support') /</span>
                        @lang('Support contact information')
                    </h4>
                </div>
            </div>
            <!-- DataTable with Buttons -->

            <div class="card">
                @include('Admin.layouts.Inc._errors')
                <div class="card-body">
                    <form action="{{ route('Admin.InfoSupport.update') }}" method="POST" class="row">
                        @csrf
                        @method('put')
                        <input type="text" name="key_support_phone" hidden
                            value="{{ $settings->key_support_phone ?? '996' }}" id="key_phone">
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label">
                                @lang('Email content')<span class="required-color">*</span></label>
                            <input type="text" required id="modalRoleName" name="support_email" class="form-control"
                                placeholder="email" value="{{ old('support_email', $settings->support_email) }}">
                        </div>



                        <div class="col-12 mb-3 col-md-6">
                            <label for="color" class="form-label">@lang('phone') <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" name="support_phone" placeholder="123456789"
                                    value="{{ old('support_phone', $settings->support_phone) }}" class="form-control"
                                    maxlength="9" pattern="\d{1,9}"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 9);"
                                    aria-label="Text input with dropdown button">
                                <button class="btn btn-outline-primary dropdown-toggle waves-effect" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ $settings->key_support_phone ?? '996' }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" style="">
                                    <li><a class="dropdown-item" data-key="971" href="javascript:void(0);">971</a></li>
                                    <li><a class="dropdown-item" data-key="996" href="javascript:void(0);">996</a></li>
                                </ul>
                            </div>
                        </div>

                        {{--  --}}
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                {{ __('save') }}
                            </button>

                        </div>
                    </form>
                </div>


            </div>
        </div>
        <!-- Modal to add new record -->

        <!--/ DataTable with Buttons -->
    </div>

    <div class="content-backdrop fade"></div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Show the modal when the page is fully loaded
                var modal = document.getElementById('pendingPaymentModal');
                if (modal) {
                    modal.classList.add('show');
                    modal.style.display = 'block';
                    modal.removeAttribute('aria-hidden');
                }
            });
        </script>

        <script>
            $(document).ready(function() {
                $('.dropdown-item').on('click', function() {
                    var key = $(this).data('key');
                    $('#key_phone').val(key);
                    $(this).closest('.input-group').find('.btn.dropdown-toggle').text(key);
                });
            });
        </script>
    @endpush
@endsection
