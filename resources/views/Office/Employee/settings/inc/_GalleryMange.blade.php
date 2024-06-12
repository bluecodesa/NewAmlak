@if (in_array('Realestate-gallery', $sectionNames) || in_array('المعرض العقاري', $sectionNames))
    <div class="card shadow-none bg-transparent">
        <div class="card-header">
            <h5 class="card-title">@lang('Gallery setting')</h5>
        </div>
        <div class="card-body shadow-none bg-transparent">
            <form action="{{ route('Broker.Gallery.update', ['Gallery' => $gallery->id]) }}" method="post" class="row">
                @csrf
                @method('PUT')

                @error('gallery_name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="row">
                    <div class="col-12 col-md-12 mb-3">
                        <label for="galleryName">@lang('Gallery URL')</label>
                        <div class="input-group">
                            <input type="text" class="form-control galleryNameCopy" readonly
                                value="{{ route('gallery.showByName', ['name' => $gallery->gallery_name]) }}">
                            <button onclick="copyToClipboard('.galleryNameCopy')"
                                class="btn btn-outline-primary waves-effect" type="button">
                                <i class="ti ti-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row">

                    @if (Auth::user()->hasPermission('update-gallery-url'))
                        <div class="col-12 col-md-12 mb-3">
                            <input hidden name="broker_id_for_gallery" value="{{ $gallery->id }}" />
                            <label for="editGalleryName">@lang('Edit Gallery Name')</label>
                            <div class="input-group">
                                <div class="col-4">
                                    <input type="text" name="gallery_name" class="form-control edit-gallery-name"
                                        id="editGalleryName" placeholder="@lang('Gallery Name')"
                                        value="{{ explode('@', $gallery->gallery_name)[0] }}" oninput="trimInput(this)">
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" id="galleryName" disabled
                                        value="{{ route('gallery.showByName', ['name' => $gallery->gallery_name]) }}" />

                                </div>
                            </div>
                            <div class="row validate-result" style="display: none">
                                <span class="alert alert-success"></span>
                                <span class="alert alert-error"></span>
                            </div>
                        </div>
                    @endif
                </div>
                @if (Auth::user()->hasPermission('activate-gallery'))
                    <div class="col-12 col-md-6 mb-3">
                        <label for="editGalleryName">@lang('Enable Gallery')</label>
                        <div class="d-flex" style="margin-top: 10px">
                            @if ($gallery->gallery_status == 0)
                                <input type="checkbox" class="toggleHomePage gallery_status" name="gallery_status"
                                    value="0" data-toggle="toggle">
                            @else
                                <input type="checkbox" class="toggleHomePage gallery_status" name="gallery_status"
                                    value="1" checked data-toggle="toggle" data-onstyle="primary">
                            @endif
                        </div>
                    </div>
                @endif



                <div class="col-12">
                    <button type="submit" class="btn btn-primary">@lang('Edit')</button>

                </div>
            </form>


        </div>
    </div>
@else
    <div class="card shadow-none bg-transparent" disabled>
        <div class="card-header">
            <h5 class="card-title">@lang('Gallery Setting')</h5>
        </div>
        <div class="card-body shadow-none bg-transparent">
            <form id="galleryForm" method="post" disabled class="row">
                @csrf
                @method('PUT')
                <div class="col-12 col-md-12 mb-3">
                    <label for="galleryName">@lang('Gallery URL')</label>
                    <div class="input-group">
                        <input type="text" class="form-control galleryNameCopy" readonly
                            value="{{ route('gallery.showByName', ['name' => $gallery->gallery_name]) }}">
                        <button onclick="copyToClipboard('.galleryNameCopy')"
                            class="btn btn-outline-primary waves-effect" type="button">
                            <i class="ti ti-copy"></i>
                        </button>
                    </div>

                </div>
                <div class="col-12 col-md-12 mb-3">
                    <input hidden name="broker_id_for_gallery" value="{{ $gallery->id }}" />
                    <label for="editGalleryName">@lang('Edit Gallery Name')</label>
                    <div class="d-flex">
                        <div class="input-group">
                            <input type="text" name="gallery_name" class="form-control edit-gallery-name"
                                id="editGalleryName" placeholder="@lang('Gallery Name')"
                                value="{{ explode('@', $gallery->gallery_name)[0] }}" oninput="validateName(this)"
                                disabled>
                            <input type="text" class="form-control" id="galleryName" disabled
                                value="{{ env('APP_URL') }}/ar/gallery/">
                        </div>
                    </div>
                    <div class="row validate-result" style="display: none">
                        <span class="alert alert-success"></span>
                        <span class="alert alert-error"></span>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-3">

                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" disabled type="checkbox" id="flexSwitchCheckChecked"
                            value="0" name="gallery_status" class="gallery_status" checked="">
                        <label class="form-check-label" for="flexSwitchCheckChecked">@lang('Enable Gallery')</label>
                    </div>

                    {{--  --}}

                </div>
            </form>
        </div>
    </div>

@endif

@push('scripts')
    <script>
        function copyToClipboard(selector) {
            // Get the input element
            var copyText = document.querySelector(selector);

            // Select the text field
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices

            // Copy the text inside the text field
            document.execCommand("copy");

            // Optionally, you can provide feedback to the user
            alertify.success(@json(__('copy done')));
        }
    </script>
@endpush
