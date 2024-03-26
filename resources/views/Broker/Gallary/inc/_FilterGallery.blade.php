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
            <div class="w-auto col-4">
                <span>@lang('Type use')</span>
                <select class="form-control form-control-sm" id="type_use_filter" name="type_use_filter">
                    @foreach ($usages as $usage)
                    <option value="{{ $usage->id }}">
                    {{ $usage->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-auto col-4">
                <span>@lang('city')</span>
                <select class="form-control form-control-sm" id="city_filter" name="city_filter">
                    @foreach ($uniqueIds as $index => $id)
                    <option value="{{ $id }}">{{ $uniqueNames[$index] }}</option>
                    @endforeach
                </select>

            </div>
            <div class="w-auto col-4">
                <span>@lang('districts')</span>
                <select class="form-control form-control-sm" id="district_filter" name="district_filter">
                    @foreach ($uniqueDistrictIds as $index => $id)
                        <option value="{{ $id }}">{{ $uniqueDistrictNames[$index] }}</option>
                    @endforeach
                </select>
            </div>



            <div class="w-auto col-4">
                <span>@lang('Project')</span>
                <select class="form-control form-control-sm" id="project_filter" name="project_filter">
                    @foreach ($units as $unit)
                        @if ($unit->PropertyData && $unit->PropertyData->ProjectData)
                            <option value="{{ $unit->PropertyData->ProjectData->id }}">{{ $unit->PropertyData->ProjectData->name }}</option>
                        @endif
                    @endforeach
                </select>

            </div>
            <div class="w-auto text-center col-12">
                <button type="submit" class="btn btn-primary mt-2 btn-sm">@lang('Filter')</button>
                <a href="{{ route('Broker.Gallery.index') }}" class="btn btn-danger mt-2 btn-sm">@lang('Cancel')</a>
            </div>
        </div>
    </form>
        </div>
    </div>
</div>
