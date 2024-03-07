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
                                    <img src="{{ asset($gallery->gallery_cover) }}" alt="Gallery Cover" class="img-fluid">
                                </div>

                                                                    <!-- Content of the first div -->

                            <form action="{{ route('Broker.Gallery.index') }}" method="GET"
                                id="subscriptionsForm">
                                <div class="row">
                                    <div class="w-auto col-4">
                                        <span>@lang('Ad type')</span>
                                        <select class="form-control form-control-sm" id="status_filter"
                                            name="status_filter">
                                            @foreach (['rent', 'sale', 'rent_sale'] as $type)
                                            <option value="{{ $type }}">
                                                {{ __($type) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="w-auto col-4">
                                        <span>@lang('Type use')</span>
                                        <select class="form-control form-control-sm" id="status_filter"
                                            name="status_filter">
                                            @foreach (['yu'] as $usage)
                                                <option value="{{ $usage }}">
                                                    {{ __($usage) }}
                                                </option>
                                                @endforeach
                                        </select>
                                    </div>
                                    <div class="w-auto col-4">
                                        <span>@lang('city')</span>
                                        <select class="form-control form-control-sm" id="status_filter"
                                            name="status_filter">
                                            <option value="" >كل
                                                الحالات</option>
                                            <option value="" >فعال
                                            </option>
                                            <option value="">غير فعال
                                            </option>
                                        </select>
                                    </div>
                                    <div class="w-auto col-4">
                                        <span>@lang('districts')</span>
                                        <select class="form-control form-control-sm" id="status_filter"
                                            name="status_filter">
                                            <option value="" >كل
                                                الحالات</option>
                                            <option value="" >فعال
                                            </option>
                                            <option value="">غير فعال
                                            </option>
                                        </select>
                                    </div>
                                    <div class="w-auto col-4">
                                        <span>@lang('Project')</span>
                                        <select class="form-control form-control-sm" id="status_filter"
                                        name="status_filter">

                                        </select>
                                    </div>




                                    <div class="w-auto text-center col-12">
                                        <button type="submit" class="w-auto btn btn-primary mt-2 btn-sm">تصفية</button>

                                        {{-- @if ($filter_counter > 0)
                                            <a href="{{ route('Admin.SubscriptionTypes.index') }}"
                                                class="clear-filter w-auto btn btn-danger mt-2 btn-sm"
                                                style="margin-bottom: 0!important;">إلغاء التصفية
                                                ({{ $filter_counter }})</a>
                                        @endif --}}
                                    </div>
                                </div>
                            </form>


                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="horizontal">                                        <button class="nav-link active" id="v-pills-menu-tab" data-toggle="pill"
                                        data-target="#v-pills-menu" type="button" role="tab"
                                        aria-controls="v-pills-menu" aria-selected="true">
                                        @lang('Menu')</button>
                                        <button class="nav-link" id="v-pills-List-tab" data-toggle="pill"
                                        data-target="#v-pills-List" type="button" role="tab"
                                        aria-controls="v-pills-List" aria-selected="false">
                                        @lang('List')</button>
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
                                                    @foreach ($gallrays as $index => $gallary)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $gallary->number_unit ?? '' }}</td>
                                                            <td>الاشغال</td>
                                                            <td>{{ __($gallary->type) ?? '' }} </td>
                                                            <td>
                                                                {{ $gallary->CityData->name ?? '' }}
                                                            </td>
                                                            <td> {{ $gallary->show_gallery == 1 ? __('Show') : __('hide') }}
                                                            </td>

                                                            <td>
                                                                <a class="share btn btn-outline-secondary btn-sm waves-effect waves-light" data-toggle="modal" data-target="#shareLinkUnit{{ $gallary->id }}"
                                                                    href="" onclick="document.querySelector('#shareLinkUnit{{ $gallary->id }} ul.share-tabs.nav.nav-tabs li:first-child a').click()">
                                                                    @lang('Share')</a>

                                                                <a href="{{ route('Broker.Gallery.show', $gallary->id) }}"
                                                                    class="btn btn-outline-warning btn-sm waves-effect waves-light">@lang('Show')</a>

                                                                <a href="{{ route('Broker.Unit.edit', $gallary->id) }}"
                                                                    class="btn btn-outline-info btn-sm waves-effect waves-light">@lang('Edit')</a>

                                                                <a href="javascript:void(0);"
                                                                    onclick="handleDelete('{{ $gallary->id }}')"
                                                                    class="btn btn-outline-danger btn-sm waves-effect waves-light delete-btn">@lang('Delete')</a>
                                                                <form id="delete-form-{{ $gallary->id }}"
                                                                    action="{{ route('Broker.Unit.destroy', $gallary->id) }}"
                                                                    method="POST" style="display: none;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        </div>

                                    <div class="tab-pane fade" id="v-pills-List" role="tabpanel" aria-labelledby="v-pills-List-tab">
                                        <div class="row">

                                            <div class="col-md-6">

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

                                            </div><!-- end col -->
                                    </div>

                                </div>
                                </div>
                            </div>


                                            <!-- share -->
                                                <div class="modal fade" id="shareLinkUnit{{ $gallery->id }}" tabindex="-1" role="dialog" aria-labelledby="shareLinkTitle" aria-hidden="true">
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
                                                                <div id="shareLinkUnit{{ $gallery->id }}" class="first">
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
                                                                        <input readonly class="w-75" style="text-align: left" id="share-url"
                                                                            value="{{ route('Broker.Gallery.index', ['gallery_name' => $gallery->gallery_name, 'id' => $gallery->id]) }}" />
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->



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

@endsection
