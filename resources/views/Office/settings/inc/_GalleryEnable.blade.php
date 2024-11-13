{{-- (in_array('Realestate-gallery', $sectionNames) || in_array('المعرض العقاري', $sectionNames)) --}}
{{-- @php
$sectionsIds = Auth::user()
    ->UserBrokerData->UserSubscription->SubscriptionSectionData->pluck('section_id')
    ->toArray();
@endphp --}}
@php
    $sectionsIds = Auth::user()
        ->UserOfficeData->UserSubscription->SubscriptionSectionData->pluck('section_id')
        ->toArray();
        dd($sectionsIds);
@endphp
@if (in_array(18, $sectionsIds))

<div class="tab-pane fade" id="v-pills-gallary" role="tabpanel" aria-labelledby="v-pills-gallary-tab">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card timeline shadow">
                    <div class="card-header">
                        <h5 class="card-title">@lang('Activation')</h5>
                        <label for="editGalleryName">@lang('Activate the gallery')</label>
                        <input type="checkbox" class="toggleHomePage gallery_status" name="gallery_status"
                            value="0" data-toggle="toggle" data-onstyle="primary">
                    </div>
                    <div class="card-body">
                        <form action="{{ route('Office.Gallery.create') }}" method="post" id="galleryForm">
                            @csrf
                            <input type="hidden" name="broker_id"
                                value="{{ auth()->user()->broker ? auth()->user()->broker->id : '' }}">
                            <div class="form-group">
                                <label for="galleryName">@lang('Gallery Name')</label>
                                <input type="text" class="form-control @error('gallery_name') is-invalid @enderror"
                                    id="galleryName" name="gallery_name"
                                    value="{{ old('gallery_name', explode('@', auth()->user()->email)[0]) }}" required>
                                @error('gallery_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" id="submitBtn" class="btn btn-primary">@lang('save')</button>
                            <button type="button" class="btn btn-light">@lang('Cancel')</button>
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
                        {{-- <form action="{{ route('Broker.Gallery.create') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-primary">@lang(' ترقيه الاشتراك')</button>
                        </form> --}}
                        <a href="{{ route('Office.ShowSubscription') }}" type="submit" class="btn btn-primary">@lang(' ترقيه الاشتراك')</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
<script>
