@extends('Home.layouts.home.app')
@section('title', __('property') . ' ' . $property->name )
@section('content')


    <!-- Content wrapper -->
    <section class="section-py first-section-pt">
        <div class="container">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">
                    <a href="{{ route('welcome') }}">الرئيسية</a>/
                    <span class="text-muted fw-light">
                        <a href="{{ route('gallery.showAllGalleries') }}">المعرض</a>
                    </span>/
                    عقار : {{ $property->name ?? '' }}
                </span>
            </h4>
            <input hidden type="text" name="property_idd" value="{{ $property->id }}" />

            <!-- Image Slider -->
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-8">
                    <div class="card mb-4">
                        <div id="carouselExampleIndicators" class="carousel slide shadow-sm" data-ride="carousel">
                            <div class="carousel-inner">
                                @php
                                    $i = 0;
                                @endphp
                                @if($property->PropertyImages->isEmpty())
                                <div class="carousel-item active">
                                    <img class="d-block w-100" src="{{ asset('Offices/Projects/default.svg') }}" alt="Default slide" style="height: 350px; object-fit: contain">
                                </div>
                                @else
                                @foreach ($property->PropertyImages as $media)
                                    <div class="carousel-item @if ($i == 0) active @endif">
                                        @if (Str::startsWith($media->image, '/Brokers/Projects'))
                                            <!-- Image -->
                                            <img class="d-block w-100" data-bs-toggle="modal" data-bs-target="#mediaModal"
                                                src="{{ asset($media->image) }}"
                                                alt="Slide {{ $i + 1 }}"
                                                style="height: 350px; object-fit: contain"
                                            >
                                        @else
                                            <!-- Video -->
                                            <video controls class="d-block w-100" controls style="height: 350px; object-fit: contain">
                                                <source src="{{ asset($media->image) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @endif
                                    </div>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach

                                @endif
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="mediaModal" tabindex="-1" role="dialog" aria-labelledby="mediaModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel1"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="carouselModal" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner">
                                            @php
                                                $j = 0;
                                            @endphp
                                            @foreach ($property->PropertyImages as $media)
                                                <div class="carousel-item @if ($j == 0) active @endif">
                                                    @if (Str::startsWith($media->image, '/Brokers/Projects/'))
                                                        <!-- Image -->
                                                        <img class="d-block w-100"
                                                            src="{{ asset($media->image) }}"
                                                            alt="Slide {{ $j + 1 }}"
                                                            style="height: 600px; object-fit: contain"
                                                        >
                                                    @else
                                                        <!-- Video -->
                                                        <video controls class="d-block w-100" style="height: 600px; object-fit: contain">
                                                            <source src="{{ asset($media->image) }}" type="video/mp4">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    @endif
                                                </div>
                                                @php
                                                    $j++;
                                                @endphp
                                            @endforeach
                                        </div>
                                        <a class="carousel-control-prev" href="#carouselModal" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselModal" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Image Slider -->

                    <!-- description of property -->
                    @if($property->note)
                    <div class="card card-action mb-4">
                        <div class="card-header align-items-center">
                            <h5 class="card-action-title mb-0">وصف العقار</h5>
                        </div>
                        <div class="card-body pb-0">
                            <div id="project-description-short">
                                {!! Str::limit(strip_tags($property->note ?? ''), 500, '...') !!}
                                <a href="javascript:void(0);" id="read-more-btn" onclick="toggleReadMore()">Read More</a>
                            </div>
                            <div id="project-description-full" style="display: none;">
                                {!! $property->note ?? '' !!}
                                <a href="javascript:void(0);" id="read-less-btn" onclick="toggleReadMore()">Read Less</a>
                            </div>
                        </div>
                    </div>
                    @endif
                 <!-- description of project -->

                  <!-- time line -->

             <!-- time line -->

                           <!-- unit card -->

                           <div class="card card-action mb-4">
                            <div class="card-header align-items-center">
                                <h5 class="card-action-title mb-0">الوحدات</h5>
                            </div>
                            <div class="col-md mb-4 mb-md-2">
                                <div class="accordion mt-3" id="accordionExample">
                                    @php
                                        $propertyTypes = $property->UnitsProperty->pluck('property_type_id')->unique();
                                    @endphp

                                    @foreach ($propertyTypes as $propertyTypeId)
                                        @php
                                            $units = $property->UnitsProperty->where('property_type_id', $propertyTypeId)->where('show_gallery', 1);
                                        @endphp

                                        @if ($units->count() > 0)
                                            @php
                                                $propertyTypeName = $units->first()->PropertyTypeData->name ?? '';
                                                $accordionId = 'accordion' . $propertyTypeId;
                                                $headingId = 'heading' . $propertyTypeId;
                                                $collapseId = 'collapse' . $propertyTypeId;
                                            @endphp

                                            <div class="card accordion-item {{ $loop->first ? 'active' : '' }}">
                                                <h2 class="accordion-header" id="{{ $headingId }}">
                                                    <button
                                                        type="button"
                                                        class="accordion-button {{ $loop->first ? '' : 'collapsed' }}"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#{{ $collapseId }}"
                                                        aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                                        aria-controls="{{ $collapseId }}">
                                                        {{ $propertyTypeName }}
                                                    </button>
                                                </h2>

                                                <div
                                                    id="{{ $collapseId }}"
                                                    class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                                    aria-labelledby="{{ $headingId }}"
                                                    data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>@lang('#')</th>
                                                                    <th>@lang('Residential number')</th>
                                                                    <th>@lang('Area (square metres)')</th>
                                                                    <th>@lang('number rooms')</th>
                                                                    <th>@lang('Ad type')</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($units as $index => $unit)
                                                                <tr class="clickable-row" data-href="{{ route('gallery.showUnitPublic', ['gallery_name' => $unit->gallery->gallery_name, 'id' => $unit->id]) }}">
                                                                    <td>{{ $index + 1 }}</td>
                                                                        <td>{{ $unit->number_unit ?? '' }}</td>
                                                                        <td>{{ $unit->space ?? '' }}</td>
                                                                        <td>{{ $unit->rooms ?? '' }}</td>
                                                                        <td>{{ __($unit->type) ?? '' }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- /unit table -->

                    <!-- Project Masterplan -->
                    @if($property->property_masterplan)
                    <div class="card card-action mb-4">
                        <div class="card-header align-items-center">
                            <h5 class="card-action-title mb-0">مخطط العقار</h5>
                        </div>
                        <div class="card-body pb-0">
                            @if (Str::endsWith($property->property_masterplan, '.pdf'))
                                <embed src="{{ $property->property_masterplan }}" type="application/pdf" width="100%" height="500px" />
                            @else
                                <img src="{{ $property->property_masterplan }}" class="img-fluid" alt="property Masterplan">
                            @endif
                        </div>
                    </div>
                    @endif
                    @if($property->property_brochure)

                    <div class="card card-action mb-4">
                        <div class="card-header align-items-center">
                            <h5 class="card-action-title mb-0">برشور العقار</h5>
                        </div>
                        <div class="card-body pb-0">
                            @if (Str::endsWith($property->property_brochure	, '.pdf'))
                                <embed src="{{ $property->property_brochure	 }}" type="application/pdf" width="100%" height="500px" />
                            @else
                                <img src="{{ $property->property_brochure	 }}" class="img-fluid" alt="property Masterplan">
                            @endif
                        </div>
                    </div>
                    @endif
                    <!-- /Project Masterplan -->
                </div>

                <!-- About User -->
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <small class="card-text text-uppercase">@lang('عن الوسيط العقاري ')</small>
                            <ul class="list-unstyled mb-4 mt-3">
                                <li class="d-flex align-items-center mb-3">
                                    <i class="ti ti-check text-heading"></i>
                                    <span class="fw-medium mx-2 text-heading">
                                        {{ $property->BrokerData->UserData->name ?? $property->OfficeData->UserData->name ?? '' }}
                                    </span>
                                </li>
                                @if ($property->BrokerData->UserData->is_broker)
                                    <li class="list-inline-item d-flex gap-1">
                                        <i class="ti ti-user-check"></i>@lang('Broker')
                                    </li>
                                @else
                                    <li class="list-inline-item d-flex gap-1">
                                        <i class="ti ti-user-check"></i>@lang('Office')
                                    </li>
                                @endif
                                <li class="list-inline-item d-flex gap-1">
                                    <i class="ti ti-color-swatch"></i>
                                    رقم رخصة فال : {{ $property->BrokerData->broker_license ?? '' }}
                                </li>
                                <li class="list-inline-item d-flex gap-1">
                                    <i class="ti ti-calendar"></i>
                                    عضو منذ {{ $property->BrokerData->UserData->created_at ?? $property->OfficeData->UserData->created_at ?? '' }}
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- /About User -->


                    <!-- Profile Overview -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="leaflet-map" id="userLocation"></div>
                            <iframe width="100%" style="border-radius: 10px;" height="200" frameborder="0"
                                style="border:0"
                                src="https://www.google.com/maps/embed/v1/place?q={{ $property->lat_long }}&amp;key=YOUR_API_KEY_HERE"></iframe>
                        </div>
                    </div>
                    <!-- /Profile Overview -->

                </div>
            </div>
            <!-- /User Profile Content -->
        </div>
        <!-- /Container -->
    </section>

    {{-- @include('Home.layouts.inc.__addSubscriberModal')


    @include('Home.Gallery.Unit.share')
    @include('Home.Auth.propertyFinder.create') --}}

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function copyUrl() {
            var id = $(this).data("url");
            var input = $("<input>").val(id).appendTo("body").select();
            document.execCommand("copy");
            input.remove();
            Swal.fire({
                icon: "success",
                text: @json(__('copy done')),
                timer: 1000,
            });
        }
    </script>



    <script>
        function updateFullPhone(input) {
            input.value = input.value.replace(/[^0-9]/g, '').slice(0, 9);
            var key_phone = $('#key_phone').val();
            var fullPhone = key_phone + input.value;
            document.getElementById('full_phone').value = fullPhone;
        }
        $(document).ready(function() {
            $('.dropdown-item').on('click', function() {
                var key = $(this).data('key');
                var phone = $('#phone').val();
                $('#key_phone').val(key);
                $('#full_phone').val(key + phone);
                $(this).closest('.input-group').find('.btn.dropdown-toggle').text(key);
            });
        });
    </script>
    <script>
        function toggleReadMore() {
            var shortDesc = document.getElementById('project-description-short');
            var fullDesc = document.getElementById('project-description-full');

            if (shortDesc.style.display === 'none') {
                shortDesc.style.display = 'block';
                fullDesc.style.display = 'none';
            } else {
                shortDesc.style.display = 'none';
                fullDesc.style.display = 'block';
            }
        }
    </script>
    <style>
        .clickable-row {
            cursor: pointer;
        }
        .clickable-row:hover {
        background-color: #f0f0f0; /* Change this color to the shade of gray you prefer */
    }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var rows = document.querySelectorAll('.clickable-row');
            rows.forEach(function(row) {
                row.addEventListener('click', function() {
                    window.location.href = row.getAttribute('data-href');
                });
            });
        });
    </script>

    <!-- Content wrapper -->
@endsection