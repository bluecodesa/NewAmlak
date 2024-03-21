<div class="tab-pane fade" id="v-pills-List" role="tabpanel" aria-labelledby="v-pills-List-tab">
    <div class="row">
            @foreach ($units as $index => $unit)
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('Residential number') }}: {{ $unit->number_unit ?? '' }}</h5>
                        <p class="card-text">{{ __('الاشغال') }}: الاشغال</p>
                        <p class="card-text">{{ __('Ad type') }}: {{ __($unit->type) ?? '' }}</p>
                        <p class="card-text">{{ __('city') }}: {{ $unit->CityData->name ?? '' }}</p>
                        <p class="card-text">{{ __('Show in Gallery') }}: {{ $unit->show_gallery == 1 ? __('Show') : __('hide') }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a class="share btn btn-outline-secondary btn-sm waves-effect waves-light" data-toggle="modal" data-target="#shareLinkUnit{{ $unit->id }}"
                                    href="" onclick="document.querySelector('#shareLinkUnit{{ $unit->id }} ul.share-tabs.nav.nav-tabs li:first-child a').click()">
                                    @lang('Share')</a>

                                    <a href="{{ route('Broker.Gallery.show', $unit->id) }}" class="btn btn-sm btn-outline-warning">@lang('Show')</a>

                                <a href="{{ route('Broker.Unit.edit', $unit->id) }}"
                                    class="btn btn-outline-info btn-sm waves-effect waves-light">@lang('Edit')</a>

                                <a href="javascript:void(0);"
                                    onclick="handleDelete('{{ $unit->id }}')"
                                    class="btn btn-outline-danger btn-sm waves-effect waves-light delete-btn">@lang('Delete')</a>
                                <form id="delete-form-{{ $unit->id }}"
                                    action="{{ route('Broker.Unit.destroy', $unit->id) }}"
                                    method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                            <small class="text-muted">{{ $index + 1 }}</small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
    </div>


    @include('Broker.Gallary.inc._shareGallery')
</div>

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
</div>

