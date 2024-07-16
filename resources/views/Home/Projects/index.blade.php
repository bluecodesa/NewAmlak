@extends('Home.layouts.home.app')
@section('title', __('Real Estate Projects'))
@section('content')
    <section class="section-py first-section-pt">
        <div class="container">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('welcome') }}">الرئيسية</a>/
                </span>المشاريع</h4>

            <div class="row rounded-5">
                <div class="col-12 rounded-5">
                    <div class="card mb-4 rounded-5">



                    </div>
                </div>
            </div>
            <!--/ Header -->
            <div class="card-body">
              
                <!-- filter  -->
          
                    <!--/ filter pills -->
                    <div class="divider divider-success">
                        <div class="divider-text">@lang('Projects')</div>
                    </div>

                    <!-- Connection Cards -->
                    <div class="row g-4">

                        @foreach ($projects as $project)
                            @if ($project->BrokerData->license_validity == 'valid' && $project->BrokerData->GalleryData->gallery_status != 0 )
                                <div class="col-xl-4 col-lg-6 col-md-6">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <div class="d-flex align-items-center justify-content-start">
                                                <a class="btn btn-label-secondary btn-icon d-flex align-items-center me-3"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#onboardHorizontalImageModal{{ $project->id }}"><i
                                                        class="ti ti-share ti-sm"></i></a>
                                                @guest

                                                    <a class="btn btn-label-secondary btn-icon d-flex align-items-center me-3"
                                                        data-bs-toggle="modal" data-bs-target="#modalToggle">
                                                        <i class="ti ti-heart ti-sm"></i>

                                                    </a>

                                                @endguest

                                                {{-- @auth

                                                    @if (auth()->user())
                                                        @php
                                                            $isFavorite = App\Models\FavoriteUnit::where(
                                                                'unit_id',
                                                                $project->id,
                                                            )
                                                                ->where('finder_id', auth()->user()->id)
                                                                ->exists();
                                                        @endphp
                                                        @if (Auth::user()->hasPermission('Add-property-as-favorite') ||
                                                                Auth::user()->hasPermission('Add-property-as-favorite-admin'))
                                                            @if ($isFavorite)
                                                                <form method="POST"
                                                                    action="{{ route('remove-from-favorites') }}">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="btn btn-label-danger btn-icon d-flex align-items-center me-3">
                                                                        <i class="ti ti-heart ti-sm"></i>
                                                                    </button>
                                                                    <input type="hidden" name="unit_id"
                                                                        value="{{ $unit->id }}">
                                                                </form>
                                                            @else
                                                                <form method="POST"
                                                                    action="{{ route('add-to-favorites') }}">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="btn btn-label-secondary btn-icon d-flex align-items-center me-3">
                                                                        <i class="ti ti-heart ti-sm"></i>
                                                                    </button>
                                                                    <input type="hidden" name="unit_id"
                                                                        value="{{ $unit->id }}">
                                                                    <input type="hidden" name="owner_id"
                                                                        value="{{ $unit->BrokerData->user_id }}">
                                                                </form>
                                                            @endif
                                                        @endif
                                                    @else
                                                        <a class="btn btn-label-secondary btn-icon d-flex align-items-center me-3"
                                                            data-bs-toggle="modal" data-bs-target="#basicModal"
                                                            data-unit-id="{{ $project->id }}"
                                                            data-user-id="{{ $project->BrokerData->user_id }}">
                                                            <i class="ti ti-heart ti-sm"></i>
                                                        </a>
                                                    @endif
                                                @endauth --}}

                                            </div>
                                            <div class="mx-auto my-3">
                                                {{-- @php
                                                    $gallery_name = $unit->gallery->gallery_name;
                                                @endphp --}}
                                                <a href="{{ route('Home.showPublicProject', $project->id) }}"
                                                    class="card-hover-border-default">
                                                    @if ($project->ProjectImages->isNotEmpty())
                                                        <img src="{{ url($project->ProjectImages->first()->image) }}"
                                                            alt="Avatar Image" class="rounded-square" width="100%"
                                                            height="100%" />
                                                    @else
                                                        <img src="{{ url('Offices/Projects/default.svg') }}"
                                                            alt="Avatar Image" class="rounded-square" width="100%"
                                                            height="100%" />
                                                    @endif
                                                </a>
                                            </div>
                                            <h4 class="mb-1 card-title">{{ $project->name ?? '' }}
                                            </h4>
                                            <div class="d-flex align-items-center justify-content-center my-3 gap-2">

                                                <span class="pb-1"><i
                                                        class="ti ti-map-pin"></i>{{ $project->CityData->name ?? '' }}</span>
                                            </div>
                                            <div class=" align-items-center my-3 gap-2 text-end">

                                                {{-- <a href="javascript:;"><span class="badge bg-label-primary">
                                                        {{ __($project->PropertyTypeData->name) ?? '' }}</span></a> --}}
                                            </div>
{{-- 
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
                                            </div> --}}
                                            @auth
                                                <div class="d-flex align-items-center justify-content-center">
                                                    @if (Auth::user()->hasPermission('Show-broker-phone') || Auth::user()->hasPermission('Show-broker-phone-admin'))
                                                        <a href="tel:+{{ $project->BrokerData->key_phone }} {{ $project->BrokerData->mobile }}"
                                                            target="_blank"
                                                            class="btn btn-primary d-flex align-items-center me-3"><i
                                                                class="ti-xs me-1 ti ti-phone me-1"></i>@lang('تواصل')</a>
                                                    @endif
                                                    @if (Auth::user()->hasPermission('Send-message-to-broker') ||
                                                            Auth::user()->hasPermission('Send-message-to-broker-admin'))
                                                        <a href="https://web.whatsapp.com/send?phone=tel:+{{ $project->BrokerData->key_phone }} {{ $project->BrokerData->mobile }}"
                                                            target="_blank" class="btn btn-label-secondary btn-icon"><i
                                                                class="ti ti-message ti-sm"></i></a>
                                                    @endif
                                                </div>
                                            @endauth
                                            @guest
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <a target="_blank"
                                                        class="btn btn-primary d-flex align-items-center me-3"><i
                                                            class="ti-xs me-1 ti ti-phone me-1"></i>@lang('تواصل')</a>
                                                    <a target="_blank" class="btn btn-label-secondary btn-icon"><i
                                                            class="ti ti-message ti-sm"></i></a>
                                                </div>
                                            @endguest

                                        </div>
                                    </div>
                                </div>
                                {{-- @include('Home.Gallery.inc.share')
                                @include('Home.Gallery.inc.unitInterest') --}}
                            @endif
                        @endforeach

                    </div>

                </div>
            </div>
    </section>


    @include('Home.layouts.inc.__addSubscriberModal')

    <script>
        function reloadUnits() {
            // Get selected filter values
            var city = document.getElementById('city_filter').value;
            var project = document.getElementById('project_filter').value;
            var type = document.getElementById('ad_type_filter').value;
            var price_from = document.getElementById('price_from').value;
            var price_to = document.getElementById('price_to').value;

            // Make AJAX request to fetch filtered units
            $.ajax({
                url: "{{ route('filtered.units') }}",
                type: "GET",
                data: {
                    city_filter: city,
                    prj_filter: project,
                    type_filter: type,
                    price_from: price_from,
                    price_to: price_to
                },
                success: function(data) {
                    // Handle the received data (update the view with filtered units)
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        Attach event listeners to select elements
        $(document).ready(function() {
            $('#city_filter, #project_filter, #ad_type_filter, #price_from, #price_to').change(function() {
                reloadUnits();
            });
        });

        $('#city_filter').on('change', function() {
            var selectedOption = $(this).find(':selected');
            var url = selectedOption.data('url');
            if (selectedOption.val() === 'all') {
                $('#district_filter').val('all');
            } else {
                $.ajax({
                    type: "get",
                    url: url,
                    beforeSend: function() {
                        $('#district_filter').fadeOut('fast');
                    },
                    success: function(data) {
                        $('#district_filter').fadeOut('fast', function() {
                            $(this).empty().append(data);
                            $(this).fadeIn('fast');
                        });
                    },
                });
            }
        });

        function redirectToCreateBroker() {
            window.location.href = "{{ route('Home.Brokers.CreateBroker') }}";
        }

        function redirectToCreatePropertyFinder() {
            window.location.href = "{{ route('Home.PropertyFinders.CreatePropertyFinder') }}";
        }

        function redirectToCreateOffice() {
            window.location.href = "{{ route('Home.Offices.CreateOffice') }}";

        }

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
@endsection

<script src="{{ URL::asset('dashboard/js/custom.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all table headers
        const headers = document.querySelectorAll('th');

        // Add click event listeners to each header
        headers.forEach(header => {
            header.addEventListener('click', () => {
                const table = document.querySelector('tbody');
                const rows = Array.from(table.querySelectorAll('tr'));
                const index = Array.from(header.parentNode.children).indexOf(header);
                const direction = header.dataset.sortDirection || 'asc';

                // Remove sort indicators from other headers
                headers.forEach(h => {
                    h.classList.remove('asc', 'desc');
                    delete h.dataset.sortDirection;
                });

                // Sort the rows based on the content of the clicked column
                const sortedRows = rows.sort((a, b) => {
                    const aValue = a.children[index].textContent.trim();
                    const bValue = b.children[index].textContent.trim();

                    if (direction === 'asc') {
                        return aValue.localeCompare(bValue);
                    } else {
                        return bValue.localeCompare(aValue);
                    }
                });

                // Update the sort direction indicator
                header.classList.toggle('asc', direction === 'asc');
                header.classList.toggle('desc', direction === 'desc');
                header.dataset.sortDirection = direction === 'asc' ? 'desc' : 'asc';

                // Reorder the rows in the table
                table.innerHTML = '';
                sortedRows.forEach(row => table.appendChild(row));
            });
        });

        // Initially sort the table by the first column in ascending order
        const initialHeader = headers[0];
        initialHeader.click();
    });
</script>
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.whatsapp-share-btn').on('click', function() {
                var unitId = $(this).data('unit-id');
                var inputId = "galleryNameCopy_" + unitId;
                var urlToShare = $("#" + inputId).val();

                var textToShare = @json(__('Share this unit from Amlak'));
                var whatsappUrl = "https://api.whatsapp.com/send?text=" + encodeURIComponent(textToShare +
                    " " + urlToShare);

                window.open(whatsappUrl, '_blank');
            });
        });

        function copyToClipboard(elementId) {
            var copyText = document.getElementById(elementId);
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices
            document.execCommand("copy");

            alertify.success(@json(__('copy done')));
        }
    </script>
@endpush
