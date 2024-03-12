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
                                <button type="button" class="btn btn-sm btn-outline-secondary">@lang('Share')</button>
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


        {{-- <div class="col-md-6">

            <div class="card m-b-30">
                <div class="card-body">
                    <h4 class="card-title font-16 mt-0">الوحده</h4>
                    <h6 class="card-subtitle font-14 text-muted">Support card subtitle</h6>
                </div>
                <img class="img-fluid" src="assets/images/small/img-4.jpg" alt="Card image cap">
                <div class="card-body">
                    <p class="card-text">Some quick example text to build on the card title and make
                        up the bulk of the card's content.</p>
                    <a href="#" class="card-link">عرض</a>
                    <a href="#" class="card-link">Another link</a>
                </div>
            </div>

        </div><!-- end col --> --}}
</div>

</div>
