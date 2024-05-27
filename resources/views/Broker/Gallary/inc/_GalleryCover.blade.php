<div class="first-div">
    <button type="button" class="btn btn-sm btn-primary mb-2" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg">
        @lang('Edit') @lang('Image') <i class="ti ti-camera"></i>
    </button>
    <img src="{{ asset($gallery->gallery_cover) }}" alt="Gallery Cover" class="img-fluid"
        style="height: 200px; width: 100%;">
</div>


<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myLargeModalLabel">@lang('Edit')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('Broker.Gallery.update-cover') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="form-control" name="gallery_id" value="{{ $gallery->id }}">
                    <input type="file" class="form-control" id="images" name="gallery_cover" required
                        accept="image/jpeg, image/png, image/jpg">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">@lang('save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
