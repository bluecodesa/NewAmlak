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
