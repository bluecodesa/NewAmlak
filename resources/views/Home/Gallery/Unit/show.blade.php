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
                            @if ($Unit->UnitImages->isEmpty())
                                <div class="carousel-item active">
                                    <img class="d-block w-100" src="{{ asset('Offices/Projects/default.svg') }}" alt="Default slide" style="height: 350px; object-fit: contain">
                                </div>
                            @else
                                @foreach ($Unit->UnitImages as $img)
                                    <div class="carousel-item @if ($i == 0) active @endif ">
                                        <img class="d-block w-100" src="{{ asset($img['image']) }}" alt="Slide {{ $i + 1 }}" style="height: 350px; object-fit: contain">
                                    </div>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                            @endif
                        </div>



                    </div>

                    <div class="card-body p-4 pt-3 pb-3">

                        <div class="row justify-content-between mt-2 mb-3">
                            <span class="w-auto m-0 p-0" style="font-weight: 900">
                                @lang('Residential number') :
                                    {{ $Unit->number_unit }}
                                </span>
                                @if ($Unit->type == 'rent')
                                <span class="w-auto m-0 p-0" style="color: #5c88b4;font-weight:900">{{ $Unit->getRentPriceByType() }}
                                    <sup>@lang('SAR') / {{ __($Unit->rent_type_show) }}
                                    </sup></span>
                                @endif
                                @if ($Unit->type == 'sale')
                                <span class="w-auto m-0 p-0" style="color: #5c88b4;font-weight:900">{{ $Unit->price }}
                                    <sup>@lang('SAR') / {{ __($Unit->rent_type_show) }}
                                    </sup></span>
                                @endif
                                @if ($Unit->type == 'rent and sale')
                                <span class="w-auto m-0 p-0" style="color: #5c88b4;font-weight:900">@lang('rent'){{ $Unit->getRentPriceByType() }}  <sup>@lang('SAR') / {{ __($Unit->rent_type_show) }}
                                </sup>
                                   </span>
                                @endif
                        </div>

                        <div class="row">

                            <span class=" w-auto mb-2" style="color: #989898">
                                {{$Unit->note ?? ''  }}
                            </span>



                        </div>

                        <div class="row">
                            <img src="{{ asset('dashboard/assets/new-icons/build.png') }}"
                                style="width: 18px;height: fit-content;" class="p-0" />
                            <span class=" w-auto mb-2" style="color: #989898">
                                {{ $Unit->PropertyTypeData->name ?? ''  }}
                            </span>



                        </div>

                        <div class="row justify-content-between gap-3">
                            <div class="w-auto d-flex service-iconss gap-2 p-0 align-items-center">

                                @if ($Unit->rooms)

                                <div class="rooms w-auto" style="height: fit-content;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="30"
                                        viewBox="487 829 32 32">
                                        <g data-name="Group 105615">
                                            <path
                                                d="M503 829a16 16 0 0 1 16 16 16 16 0 0 1-16 16 16 16 0 0 1-16-16 16 16 0 0 1 16-16z"
                                                fill="#f5f5f5" fill-rule="evenodd" data-name="Rectangle 29186" />
                                            <g data-name="bed">
                                                <path
                                                    d="M496.814 838.798a1.126 1.126 0 0 0-.589.6c-.072.189-.072.24-.072 2.65v2.462h-.12c-.352 0-.776.31-.91.672-.069.182-.072.258-.072 1.411v1.223h-.207c-.344 0-.344.003-.344.826s0 .827.344.827h.207v.62c0 .808-.045.757.668.757.571 0 .623-.007.678-.107.024-.048.272-1.188.272-1.26 0-.007 2.868-.01 6.37-.01 3.505 0 6.37.003 6.37.01 0 .072.248 1.212.272 1.26.055.1.107.107.678.107.713 0 .668.051.668-.758v-.62h.207c.344 0 .344-.003.344-.826s0-.826-.344-.826h-.207v-1.223c0-1.153-.003-1.229-.072-1.411-.134-.362-.558-.672-.91-.672h-.12v-2.462c0-2.41 0-2.461-.072-2.65a1.11 1.11 0 0 0-.599-.6l-.193-.072-6.032.003c-5.978 0-6.033 0-6.215.07Zm12.092.513a.565.565 0 0 1 .382.28c.066.113.07.188.08 2.516l.01 2.403h-.554v-.671c0-.592-.007-.689-.073-.86a1.11 1.11 0 0 0-.599-.6c-.186-.069-.251-.072-2.083-.072-1.832 0-1.897.003-2.083.072a1.11 1.11 0 0 0-.6.6c-.065.171-.071.268-.071.86v.671h-.551v-.671c0-.592-.007-.689-.073-.86a1.11 1.11 0 0 0-.599-.6c-.186-.069-.251-.072-2.083-.072-1.832 0-1.897.003-2.083.072a1.11 1.11 0 0 0-.6.6c-.065.171-.071.268-.071.86v.671h-.555l.01-2.403c.01-2.328.014-2.403.08-2.517a.576.576 0 0 1 .365-.279c.165-.038 11.586-.041 11.751 0Zm-7.162 3.581a.565.565 0 0 1 .383.279c.062.103.068.193.079.726l.014.613H497.799l.013-.613c.01-.533.018-.623.08-.726a.576.576 0 0 1 .364-.279c.162-.038 3.323-.041 3.488 0Zm6.06 0a.565.565 0 0 1 .383.279c.062.103.068.193.079.726l.014.613H503.859l.013-.613c.01-.533.018-.623.08-.726a.576.576 0 0 1 .364-.279c.162-.038 3.323-.041 3.488 0Zm2.204 2.204a.565.565 0 0 1 .382.279c.066.11.07.189.08 1.277l.01 1.164H495.598l.01-1.164c.011-1.088.014-1.167.08-1.277a.576.576 0 0 1 .365-.28c.165-.037 13.79-.04 13.955 0Zm1.02 3.546v.276H495.05v-.551h15.976v.275Zm-14.996 1.04c-.024.12-.062.306-.086.413l-.038.2h-.306v-.826h.475l-.045.213Zm14.444.2v.413h-.306l-.038-.2a21.05 21.05 0 0 1-.086-.413l-.045-.213h.475v.413Z"
                                                    fill="#497aac" fill-rule="evenodd" data-name="Path 29126" />
                                            </g>
                                        </g>
                                    </svg>
                                    <span>@lang('number rooms') : {{ $Unit->rooms }}</span>

                                </div>
                                @endif
                                @if ($Unit->bathrooms)

                                <div class="bathrooms w-auto d-flex align-items-center"
                                    style="height: fit-content;">
                                    <div class="cont"
                                        style="display: block; border-radius: 50%;width: 30px; background-color: whitesmoke;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30.568" height="31.229"
                                            style="    width: 18px;" viewBox="416.229 837.234 15.284 15.615">
                                            <g data-name="bathroom">
                                                <path
                                                    d="M420.264 837.263a2.462 2.462 0 0 0-1.903 1.903c-.055.26-.058.467-.058 3.334v3.059h-2.074v1.714c0 1.882.01 2.007.183 2.532a3.473 3.473 0 0 0 2.943 2.339c.18.018.485.034.677.034h.345v.671h.732v-.671h5.52v.671h.733v-.671h.36c.701-.004 1.156-.077 1.644-.275a3.541 3.541 0 0 0 2.043-2.333l.086-.305.009-1.855.009-1.851H419.035v-3.044c0-2.94.003-3.056.061-3.282.284-1.113 1.604-1.64 2.562-1.022.46.296.738.75.805 1.315l.016.143-.174.034c-.702.143-1.37.68-1.684 1.345-.162.344-.213.625-.235 1.223l-.018.543h4.929l-.019-.543c-.018-.595-.073-.875-.234-1.223-.311-.665-.982-1.202-1.681-1.342l-.17-.037-.02-.25c-.07-.985-.838-1.876-1.832-2.126a3.45 3.45 0 0 0-1.077-.03Zm2.992 3.172c.131.033.314.103.412.158.253.144.577.485.699.739.097.198.186.527.189.68v.07h-3.447v-.07c.003-.162.095-.488.198-.696.135-.265.43-.576.693-.723.366-.21.832-.268 1.256-.158Zm7.552 7.03c0 .665-.015 1.34-.033 1.504-.128 1.153-.934 2.083-2.071 2.391l-.26.07h-4.56c-4.391 0-4.568-.003-4.788-.058-1.003-.256-1.699-.909-2.031-1.909l-.086-.26-.012-1.473-.01-1.47H430.809v1.205Z"
                                                    fill="#497aac" fill-rule="evenodd" data-name="Path 29125" />
                                            </g>
                                        </svg>
                                    </div>
                                    <span>@lang('Number bathrooms') : {{ $Unit->bathrooms }}</span>


                                </div>
                                @endif
                                @if ($Unit->space)

                                <div class="area w-auto" style="height: fit-content;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="30"
                                        viewBox="326 829 32 32">
                                        <g data-name="Group 105616">
                                            <path
                                                d="M342 829a16 16 0 0 1 16 16 16 16 0 0 1-16 16 16 16 0 0 1-16-16 16 16 0 0 1 16-16z"
                                                fill="#f5f5f5" fill-rule="evenodd" data-name="Rectangle 29186" />
                                            <g data-name="plans (1)">
                                                <path
                                                    d="M334.174 837.502c-.038.038-.274.404-.527.81-.384.618-.457.757-.457.858 0 .088.022.145.08.198.072.076.094.08.437.08h.363l.01.627c.009.614.012.63.084.709.06.063.108.082.208.082.101 0 .149-.02.209-.082.072-.079.075-.095.085-.71l.01-.627h.362c.343 0 .365-.003.438-.079.057-.053.079-.11.079-.198 0-.101-.073-.24-.457-.858-.253-.406-.49-.772-.527-.81-.05-.053-.104-.072-.199-.072-.094 0-.148.019-.198.072Zm.552 1.337c.012.031-.07.04-.35.04-.202 0-.366-.009-.366-.018 0-.01.082-.151.18-.31l.182-.29.17.269c.092.148.177.29.184.309Z"
                                                    fill="#497aac" fill-rule="evenodd" data-name="Path 29127" />
                                                <path
                                                    d="m336.403 837.512-.076.082v12.666l.088.085.085.089h12.667l.082-.076.082-.076v-5.457c-.003-4.24-.01-5.47-.04-5.507-.108-.139-.335-.151-.452-.025-.056.063-.06.164-.069 2.471l-.006 2.409-.596.01c-.583.009-.6.012-.678.084a.236.236 0 0 0-.082.183c0 .278.117.325.82.325h.536V849.85h-7.819v-.677c0-.766-.015-.836-.198-.896-.126-.04-.227-.012-.322.092-.06.063-.063.123-.072.775l-.01.706h-3.433v-11.853h3.436l.007 4.325c.01 4.792-.007 4.439.217 4.505.139.044.3-.025.344-.148.019-.044.031-.489.031-.993v-.911l2.437-.003c1.8 0 2.462-.01 2.544-.038a.28.28 0 0 0 .158-.369c-.082-.195.022-.19-2.68-.19h-2.459v-6.178h7.819v.318c0 .423.06.53.293.533a.242.242 0 0 0 .195-.079c.08-.075.08-.082.08-.64 0-.548-.004-.564-.073-.63l-.073-.07h-12.708l-.075.083Z"
                                                    fill="#497aac" fill-rule="evenodd" data-name="Path 29128" />
                                                <path
                                                    d="M334.227 841.07a.303.303 0 0 0-.12.146c-.025.072-.034 1.135-.034 3.64v3.544h-.363c-.346 0-.368.003-.44.08-.058.053-.08.11-.08.198 0 .104.073.24.445.845.246.397.485.763.533.813.12.123.29.123.41-.003.047-.047.286-.413.532-.81.372-.606.445-.741.445-.845 0-.088-.022-.145-.08-.199-.072-.076-.094-.079-.44-.079h-.363v-3.543c0-2.51-.01-3.569-.035-3.641a.324.324 0 0 0-.27-.193.425.425 0 0 0-.14.048Zm.499 7.936a4.05 4.05 0 0 1-.183.312l-.17.268-.183-.29a3.68 3.68 0 0 1-.18-.31c0-.009.164-.018.366-.018.28 0 .362.01.35.038Z"
                                                    fill="#497aac" fill-rule="evenodd" data-name="Path 29129" />
                                                <path
                                                    d="M337.238 851.65c-.397.246-.763.486-.81.533a.27.27 0 0 0 0 .41c.047.047.413.287.81.533.605.372.741.444.845.444.088 0 .145-.022.199-.078.075-.073.078-.095.078-.442v-.362h8.954v.362c0 .347.003.37.078.442.054.056.11.078.199.078.1 0 .24-.072.857-.457.407-.252.773-.488.81-.526.101-.095.101-.303 0-.397-.037-.038-.403-.275-.81-.527-.617-.384-.756-.457-.857-.457-.088 0-.145.022-.199.079-.075.072-.078.094-.078.441v.363h-8.954v-.363c0-.347-.003-.369-.078-.441-.054-.057-.11-.079-.199-.079-.104 0-.24.073-.845.445Zm.555.738c0 .199-.01.363-.019.363-.01 0-.151-.082-.309-.18l-.29-.183.284-.18c.157-.1.296-.182.312-.182.013 0 .022.164.022.362Zm10.416-.183.29.183-.268.17a5.19 5.19 0 0 1-.31.183c-.03.013-.04-.069-.04-.35 0-.201.01-.365.019-.365.01 0 .151.082.309.18Z"
                                                    fill="#497aac" fill-rule="evenodd" data-name="Path 29130" />
                                            </g>
                                        </g>
                                    </svg>
                                    <span>@lang('Area (square metres)') : {{ $Unit->space }}</span>

                                </div>
                                @endif

                                <div class="row justify-content-between m-0 p-0 mt-2 mb-3">
                                    <!-- Add eye icon -->
                                    <span class="w-auto m-0 p-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                            <path d="M8 1a7 7 0 0 1 7 7c0 3.07-2.5 5.572-5.571 5.572A5.573 5.573 0 0 1 2.429 8 5.573 5.573 0 0 1 8 2.429 5.573 5.573 0 0 1 13.571 8 7 7 0 0 1 8 1zm0 2a5 5 0 0 0-5 5c0 1.993 1.226 3.714 3 4.413V11a1 1 0 0 0 2 0v-.586c1.774-.699 3-2.42 3-4.413a5 5 0 0 0-5-5zm0 4a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                                        </svg>
                                        {{ $unitVisitorsCount[$Unit->id] ?? 0 }}
                                    </span>
                                </div>
                            </div>

                        </div>
                        <div class="row gallery-services mb-3"
                        style="
                         @if (!$Unit->daily_rent ) visibility:hidden @endif">
                        <p class="w-auto m-0 p-0" style="color: #989898">متاج @lang('Daily Rent')</p>
                            <div class="text-container">
                                <span class="text-with-ellipsis">
                                <span>{{ $Unit->UnitRentPrice->daily  }}</span>

                                </span>
                            </div>

                     </div>
                        <div class="row justify-content-between gap-3">
                            @if ($Unit->UnitFeatureData->isNotEmpty() && $Unit->UnitFeatureData->whereNotNull('qty')->isNotEmpty())
                            <div class="d-block text-black">
                                <strong>@lang('Additional details')</strong>
                            </div>
                            <ol class="list-group list-group-numbered">
                                @foreach ($Unit->UnitFeatureData as $feature)
                                    @if ($feature->qty)
                                        <span>{{ $feature->FeatureData->name ?? '' }} : {{ $feature->qty }}</span>
                                    @endif
                                @endforeach
                            </ol>
                        @endif


                        @if ($Unit->UnitServicesData->isNotEmpty())
                        <div class="d-block text-black" role="alert">
                            <strong>@lang('Property features')</strong>
                        </div>
                        <ol class="list-group list-group-numbered">
                            <span class="text-with-ellipsis">
                                @foreach ($Unit->UnitServicesData as $service)
                                    <span>{{ $service->ServiceData->name ?? '' }}</span>
                                @endforeach
                            </span>
                        </ol>
                    @endif

                        </div>

                    </div>
                </div>

                <div class="card border-0"
                    style="border-radius: 20px;filter:drop-shadow(0px 3px 3px rgba(161,137,137,0.09 ));">
                    <p class="font-weight-bold">
                        <img src="{{ asset('dashboard/assets/new-icons/Iconly_Light_Locatio.png') }}"
                        style="width: 18px;height: fit-content;" class="p-0" />
                    <span class=" w-auto mb-2" style="color: #989898"> @lang('Region') -
                        {{ $Unit->CityData->RegionData->name ?? '' }} - @lang('city')  -
                        {{ $Unit->CityData->name ?? '' }}
                        </span>
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
                        @if (!empty($brokers->avatar))
                            <img src="{{ $brokers->avatar }}" alt="user" class="img-fluid rounded-circle">
                        @else
                            <img src="{{ asset('https://www.svgrepo.com/show/29852/user.svg') }}" alt="Default User" class="img-fluid rounded-circle">
                        @endif
                    </div>


                    <div class="w-auto">
                        <p class="mb-0 font-weight-bold">{{ $brokers->name}}</p>
                        <p class="mb-0 font-weight-bold">رقم رخصة فال : {{ $broker->broker_license}}</p>
                        @if( $brokers->is_broker)
                        <p class="mb-0 font-weight-bold">@lang('Broker')</p>
                        @endif
                        @php
                            $createdAt = new DateTime($brokers->created_at);

                            // Get the month name
                            $monthName = $createdAt->format('F');

                            // Get the number of days in the month
                            $numDay = $createdAt->format('d');
                            $yearName = $createdAt->format('Y');


                        @endphp
                        <span style="font-size: 13px">عضو منذ
                             {{ $monthName }} {{ $numDay }} {{ $yearName }}
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
                                    {!! QrCode::size(150)->generate(route('gallery.showUnitPublic', ['gallery_name' => $gallery->gallery_name, 'id' => $Unit->id])) !!}

                                </div>
                                <div class="d-flex gap-4" style="flex: auto;flex-direction:column">
                                    <p>قم بتحميل الكود لكي تستطيع مشاركته مع اصدقائك لكي يمكنهم الوصول الي بيانات هذا العقار
                                        عن طريق الجوال
                                    </p>
                                    @php
                                        $url = "route('gallery.showUnitPublic', ['gallery_name' => $gallery->gallery_name, 'id' => $Unit->id]) ";
                                    @endphp
                                    <a href="{{ route('download.qrcode', $url) }}" class="d-block btn btn-new-b mt-3" style="width: fit-content">Download QR Code</a>

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
