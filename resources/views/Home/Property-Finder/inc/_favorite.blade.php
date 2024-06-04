


      <!-- Teams Cards -->
      <div class="row g-4">
        {{-- <div class="col-xl-4 col-lg-6 col-md-6"> --}}
            {{-- <div class="card">
              <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                  <a href="javascript:;" class="d-flex align-items-center">
                    <div class="avatar me-2">
                      <img
                        src="../../assets/img/icons/brands/react-label.png"
                        alt="Avatar"
                        class="rounded-circle" />
                    </div>
                    <div class="me-2 text-body h5 mb-0">React Developers</div>
                  </a>
                  <div class="ms-auto">
                    <ul class="list-inline mb-0 d-flex align-items-center">
                      <li class="list-inline-item me-0">
                        <a href="javascript:void(0);" class="d-flex align-self-center text-body"
                          ><i class="ti ti-star text-muted me-1"></i
                        ></a>
                      </li>
                      <li class="list-inline-item">
                        <div class="dropdown">
                          <button
                            type="button"
                            class="btn dropdown-toggle hide-arrow p-0"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="ti ti-dots-vertical text-muted"></i>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="javascript:void(0);">Rename Team</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">View Details</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">Add to favorites</a></li>
                            <li>
                              <hr class="dropdown-divider" />
                            </li>
                            <li>
                              <a class="dropdown-item text-danger" href="javascript:void(0);">Delete Team</a>
                            </li>
                          </ul>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
                <p class="mb-3">
                  We don’t make assumptions about the rest of your technology stack, so you can develop new
                  features in React.
                </p>
                <div class="d-flex align-items-center pt-1">
                  <div class="d-flex align-items-center">
                    <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                      <li
                        data-bs-toggle="tooltip"
                        data-popup="tooltip-custom"
                        data-bs-placement="top"
                        title="Vinnie Mostowy"
                        class="avatar avatar-sm pull-up">
                        <img class="rounded-circle" src="../../assets/img/avatars/5.png" alt="Avatar" />
                      </li>
                      <li
                        data-bs-toggle="tooltip"
                        data-popup="tooltip-custom"
                        data-bs-placement="top"
                        title="Allen Rieske"
                        class="avatar avatar-sm pull-up">
                        <img class="rounded-circle" src="../../assets/img/avatars/12.png" alt="Avatar" />
                      </li>
                      <li
                        data-bs-toggle="tooltip"
                        data-popup="tooltip-custom"
                        data-bs-placement="top"
                        title="Julee Rossignol"
                        class="avatar avatar-sm pull-up">
                        <img class="rounded-circle" src="../../assets/img/avatars/6.png" alt="Avatar" />
                      </li>
                      <li class="avatar avatar-sm">
                        <span
                          class="avatar-initial rounded-circle pull-up"
                          data-bs-toggle="tooltip"
                          data-bs-placement="top"
                          title="8 more"
                          >+8</span
                        >
                      </li>
                    </ul>
                  </div>
                  <div class="ms-auto">
                    <a href="javascript:;" class="me-2"><span class="badge bg-label-primary">React</span></a>
                    <a href="javascript:;"><span class="badge bg-label-warning">Vue.JS</span></a>
                  </div>
                </div>
              </div>
            </div>
        </div> --}}
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
                    {{-- <a class="btn btn-label-secondary btn-icon d-flex align-items-center me-3"
                    data-bs-toggle="modal"
                    data-bs-target="#basicModal"
                    data-unit-id="{{ $unit->id }}"
                    data-user-id="{{ $unit->BrokerData->user_id }}"
                    >
                    <i class="ti ti-heart ti-sm"></i>
                    </a> --}}

                    @if(auth()->user()->is_property_finder)
                        @php
                        $isFavorite = App\Models\FavoriteUnit::where('unit_id', $unit->id)
                        ->where('finder_id', auth()->user()->id)
                        ->exists();
                        @endphp

                        @if($isFavorite)
                        <form method="POST" action="{{ route('remove-from-favorites') }}">
                            @csrf
                            <button type="submit" class="btn btn-label-secondary btn-icon d-flex align-items-center me-3">
                            <i class="ti ti-heart ti-sm bg-danger"></i>
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
                    <a href="tel:+{{ $broker->key_phone }} {{$broker->mobile }}" target="_blank" class="btn btn-primary d-flex align-items-center me-3"
                    ><i class="ti-xs me-1 ti ti-phone me-1"></i>@lang('تواصل')</a
                    >
                    <a href="https://web.whatsapp.com/send?phone=tel:+{{ $broker->key_phone }} {{ $broker->mobile}}" target="_blank" class="btn btn-label-secondary btn-icon"
                    ><i class="ti ti-message ti-sm"></i
                    ></a>
                </div> --}}
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
