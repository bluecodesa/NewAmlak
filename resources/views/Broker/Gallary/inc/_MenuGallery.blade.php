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
                        <td>{{ __($unit->status) }}</td>
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
                                <input type="radio" name="options" id="option1" checked onclick="toggleShare('share-link')"> مشاركه الرابط
                            </label>
                            <label class="btn btn-light">
                                <input type="radio" name="options" id="option2" onclick="toggleShare('qr-code')"> QR Code
                            </label>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body share-divs">
                    <div id="share-link">
                        <h6>مشاركة الرابط</h6>
                        <p>مشاركة لينك العقار او انسخه في موقعك</p>
                        <div class="row link justify-content-between">
                            <div class="w-auto" onclick="copy()" style="cursor: pointer"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="20.782" height="30.633"
                                    viewBox="1039.055 450.797 19.891 24.817">
                                    <!-- SVG content for copying link -->
                                </svg></div>
                                <div class="input-group">
                                <input type="text" class="form-control"
                                id="galleryName" disabled
                                value="{{ env('APP_URL', 'https://newamlak.tryamlak.com') }}/ar/gallery/{{ $gallery->gallery_name }}/{{ $unit->id }}">
                            <div class="input-group-append">
                                <span class="input-group-text"
                                    style="cursor: pointer;"
                                    onclick="selectText()">
                                    <i class="fas fa-copy"></i>
                                </span>
                            </div>
                                </div>
                        </div>
                    </div>
                    <div id="qr-code" style="display: none;">
                        <div class="row pb-5 pt-4 flex-nowrap align-items-center">
                            <div class="w-auto">
                                {!! QrCode::size(150)->generate(route('gallery.showUnitPublic', ['gallery_name' => $gallery->gallery_name, 'id' => $unit->id])) !!}
                            </div>
                            <div class="d-flex gap-4" style="flex: auto;flex-direction:column">
                                <p>قم بتحميل الكود لكي تستطيع مشاركته مع اصدقائك لكي يمكنهم الوصول الي بيانات هذا العقار
                                    عن طريق الجوال
                                </p>
                                @php
                                    $url = "route('gallery.showUnitPublic', ['gallery_name' => $gallery->gallery_name, 'id' => $unit->id])";
                                @endphp
                                <a href="{{ route('download.qrcode', $url) }}" class="d-block btn btn-new-b mt-3" style="width: fit-content">Download QR Code</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    @endforeach
    </div>

    <script>
        function toggleShare(type) {
            if (type === 'share-link') {
                document.getElementById('share-link').style.display = 'block';
                document.getElementById('qr-code').style.display = 'none';
            } else if (type === 'qr-code') {
                document.getElementById('share-link').style.display = 'none';
                document.getElementById('qr-code').style.display = 'block';
            }
        }
    </script>

