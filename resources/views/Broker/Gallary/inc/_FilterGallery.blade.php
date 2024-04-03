<div class="col-xl-12">
    <div class="card m-b-30">
        <div class="card-body">
            <form action="{{ route('Broker.Gallery.index') }}" method="GET" id="subscriptionsForm">
                <div class="row">
                    <div class="w-auto col-4">
                        <span>@lang('Ad type')</span>
                        <select class="form-control form-control-sm" id="ad_type_filter" name="ad_type_filter">
                            <option value="all" {{ $adTypeFilter == 'all' ? 'selected' : '' }}>@lang('All')</option>
                            @foreach (['rent', 'sale', 'rent_sale'] as $type)
                                <option value="{{ $type }}" {{ $adTypeFilter == $type ? 'selected' : '' }}>
                                    {{ __($type) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-auto col-4">
                        <span>@lang('Type use')</span>
                        <select class="form-control form-control-sm" id="type_use_filter" name="type_use_filter">
                            <option value="all" {{ $typeUseFilter == 'all' ? 'selected' : '' }}>@lang('All')</option>
                            @foreach ($usages as $usage)
                                <option value="{{ $usage->id }}" {{ $typeUseFilter == $usage->id ? 'selected' : '' }}>
                                    {{ $usage->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-auto col-4">
                        <span>@lang('City')</span>
                        <select class="form-control form-control-sm" id="city_filter" name="city_filter">
                            <option value="all" {{ $cityFilter == 'all' ? 'selected' : '' }}>@lang('All')</option>
                            @foreach ($uniqueIds as $index => $id)
                                <option value="{{ $id }}" {{ $cityFilter == $id ? 'selected' : '' }}>
                                    {{ $uniqueNames[$index] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-auto col-4">
                        <span>@lang('districts')</span>
                        <select class="form-control form-control-sm" id="district_filter" name="district_filter">
                            <option value="all" {{ $districtFilter == 'all' ? 'selected' : '' }}>@lang('All')</option>
                            @foreach ($uniqueDistrictIds as $index => $id)
                                <option value="{{ $id }}" {{ $districtFilter == $id ? 'selected' : '' }}>
                                    {{ $uniqueDistrictNames[$index] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-auto col-4">
                        <span>@lang('Project')</span>
                        <select class="form-control form-control-sm" id="project_filter" name="project_filter">
                            <option value="all" {{ $projectFilter == 'all' ? 'selected' : '' }}>@lang('All')</option>
                            @foreach ($projectuniqueIds as $index => $id)
                                    <option value="{{ $id }}" {{ $projectFilter == $id ? 'selected' : '' }}>
                                        {{ $projectUniqueNames[$index] }}
                                    </option>
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



<script>
    // Add an event listener to the submit button
    document.querySelector('#subscriptionsForm').addEventListener('submit', function(event) {
        // Get the selected filter values
        let adTypeFilter = document.querySelector('select#ad_type_filter').value;
        let typeUseFilter = document.querySelector('select#type_use_filter').value;
        let cityFilter = document.querySelector('select#city_filter').value;
        let districtFilter = document.querySelector('select#district_filter').value;
        let projectFilter = document.querySelector('select#project_filter').value;

        // Update the hidden input fields with the selected filter values
        document.querySelector('input#ad_type_filter').value = adTypeFilter;
        document.querySelector('input#type_use_filter').value = typeUseFilter;
        document.querySelector('input#city_filter').value = cityFilter;
        document.querySelector('input#district_filter').value = districtFilter;
        document.querySelector('input#project_filter').value = projectFilter;
    });
</script>
