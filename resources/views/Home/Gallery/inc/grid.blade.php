<div id="filtered-results">
    @php
        $ind = 0;
    @endphp
    @foreach ($units as $unit)
        @php
            $ind++;
        @endphp
        <div class="col-sm-12 col-md-6 p-1">

            <a href="">
                <div class="card-single p-0">
                    <input hidden name="unit_id" value="{{ $unit->id }}" />

                    <input hidden name="edit_unit_number" value="{{ __('Residential number') }}: {{ $unit->number_unit ?? '' }}" />
                    <input hidden name="edit_unit_area" value="{{ __('الاشغال') }}: الاشغال" />
                    <input hidden name="edit_unit_rooms" value="{{ __('Ad type') }}: {{ __($unit->type) ?? '' }}" />
                    <input hidden name="edit_unit_bathrooms" value="{{ __('city') }}: {{ $unit->CityData->name ?? '' }}" />
                    <input hidden name="edit_unit_view_in_gallery " value="{{ $unit->view_in_gallery }}" />
                    <input hidden name="edit_unit_owner_id" value="{{ $unit->owner_id }}" />
                    <input hidden name="edit_unit_employee_id" value="{{ $unit->employee_id }}" />

                    <div class="card">

                        <div class="card-img position-relative" style="width: 95%">

                            <div class="col-md-3">
                                <div class="row">
                                    @forelse($unit->UnitImages as $image)
                                        <div class="col-6 mb-1">
                                            <img class="rounded" src="{{ url($image->image) }}"
                                                alt="{{ $unit->number_unit }}" style="width: 100%;">
                                        </div>
                                    @empty
                                        <img class="d-flex align-self-end rounded mr-3 col"
                                            src="{{ url('Offices/Projects/default.svg') }}"
                                            alt="{{ $unit->number_unit }}" height="200">
                                    @endforelse

                                </div>
                            </div>

                            <div class="custom-cards position-absolute">
                                <div class="row justify-content-between m-0 p-0">
                                    <div class="w-auto">
                                        <a class="share" data-toggle="modal" data-target="#shareLinkUnit{{ $unit->id }}"
                                            href="" onclick="document.querySelector('#shareLinkUnit{{ $unit->id }} ul.share-tabs.nav.nav-tabs li:first-child a').click()">
                                            <img
                                                src="{{ asset('dashboard/assets/new-icons/share.png') }}"
                                                class="img-fluid" /></a>
                                        <a class="love" data-toggle="modal" data-target="#interestUnit" href=""
                                            onclick="interestUnit({{ $unit->id }})"><img
                                                src="{{ asset('dashboard/assets/new-icons/interest.png') }}"
                                                class="img-fluid" /></a>
                                    </div>
                                    <div class="w-auto">
                                        @if ($unit->type == 'rent' || $unit->type == 'both' )
                                        <span class="rent">للايجار</span>
                                        @endif
                                        @if ($unit->type == 'sale' || $unit->type == 'both' )

                                        <span class="sale">للبيع</span>
                                        @endif
                                    </div>
                                </div>

                            </div>


                        </div>
                        <div class="card-body gallery-card m-0 p-3 w-100">
                            <div class="row justify-content-between m-0 p-0 mt-2 mb-3">
                                <span class="w-auto m-0 p-0 " style="font-weight: 900">
                                    {{ __('Residential number') }} / {{ $unit->number_unit ?? '' }}</span>
                                    @if ($unit->price && !$unit->hide_price)
                                    <span class="w-auto m-0 p-0" style="color: #5c88b4;font-weight:900">{{ $unit->price }}
                                        sar</span>
                                    @endif
                            </div>
                            <div class="row m-0 p-0">
                                <img src="{{ asset('dashboard/assets/new-icons/build.png') }}"
                                    style="width: 18px;height: fit-content;" class="p-0" />

                            </div>

                            <div class="row m-0 p-0">
                                <img src="{{ asset('dashboard/assets/new-icons/Iconly_Light_Locatio.png') }}"
                                    style="width: 18px;height: fit-content;" class="p-0" />
                                <span class="mb-2 w-auto" style="color: #989898">


                                    </span>
                            </div>
                        </div>
                        <div class="card-footer bg-white text-center p-0" style="    border-top: 1px solid #ededed;">
                            <div class="row m-0 p-0">
                                <div class="col-6 p-3" style="border-left: 1px solid #ededed">

                                    <a
                                        href="tel:"><img
                                            src="{{ asset('dashboard/assets/new-icons/call.png') }}"
                                            style="width: 22px;height: fit-content;" class="p-0" /></a>


                                </div>
                                <div class="col-6 p-3">
                                    <a href="https://web.whatsapp.com/send?phone={{ env('COUNTRY_CODE') }}"
                                        target="_blank"> <img src="{{ asset('dashboard/assets/new-icons/chatt.png') }}"
                                            style="width: 22px;height: fit-content;" class="p-0" /></a>


                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </a>
        </div>



        <div class="modal fade" id="shareLinkUnit{{ $unit->id }}" tabindex="-1" role="dialog" aria-labelledby="shareLinkTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <ul class="share-tabs nav nav-tabs">
                            <li class="shareLinkUnit{{ $unit->id }} active"><a href="#shareLinkUnit{{ $unit->id }}" onclick="share('shareLinkUnit{{ $unit->id }}')">مشاركة الرابط</a>
                            </li>
                            <li class="qrCodeUnit{{ $unit->id }}"><a href="#qrCodeUnit{{ $unit->id }}" onclick="share('qrCodeUnit{{ $unit->id }}')">qr code</a></li>

                        </ul>
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
                                <input readonly class="w-75" style="text-align: left" id="share-url"
                                    value="{{ route('gallery.showUnitPublic', ['gallery_name' => $gallery->gallery_name, 'id' => $unit->id]) }}" />
                            </div>

                            @php
                                $url =  route('gallery.showUnitPublic', ['gallery_name' => $gallery->gallery_name, 'id' => $unit->id]) ;
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
                        <div id="qrCodeUnit{{ $unit->id }}" class="second">

                            <div class="row pb-5 pt-4 flex-nowrap align-items-center">
                                <div class="w-auto">

                                </div>
                                <div class="d-flex gap-4" style="flex: auto;flex-direction:column">
                                    <p>قم بتحميل الكود لكي تستطيع مشاركته مع اصدقائك لكي يمكنهم الوصول الي بيانات هذا العقار
                                        عن طريق الجوال
                                    </p>
                                    @php
                                        $url = "route('galleryOfficeUnit', ['gallery_name' => $unit->gallery_name, 'id' => $unit->id])";
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
    @endforeach
</div>
