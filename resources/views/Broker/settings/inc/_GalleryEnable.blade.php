
                                                @if (in_array('Realestate-gallery', $sectionNames) || in_array('المعرض العقاري', $sectionNames))
                                                <div class="tab-pane fade" id="v-pills-gallary" role="tabpanel" aria-labelledby="v-pills-gallary-tab">
                                                    <div class="row justify-content-center">
                                                        <div class="col-lg-10">
                                                            <div class="card timeline shadow">
                                                                <div class="card-header">
                                                                    <h5 class="card-title">@lang('التفعيل')</h5>
                                                                    <label for="editGalleryName">@lang('تفعيل المعرض')</label>
                                                                    <input type="checkbox" class="toggleHomePage gallery_status" name="gallery_status" value="0"  data-toggle="toggle" data-onstyle="primary">

                                                                </div>
                                                                <div class="card-body">
                                                                    <form action="{{ route('Broker.Gallery.create')}}" method="post">
                                                                        @csrf

                                                                        <input type="hidden" name="gallery_name" value="{{ explode('@', auth()->user()->email)[0] }}">
                                                                        <input type="hidden" name="broker_id" value="{{ auth()->user()->broker ? auth()->user()->broker->id : '' }}">
                                                                        <button type="submit" class="btn btn-primary">@lang('save')</button>
                                                                        <button type="submit" class="btn btn-light">@lang('Cancel')</button>

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
                                                            <div class="card timeline shadow">
                                                                <div class="card-header">
                                                                    <h5 class="card-title">@lang('لا يوجد معرض')</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <p>@lang(' الاشتراك الحالي لا يحتوي ع المعرض ')</p>
                                                                    <form action="{{ route('Broker.Gallery.create')}}" method="post">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-primary">@lang(' ترقيه الاشتراك')</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
