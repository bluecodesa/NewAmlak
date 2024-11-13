<div class="modal fade" id="onboardHorizontalImageModal{{ $unit->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
        <div class="modal-content">
            <div class="modal-body p-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center">
                    @php
                        $isGalleryUnit = isset($unit->isGalleryUnit) && $unit->isGalleryUnit;
                        $isGalleryProject = isset($unit->isGalleryProject) && $unit->isGalleryProject;
                        $isGalleryProperty = isset($unit->isGalleryProperty) && $unit->isGalleryProperty;
                        $shareLabel = $isGalleryUnit ? 'Unit' : ($isGalleryProject ? 'Project' : ($isGalleryProperty ? 'Property' : 'Item'));
                        $routeName = $isGalleryUnit ? 'gallery.showUnitPublic' : ($isGalleryProject ? 'Home.showPublicProject' : 'Home.showPublicProperty');
                    @endphp
                    <h3 class="mb-2">@lang('Share the ' . $shareLabel)</h3>
                </div>

                <div class="card text-center mb-3 shadow-none bg-transparent">
                    <div class="card-header pt-0">
                        <ul class="nav nav-tabs card-header-tabs row" role="tablist">
                            <li class="nav-item col" role="presentation">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-within-card-active_{{ $unit->id }}"
                                    aria-controls="navs-within-card-active_{{ $unit->id }}" aria-selected="true">
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
                    @php
                            if( $unit->BrokerData){
                            $GalleryData= $unit->BrokerData->GalleryData;
                        }elseif( $unit->OfficeData){
                            $GalleryData= $unit->OfficeData->GalleryData;

                        }
                    @endphp
                    <div class="card-body p-0">
                        <div class="tab-content p-0 pt-4">
                            <div class="tab-pane fade active show" id="navs-within-card-active_{{ $unit->id }}" role="tabpanel">
                                <div class="alert alert-primary" role="alert">
                                    @lang('Download the code so that you can share it with your friends so that they can access this property’s data via mobile phone')
                                </div>
                                <div class="col-12">
                                    {{ \QrCode::size(150)->style('dot')->eye('circle')->color(40, 199, 111)->margin(1)->generate(route($routeName, ['gallery_name' => $GalleryData->gallery_name, 'id' => $unit->id])) }}
                                </div>
                                <div class="col-12" style="">
                                    @php
                                        $gallery_name = $GalleryData->gallery_name;
                                        $url = route($routeName, ['gallery_name' => $gallery_name, 'id' => $unit->id]);
                                    @endphp
                                    <br>
                                    <a href="{{ route('download.qrcode', ['link' => $url]) }}" class="btn-sm btn btn-success">
                                        @lang('Download') @lang('Qr Code')
                                    </a>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="navs-within-card-link_{{ $unit->id }}" role="tabpanel">
                                <h6>@lang('Share the link')</h6>
                                <p>@lang('Share the property link or copy it on your site')</p>
                                <div class="input-group">
                                    <input type="text" class="form-control galleryNameCopy" id="{{ 'galleryNameCopy_' . $unit->id }}" readonly
                                        value="{{ route($routeName, ['gallery_name' => $gallery_name, 'id' => $unit->id]) }}">
                                    <button onclick="copyToClipboard('galleryNameCopy_{{ $unit->id }}')" class="btn btn-outline-primary waves-effect" type="button">
                                        <i class="ti ti-copy"></i>
                                    </button>
                                    <button class="whatsapp-share-btn btn btn-outline-primary waves-effect" data-unit-id="{{ $unit->id }}" type="button">
                                        <i class="ti ti-brand-whatsapp"></i>
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
