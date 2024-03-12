<div class="first-div">
    <a type="button" class="btn  waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-lg">
        تعديل الصورة
        <svg xmlns="http://www.w3.org/2000/svg" width="20.049" height="16.053" viewBox="71.975 141.947 20.049 16.053">
            <g data-name="photo-camera">
                <path
                    d="M78.985 142.018c-.486.13-.971.435-1.245.78-.079.101-.4.575-.713 1.053l-.568.87-1.175.003c-.869 0-1.245.016-1.445.059a2.41 2.41 0 0 0-1.62 1.276c-.087.18-.177.423-.2.537-.032.14-.044 1.637-.044 4.793 0 4.037.008 4.609.063 4.82a2.426 2.426 0 0 0 1.269 1.547c.184.086.427.176.54.2.294.059 16.012.059 16.306 0 .114-.024.356-.114.54-.2.611-.29 1.1-.889 1.27-1.547.054-.211.062-.783.062-4.82 0-3.156-.012-4.652-.043-4.793a3.046 3.046 0 0 0-.2-.537 2.41 2.41 0 0 0-1.621-1.276c-.2-.043-.576-.059-1.445-.059l-1.175-.004-.568-.87a31.242 31.242 0 0 0-.712-1.053c-.282-.352-.791-.67-1.289-.79-.223-.055-.595-.063-2.995-.06-2.483 0-2.761.009-2.992.071Zm3.818 3.313c1.1.176 2.11.678 2.894 1.43 1.096 1.053 1.668 2.368 1.672 3.86 0 1.555-.576 2.867-1.739 3.967-.505.478-1.433 1.003-2.114 1.195-1.864.536-3.834.054-5.213-1.27-1.096-1.053-1.668-2.368-1.672-3.86 0-.87.16-1.59.529-2.346.78-1.594 2.232-2.674 3.998-2.972.423-.074 1.214-.074 1.645-.004Zm6.74 1.465c.496.227.54.94.07 1.206-.141.082-.204.09-.752.09-.674 0-.783-.028-.975-.247a.667.667 0 0 1 .239-1.05c.133-.058.258-.074.708-.074.45 0 .576.016.71.075Z"
                    fill="#497aac" fill-rule="evenodd" data-name="Path 29133" />
                <path
                    d="M81.483 147.661c-.967.176-1.86.87-2.248 1.75-.188.423-.262.842-.238 1.363.039.963.458 1.75 1.221 2.299a3.04 3.04 0 0 0 4.34-.834c.563-.881.61-2.076.117-3.016a3.092 3.092 0 0 0-1.167-1.21 3.855 3.855 0 0 0-.568-.234c-.31-.106-.439-.13-.822-.141a4.523 4.523 0 0 0-.635.023Z"
                    fill="#497aac" fill-rule="evenodd" data-name="Path 29134" />
            </g>
        </svg>

    </a>
    <img src="{{ asset($gallery->gallery_cover) }}" alt="Gallery Cover" class="img-fluid">


</div>


<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myLargeModalLabel">Large modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('Broker.Gallery.update-cover') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="gallery_id" value="{{ $gallery->id }}">
                    <input type="file" name="gallery_cover">
                    <button type="submit" class="btn btn-primary">تحديث الصورة</button>
                </form>
            </div>
        </div>
    </div>
</div>
