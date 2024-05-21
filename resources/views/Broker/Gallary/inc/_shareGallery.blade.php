@foreach ($units as $index => $unit)
    <div class="modal fade" id="addNewCCModal_{{ $unit->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center">
                        <h3 class="mb-2">@lang('Share the unit')</h3>
                    </div>


                    <div class="card text-center mb-3 shadow-none bg-transparent">
                        <div class="card-header pt-0">
                            <ul class="nav nav-tabs card-header-tabs row" role="tablist">
                                <li class="nav-item col" role="presentation">
                                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-within-card-active_{{ $unit->id }}"
                                        aria-controls="navs-within-card-active_{{ $unit->id }}"
                                        aria-selected="true">
                                        @lang('Qr Code')
                                    </button>
                                </li>
                                <li class="nav-item col" role="presentation">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-within-card-link_{{ $unit->id }}"
                                        aria-controls="navs-within-card-link_{{ $unit->id }}" aria-selected="false"
                                        tabindex="-1">
                                        @lang('Share')
                                    </button>
                                </li>

                            </ul>
                        </div>
                        <div class="card-body p-0">
                            <div class="tab-content p-0 pt-4">
                                <div class="tab-pane fade active show" id="navs-within-card-active_{{ $unit->id }}"
                                    role="tabpanel">
                                    <div class="alert alert-primary" role="alert">
                                        @lang('Download the code so that you can share it with your friends so that they can access this property’s data via mobile phone')
                                    </div>
                                    <div class="col-12">
                                        {{ \QrCode::size(150)->style('dot')->eye('circle')->color(40, 199, 111)->margin(1)->generate(route('gallery.showUnitPublic', ['gallery_name' => $gallery->gallery_name, 'id' => $unit->id])) }}
                                    </div>
                                    <div class="col-12" style="">


                                        @php
                                            $url = "route('gallery.showUnitPublic', ['gallery_name' => $gallery->gallery_name, 'id' => $unit->id])";
                                        @endphp
                                        <br>
                                        <a
                                            href="{{ route('download.qrcode', ['link' => $url]) }}"class="btn-sm btn btn-success">@lang('Download')
                                            @lang('Qr Code')</a>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="navs-within-card-link_{{ $unit->id }}"
                                    role="tabpanel">
                                    <h6>@lang('Share the link')</h6>
                                    <p>@lang('Share the property link or copy it on your site')</p>
                                    <div class="input-group">

                                        <span onclick="copyToClipboard(this)"
                                            data-url="{{ route('gallery.showUnitPublic', ['gallery_name' => $gallery->gallery_name, 'id' => $unit->id]) }}"
                                            class="input-group-text" id="basic-addon11"><i
                                                class="tf-icons ti ti-copy"></i></span>

                                        <input type="text" class="form-control" readonly
                                            id="galleryNameCopy_{{ $unit->id }}"
                                            value="{{ route('gallery.showUnitPublic', ['gallery_name' => $gallery->gallery_name, 'id' => $unit->id]) }}"
                                            placeholder="Username" aria-label="Username"
                                            aria-describedby="basic-addon11">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function trimInput(input) {
            input.value = input.value.trim();
        }

        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).data('url')).select();
            document.execCommand("copy");
            $temp.remove();
            alertify.success(@json(__('copy done')));
        }
    </script>
@endforeach
