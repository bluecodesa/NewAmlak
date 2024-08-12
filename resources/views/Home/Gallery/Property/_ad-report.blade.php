   <!-- Modal -->
   <div class="modal fade" id="modalReport" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel1">@lang('ابلاغ عن الاعلان')</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('Home.Tickets.send-report') }}" method="POST" class="row"
            enctype="multipart/form-data">
            @csrf
            @include('Admin.layouts.Inc._errors')

          <div class="row">
            @php

            $routeName ='Home.showPublicProperty';

            $gallery_name = $property->BrokerData->GalleryData->gallery_name;
            $ad_url = route($routeName, ['gallery_name' => $gallery_name, 'id' => $property->id]);
            @endphp
            <input type="hidden" name="ad_url" value="{{ $ad_url }}" class="form-control" required>

                {{-- <input type="hidden" name="property_id" value="{{ $property->id }}" class="form-control" required>
                    <div class="col-md-6 mb-3 col-12">

                <label class="form-label">{{ __('Ticket Type') }} <span class="required-color">*</span></label>
                <select class="form-select" name="type" required disabled>
                    <option value="" disabled> @lang('Ticket Type') </option>
                    @foreach ($ticketTypes as $ticketType)
                        <option value="{{ $ticketType->id }}" {{ $ticketType->id == 39 ? 'selected' : '' }}>
                            {{ $ticketType->name }}
                        </option>
                    @endforeach
                </select>


            </div> --}}
            <input type="hidden" name="type" value="39" required>


            <div class="col-md-6 mb-3 col-12">
                <label class="form-label"> @lang('Ticket Address') <span class="required-color">*</span></label>
                <input type="text" required name="subject" class="form-control" value="{{ $property->name }}"
                    placeholder="@lang('Ticket Address')">
            </div>
            <div class="col-md-6 mb-3 col-12">
                <label class="form-label">@lang('Image')</label>
                <input type="file" class="form-control" name="image"
                    accept="image/jpeg,image/png,image/gif,image/jpg">

            </div>
            <div class="col-md-12 mb-3 col-12">
                <label class="form-label">{{ __('Description') }} <span class="required-color">*</span></label>
                <textarea id="textarea" class="form-control" name="content" cols="5" rows="5" placeholder=""
                required></textarea>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
            @lang('close')
          </button>
          <button type="submit" class="btn btn-primary">@lang('ابلاغ')</button>
        </div>
    </form>
      </div>
    </div>
  </div>

  <script>
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
