

<div class="modal fade" id="twoFactorAuth" tabindex="-1" aria-hidden="true">
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
                          <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-within-card-active_{{ $Unit->id }}" aria-controls="navs-within-card-active_{{ $Unit->id }}" aria-selected="true">
                            @lang('Qr Code')
                          </button>
                        </li>
                        <li class="nav-item col" role="presentation">
                          <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-within-card-link_{{ $Unit->id }}" aria-controls="navs-within-card-link_{{ $Unit->id }}" aria-selected="false" tabindex="-1">
                            @lang('Share')
                          </button>
                        </li>

                      </ul>
                    </div>
                    <div class="card-body p-0">
                      <div class="tab-content p-0 pt-4">
                        <div class="tab-pane fade active show" id="navs-within-card-active_{{ $Unit->id }}" role="tabpanel">
                            <div class="alert alert-primary" role="alert">
                                @lang('Download the code so that you can share it with your friends so that they can access this property’s data via mobile phone')
                            </div>
                            <div class="col-12">
                                {{ \QrCode::size(150)->style('dot')->eye('circle')->color(40, 199, 111)->margin(1)->generate(route('gallery.showUnitPublic', ['gallery_name' => $gallery->gallery_name, 'id' => $Unit->id])) }}
                            </div>
                            <div class="col-12" style="">


                                @php
                                    $url = "route('gallery.showUnitPublic', ['gallery_name' => $gallery->gallery_name, 'id' => $Unit->id])";
                                @endphp
                                <br>
                                <a href="{{ route('download.qrcode', ['link' => $url]) }}"class="btn-sm btn btn-success">@lang('Download')
                                    @lang('Qr Code')</a>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="navs-within-card-link_{{ $Unit->id }}" role="tabpanel">
                            <h6>@lang('Share the link')</h6>
                            <p>@lang('Share the property link or copy it on your site')</p>
                            {{-- <div class="input-group">
                                <span onclick="copyUrl()" data-url="{{ route('gallery.showUnitPublic', ['gallery_name' => $gallery->gallery_name, 'id' => $Unit->id]) }}" class="input-group-text" id="basic-addon11"><i class="tf-icons ti ti-copy"></i></span>
                                <input type="text" class="form-control" readonly value="{{ route('gallery.showUnitPublic', ['gallery_name' => $gallery->gallery_name, 'id' => $Unit->id]) }}" placeholder="Username" aria-label="Username" aria-describedby="basic-addon11">
                              </div> --}}
                              <div class="input-group">
                                <input type="text" class="form-control galleryNameCopy" readonly
                                    value="{{ route('gallery.showUnitPublic', ['gallery_name' => $gallery->gallery_name, 'id' => $Unit->id]) }}">
                                <button onclick="copyToClipboard('.galleryNameCopy')"
                                    class="btn btn-outline-primary waves-effect" type="button">
                                    <i class="ti ti-copy"></i>
                                </button>
                            </div>

                        </div>
                      </div>
                    </div>
                  </div>
            </div>
        </div>
    </div>
</div>


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
