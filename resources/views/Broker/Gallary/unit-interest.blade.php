@extends('Admin.layouts.app')
@section('title', __('Gallary'))
@section('content')

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">
                                @lang('Requests for interest')</h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item active"><a
                                        href="{{ route('Broker.Gallary.showInterests') }}">@lang('Requests for interest')</a>
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
                                <form action="{{ route('Broker.Gallary.showInterests') }}" method="GET" id="interestsForm">

                                <div class="row" style="align-items: end;">
                                    <div class="w-auto  p-0 ml-2">
                                        <span>@lang('status')</span>
                                    <select class="form-control form-control-sm" id="status_filter" name="status_filter" onchange="reloadInterests()">
                                        <option value="all" {{ $statusFilter == 'all' ? 'selected' : '' }}>@lang('All')</option>
                                        @foreach ($interestsTypes as $interestsType)
                                        <option value="{{ __($interestsType->name) }}"  {{ $statusFilter == $interestsType->name ? 'selected' : '' }}>
                                            {{ __($interestsType->name) }}
                                        </option>
                                    @endforeach

                                    </select>
                                    </div>
                                    <div class="w-auto  p-0 ml-2">
                                        <span>@lang('Project')</span>
                                        <select class="form-control form-control-sm " id="prj_filter" required="" name="prj_filter" style="width:95%!important" onchange="reloadInterests()">
                                            <option value="all" {{ $projectFilter == 'all' ? 'selected' : '' }}>@lang('All')</option>
                                            @foreach ($unitInterests as $unitInterest)
                                                @if ($unitInterest->PropertyData && $unitInterest->PropertyData->ProjectData)
                                                    <option value="{{ $unitInterest->PropertyData->ProjectData->id }}" {{ $projectFilter == $unitInterest->PropertyData->ProjectData->id ? 'selected' : '' }}>
                                                        {{ $unitInterest->PropertyData->ProjectData->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="w-auto  p-0 ml-2">
                                        <span>@lang('property')</span>
                                        <select class="form-control form-control-sm" id="prop_filter" required="" name="prop_filter" style="width:95%!important" onchange="reloadInterests()">
                                            <option value="all" {{ $propFilter == 'all' ? 'selected' : '' }}>@lang('All')</option>
                                            @foreach ($unitInterests as $unitInterest)
                                                @if ($unitInterest->PropertyData )
                                                    <option value="{{ $unitInterest->PropertyData->id }}" {{ $propFilter == $unitInterest->PropertyData->id ? 'selected' : '' }}>
                                                        {{ $unitInterest->PropertyData->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="w-auto  p-0 ml-2">
                                        <span>@lang('Unit')</span>
                                        <select class="form-control form-control-sm" id="unit_filter" required="" name="unit_filter" style="width:95%!important" onchange="reloadInterests()">
                                            <option value="all" {{ $unitFilter == 'all' ? 'selected' : '' }}>@lang('All')</option>
                                            @foreach ($unitInterests as $unitInterest)
                                            @if ($unitInterest->unit )
                                                <option value="{{ $unitInterest->unit->id }}" {{ $unitFilter == $unitInterest->unit->id ? 'selected' : '' }}>
                                                    {{ $unitInterest->unit->number_unit }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    </div>

                                    <div class="w-auto  p-0 ml-2">
                                        <span>@lang('Client Name')</span>
                                        <select class="form-control form-control-sm" id="client_filter" required="" name="client_filter" style="width:95%!important" onchange="reloadInterests()">
                                            <option value="all" {{ $clientFilter == 'all' ? 'selected' : '' }}>@lang('All')</option>
                                            @foreach ($unitInterests as $unitInterest)
                                            @if ($unitInterest->name )
                                                <option value="{{ $unitInterest->id }}" {{ $clientFilter == $unitInterest->id ? 'selected' : '' }}>
                                                    {{ $unitInterest->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary">@lang('Filter')</button>
                                        <a href="{{ route('Broker.Gallary.showInterests') }}" class="btn btn-danger">@lang('Cancel')</a>
                                    </div>
                                </div>
                                </form>
                                    <div class="table-responsive b-0" data-pattern="priority-columns">
                                        <table id="datatable-buttons"
                                            class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>@lang('Residential number')</th>
                                                    <th>@lang('property')</th>
                                                    <th>@lang('Client Name')</th>
                                                    <th>@lang('phone')</th>
                                                    <th>@lang('status')</th>
                                                    <th>@lang('Action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($unitInterests as $index => $client)
                                                    <tr>

                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $client->unit->number_unit ?? '' }}</td>
                                                        <td>{{ $client->unit->PropertyData->name ?? __('nothing') }}</td>
                                                        <td> {{ $client->name }}</td>
                                                        <td>{{ $client->whatsapp }}</td>
                                                        <td>
                                                            <form method="POST" action="{{ route('Broker.Interest.status.update', $client->id) }}">
                                                                @csrf
                                                                <input type="hidden" name="id" value="{{ $client->id }}">
                                                                <select class="form-control select-input w-auto" name="status" onchange="this.form.submit()">
                                                                    @foreach ($interestsTypes as $interestsType)
                                                                        <option value="{{ __($interestsType->name) }}" {{ $client->status == __($interestsType->name) ? 'selected' : '' }}>
                                                                            {{ __($interestsType->name) }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <button type="submit" class="submit-from" hidden=""></button>
                                                            </form>

                                                        </td>

                                                        <td>
                                                            <a class="share btn btn-outline-secondary btn-sm waves-effect waves-light" data-toggle="modal" data-target="#shareLinkUnit{{ $client->id }}"
                                                                href="tel:{{ env('COUNTRY_CODE') . $client->whatsapp }}" onclick="document.querySelector('#shareLinkUnit{{ $client->id }} ul.share-tabs.nav.nav-tabs li:first-child a').click()">
                                                                @lang('مكالمة')</a>

                                                            <a href="https://web.whatsapp.com/send?phone={{ env('COUNTRY_CODE') . $client->whatsapp }}"
                                                                class="btn btn-outline-warning btn-sm waves-effect waves-light">@lang('محادثة(شات)')</a>


                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>


                        </div> <!-- /.card-body -->

                    </div> <!-- / .card -->
                     </div>

            </div> <!-- / .card -->

        </div>
    </div>
</div> <!-- .row-->


@endsection
