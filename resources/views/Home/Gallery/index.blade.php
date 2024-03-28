@extends('Home.layouts.home.app')
@section('title')
    معرض العقارات
@stop
@section('content')

    <link href="{{ asset('HOME_PAGE/css/public_gallery.css') }}" rel="stylesheet" type="text/css" id="theme-opt" />
    <section id="gallery_public" class="container">
        <div class="row gallery-public m-0 p-0 justify-content-center">
            <input hidden name="gallery_name" value="" />
            <div class="row p-0 mb-4">
                <div class="gallery-cover"
                style="background-image: url({{ $gallery->gallery_cover ? asset($gallery->gallery_cover) : asset('dashboard/assets/new-icons/cover1.png') }})">


                {{-- @if ($gallery->gallery_cover)
                    <img src="{{ asset($gallery->gallery_cover)}}" />
                @else
                    <img src="{{ asset('dashboard/assets/new-icons/cover1.png') }}" />
                @endif --}}

                </div>
            </div>

            <div class="row filter sort">
                <div class="view-select">
                    <div class="col-menu grid selected" style="cursor: pointer" onclick="changeView('grid')">menu</div>
                    <div class="col-list list" style="cursor: pointer" onclick="changeView('list')">list</div>
                </div>
                <select class="form-control select-input h-auto" id="city" required name="city">
                    <option value="all">
                        الاحدث </option>

                </select>
            </div>

            <div class="row p-0 gap-5 justify-content-center pe-2 ps-2">
                <div class="filter-container-col">
                    <div class="filter">

                        <form action="{{ route('gallery.showByName', ['name' => $gallery->gallery_name]) }}" method="GET">
                            <div class="row gap-3" style="align-items: end;">
                                <div class="col-12 p-0 ml-2">
                                    <span>المدينة</span>
                                    <select class="form-control" name="city_filter" id="cityFilter">
                                        <option value="all" {{ old('city_filter') == 'all' ? 'selected' : '' }}>@lang('All')</option>
                                        @foreach ($uniqueIds as $index => $id)
                                            <option value="{{ $id }}" {{ old('city_filter') == $id ? 'selected' : '' }}>{{ $uniqueNames[$index] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 p-0 ml-2">
                                    <span>المشروع</span>
                                    <select class="form-control form-control-sm" id="project_filter" name="project_filter">
                                        <option value="all" {{ old('project_filter') == 'all' ? 'selected' : '' }}>@lang('All')</option>
                                        @foreach ($units as $unit)
                                            @if ($unit->PropertyData && $unit->PropertyData->ProjectData)
                                                <option value="{{ $unit->PropertyData->ProjectData->id }}" {{ old('project_filter') == $unit->PropertyData->ProjectData->id ? 'selected' : '' }}>{{ $unit->PropertyData->ProjectData->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 p-0 ml-2">
                                    <span>الفئات</span>
                                    <select class="form-control" name="type_use_filter" id="typeUseFilter">
                                        <option value="all" {{ old('type_use_filter') == 'all' ? 'selected' : '' }}>@lang('All')</option>
                                        @foreach ($usages as $usage)
                                            <option value="{{ $usage->id }}" {{ old('type_use_filter') == $usage->id ? 'selected' : '' }}>{{ $usage->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 p-0 ml-2">
                                    <span>@lang('Ad type')</span>
                                    <select class="form-control form-control-sm" id="ad_type_filter" name="ad_type_filter">
                                     <option value="all">@lang('All')</option>
                                @foreach (['rent', 'sale', 'rent_sale'] as $type)
                                    <option value="{{ $type }}">{{ __($type) }}</option>
                                @endforeach
                            </select>
                                </div>
                                <div class="col-12 p-0 ml-2">
                                    <span>السعر</span>
                                    <div class="row m-0 p-0 gap-3">
                                        <div class="col-5 p-0">
                                            <input class="form-control" name="price_from" id="price_from" placeholder="من" value="{{ request()->input('price_from', null) }}" onchange="reloadUnits()" />
                                        </div>
                                        <div class="col-5 p-0">
                                            <input class="form-control" name="price_to" id="price_to" placeholder="الي" value="{{ request()->input('price_to', null) }}" onchange="reloadUnits()" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 p-0 ml-2">
                                    <button type="submit" class="btn btn-primary">@lang('Filter')</button>
                                    <a href="{{ route('gallery.showByName', ['name' => $gallery->gallery_name]) }}" class="btn btn-danger mt-2 btn-sm">@lang('Cancel')</a>
                                </div>

                        </form>

                            {{-- <div class="col-12 p-0 mt-4" style="margin-left:0.5rem;margin-right:0.5rem;width:90%">
                                <div class="row d-flex justify-content-between m-0 p-0 filter-statuses">
                                    <div class="w-auto item sale" onclick="reloadUnits('sale')" status="sale">للبيع</div>
                                    <div class="w-auto item rent" onclick="reloadUnits('rent')" status="rent">للايجار</div>
                                    <div class="w-auto item both" onclick="reloadUnits('both')" status="both">بيع/إيجار</div>
                                </div>
                            </div> --}}
                            <div class="row mt-3">
                                <div class="form-group d-flex">
                                    <input type="checkbox" id="without_images" name="without_images" onchange="reloadUnits()">
                                    <label class="w-auto" style="margin-bottom:7px;margin-top:7px;margin-right: 10px;font-size: 14px;">الاعلانات بدون الصور</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group d-flex">
                                    <input type="checkbox" id="with_images" name="with_images" onchange="reloadUnits()">
                                    <label class="w-auto" style="margin-bottom:7px;margin-top:7px;margin-right: 10px;font-size: 14px;">الاعلانات مع الصور</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group d-flex">
                                    <input type="checkbox" id="with_price" name="with_price" onchange="reloadUnits()">
                                    <label class="w-auto" style="margin-bottom:7px;margin-top:7px;margin-right: 10px;font-size: 14px;">الاعلانات مع السعر</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group d-flex">
                                    <input type="checkbox" id="without_price" name="without_price" onchange="reloadUnits()">
                                    <label class="w-auto" style="margin-bottom:7px;margin-top:7px;margin-right: 10px;font-size: 14px;">الاعلانات بدون السعر</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group d-flex">
                                    <input type="checkbox" id="reserved_units" name="reserved_units" onchange="reloadUnits()">
                                    <label class="w-auto" style="margin-bottom:7px;margin-top:7px;margin-right: 10px;font-size: 14px;">اعلانات العقارات المحجوزة</label>
                                </div>
                            </div>
                        </div>
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


    </script>



@endpush
