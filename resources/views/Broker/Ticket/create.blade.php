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
                            {{-- <textarea class="form-control" name="content" rows="5" required></textarea> --}}
                            <textarea id="textarea" class="form-control" name="content" cols="30" rows="30" placeholder=""
                            required></textarea>
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


            $(document).ready(function() {
                $('#textarea').summernote({
                    height: 100, // set editor height
                    minHeight: null, // set minimum height of editor
                    maxHeight: null, // set maximum height of editor
                    focus: true, // set focus to editable area after initializing summernote
                    toolbar: [
                        // Include only the options you want in the toolbar, excluding 'fontname', 'video', and 'table'
                        ['style', ['bold', 'underline']],
                        ['insert', ['link', 'picture', 'hr']], // 'video' is deliberately excluded
                        ['para', ['ul', 'ol']],
                        ['misc', ['fullscreen', 'undo', 'redo']],
                        // Any other toolbar groups and options you want to include...
                    ],
                    // Explicitly remove table and font name options by not including them in the toolbar
                });
                $('.card-body .badge').click(function() {
                    var variableValue = $(this).attr('data-variable');
                    var $textarea = $('#textarea');
                    var summernoteEditor = $textarea.summernote('code');

                    // Check if Summernote editor is focused
                    if ($('.note-editable').is(':focus')) {
                        var node = document.createElement("span");
                        node.innerHTML = variableValue;
                        $('.note-editable').append(
                            node); // This line appends the variable as a new node to the editor
                        var range = document.createRange();
                        var sel = window.getSelection();
                        range.setStartAfter(node);
                        range.collapse(true);
                        sel.removeAllRanges();
                        sel.addRange(range);
                    } else {
                        var currentContent = $textarea.summernote('code');
                        $textarea.summernote('code', currentContent + variableValue);
                    }
                });
            });

        </script>
    @endpush

@endsection
