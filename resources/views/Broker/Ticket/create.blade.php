@extends('Admin.layouts.app')
@section('title', __('Add New Ticket'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 ">

                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Broker.Tickets.index') }}" class="text-muted fw-light">@lang('Tickets')
                        </a> /
                        @lang('Add New Ticket')
                    </h4>
                </div>
            </div>
            <!-- DataTable with Buttons -->
            <div class="card">
                @include('Admin.layouts.Inc._errors')
                <div class="card-body">
                    <form action="{{ route('Broker.Tickets.store') }}" method="POST" class="row"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="col-md-6 mb-3 col-12">

                            <label class="form-label">{{ __('Ticket Type') }} <span class="required-color">*</span></label>
                            <select class="form-select" name="type" required>
                                <option value="" selected disabled> @lang('Ticket Type') </option>
                                @foreach ($ticketTypes as $ticketType)
                                    <option value="{{ $ticketType->id }}">
                                        {{ $ticketType->name }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="col-md-6 mb-3 col-12">
                            <label class="form-label"> @lang('Ticket Address') <span class="required-color">*</span></label>
                            <input type="text" required name="subject" class="form-control"
                                placeholder="@lang('Ticket Address')">

                        </div>
                        <div class="col-md-6 mb-3 col-12">
                            <label class="form-label">{{ __('Description') }} <span class="required-color">*</span></label>
                            <textarea class="form-control" name="content" rows="5" required></textarea>

                        </div>

                        <div class="col-md-6 mb-3 col-12">
                            <label class="form-label">@lang('Image')</label>
                            <input type="file" class="form-control" name="image"
                                accept="image/jpeg,image/png,image/gif,image/jpg">

                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary me-1">{{ __('save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Modal to add new record -->

            <!--/ DataTable with Buttons -->


        </div>

        <div class="content-backdrop fade"></div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('.model-checkbox').on('click', function() {
                    var model = $(this).val();
                    var checkboxes = $('input[name="permission[]"][data-model="' + model + '"]');
                    checkboxes.prop('checked', $(this).prop('checked'));
                });

                $('.all-checkbox').on('click', function() {
                    var model = $(this).val();
                    var checkboxes = $('input[name="permission[]"]');
                    checkboxes.prop('checked', $(this).prop('checked'));
                });

                $('.TypeUser').on('click', function() {

                    var show = $(this).val();
                    var hide = $(this).data('hide');
                    $('.' + show).css('display', 'block')
                    $('.' + hide).css('display', 'none');
                });

            });
        </script>
    @endpush

@endsection
