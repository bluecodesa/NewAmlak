@extends('Home.layouts.home.app')
@section('title')
    معرض العقارات
@stop
@section('content')

    @include('Home.layouts.inc.__addSubscriberModal')

    <link href="{{ asset('HOME_PAGE/css/public_gallery.css') }}" rel="stylesheet" type="text/css" id="theme-opt" />
    <section id="gallery_public" class="container">
        <div class="row gallery-public m-0 p-0 justify-content-center">
            <input hidden name="gallery_name" value="" />
            <div class="row p-0 mb-4">
                <div class="gallery-cover"
                    style="background-image: url({{ $gallery->gallery_cover ? asset($gallery->gallery_cover) : asset('dashboard/assets/new-icons/cover1.png') }}); height: 200px; width: 100%; background-size: cover;">
                </div>
            </div>

            <div class="row filter sort">
                <div class="view-select">
                    <div class="col-menu grid selected" style="cursor: pointer" onclick="changeView('grid')">
                        @lang('Card')</div>
                    <div class="col-list list" style="cursor: pointer" onclick="changeView('list')">@lang('List')</div>
                </div>
                <select class="form-control select-input h-auto" id="city" required name="city">
                    <option value="all">
                        الاحدث </option>

                </select>
            </div>

            <div class="row p-0 gap-5 justify-content-center pe-2 ps-2">
                <div class="filter-container-col">
                    <div class="filter">
                        <form action="{{ route('gallery.showAllGalleries') }}" method="GET">
                            <div class="row gap-3" style="align-items: end;">
                                <div class="col-12 p-0 ml-2">
                                    <span>@lang('Ads with images')</span>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="hasImageFilter"
                                            name="has_image_filter" {{ $hasImageFilter ? 'checked' : '' }}>
                                    </div>
                                </div>
                                <div class="col-12 p-0 ml-2">
                                    <span>@lang('Ads with price')</span>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="hasPriceFilter"
                                            name="has_price_filter" {{ $hasPriceFilter ? 'checked' : '' }}>
                                    </div>
                                </div>
                                <div class="col-12 p-0 ml-2">
                                    <span>@lang('Available For Daily Rent')</span>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="daily_rent" name="daily_rent"
                                            {{ $daily_rent ? 'checked' : '' }}>
                                    </div>
                                </div>
                                <div class="col-12 p-0 ml-2">
                                    <span>@lang('Property type')</span>
                                    <select class="form-control form-control-sm" id="property_type_filter" name="property_type_filter">
                                        <option value="all" {{ $propertyTypeFilter == 'all' ? 'selected' : '' }}>
                                            @lang('All')</option>
                                        @foreach ($units as $unit)
                                            @if ($unit->PropertyTypeData)
                                                <option value="{{ $unit->PropertyTypeData->id }}"
                                                    {{ $propertyTypeFilter == $unit->PropertyTypeData->id ? 'selected' : '' }}>
                                                    {{ $unit->PropertyTypeData->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 p-0 ml-2">

                                    <span>@lang('City')</span>
                                    <select class="form-control form-control-sm" id="city_filter" name="city_filter">
                                        <option value="all" {{ $cityFilter == 'all' ? 'selected' : '' }}>
                                            @lang('All')</option>
                                            @foreach ($uniqueIds as $index => $id)
                                            <option value="{{ $id }}"
                                                data-url="{{ route('Broker.Gallary.GetDistrictByCity', $id) }}"
                                                {{ $cityFilter == $id ? 'selected' : '' }}>
                                                {{ $uniqueNames[$index] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 p-0 ml-2">

                                    <span>@lang('district')</span>
                                    <select class="form-control form-control-sm" id="district_filter"
                                        name="district_filter">
                                        <option value="all" {{ $districtFilter == 'all' ? 'selected' : '' }}>
                                            @lang('All')</option>
                                        @foreach ($districts as $index => $district)
                                            <option value="{{ $district->district_id }}"
                                                {{ $districtFilter == $district->district_id ? 'selected' : '' }}>
                                                {{ $district->DistrictData->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 p-0 ml-2">
                                    <span>@lang('Project')</span>
                                    <select class="form-control form-control-sm" id="project_filter" name="project_filter">
                                        <option value="all" {{ $projectFilter == 'all' ? 'selected' : '' }}>
                                            @lang('All')</option>
                                        @foreach ($units as $unit)
                                            @if ($unit->PropertyData && $unit->PropertyData->ProjectData)
                                                <option value="{{ $unit->PropertyData->ProjectData->id }}"
                                                    {{ $projectFilter == $unit->PropertyData->ProjectData->id ? 'selected' : '' }}>
                                                    {{ $unit->PropertyData->ProjectData->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 p-0 ml-2">
                                    <span>@lang('Type use')</span>
                                    <select class="form-control form-control-sm" id="type_use_filter"
                                        name="type_use_filter">
                                        <option value="all" {{ $typeUseFilter == 'all' ? 'selected' : '' }}>
                                            @lang('All')</option>
                                        @foreach ($usages as $usage)
                                            <option value="{{ $usage->id }}"
                                                {{ $typeUseFilter == $usage->id ? 'selected' : '' }}>
                                                {{ $usage->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 p-0 ml-2">
                                    <span>@lang('Ad type')</span>
                                    <select class="form-control form-control-sm" id="ad_type_filter" name="ad_type_filter">
                                        <option value="all" {{ $adTypeFilter == 'all' ? 'selected' : '' }}>
                                            @lang('All')</option>
                                        @foreach (['rent', 'sale', 'rent and sale'] as $type)
                                            <option value="{{ $type }}"
                                                {{ $adTypeFilter == $type ? 'selected' : '' }}>
                                                {{ __($type) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 p-0 ml-2">
                                    <span>السعر</span>
                                    <div class="row m-0 p-0 gap-3">
                                        <div class="col-5 p-0">
                                            <input class="form-control" name="price_from" id="price_from" placeholder="من"
                                                value="{{ request()->input('price_from', null) }}"
                                                onchange="reloadUnits()" />
                                        </div>
                                        <div class="col-5 p-0">
                                            <input class="form-control" name="price_to" id="price_to" placeholder="الي"
                                                value="{{ request()->input('price_to', null) }}"
                                                onchange="reloadUnits()" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 p-0 ml-2">
                                        <a type="submit" class="btn btn-new ArFont">@lang('Filter')</a>

                                    </div>
                                    <div class="col-6 p-0 ml-2">
                                        <a href="{{ route('gallery.showAllGalleries')}}"
                                            class="btn btn-secondary">@lang('Cancel')</a>
                                    </div>
                                </div>

                            </div>
                        </form>


                    </div>
                </div>

                <div class="cards-gallery-container">

                    @include('Home.Gallery.inc.filtered')
                </div>




            </div>
        </div>

        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
            aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel">تعديل صورة الهيدر</h5>

                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">

                @include('Home.Gallery.inc.edit-cover')


            </div>
        </div>







        <!-- Modal -->
        <div class="modal fade" id="interestUnit" tabindex="-1" role="dialog" aria-labelledby="interestUnitTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>ابداء اهتمام للوحدة</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>

                        </button>

                    </div>

                    <div class="modal-body pb-3">
                        <p>برجاء ادخال بياناتك وسوف نتواصل مع حضرتك في أقرب وقت</p>

                        <form action="{{ route('unit_interests.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <input hidden name="unit_id" value="{{ $unit_id }}" />
                                <input hidden name="user_id" value="{{ $user_id }}" /> <!-- Add this line -->
                                <div class="col-sm-12 col-md-6">
                                    <label for="name">الاسم<span class="text-danger">*</span></label>

                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>

                                <div class="col-sm-12 col-md-6">

                                    <label for="whatsapp">رقم (واتساب)<span class="text-danger">*</span></label>

                                    <div style="position:relative">
                                        <input type="tel" class="form-control" id="whatsapp" minlength="9"
                                            maxlength="9" pattern="[0-9]*"
                                            oninvalid="setCustomValidity('Please enter 9 numbers.')"
                                            onchange="try{setCustomValidity('')}catch(e){}" placeholder="599123456"
                                            name="whatsapp" required="" value="">

                                        <span
                                            style="position: absolute;left: -1px;top: 0;background-color: #e9ecef;height: 100%;display: flex; align-items: center;  justify-content: center;border-top-left-radius: 5px;border-bottom-left-radius: 5px;padding: 0px 20px;border: 1px solid #ced4da; border-top-left-radius: 8px;border-bottom-left-radius: 8px;">966+</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row text-center justify-content-center">
                                <button type="submit" class="mt-3 w-auto" style="padding:6px 20px">ارسال</button>
                            </div>
                        </form>


                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection

@push('home-scripts')
    <script src="{{ URL::asset('dashboard/js/custom.js') }}"></script>

    <script>
        window.onload = function() {

            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                let page = url.split("?page=");
                reloadUnits(null, page[1]);
            });
        }

        function setEditData(index, item) {
            row = item.closest('div.card-single');

            document.querySelector('#editUnit input[name="edit_unit_id"]').value = row.querySelector(
                'input[name="unit_id"]').value;



            document.querySelector('#editUnit input[name="number"]').value = row.querySelector(
                'input[name="edit_unit_number"]').value;
            document.querySelector('#editUnit input[name="area"]').value = row.querySelector('input[name="edit_unit_area"]')
                .value;
            document.querySelector('#editUnit input[name="rooms"]').value = row.querySelector(
                'input[name="edit_unit_rooms"]').value;
            document.querySelector('#editUnit input[name="bathrooms"]').value = row.querySelector(
                'input[name="edit_unit_bathrooms"]').value;
            //document.querySelector('#editUnit input[name="bathrooms"]').value =  row.querySelector('input[name="edit_unit_view_in_gallery"]').value;

            document.querySelector('#editUnit .unit-images').innerHTML = row.querySelector('.unit-images-hidden').innerHTML;
            document.querySelector('#editUnit .unit-services').innerHTML = row.querySelector('.unit-services-hidden')
                .innerHTML;


            let options = document.querySelector('select[name="owner_id"]').options;
            for (let i = 0; i < options.length; i++) {
                if (options[i].value == row.querySelector('input[name="edit_unit_owner_id"]').value) {
                    $('#editUnit select[name="owner_id"]').val(options[i].value);
                    // $('#editUnit select[name="owner_id"]').select2().trigger('change');
                    if ('createEvent' in document) {
                        var event = document.createEvent('HTMLEvents');
                        event.initEvent('change', false, true); // onchange event
                        document.querySelector('#editUnit select[name="owner_id"]').dispatchEvent(event);
                    } else {
                        document.querySelector('#editUnit select[name="owner_id"]').fireEvent(
                            'change'); // only for backward compatibility (older browsers)
                    }
                    break;
                }
            }


            let options2 = document.querySelector('select[name="employee_id"]').options;
            for (let i = 0; i < options2.length; i++) {
                if (options2[i].value == row.querySelector('input[name="edit_unit_employee_id"]').value) {
                    $('#editUnit select[name="employee_id"]').val(options2[i].value);
                    // $('#editUnit select[name="employee_id"]').select2().trigger('change');

                    if ('createEvent' in document) {
                        var event = document.createEvent('HTMLEvents');
                        event.initEvent('change', false, true); // onchange event
                        document.querySelector('#editUnit select[name="employee_id"]').dispatchEvent(event);
                    } else {
                        document.querySelector('#editUnit select[name="employee_id"]').fireEvent(
                            'change'); // only for backward compatibility (older browsers)
                    }
                    break;
                }
            }


        }


        function copy() {
            let copyGfGText = document.getElementById("share-url");
            copyGfGText.select();
            document.execCommand("copy");
            console.log(copyGfGText.value);
        }

        function share(classname) {

            let actives = document.querySelectorAll('.share-tabs .active');
            for (let i = 0; i < actives.length; i++)
                actives[i].classList.remove('active');
            document.querySelector(`.share-tabs .${classname}`).classList.add('active');

            let views = document.querySelectorAll('.share-divs .first,.share-divs .second');

            for (let i = 0; i < views.length; i++)
                views[i].style.display = "none";

            document.querySelector(`.share-divs #${classname}`).style.display = "block";


        }





        function changeView(type) {
            document.querySelector('.view-select .selected').classList.remove('selected');
            document.querySelector(`.view-select .${type}`).classList.add('selected');

            let views = document.querySelectorAll('.row.change-view');

            for (let i = 0; i < views.length; i++)
                views[i].style.display = "none";

            document.querySelector(`.row.change-view.${type}`).style.display = "flex";
            localStorage.setItem("home-gallery-view", type);
        }

        function interestUnit(id) {
            document.querySelector('#interestUnit input[name="unit_id"]').value = id;
        }

        function checkCurrentVie() {

            if (localStorage.getItem("home-gallery-view") !== null && localStorage.getItem("home-gallery-view") == 'list')
                changeView('list');
            else
                changeView('grid');
        }


        checkCurrentVie();




        // Function to reload units based on selected filters
        function reloadUnits() {
            // Get selected filter values
            var city = document.getElementById('city_filter').value;
            var project = document.getElementById('prj_filter').value;
            var type = document.getElementById('type_filter').value;
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

        // Attach event listeners to select elements
        $(document).ready(function() {
            $('#city_filter, #prj_filter, #type_filter, #price_from, #price_to').change(function() {
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
    </script>

    <script>
        function redirectToCreateBroker() {
            window.location.href = "{{ route('Home.Brokers.CreateBroker') }}";
        }

        function redirectToCreateOffice() {
            window.location.href = "{{ route('Home.Offices.CreateOffice') }}";

        }
    </script>
@endpush
