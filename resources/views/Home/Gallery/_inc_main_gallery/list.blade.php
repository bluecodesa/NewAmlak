<div class="row g-4">
    @foreach ($allItems as $index => $unit)

        @php
            // $falLicenseUser = $unit->BrokerData->UserData->UserFalData;

            if ($unit->BrokerData) {
                $falLicenseUser = $unit->BrokerData->UserData->UserFalData;
            } elseif ($unit->OfficeData) {
                $falLicenseUser = $unit->OfficeData->UserData->UserFalData;
            }

        @endphp

        @if (
            $falLicenseUser &&
                $falLicenseUser->ad_license_status == 'valid' &&
                $falLicenseUser->falData->for_gallery == 1 &&
                $unit->ad_license_status == 'Valid')
            {{-- @if ($falLicenseUser && $falLicenseUser->ad_license_status == 'valid' && $unit->ad_license_status == 'Valid') --}}

            {{-- @if ($unit->BrokerData->license_validity == 'valid' && $unit->ad_license_status == 'Valid') --}}
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card h-200">
                    <div class="card-body text-center">
                        <div class="dropdown btn-pinned">
                            @if (isset($unit->isGalleryUnit) && $unit->isGalleryUnit)
                                @if ($unit->type == 'rent')
                                    @if ($unit->getRentPriceByType())
                                        <span class="pb-1">
                                            {{ $unit->getRentPriceByType() }} @lang('SAR') /
                                            {{ __($unit->rent_type_show) }}
                                        </span>
                                    @endif
                                @elseif ($unit->type == 'sale')
                                    @if ($unit->price)
                                        {{ $unit->price }} @lang('SAR')
                                    @endif
                                @else
                                    @if ($unit->getRentPriceByType())
                                        <span class="pb-1">
                                            {{ $unit->getRentPriceByType() }} @lang('SAR') /
                                            {{ __($unit->rent_type_show) }}
                                        </span>
                                    @elseif ($unit->price)
                                        {{ $unit->price }} @lang('SAR')
                                    @endif
                                @endif
                            @endif

                        </div>
                        <div class="d-flex align-items-center justify-content-start">
                            <a class="btn btn-label-secondary btn-icon d-flex align-items-center me-3"
                                data-bs-toggle="modal"
                                data-bs-target="#onboardHorizontalImageModal{{ $unit->id }}"><i
                                    class="ti ti-share ti-sm"></i></a>
                            @guest

                                {{-- <a class="btn btn-label-secondary btn-icon d-flex align-items-center me-3"
                                            data-bs-toggle="modal" data-bs-target="#modalToggle">
                                            <i class="ti ti-heart ti-sm"></i>

                                        </a> --}}

                                <a class="btn btn-label-secondary btn-icon d-flex align-items-center me-3"
                                    href="{{ route('login') }}">
                                    <i class="ti ti-heart ti-sm"></i>

                                </a>
                                {{--
                                <a class=" d-flex align-items-center me-3"
                                href="{{ route('login') }}">
                                <i class="ti ti-report ti-sm"></i>
                                    @lang('الابلاغ عن الاعلان')
                                </a> --}}

                            @endguest
                            @php
                                $isGalleryUnit = isset($unit->isGalleryUnit) && $unit->isGalleryUnit;
                                $isGalleryProject =
                                    isset($unit->isGalleryProject) && $unit->isGalleryProject;
                                $isGalleryProperty =
                                    isset($unit->isGalleryProperty) && $unit->isGalleryProperty;
                            @endphp

                            @auth
                                @if (auth()->user())
                                    @php
                                        $isFavorite = App\Models\FavoriteUnit::where(
                                            'finder_id',
                                            auth()->user()->id,
                                        )
                                            ->where(function ($query) use ($unit) {
                                                $query
                                                    ->where('unit_id', $unit->id)
                                                    ->orWhere('property_id', $unit->id)
                                                    ->orWhere('project_id', $unit->id);
                                            })
                                            ->exists();

                                        // Determine the type (unit, property, or project)
                                        $type = $isGalleryUnit
                                            ? 'unit'
                                            : ($isGalleryProject
                                                ? 'project'
                                                : ($isGalleryProperty
                                                    ? 'property'
                                                    : ''));
                                    @endphp

                                    @if (Auth::user()->hasPermission('Add-property-as-favorite') ||
                                            Auth::user()->hasPermission('Add-property-as-favorite-admin'))
                                        @if ($isFavorite)
                                            <form method="POST" action="{{ route('remove-from-favorites') }}">
                                                @csrf
                                                <button type="submit"
                                                    class="btn btn-label-danger btn-icon d-flex align-items-center me-3">
                                                    <i class="ti ti-heart ti-sm"></i>
                                                </button>
                                                <input type="hidden" name="unit_id"
                                                    value="{{ $unit->id }}">
                                                <!-- Send the type as hidden input -->
                                                <input type="hidden" name="type"
                                                    value="{{ $type }}">
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('add-to-favorites') }}">
                                                @csrf
                                                <button type="submit"
                                                    class="btn btn-label-secondary btn-icon d-flex align-items-center me-3">
                                                    <i class="ti ti-heart ti-sm"></i>
                                                </button>
                                                <input type="hidden" name="unit_id"
                                                    value="{{ $unit->id }}">
                                                {{-- <input type="hidden" name="owner_id"
                                                    value="{{ $unit->BrokerData->user_id }}"> --}}
                                                    @php

                                                    $ownerId = null;
                                                    if ($unit->BrokerData) {
                                                        $ownerId = $unit->BrokerData->user_id;
                                                    } elseif ($unit->OfficeData) {
                                                        $ownerId = $unit->OfficeData->user_id;
                                                    }
                                                    @endphp

                                                <input type="hidden" name="owner_id" value="{{ $ownerId }}">

                                                <!-- Send type as hidden input -->
                                                <input type="hidden" name="type"
                                                    value="{{ $type }}">
                                            </form>
                                        @endif
                                    @endif
                                @else
                                    <a class="btn btn-label-secondary btn-icon d-flex align-items-center me-3"
                                        data-bs-toggle="modal" data-bs-target="#basicModal"
                                        data-unit-id="{{ $unit->id }}"
                                        data-user-id="{{ $unit->BrokerData->user_id }}">
                                        <i class="ti ti-heart ti-sm"></i>
                                    </a>
                                @endif

                                {{-- <a class=" d-flex align-items-center me-3"
                                href="" data-bs-toggle="modal"
                                data-bs-target="#modalReport" >
                                <i class="ti ti-report ti-sm"></i>
                                    @lang('الابلاغ عن الاعلان')
                                </a> --}}
                            @endauth

                        </div>
                        <div class="mx-auto my-3">
                            @php

                                $isGalleryUnit = isset($unit->isGalleryUnit) && $unit->isGalleryUnit;
                                $isGalleryProject =
                                    isset($unit->isGalleryProject) && $unit->isGalleryProject;
                                $isGalleryProperty =
                                    isset($unit->isGalleryProperty) && $unit->isGalleryProperty;

                                if( $unit->BrokerData){
                                   $GalleryData= $unit->BrokerData->GalleryData;
                                }elseif( $unit->OfficeData){
                                   $GalleryData= $unit->OfficeData->GalleryData;

                                }
                            @endphp

                            @if ($isGalleryUnit)
                                <a href="{{ route('gallery.showUnitPublic', [
                                    'gallery_name' => optional($GalleryData)->gallery_name,
                                    'id' => $unit->id,
                                ]) }}"
                                    class="card-hover-border-default">
                                @elseif ($isGalleryProject)
                                    <a href="{{ route('Home.showPublicProject', [
                                        'gallery_name' => optional($GalleryData)->gallery_name,
                                        'id' => $unit->id,
                                    ]) }}"
                                        class="card-hover-border-default">
                                    @elseif ($isGalleryProperty)
                                        <a href="{{ route('Home.showPublicProperty', [
                                            'gallery_name' => optional($GalleryData)->gallery_name,
                                            'id' => $unit->id,
                                        ]) }}"
                                            class="card-hover-border-default">
                            @endif

                            <div class="image-container"
                                style="position: relative; width: 100%; height: 200px;">
                                @if ($unit->UnitImages && $unit->UnitImages->isNotEmpty())
                                    <img src="{{ url($unit->UnitImages->first()->image) }}"
                                        alt="Avatar Image" class="rounded-square"
                                        style="width: 100%; height: 100%;" />
                                @elseif ($unit->ProjectImages && $unit->ProjectImages->isNotEmpty())
                                    <img src="{{ url($unit->ProjectImages->first()->image) }}"
                                        alt="Avatar Image" class="rounded-square"
                                        style="width: 100%; height: 100%;" />
                                @elseif ($unit->PropertyImages && $unit->PropertyImages->isNotEmpty())
                                    <img src="{{ url($unit->PropertyImages->first()->image) }}"
                                        alt="Avatar Image" class="rounded-square"
                                        style="width: 100%; height: 100%;" />
                                @else
                                    <img src="{{ url('Offices/Projects/default.svg') }}" alt="Avatar Image"
                                        class="rounded-square" style="width: 100%; height: 100%;" />
                                @endif
                                <div class="lable bg-label-primary"
                                    style="position: absolute; top: 10px; right: 10px; background: rgba(0, 0, 0, 0.5); color: white; padding: 5px; border-radius: 5px;">
                                    <small class="card-text text-uppercase">
                                        @lang('last update') {{ $unit->updated_at->diffForHumans() }}
                                    </small>
                                </div>
                                <div class="lable bg-label-primary"
                                    style="position: absolute; top: 10px; left: 10px; background: rgba(0, 0, 0, 0.5); color: white; padding: 5px; border-radius: 5px;">
                                    @if ($isGalleryUnit)
                                        @lang('Unit')
                                    @elseif ($isGalleryProject)
                                        @lang('Project')
                                    @elseif ($isGalleryProperty)
                                        @lang('property')
                                    @endif
                                </div>

                            </div>
                            </a>
                        </div>



                        <h4 class="mb-1 card-title">
                            @php
                                 if( $unit->BrokerData){
                                   $GalleryData= $unit->BrokerData->GalleryData;
                                }elseif( $unit->OfficeData){
                                   $GalleryData= $unit->OfficeData->GalleryData;

                                }
                            @endphp

                            @if ($isGalleryUnit)
                                <a href="{{ route('gallery.showUnitPublic', [
                                    'gallery_name' => optional($GalleryData)->gallery_name,
                                    'id' => $unit->id,
                                ]) }}"
                                    class="card-hover-border-default">{{ $unit->ad_name ?? ($unit->name ?? '') }}</a>
                            @elseif ($isGalleryProject)
                                <a href="{{ route('Home.showPublicProject', [
                                    'gallery_name' => optional($GalleryData)->gallery_name,
                                    'id' => $unit->id,
                                ]) }}"
                                    class="card-hover-border-default">{{ $unit->ad_name ?? ($unit->name ?? '') }}</a>
                            @elseif ($isGalleryProperty)
                                <a href="{{ route('Home.showPublicProperty', [
                                    'gallery_name' => optional($GalleryData)->gallery_name,
                                    'id' => $unit->id,
                                ]) }}"
                                    class="card-hover-border-default">{{ $unit->ad_name ?? ($unit->name ?? '') }}</a>
                            @endif


                        </h4>
                        <div class="d-flex align-items-center justify-content-center my-3 gap-2">

                            <span class="pb-1"><i
                                    class="ti ti-map-pin"></i>{{ $unit->CityData->name ?? '' }}</span>
                        </div>
                        @if (isset($unit->isGalleryUnit) && $unit->isGalleryUnit)
                            <div class="d-flex align-items-center justify-content-center my-3 gap-2">

                                <a href="javascript:;"><span class="badge bg-label-primary">
                                        {{ __($unit->PropertyTypeData->name) ?? '' }}</span></a>
                                @if ($unit->type == 'rent')
                                    <a href="javascript:;"><span
                                            class="badge bg-label-warning">@lang('rent')</span></a>
                                @endif
                                @if ($unit->type == 'sale')
                                    <a href="javascript:;"><span
                                            class="badge bg-label-success">@lang('sale')</span></a>
                                @endif

                                @if ($unit->type == 'rent and sale')
                                    <a href="javascript:;"><span
                                            class="badge bg-label-info">@lang('sale')</span></a>

                                    <a href="javascript:;"><span
                                            class="badge bg-label-warning">@lang('rent')</span></a>
                                @endif
                                @if ($unit->daily_rent)
                                    <a href="javascript:;" class="me-1">
                                        <span class="badge bg-label-secondary">متاح
                                            @lang('Daily Rent')</span></a>
                                @endif

                            </div>
                            <div class="d-flex align-items-center justify-content-around my-3 py-1">
                                <div>
                                    <h4 class="mb-0">{{ $unit->rooms ?? ' ' }}</h4>
                                    <span>@lang('number rooms')</span>
                                </div>
                                <div>
                                    <h4 class="mb-0">{{ $unit->bathrooms ?? ' ' }}</h4>
                                    <span>@lang('Number bathrooms')</span>
                                </div>
                                <div>
                                    <h4 class="mb-0">{{ $unit->space ?? ' ' }}</h4>
                                    <span>@lang('Area (m²)')</span>
                                </div>
                                <div data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="عدد المشاهدات اخر 7 ايام">
                                    <h4 class="mb-0">{{ $unitVisitorsCount[$unit->id] ?? 0 }}</h4>
                                    <span class="ti ti-eye"></span>
                                </div>

                            </div>
                        @endif

                        @if (isset($unit->isGalleryProject) && $unit->isGalleryProject)
                            <div class="d-flex align-items-center justify-content-center my-3 gap-2"
                                style="text-align: center;">
                                <a href="javascript:;"><span class="badge bg-label-primary">
                                        {{ __('Project') ?? '' }}</span></a>

                            </div>
                            <div class="d-flex align-items-center justify-content-around my-3 py-1">
                                <div>
                                    <h4 class="mb-0">{{ $unit->PropertiesProject->count() ?? 0 }}</h4>
                                    <span>@lang('Number Properties')</span>
                                </div>
                                <div>
                                    <h4 class="mb-0">{{ $unit->UnitsProject->count() ?? 0 }}</h4>
                                    <span>@lang('Number units')</span>
                                </div>

                                {{-- <div>
                                <h4 class="mb-0">{{ $unitVisitorsCount[$unit->id] ?? 0 }}</h4>
                                <span class="ti ti-eye"></span>
                            </div> --}}
                                <div data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="عدد المشاهدات اخر 7 ايام">
                                    <h4 class="mb-0">{{ $unitVisitorsCount[$unit->id] ?? 0 }}</h4>
                                    <span class="ti ti-eye"></span>
                                </div>
                            </div>
                        @endif

                        @if (isset($unit->isGalleryProperty) && $unit->isGalleryProperty)
                            <div class="d-flex align-items-center justify-content-center my-3 gap-2"
                                style="text-align: center;">

                                <a href="javascript:;"><span class="badge bg-label-primary">
                                        {{ __('property') ?? '' }}</span></a>

                            </div>
                            <div class="d-flex align-items-center justify-content-around my-3 py-1">
                                <div>
                                    <h4 class="mb-0">{{ $unit->UnitsProperty->count() ?? 0 }}</h4>
                                    <span>@lang('Number units')</span>
                                </div>

                                {{-- <div>
                                <h4 class="mb-0">{{ $unitVisitorsCount[$unit->id] ?? 0 }}</h4>
                                <span class="ti ti-eye"></span>
                            </div> --}}
                                <div data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="عدد المشاهدات اخر 7 ايام">
                                    <h4 class="mb-0">{{ $unitVisitorsCount[$unit->id] ?? 0 }}</h4>
                                    <span class="ti ti-eye"></span>
                                </div>
                            </div>
                        @endif
                        @auth
                        @php
                             if( $unit->BrokerData){
                                   $key_phone= $unit->BrokerData->UserData->key_phone;
                                   $phone= $unit->BrokerData->userData->phone;

                                }elseif( $unit->OfficeData){
                                   $key_phone= $unit->OfficeData->UserData->key_phone;
                                   $phone= $unit->OfficeData->userData->phone;


                                }
                        @endphp
                            <div class="d-flex align-items-center justify-content-center">
                                @if (Auth::user()->hasPermission('Show-broker-phone') || Auth::user()->hasPermission('Show-broker-phone-admin'))
                                    <a href="tel:+{{ $key_phone }} {{ $phone }}"
                                        target="_blank" class="btn btn-primary d-flex align-items-center me-3"><i
                                            class="ti-xs me-1 ti ti-phone me-1"></i>@lang('تواصل')</a>
                                @endif
                                @if (Auth::user()->hasPermission('Send-message-to-broker') ||
                                        Auth::user()->hasPermission('Send-message-to-broker-admin'))
                                    <a href="https://web.whatsapp.com/send?phone=tel:+{{ $key_phone }} {{ $phone }}"
                                        target="_blank" class="btn btn-label-secondary btn-icon"><i
                                            class="ti ti-message ti-sm"></i></a>
                                @endif
                            </div>
                        @endauth
                        @guest
                            <div class="d-flex align-items-center justify-content-center">
                                {{-- <a target="_blank" class="btn btn-primary d-flex align-items-center me-3"
                                style="color: white;" data-bs-toggle="modal" data-bs-target="#modalToggle"><i
                                    class="ti-xs me-1 ti ti-phone me-1"></i>@lang('تواصل')</a>
                            <a target="_blank" class="btn btn-label-secondary btn-icon" data-bs-toggle="modal"
                                data-bs-target="#modalToggle"><i class="ti ti-message ti-sm"></i></a> --}}
                                <a target="_blank" class="btn btn-primary d-flex align-items-center me-3"
                                    style="color: white;" href="{{ route('login') }}"><i
                                        class="ti-xs me-1 ti ti-phone me-1"></i>@lang('تواصل')</a>
                                <a target="_blank" class="btn btn-label-secondary btn-icon"
                                    href="{{ route('login') }}"><i class="ti ti-message ti-sm"></i></a>
                            </div>
                        @endguest

                    </div>
                </div>
            </div>
            @include('Home.Gallery.inc.share')
            @include('Home.Gallery.inc.unitInterest')

        @endif

    @endforeach

</div>