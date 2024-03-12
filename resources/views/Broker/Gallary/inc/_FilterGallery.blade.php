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
                <button type="submit" class="w-auto btn btn-primary mt-2 btn-sm">@lang('Filter')</button>
            </div>
        </div>
    </form>
        </div>
    </div>
</div>
