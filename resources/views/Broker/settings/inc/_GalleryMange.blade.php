@if(in_array('Realestate-gallery', $sectionNames) || in_array('المعرض العقاري', $sectionNames))

<div class="tab-pane fade" id="v-pills-gallary" role="tabpanel"
aria-labelledby="v-pills-gallary-tab">
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card timeline shadow">
            <div class="card-header">
                <h5 class="card-title">@lang('Gallery setting')</h5>
            </div>
            <div class="card-body">
                <form
                    action="{{ route('Broker.Gallery.update', ['Gallery' => $gallery->id]) }}"
                    method="post">
                    @csrf
                    @method('PUT')

                    @error('gallery_name')
                    <div class="alert alert-danger">{{ $message }}</div>
                     @enderror
                    <div class="form-group">
                        <label
                            for="galleryName">@lang('Gallery URL')</label>
                        <div class="input-group">
                            <input type="text" class="form-control"
                                id="galleryName" disabled
                                value="{{ route('gallery.showByName', ['name' => $gallery->gallery_name]) }}" />

                                {{-- value="{{ env('APP_URL', 'https://newamlak.tryamlak.com','https://stage-newamlak.tryamlak.com') }}/ar/gallery/{{ $gallery->gallery_name }}"> --}}
                            <div class="input-group-append">
                                <span class="input-group-text"
                                    style="cursor: pointer;"
                                    onclick="selectText()">
                                    <i class="fas fa-copy"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input hidden name="broker_id_for_gallery"
                            value="{{ $gallery->id }}" />
                        <label
                            for="editGalleryName">@lang('Edit Gallery Name')</label>
                        <div class="d-flex" style="margin-top: 10px">
                            <div class="input-group">
                                <input type="text"
                                    name="gallery_name"
                                    class="form-control edit-gallery-name"
                                    id="editGalleryName"
                                    placeholder="@lang('Gallery Name')"
                                    value="{{ explode('@', $gallery->gallery_name)[0] }}"
                                    oninput="trimInput(this)">
                                <input type="text"
                                    class="form-control"
                                    id="galleryName" disabled
                                    value="{{ route('gallery.showByName', ['name' => $gallery->gallery_name]) }}" />

                                    {{-- value="{{ env('APP_URL', 'https://newamlak.tryamlak.com','https://stage-newamlak.tryamlak.com') }}/ar/gallery/"> --}}
                            </div>
                        </div>
                        <div class="row validate-result"
                            style="display: none">
                            <span class="alert alert-success"></span>
                            <span class="alert alert-error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label
                        for="editGalleryName">@lang('تفعيل المعرض')</label>
                        <div class="d-flex" style="margin-top: 10px">
                            @if ($gallery->gallery_status == 0)
                            <input type="checkbox"
                                class="toggleHomePage gallery_status"
                                name="gallery_status" value="0"
                                data-toggle="toggle">
                        @else
                            <input type="checkbox"
                                class="toggleHomePage gallery_status"
                                name="gallery_status" value="1"
                                checked data-toggle="toggle"
                                data-onstyle="primary">
                        @endif
                        </div>
                    </div>


                    <button type="submit"
                        class="btn btn-primary">@lang('Edit')</button>
                </form>


            </div>
        </div>
    </div>
</div>
</div>


@else

<div class="tab-pane fade" id="v-pills-gallary" role="tabpanel" aria-labelledby="v-pills-gallary-tab">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card timeline shadow" disabled>
                <div class="card-header">
                    <h5 class="card-title">@lang('اعدادات المعرض')</h5>
                </div>
                <div class="card-body">
                    <form id="galleryForm" method="post" disabled>
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="galleryName">@lang('Gallery URL')</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="galleryName" disabled value="{{ env('APP_URL') }}/ar/gallery/{{ $gallery->gallery_name }}">
                                <div class="input-group-append">
                                    <span class="input-group-text" style="cursor: not-allowed;">
                                        <i class="fas fa-copy"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input hidden name="broker_id_for_gallery" value="{{ $gallery->id }}" />
                            <label for="editGalleryName">@lang('Edit Gallery Name')</label>
                            <div class="d-flex" style="margin-top: 10px">
                                <div class="input-group">
                                    <input type="text" name="gallery_name" class="form-control edit-gallery-name" id="editGalleryName" placeholder="@lang('Gallery Name')" value="{{ explode('@', $gallery->gallery_name)[0] }}" oninput="validateName(this)" disabled>
                                    <input type="text" class="form-control" id="galleryName" disabled value="{{ env('APP_URL') }}/ar/gallery/">
                                </div>
                            </div>
                            <div class="row validate-result" style="display: none">
                                <span class="alert alert-success"></span>
                                <span class="alert alert-error"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="editGalleryName">@lang('تفعيل المعرض')</label>
                            <div class="d-flex" style="margin-top: 10px">
                                <input type="checkbox" class="toggleHomePage gallery_status" name="gallery_status" value="0" data-toggle="toggle" data-onstyle="danger" disabled>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endif

<script>
    function trimInput(input) {
        input.value = input.value.trim();
    }
</script>
