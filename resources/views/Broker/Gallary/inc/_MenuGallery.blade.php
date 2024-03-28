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
                                action="{{ route('Broker.gallery.unit.destroy', $unit->id) }}"
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

