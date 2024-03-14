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
                    style="background-image: url({{ asset('dashboard/assets/new-icons/cover1.png') }})">

                    {{-- @if ($office->setting->gallery_cover)
                    <img src="{{ asset('Gallery_covers/' . $office->setting->gallery_cover) }}" />
                @else
                    <img src="{{ asset('dashboard/assets/new-icons/cover1.jpeg') }}" />
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


        function reloadUnits(rent_status, page = 1) {

            if (rent_status == 'rent') {
                document.querySelector('.filter-statuses .item.active').classList.remove('active');
                document.querySelector('.filter-statuses .item.rent').classList.add('active');
            } else if (rent_status == 'sale') {
                document.querySelector('.filter-statuses .item.active').classList.remove('active');
                document.querySelector('.filter-statuses .item.sale').classList.add('active');
            } else if (rent_status == 'both') {
                document.querySelector('.filter-statuses .item.active').classList.remove('active');
                document.querySelector('.filter-statuses .item.both').classList.add('active');
            }

            let city = document.querySelector('select#city_filter').value;
            let prj_id = document.querySelector('select#prj_filter').value;
            let type_filter = document.querySelector('select#type_filter').value;

            let price_from = document.querySelector('input#price_from').value;
            let price_to = document.querySelector('input#price_to').value;
            let gallery_name = document.querySelector('input[name="gallery_name"]').value;

            $.ajax({
                url: '/gallery/' + gallery_name + '?page=' + page,
                method: 'GET',

                data: {
                    'prj_filter': prj_id,
                    'city': city,
                    'type_filter': type_filter,
                    'rent_status': document.querySelector('.filter-statuses .item.active').getAttribute('status'),
                    'price_from': price_from,
                    'price_to': price_to,
                    'without_images': document.querySelector('input#without_images').checked ? 1 : 0,
                    'with_images': document.querySelector('input#with_images').checked ? 1 : 0,
                    'with_price': document.querySelector('input#with_price').checked ? 1 : 0,
                    'without_price': document.querySelector('input#without_price').checked ? 1 : 0,
                    'reserved_units': document.querySelector('input#reserved_units').checked ? 1 : 0
                },

                success: function(data) {

                    document.querySelector('.cards-gallery-container').innerHTML = data;


                    if (city != 'all') {
                        document.querySelector('.galler-filter').innerHTML +=
                            `<div><span class="filter-name"><span class="city">${city}</span> <span class="close-filter" onclick="closeCityFilter()">x</span></span></div>`;
                        document.querySelector('.view-filters').style.display = 'flex';
                    }


                    if (prj_id != 'all') {
                        let index = document.querySelector('select#prj_filter').selectedIndex
                        prj_name = document.querySelector('select#prj_filter').options[index].text;

                        document.querySelector('.galler-filter').innerHTML +=
                            `<div><span class="filter-name"><span class="project">${prj_name}</span> <span class="close-filter" onclick="closeProjectFilter()">x</span></span></div>`;
                        document.querySelector('.view-filters').style.display = 'flex';

                    }


                    if (type_filter != 'all') {
                        let index = document.querySelector('select#type_filter').selectedIndex;
                        let type_name = document.querySelector('select#type_filter').options[index].text;

                        document.querySelector('.galler-filter').innerHTML +=
                            `<div><span class="filter-name"><span class="type_filter">${type_name}</span> <span class="close-filter" onclick="closeTypeFilter()">x</span></span></div>`;
                        document.querySelector('.view-filters').style.display = 'flex';

                    }
                    checkCurrentVie();
                }
            });

        }


        function closeTypeFilter() {
            document.querySelector('select#type_filter').selectedIndex = 0;
            reloadUnits();

        }

        function closeCityFilter() {
            document.querySelector('select#city_filter').selectedIndex = 0;
            reloadUnits();
        }


        function closeProjectFilter() {
            document.querySelector('select#prj_filter').selectedIndex = 0;
            reloadUnits();
        }

        function clearAllFilters() {
            document.querySelector('select#type_filter').selectedIndex = 0;
            document.querySelector('select#city_filter').selectedIndex = 0;
            document.querySelector('select#prj_filter').selectedIndex = 0;

            reloadUnits();

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
    </script>
@endpush
