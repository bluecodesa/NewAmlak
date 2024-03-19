@extends('Home.layouts.home.app')
@section('title')

    عرض الوحدة ف المعرض

@stop
@section('content')
    <link href="{{ asset('HOME_PAGE/css/public_gallery.css') }}" rel="stylesheet" type="text/css" id="theme-opt" />

    <section id="gallery_unit_public" class="container">
        <div class="row show-unit">
            <input hidden type="text" name="unit_idd" value="{{ $Unit->id }}" />
            <div class="col-md-9">
                <div class="card border-0"
                    style="border-radius: 28px;filter:drop-shadow(0px 3px 3px rgba(161,137,137,0.09 ));">

                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

                            {{-- <ol class="carousel-indicators">
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($Unit->UnitImages as $img)
                            <img class="d-block w-100" src="{{ asset($img['image']) }}" alt="First slide"
                                        style="height: 350px;object-fit:contain">
                            @endforeach
                        </ol> --}}
                        <div class="carousel-inner">
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($Unit->UnitImages as $img)
                                <div class="carousel-item @if ($i == 0) active @endif ">
                                    <img class="d-block w-100" src="{{ asset($img['image']) }}" alt="First slide"
                                        style="height: 350px;object-fit:contain">
                                </div>
                                @php
                                    $i++;
                                @endphp
                            @endforeach


                        </div>


                    </div>

                    <div class="card-body p-4 pt-3 pb-3">

                        <div class="row justify-content-between mt-2 mb-3">
                            <span class="w-auto m-0 p-0" style="font-weight: 900">
                                @lang('Residential number') :
                                    {{ $Unit->number_unit }}
                                </span>
                            <span class="w-auto m-0 p-0" style="color: #5c88b4;font-weight:900">{{ $Unit->price }}
                                @lang('SAR')</span>
                        </div>
                        <div class="row">
                            <img src="{{ asset('dashboard/assets/new-icons/build.png') }}"
                                style="width: 18px;height: fit-content;" class="p-0" />
                            <span class=" w-auto mb-2" style="color: #989898">@lang('owner name') /
                                {{ $Unit->OwnerData->name ?? '' }}
                            </span>
                            <img src="{{ asset('dashboard/assets/new-icons/Iconly_Light_Locatio.png') }}"
                            style="width: 18px;height: fit-content;" class="p-0" />
                        <span class=" w-auto mb-2" style="color: #989898"> @lang('Region') -
                            {{ $Unit->CityData->RegionData->name ?? '' }} - @lang('city')  -
                            {{ $Unit->CityData->name ?? '' }}
                            </span>


                        </div>

                        <div class="row">
                            <img src="{{ asset('dashboard/assets/new-icons/Iconly_Light_Locatio.png') }}"
                                style="width: 18px;height: fit-content;" class="p-0" />
                            <span class="mb-2 w-auto" style="color: #989898">
                                @lang('number rooms') :
                                 {{ $Unit->rooms }}
                            </span>
                        </div>

                    </div>
                </div>

                <div class="row m-0 mt-3 bg-white p-2 pt-3 pb-3 "
                    style="border-radius: 20px;filter:drop-shadow(0px 3px 3px rgba(161,137,137,0.09 ));">
                    <p class="font-weight-bold">        <img src="{{ asset('dashboard/assets/new-icons/Iconly_Light_Locatio.png') }}"
                        style="width: 18px;height: fit-content;" class="p-0" /></p>
                    <div class="row m-0">

                            <iframe width="100%" style="border-radius: 10px;" height="200" frameborder="0"
                            style="border:0"
                            src="https://www.google.com/maps/embed/v1/place?q={{ $Unit->lat_long }}&amp;key=AIzaSyAzFIgHaU5mzPcf16Qf3sdi0ioKqOKoy6E"></iframe>


                    </div>
                    <div class="row m-0 p-0">
                        <div id="map"></div>

                        {{--  <iframe src="" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-3 bg-white p-4"
                style="height: fit-content;border-radius: 20px;filter:drop-shadow(0px 3px 3px rgba(161,137,137,0.09 ));">
                <div class="row m-0 align-items-center mb-4">
                    <div class="unit-employee">
                        {{-- <img src="{{$brokers->avatar}}" alt="user" class="rounded-circle"> --}}
                    </div>
                    <div class="w-auto">
                        <p class="mb-0 font-weight-bold">{{ $brokers->name}}</p>
                        @php
                            $createdAt = new DateTime($brokers->created_at);

                            // Get the month name
                            $monthName = $createdAt->format('F');

                            // Get the number of days in the month
                            $numDay = $createdAt->format('d');

                        @endphp
                        <span style="font-size: 13px">عضو منذ
                             {{ $monthName }} {{ $numDay }}
                        </span>
                    </div>
                </div>
                <hr class="mb-3" style=" color: #bab2b2;" />
                @if ($broker->mobile)
                    <a class="d-block btn-new text-center text-white"
                        href="tel:{{ env('COUNTRY_CODE') . $broker->moblie }}"
                        style="text-decoration: none;cursor: pointer;">{{ $broker->mobile }}</a>


                    <a class="d-block btn btn-new-b mt-3 w-100"
                        href="https://web.whatsapp.com/send?phone={{ env('COUNTRY_CODE') . $broker->mobile}}"
                        target="_blank">دردشة</a>
                @endif
                <div class="row m-0 justify-content-between mt-3 align-items-center">

                    <a class="love w-auto" data-toggle="modal" data-target="#interestUnit" href=""
                        onclick="interestUnit({{ $Unit->id }})"
                        style="color: #4a5865;border: 1px solid #eeecec; border-radius: 12px;"><img
                            src="{{ asset('dashboard/assets/new-icons/interest.png') }}" class="img-fluid"
                            style="height: 34px;" />تسجيل اهتمام</a>
                    <a class="share w-auto p-0" data-toggle="modal" data-target="#shareLink">
                        <img src="{{ asset('dashboard/assets/new-icons/share.png') }}" class="img-fluid"
                            style="height: 43px;border: 1px solid #eeecec;border-radius: 12px;cursor: pointer;" /></a>
                </div>
            </div>
        </div>

        <input hidden id="google_map" value="  {!! Str::limit($Unit->location, 13, ' .') !!}" />



        <!-- Modal -->
        <div class="modal fade" id="shareLink" tabindex="-1" role="dialog" aria-labelledby="shareLinkTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <ul class="share-tabs nav nav-tabs">
                            <li class="shareLink active"><a href="#shareLink" onclick="share('shareLink')">مشاركة الرابط</a>
                            </li>
                            <li class="qrCode"><a href="#qrCode" onclick="share('qrCode')">qr code</a></li>

                        </ul>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>

                        </button>

                    </div>
                    <div class="modal-body share-divs">
                        <div id="shareLink">
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
                                    value="{{ route('gallery.showUnitPublic', ['gallery_name' => $gallery->gallery_name, 'id' => $Unit->id])}} " />
                            </div>

                            @php
                                $url = route('gallery.showUnitPublic', ['gallery_name' => $gallery->gallery_name, 'id' => $Unit->id]) ;
                            @endphp
                            <div class="row justify-content-center p-4">
                                <div class="whats-conatiner">
                                    {{-- whatsapp webbb --}}
                                    <a href='https://web.whatsapp.com/send?text=Check%20out%20this%20link:%20{{ urlencode("$url") }}'
                                        target="_blank">

                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="96px"
                                            height="96px" clip-rule="evenodd">
                                            <path fill="#fff"
                                                d="M4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98c-0.001,0,0,0,0,0h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303z" />
                                            <path fill="#fff"
                                                d="M4.868,43.803c-0.132,0-0.26-0.052-0.355-0.148c-0.125-0.127-0.174-0.312-0.127-0.483l2.639-9.636c-1.636-2.906-2.499-6.206-2.497-9.556C4.532,13.238,13.273,4.5,24.014,4.5c5.21,0.002,10.105,2.031,13.784,5.713c3.679,3.683,5.704,8.577,5.702,13.781c-0.004,10.741-8.746,19.48-19.486,19.48c-3.189-0.001-6.344-0.788-9.144-2.277l-9.875,2.589C4.953,43.798,4.911,43.803,4.868,43.803z" />
                                            <path fill="#cfd8dc"
                                                d="M24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,4C24.014,4,24.014,4,24.014,4C12.998,4,4.032,12.962,4.027,23.979c-0.001,3.367,0.849,6.685,2.461,9.622l-2.585,9.439c-0.094,0.345,0.002,0.713,0.254,0.967c0.19,0.192,0.447,0.297,0.711,0.297c0.085,0,0.17-0.011,0.254-0.033l9.687-2.54c2.828,1.468,5.998,2.243,9.197,2.244c11.024,0,19.99-8.963,19.995-19.98c0.002-5.339-2.075-10.359-5.848-14.135C34.378,6.083,29.357,4.002,24.014,4L24.014,4z" />
                                            <path fill="#40c351"
                                                d="M35.176,12.832c-2.98-2.982-6.941-4.625-11.157-4.626c-8.704,0-15.783,7.076-15.787,15.774c-0.001,2.981,0.833,5.883,2.413,8.396l0.376,0.597l-1.595,5.821l5.973-1.566l0.577,0.342c2.422,1.438,5.2,2.198,8.032,2.199h0.006c8.698,0,15.777-7.077,15.78-15.776C39.795,19.778,38.156,15.814,35.176,12.832z" />
                                            <path fill="#fff" fill-rule="evenodd"
                                                d="M19.268,16.045c-0.355-0.79-0.729-0.806-1.068-0.82c-0.277-0.012-0.593-0.011-0.909-0.011c-0.316,0-0.83,0.119-1.265,0.594c-0.435,0.475-1.661,1.622-1.661,3.956c0,2.334,1.7,4.59,1.937,4.906c0.237,0.316,3.282,5.259,8.104,7.161c4.007,1.58,4.823,1.266,5.693,1.187c0.87-0.079,2.807-1.147,3.202-2.255c0.395-1.108,0.395-2.057,0.277-2.255c-0.119-0.198-0.435-0.316-0.909-0.554s-2.807-1.385-3.242-1.543c-0.435-0.158-0.751-0.237-1.068,0.238c-0.316,0.474-1.225,1.543-1.502,1.859c-0.277,0.317-0.554,0.357-1.028,0.119c-0.474-0.238-2.002-0.738-3.815-2.354c-1.41-1.257-2.362-2.81-2.639-3.285c-0.277-0.474-0.03-0.731,0.208-0.968c0.213-0.213,0.474-0.554,0.712-0.831c0.237-0.277,0.316-0.475,0.474-0.791c0.158-0.317,0.079-0.594-0.04-0.831C20.612,19.329,19.69,16.983,19.268,16.045z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>

                                    {{-- - whatspp mob --}}
                                    <a class="d-none"
                                        href="whatsapp://send?text=Check%20out%20this%20link:%20{{ urlencode('https://example.com') }}"
                                        target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="96px"
                                            height="96px" clip-rule="evenodd">
                                            <path fill="#fff"
                                                d="M4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98c-0.001,0,0,0,0,0h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303z" />
                                            <path fill="#fff"
                                                d="M4.868,43.803c-0.132,0-0.26-0.052-0.355-0.148c-0.125-0.127-0.174-0.312-0.127-0.483l2.639-9.636c-1.636-2.906-2.499-6.206-2.497-9.556C4.532,13.238,13.273,4.5,24.014,4.5c5.21,0.002,10.105,2.031,13.784,5.713c3.679,3.683,5.704,8.577,5.702,13.781c-0.004,10.741-8.746,19.48-19.486,19.48c-3.189-0.001-6.344-0.788-9.144-2.277l-9.875,2.589C4.953,43.798,4.911,43.803,4.868,43.803z" />
                                            <path fill="#cfd8dc"
                                                d="M24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,4C24.014,4,24.014,4,24.014,4C12.998,4,4.032,12.962,4.027,23.979c-0.001,3.367,0.849,6.685,2.461,9.622l-2.585,9.439c-0.094,0.345,0.002,0.713,0.254,0.967c0.19,0.192,0.447,0.297,0.711,0.297c0.085,0,0.17-0.011,0.254-0.033l9.687-2.54c2.828,1.468,5.998,2.243,9.197,2.244c11.024,0,19.99-8.963,19.995-19.98c0.002-5.339-2.075-10.359-5.848-14.135C34.378,6.083,29.357,4.002,24.014,4L24.014,4z" />
                                            <path fill="#40c351"
                                                d="M35.176,12.832c-2.98-2.982-6.941-4.625-11.157-4.626c-8.704,0-15.783,7.076-15.787,15.774c-0.001,2.981,0.833,5.883,2.413,8.396l0.376,0.597l-1.595,5.821l5.973-1.566l0.577,0.342c2.422,1.438,5.2,2.198,8.032,2.199h0.006c8.698,0,15.777-7.077,15.78-15.776C39.795,19.778,38.156,15.814,35.176,12.832z" />
                                            <path fill="#fff" fill-rule="evenodd"
                                                d="M19.268,16.045c-0.355-0.79-0.729-0.806-1.068-0.82c-0.277-0.012-0.593-0.011-0.909-0.011c-0.316,0-0.83,0.119-1.265,0.594c-0.435,0.475-1.661,1.622-1.661,3.956c0,2.334,1.7,4.59,1.937,4.906c0.237,0.316,3.282,5.259,8.104,7.161c4.007,1.58,4.823,1.266,5.693,1.187c0.87-0.079,2.807-1.147,3.202-2.255c0.395-1.108,0.395-2.057,0.277-2.255c-0.119-0.198-0.435-0.316-0.909-0.554s-2.807-1.385-3.242-1.543c-0.435-0.158-0.751-0.237-1.068,0.238c-0.316,0.474-1.225,1.543-1.502,1.859c-0.277,0.317-0.554,0.357-1.028,0.119c-0.474-0.238-2.002-0.738-3.815-2.354c-1.41-1.257-2.362-2.81-2.639-3.285c-0.277-0.474-0.03-0.731,0.208-0.968c0.213-0.213,0.474-0.554,0.712-0.831c0.237-0.277,0.316-0.475,0.474-0.791c0.158-0.317,0.079-0.594-0.04-0.831C20.612,19.329,19.69,16.983,19.268,16.045z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>

                                </div>
                            </div>
                        </div>
                        <div id="qrCode">

                            <div class="row pb-5 pt-4 flex-nowrap align-items-center">
                                <div class="w-auto">

                                </div>
                                <div class="d-flex gap-4" style="flex: auto;flex-direction:column">
                                    <p>قم بتحميل الكود لكي تستطيع مشاركته مع اصدقائك لكي يمكنهم الوصول الي بيانات هذا العقار
                                        عن طريق الجوال
                                    </p>
                                    @php
                                        $url = "route('gallery.showUnitPublic', ['gallery_name' => $gallery->gallery_name, 'id' => $Unit->id]) ";
                                    @endphp
                                    <a href=""
                                        class="d-block btn btn-new-b mt-3">Download QR Code</a>

                                </div>
                            </div>




                        </div>

                    </div>

                </div>
            </div>
        </div>



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
    {{--     <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZqjHusxNNUpqBldMAd44zMrKPysscxI4" async defer></script>
 --}}
    <script>
        (g => {
            var h, a, k, p = "The Google Maps JavaScript API",
                c = "google",
                l = "importLibrary",
                q = "__ib__",
                m = document,
                b = window;
            b = b[c] || (b[c] = {});
            var d = b.maps || (b.maps = {}),
                r = new Set,
                e = new URLSearchParams,
                u = () => h || (h = new Promise(async (f, n) => {
                    await (a = m.createElement("script"));
                    e.set("libraries", [...r] + "");
                    for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]);
                    e.set("callback", c + ".maps." + q);
                    a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
                    d[q] = f;
                    a.onerror = () => h = n(Error(p + " could not load."));
                    a.nonce = m.querySelector("script[nonce]")?.nonce || "";
                    m.head.append(a)
                }));
            d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() =>
                d[l](f, ...n))
        })
        ({
            key: "AIzaSyBZqjHusxNNUpqBldMAd44zMrKPysscxI4",
            v: "beta"
        });

        window.onload = function() {
            //   createEmbedLink();
            initMap();
        }

        function copy() {
            let copyGfGText = document.getElementById("share-url");
            copyGfGText.select();
            console.log(copyGfGText.value);
        }

        function interestUnit(id) {
            document.querySelector('#interestUnit input[name="unit_id"]').value = id;
        }

        function share(classname) {

            document.querySelector('.share-tabs .active').classList.remove('active');
            document.querySelector(`.share-tabs .${classname}`).classList.add('active');

            let views = document.querySelectorAll('.share-divs #shareLink,.share-divs #qrCode');

            for (let i = 0; i < views.length; i++)
                views[i].style.display = "none";

            document.querySelector(`.share-divs #${classname}`).style.display = "block";

        }

        function createEmbedLink() {
            googleMapsUrl = document.querySelector('input#google_map').value;

            console.log(googleMapsUrl);
            // const googleMapsUrl = "https://www.google.com/maps/@37.7749,-122.4194,15z";

            // Regular expression to match the coordinates in the URL
            const regex = /@([-+]?\d+\.\d+),([-+]?\d+\.\d+),\d+z/;

            // Use the regular expression to extract the coordinates
            const match = googleMapsUrl.match(regex);

            if (match) {
                const latitude = parseFloat(match[1]);
                const longitude = parseFloat(match[2]);
                const wrong = '';


                const zoom = 15; // Adjust the zoom level as needed
                const markerLabel = 'A'; // Marker label (optional)

                // Construct the Google Maps embed URL with coordinates, zoom, and marker
                let embedUrl = `https://www.google.com/maps/embed/v1/view?key=AIzaSyBZqjHusxNNUpqBldMAd44zMrKPysscxI4
                &center=${latitude},${longitude}
                &zoom=${zoom}
                &q=${latitude},${longitude}
                `;
                document.querySelector('iframe').src = embedUrl;
            } else {
                console.log("Coordinates not found in the URL.");
            }
        }

        function clickAuto() {
            document.querySelector('a.clikccc').click();
        }


        function changeViewUnit() {
            let unit_id = document.querySelector('input[name="unit_idd"]').value;
            let view_in_gallery = document.querySelector('input#view_in_gallery').checked ? 1 : 0;

            $.ajax({
                url: '/unit/update_gallery',
                method: 'GET',

                data: {
                    'unit_id': unit_id,
                    'view_in_gallery': view_in_gallery,
                },

                success: function(data) {}
            });

        }



        async function initMap() {

            // The location of Uluru
            googleMapsUrl = document.querySelector('input#google_map').value;

            if (googleMapsUrl) {
                const regex = /@([-+]?\d+\.\d+),([-+]?\d+\.\d+),\d+z/;

                // Use the regular expression to extract the coordinates
                const match = googleMapsUrl.match(regex);

                const latitude = parseFloat(match[1]);
                const longitude = parseFloat(match[2]);
                const position = {
                    lat: latitude,
                    lng: longitude
                };
                // Request needed libraries.
                //@ts-ignore
                const {
                    Map
                } = await google.maps.importLibrary("maps");
                const {
                    AdvancedMarkerElement
                } = await google.maps.importLibrary("marker");

                // The map, centered at Uluru
                map = new Map(document.getElementById("map"), {
                    zoom: 14,
                    center: position,
                    mapId: "DEMO_MAP_ID",
                });

                // The marker, positioned at Uluru
                const marker = new AdvancedMarkerElement({
                    map: map,
                    position: position,
                    title: "Uluru",
                });
            }
        }
    </script>
@endpush
