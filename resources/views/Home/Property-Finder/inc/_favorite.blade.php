


      <!-- Teams Cards -->
      <div class="row g-4">

        @forelse ($units as $unit )

                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="card">
                <div class="card-body text-center">
                <div class="dropdown btn-pinned">

                    <span class="pb-1">{{ $unit->getRentPriceByType() }}
                        @lang('SAR') / {{ __($unit->rent_type_show) }}</span>

                </div>
                <div class="d-flex align-items-center justify-content-start">
                    <a  class="btn btn-label-secondary btn-icon d-flex align-items-center me-3"
                    data-bs-toggle="modal"
                    data-bs-target="#onboardHorizontalImageModal{{$unit->id}}"><i class="ti ti-share ti-sm"></i></a
                    >
                    @auth

                    @if(auth()->user()->is_property_finder)
                        @php
                        $isFavorite = App\Models\FavoriteUnit::where('unit_id', $unit->id)
                        ->where('finder_id', auth()->user()->id)
                        ->exists();
                        @endphp

                        @if($isFavorite)
                        <form method="POST" action="{{ route('remove-from-favorites') }}">
                            @csrf
                            <button type="submit" class="btn btn-label-danger btn-icon d-flex align-items-center me-3">
                            <i class="ti ti-heart ti-sm"></i>
                            </button>
                            <input type="hidden" name="unit_id" value="{{ $unit->id }}">
                        </form>
                        @else
                        <form method="POST" action="{{ route('add-to-favorites') }}">
                            @csrf
                            <button type="submit" class="btn btn-label-secondary btn-icon d-flex align-items-center me-3">
                            <i class="ti ti-heart ti-sm"></i>
                            </button>
                            <input type="hidden" name="unit_id" value="{{ $unit->id }}">
                            <input type="hidden" name="owner_id" value="{{$unit->BrokerData->user_id }}">
                        </form>
                        @endif

                    @endif
                    @endauth

                </div>
                <div class="mx-auto my-3">
                    {{-- <a href="{{ route('gallery.showUnitPublic', ['gallery_name' => $gallery->gallery_name, 'id' => $unit->id]) }}" class="card-hover-border-default"> --}}
                    @if ($unit->UnitImages->isNotEmpty())
                    <img src="{{ url($unit->UnitImages->first()->image) }}" alt="Avatar Image" class="rounded-square"  width="140"  height="140" />
                    @else
                    <img src="{{ url('Offices/Projects/default.svg') }}" alt="Avatar Image" class="rounded-square"  width="140"  height="140" />

                    @endif
                    </a>
                </div>
                <h4 class="mb-1 card-title">{{ $unit->number_unit ?? '' }}</h4>
                <div class="d-flex align-items-center justify-content-center my-3 gap-2">

                <span class="pb-1"><i class="ti ti-map-pin"></i>{{ $unit->CityData->name ?? '' }}</span>
                </div>
                <div class="d-flex align-items-center justify-content-center my-3 gap-2">

                    <a href="javascript:;"><span class="badge bg-label-primary"> {{ __($unit->PropertyTypeData->name) ?? '' }}</span></a>
                    @if ($unit->type == 'rent')
                    <a href="javascript:;"><span class="badge bg-label-warning">@lang('rent')</span></a>
                    @endif
                    @if ($unit->type == 'sale')
                    <a href="javascript:;"><span class="badge bg-label-success">@lang('sale')</span></a>
                    @endif

                    @if ($unit->type == 'rent and sale')
                    <a href="javascript:;"><span class="badge bg-label-info">@lang('rent and sale')</span></a>
                    @endif
                    <a href="javascript:;" class="me-1"
                    style="
                    @if (!$unit->daily_rent ) visibility:hidden @endif">
                    <span class="badge bg-label-secondary">متاح @lang('Daily Rent')</span></a>
                </div>

                <div class="d-flex align-items-center justify-content-around my-3 py-1">
                    <div>
                    <h4 class="mb-0">{{ $unit->rooms }}</h4>
                    <span>@lang('number rooms')</span>
                    </div>
                    <div>
                    <h4 class="mb-0">{{ $unit->bathrooms }}</h4>
                    <span>@lang('Number bathrooms')</span>
                    </div>
                    <div>
                    <h4 class="mb-0">{{ $unit->space }}</h4>
                    <span>@lang('Area (square metres)')</span>
                    </div>
                    <div>
                        <h4 class="mb-0">{{ $unitVisitorsCount[$unit->id] ?? 0 }}</h4>
                        <span>@lang('Views')</span>
                    </div>
                </div>

                {{-- <div class="d-flex align-items-center justify-content-center">
                    <a href="tel:+{{ $unit->BrokerData->key_phone }} {{$unit->BrokerData->mobile }}" target="_blank" class="btn btn-primary d-flex align-items-center me-3"
                    ><i class="ti-xs me-1 ti ti-phone me-1"></i>@lang('تواصل')</a
                    >
                    <a href="https://web.whatsapp.com/send?phone=tel:+{{ $unit->BrokerData->key_phone }} {{ $unit->BrokerData->mobile}}" target="_blank" class="btn btn-label-secondary btn-icon"
                    ><i class="ti ti-message ti-sm"></i
                    ></a>
                </div> --}}

                <div class="d-flex align-items-center justify-content-center">
                    @if (Auth::user()->hasPermission('Show-broker-phone') || Auth::user()->hasPermission('Show-broker-phone-admin'))
                    <a href="tel:+{{ $unit->BrokerData->key_phone }} {{$unit->BrokerData->mobile }}" target="_blank" class="btn btn-primary d-flex align-items-center me-3"
                        ><i class="ti-xs me-1 ti ti-phone me-1"></i>@lang('تواصل')</a>
                      @else
                      <a @disabled(true) target="_blank" class="btn btn-primary d-flex align-items-center me-3"
                        ><i class="ti-xs me-1 ti ti-phone me-1"></i>@lang('تواصل')</a>
                    @endif
                    @if (Auth::user()->hasPermission('Send-message-to-broker') || Auth::user()->hasPermission('Send-message-to-broker-admin'))
                    <a href="https://web.whatsapp.com/send?phone=tel:+{{ $unit->BrokerData->key_phone }} {{ $unit->BrokerData->mobile}}" target="_blank" class="btn btn-label-secondary btn-icon"
                        ><i class="ti ti-message ti-sm"></i
                    ></a>
                    @else
                    <a @disabled(true) target="_blank" class="btn btn-label-secondary btn-icon"
                        ><i class="ti ti-message ti-sm"></i
                      ></a>
                    @endif
                  </div> 

                </div>
            </div>
            </div>
        @empty
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <span class="alert-icon text-danger me-2">
                <i class="ti ti-ban ti-xs"></i>
            </span>
            @lang('No Data Found!')
        </div>
        @endforelse


      </div>
      <!--/ Teams Cards -->
