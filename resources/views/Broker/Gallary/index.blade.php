@extends('Admin.layouts.app')
@section('title', __('Gallary'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">
                                @lang('Gallary')</h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item active"><a
                                        href="{{ route('Broker.Gallery.index') }}">@lang('Gallary')</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('Broker.home') }}">@lang('dashboard')</a></li>
                            </ol>
                        </div>


                    </div> <!-- end row -->
                </div>
                <!-- end page-title -->

                <div class="row">

                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="first-div">
                                    <a type="button" class="btn  waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-lg">
                                        تعديل الصورة
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20.049" height="16.053" viewBox="71.975 141.947 20.049 16.053">
                                            <g data-name="photo-camera">
                                                <path
                                                    d="M78.985 142.018c-.486.13-.971.435-1.245.78-.079.101-.4.575-.713 1.053l-.568.87-1.175.003c-.869 0-1.245.016-1.445.059a2.41 2.41 0 0 0-1.62 1.276c-.087.18-.177.423-.2.537-.032.14-.044 1.637-.044 4.793 0 4.037.008 4.609.063 4.82a2.426 2.426 0 0 0 1.269 1.547c.184.086.427.176.54.2.294.059 16.012.059 16.306 0 .114-.024.356-.114.54-.2.611-.29 1.1-.889 1.27-1.547.054-.211.062-.783.062-4.82 0-3.156-.012-4.652-.043-4.793a3.046 3.046 0 0 0-.2-.537 2.41 2.41 0 0 0-1.621-1.276c-.2-.043-.576-.059-1.445-.059l-1.175-.004-.568-.87a31.242 31.242 0 0 0-.712-1.053c-.282-.352-.791-.67-1.289-.79-.223-.055-.595-.063-2.995-.06-2.483 0-2.761.009-2.992.071Zm3.818 3.313c1.1.176 2.11.678 2.894 1.43 1.096 1.053 1.668 2.368 1.672 3.86 0 1.555-.576 2.867-1.739 3.967-.505.478-1.433 1.003-2.114 1.195-1.864.536-3.834.054-5.213-1.27-1.096-1.053-1.668-2.368-1.672-3.86 0-.87.16-1.59.529-2.346.78-1.594 2.232-2.674 3.998-2.972.423-.074 1.214-.074 1.645-.004Zm6.74 1.465c.496.227.54.94.07 1.206-.141.082-.204.09-.752.09-.674 0-.783-.028-.975-.247a.667.667 0 0 1 .239-1.05c.133-.058.258-.074.708-.074.45 0 .576.016.71.075Z"
                                                    fill="#497aac" fill-rule="evenodd" data-name="Path 29133" />
                                                <path
                                                    d="M81.483 147.661c-.967.176-1.86.87-2.248 1.75-.188.423-.262.842-.238 1.363.039.963.458 1.75 1.221 2.299a3.04 3.04 0 0 0 4.34-.834c.563-.881.61-2.076.117-3.016a3.092 3.092 0 0 0-1.167-1.21 3.855 3.855 0 0 0-.568-.234c-.31-.106-.439-.13-.822-.141a4.523 4.523 0 0 0-.635.023Z"
                                                    fill="#497aac" fill-rule="evenodd" data-name="Path 29134" />
                                            </g>
                                        </svg>

                                    </a>
                                    <img src="{{ asset($gallery->gallery_cover) }}" alt="Gallery Cover" class="img-fluid">


                                </div>


                                <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title mt-0" id="myLargeModalLabel">Large modal</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('Broker.Gallery.update-cover') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="gallery_id" value="{{ $gallery->id }}">
                                                    <input type="file" name="gallery_cover">
                                                    <button type="submit" class="btn btn-primary">تحديث الصورة</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-xl-12">
                                    <div class="card m-b-30">
                                        <div class="card-body">


                                     <!-- Content of the first div -->
                                     <form action="{{ route('Broker.Gallery.index') }}" method="GET" id="subscriptionsForm">
                                        <div class="row">
                                            <div class="w-auto col-4">
                                                <span>@lang('Ad type')</span>
                                                <select class="form-control form-control-sm" id="ad_type_filter" name="ad_type_filter">
                                                    @foreach (['rent', 'sale', 'rent_sale'] as $type)
                                                        <option value="{{ $type }}">{{ __($type) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            {{-- <div class="w-auto col-4">
                                                <span>@lang('Type use')</span>
                                                <select class="form-control form-control-sm" id="type_use_filter" name="type_use_filter">
                                                    @foreach (['سكني', 'تجاري'] as $usage)
                                                        <option value="{{ $usage }}">{{ $usage}}</option>
                                                    @endforeach
                                                </select>
                                            </div> --}}
                                            <div class="w-auto col-4">
                                                <span>@lang('city')</span>
                                                <select class="form-control form-control-sm" id="city_filter" name="city_filter">
                                                    <option value="">All Cities</option>
                                                    @foreach ($units as $unit)
                                                    <option value="{{ $unit->CityData->id }}">{{ $unit->CityData->name }}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                            {{-- <div class="w-auto col-4">
                                                <span>@lang('districts')</span>
                                                <select class="form-control form-control-sm" id="district_filter" name="district_filter">
                                                    <option value="">All Districts</option>
                                                    @foreach ($units as $unit)
                                                @endforeach
                                                </select>
                                            </div>
                                            <div class="w-auto col-4">
                                                <span>@lang('Project')</span>
                                                <select class="form-control form-control-sm" id="project_filter" name="project_filter">
                                                    <option value="">All Projects</option>
                                                    @foreach ($projects as $projectId => $projectName)
                                                        <option value="{{ $projectId }}">{{ $projectName }}</option>
                                                    @endforeach
                                                </select>
                                            </div> --}}
                                            <div class="w-auto text-center col-12">
                                                <button type="submit" class="w-auto btn btn-primary mt-2 btn-sm">Filter</button>
                                            </div>
                                        </div>
                                    </form>
                                        </div>
                                    </div>
                                </div>

                                    <div class="col-xl-12">
                                        <div class="card m-b-30">
                                            <div class="card-body">

                                    <ul class="nav nav-pills nav-justified" role="tablist">
                                        <li class="nav-item waves-effect waves-light">
                                            <a id="v-pills-menu-tab" class="nav-link active" data-toggle="tab" href="#home-1" role="tab" data-target="#v-pills-menu" aria-controls="v-pills-menu">
                                                <span class="d-none d-md-block">@lang('Menu')</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
                                            </a>
                                        </li>
                                        <li class="nav-item waves-effect waves-light">
                                            <a id="v-pills-List-tab" class="nav-link" aria-controls="v-pills-List" data-target="#v-pills-List" data-toggle="tab" href="#profile-1" role="tab">
                                                <span class="d-none d-md-block">@lang('List')</span><span class="d-block d-md-none"><i class="mdi mdi-account h5"></i></span>
                                            </a>
                                        </li>

                                    </ul>
                                            </div>
                                        </div>
                                    </div>


                                <div class="col-12">
                                    <div class="tab-content" id="v-pills-tabContent">
                                        <div class="tab-pane fade show active" id="v-pills-menu" role="tabpanel"
                                            aria-labelledby="v-pills-menu-tab">
                                             <div class="table-responsive b-0" data-pattern="priority-columns">
                                            <table id="datatable-buttons"
                                                class="table table-striped table-bordered dt-responsive nowrap"
                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>@lang('Residential number')</th>
                                                        <th>@lang('الاشغال')</th>
                                                        <th>@lang('Ad type')</th>
                                                        <th>@lang('city')</th>
                                                        <th>@lang('Show in Gallery')</th>
                                                        <th>@lang('Action')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($units as $index => $unit)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $unit->number_unit ?? '' }}</td>
                                                            <td>الاشغال</td>
                                                            <td>{{ __($unit->type) ?? '' }} </td>
                                                            <td>
                                                                {{ $unit->CityData->name ?? '' }}
                                                            </td>
                                                            <td> {{ $unit->show_gallery == 1 ? __('Show') : __('hide') }}
                                                            </td>

                                                            <td>
                                                                <a class="share btn btn-outline-secondary btn-sm waves-effect waves-light" data-toggle="modal" data-target="#shareLinkUnit{{ $unit->id }}"
                                                                    href="" onclick="document.querySelector('#shareLinkUnit{{ $unit->id }} ul.share-tabs.nav.nav-tabs li:first-child a').click()">
                                                                    @lang('Share')</a>

                                                                <a href="{{ route('Broker.Gallery.show', $unit->id) }}"
                                                                    class="btn btn-outline-warning btn-sm waves-effect waves-light">@lang('Show')</a>

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
                                                            </td>
                                                            @endforeach

                                                        </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        @foreach ($units as $index => $unit)

                                        <div class="modal fade" id="shareLinkUnit{{ $unit->id }}" tabindex="-1" role="dialog" aria-labelledby="shareLinkTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <div class="col-6">

                                                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                            <label class="btn btn-light active">
                                                                <input type="radio" name="options" id="option1" checked=""> مشاركه الرابط
                                                            </label>
                                                            <label class="btn btn-light">
                                                                <input type="radio" name="options" id="option2"> QR Code
                                                            </label>

                                                            </div>
                                                        </div>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        </div>
                                                    <div class="modal-body share-divs">
                                                        <div id="shareLinkUnit{{ $unit->id }}" class="first">
                                                            <h6>مشاركة الرابط</h6>
                                                            <p>مشاركة لينك العقار او انسخه في موقعك</p>

                                                            <div class="row link justify-content-between">
                                                                <div class="w-auto" onclick="copy()" style="cursor: pointer"><svg
                                                                        xmlns="http://www.w3.org/2000/svg" width="20.782" height="30.633"
                                                                        viewBox="1039.055 450.797 19.891 24.817">
                                                                        <g data-name="copy">
                                                                            <path
                                                                                d="M1044.82 450.851c-.543.204-.941.558-1.18 1.049-.198.422-.237.975-.082 1.233.258.412.923.422 1.194.014.044-.068.093-.228.117-.354.044-.282.121-.418.3-.524.122-.068.685-.078 6.04-.078 6.51 0 6.068-.02 6.257.291.073.127.078.85.078 8.554 0 8.242 0 8.417-.097 8.568-.112.184-.214.242-.49.286-.433.063-.675.33-.675.738 0 .238.16.49.388.607.136.068.233.082.476.058a1.977 1.977 0 0 0 1.728-1.36c.073-.227.077-.96.068-8.98l-.015-8.738-.15-.315a2.059 2.059 0 0 0-.942-.942l-.316-.15-6.262-.01c-5.073-.005-6.296.005-6.437.053Z"
                                                                                fill="#497aac" fill-rule="evenodd" data-name="Path 29137" />
                                                                            <path
                                                                                d="M1040.616 455.152c-.694.141-1.262.65-1.49 1.335-.073.228-.077.961-.068 8.98l.015 8.739.15.315c.194.403.54.748.942.942l.316.15H1053.102l.315-.15c.403-.194.748-.539.942-.942l.15-.315.015-8.748c.01-8.68.01-8.748-.087-9.01-.214-.572-.612-.99-1.15-1.208l-.282-.112-6.092-.01c-3.35 0-6.185.015-6.297.034Zm12.238 1.471c.287.19.272-.335.272 8.777 0 7.505-.01 8.369-.077 8.514-.156.335.237.316-6.258.316-6.47 0-6.087.02-6.257-.306-.078-.146-.083-.781-.068-8.612l.015-8.451.116-.126a.73.73 0 0 1 .267-.17c.087-.03 2.67-.044 6-.039 5.583.01 5.86.015 5.99.097Z"
                                                                                fill="#497aac" fill-rule="evenodd" data-name="Path 29138" />
                                                                        </g>
                                                                    </svg></div>
                                                                    <input readonly class="w-75" style="text-align: left" id="share-url" value="{{ env('APP_URL') }}/ar/gallery/{{ $gallery->gallery_name }}/{{ $unit->id }}" />
                                                            </div>


                                                                {{-- <input readonly class="w-75" style="text-align: left" id="share-url"
                                                                    value="{{ route('Broker.Gallery.index', $gallery->gallery_name.'/'.$unit->id) }}" />
                                                            </div> --}}
                                                        </div>


                                                    </div>

                                                </div><!-- /.modal-content -->

                                            </div><!-- /.modal-dialog -->

                                        </div><!-- /.modal -->
                                        @endforeach
                                        </div>



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
                                </div>
                            </div>


                                            <!-- share -->




                                        <!--end share -->


                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div>
        <!-- container-fluid -->

    </div>


    {{-- @if ($pendingPayment)
        @include('Home.Payments.pending_payment')
@endif --}}



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show the modal when the page is fully loaded
            var modal = document.getElementById('pendingPaymentModal');
            if (modal) {
                modal.classList.add('show');
                modal.style.display = 'block';
                modal.removeAttribute('aria-hidden');
            }
        });
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var editImageLink = document.getElementById('editImageLink');
        var imageEditFormContainer = document.getElementById('imageEditFormContainer');

        editImageLink.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent the default link behavior
            imageEditFormContainer.style.display = 'block'; // Show the form container
        });
    });
</script>


@endsection
