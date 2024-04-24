@foreach ($units as $index => $unit)
    <div class="modal fade" id="shareLinkUnit{{ $unit->id }}" tabindex="-1" role="dialog"
        aria-labelledby="shareLinkTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6>مشاركة الوحدة</h6>
                </div>
                <div class="modal-body share-divs">
                    <ul class="nav nav-pills nav-justified" role="tablist">
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-toggle="tab" href="#home_{{ $unit->id }}" role="tab"
                                aria-selected="false">
                                <span class="d-none d-md-block">Qr code</span><span class="d-block d-md-none"><i
                                        class="mdi mdi-home-variant h5"></i></span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link active" data-toggle="tab" href="#profile_{{ $unit->id }}"
                                role="tab" aria-selected="true">
                                <span class="d-none d-md-block">مشاركة</span><span class="d-block d-md-none"><i
                                        class="mdi mdi-account h5"></i></span>
                            </a>
                        </li>

                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane p-3" id="home_{{ $unit->id }}" role="tabpanel">
                            <div class="row pb-5 pt-4 flex-nowrap align-items-center">
                                <div class="w-auto col-3">
                                    {{ \QrCode::size(150)->style('dot')->eye('circle')->color(40, 199, 111)->margin(1)->generate(route('gallery.showUnitPublic', ['gallery_name' => $gallery->gallery_name, 'id' => $unit->id])) }}
                                </div>
                                <div class="col-9 gap-4" style="flex: auto;flex-direction:column">
                                    <p>قم بتحميل الكود لكي تستطيع مشاركته مع اصدقائك لكي يمكنهم الوصول الي بيانات هذا
                                        العقار
                                        عن طريق الجوال
                                    </p>
                                    @php
                                        $url = "route('gallery.showUnitPublic', ['gallery_name' => $gallery->gallery_name, 'id' => $unit->id])";
                                    @endphp
                                    <br>
                                    <a href="{{ route('download.qrcode', ['link' => $url]) }}"
                                        class="d-block btn btn-new-b btn-dark btn-sm mt-3"
                                        style="width: fit-content">Download
                                        QR
                                        Code</a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane p-3 active" id="profile_{{ $unit->id }}" role="tabpanel">
                            <h6>مشاركة الرابط</h6>
                            <p>مشاركة لينك العقار او انسخه في موقعك</p>
                            <div class="row link justify-content-between">
                                <div class="w-auto" onclick="copy()" style="cursor: pointer"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="20.782" height="30.633"
                                        viewBox="1039.055 450.797 19.891 24.817">
                                        <!-- SVG content for copying link -->
                                    </svg></div>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="galleryName" disabled
                                        value="{{ route('gallery.showUnitPublic', ['gallery_name' => $gallery->gallery_name, 'id' => $unit->id]) }}" />
                                    <div class="input-group-append">
                                        <span class="input-group-text" style="cursor: pointer;" onclick="selectText()">
                                            <i class="fas fa-copy"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            {{--  --}}

                        </div>

                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endforeach

<script>
    function toggleShare(type) {
        if (type === 'share-link') {
            document.getElementById('share-link').style.display = 'block';
            document.getElementById('qr-code').style.display = 'none';
        } else if (type === 'qr-code') {
            document.getElementById('share-link').style.display = 'none';
            document.getElementById('qr-code').style.display = 'block';
        }
    }
</script>
