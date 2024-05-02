<form action="{{ route('Broker.Gallery.update-cover') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="col-12">
        <div class="form-group">
            <label for="images">@lang('Image')</label>
            <div class="upload__box d-flex">
                <div class="upload__btn-box">
                    <input type="file" id="images" name="gallery_cover" class="upload__inputfile" required accept="image/jpeg, image/png, image/jpg">
                </div>
            </div>
        </div>
    </div>
    <div>
        <button class="btn btn-dark-canvas btn-sm " type="submit">@lang('save')</button>
    </div>
</form>

@push('other-scripts')
    <script>
         var global_files = new DataTransfer();
    var iterator = 0;

        function saveImages() {
            document.getElementById("images").files = global_files.files;
        }

        $(document).ready(function() {

            ImgUpload();

        });

        function removeFile(index) {
            document.getElementById("images").files = global_files.files;
            var attachments = document.getElementById("images").files; // <-- reference your file input here
            var fileBuffer = new DataTransfer();

            for (let i = 0; i < attachments.length; i++) {
                if (index !== i)
                    fileBuffer.items.add(attachments[i]);
            }
            document.querySelector(`.delete-uploadimg[index="${index}"]`).parentNode.remove();
            document.getElementById("images").files = fileBuffer.files; // <-- according to your file input reference
            global_files.items.remove(index);
        }

        function ImgUpload() {
            var imgWrap = "";
            var imgArray = [];

            $('.upload__inputfile').each(function() {
                $(this).on('change', function(e) {

                    let files_sm = document.getElementById("images").files;
                    for (let i = 0; i < files_sm.length; i++) {
                        global_files.items.add(files_sm[i]);
                    }

                    //  console.log(document.getElementById("images").files);
                    imgWrap = $(this).closest('.upload__box');

                    if(document.querySelector('.upload__img-box'))
                    document.querySelector('.upload__img-box').remove();


                    var files = e.target.files;
                    var filesArr = Array.prototype.slice.call(files);
                    filesArr.forEach(function(f, index) {

                        if (!f.type.match('image.*')) {
                            return;
                        }


                        var len = 0;
                        for (var i = 0; i <imgArray.length; i++) {
                            if (imgArray[i] !== undefined) {
                                len++;
                            }
                        }

                        imgArray.push(f);

                        var reader = new FileReader();
                        reader.onload = function(e) {
                            var html =
                                "<div class='upload__img-box'><div class='delete-uploadimg' index ='" +
                                iterator + "' onclick='removeFile(" + iterator +
                                ")'><img src='/dashboard/assets/new-icons/del.png' style='width: 27px;height: fit-content;' class='p-0'></div><div style='background-image: url(" +
                                e.target.result + ")' data-number='" + $(
                                    ".upload__img-close").length + "' data-file='" + f
                                .name +
                                "' class='img-bg'></div></div>";
                            imgWrap.append(html);
                            iterator++;
                        }
                        reader.readAsDataURL(f);

                        // document.getElementById("images").files = global_files;

                    });
                });
            });
        }
    </script>
@endpush
