<div class="col-xl-12">
    <div class="card m-b-30 shadow-none bg-transparent">
        <div class="card-body">
            <form action="{{ route('Broker.Gallery.index') }}" method="GET" id="subscriptionsForm">
                <div class="row">
                    <div class="col-md-4 col-12 mb-3">
                        <label class="form-label">@lang('Ad type')</label>
                        <select class="form-select form-control-sm" id="ad_type_filter" name="ad_type_filter">
                            <option value="all" {{ $adTypeFilter == 'all' ? 'selected' : '' }}>@lang('All')
                            </option>
                            @foreach (['rent', 'sale'] as $type)
                                <option value="{{ $type }}" {{ $adTypeFilter == $type ? 'selected' : '' }}>
                                    {{ __($type) }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-md-4 col-12 mb-3">
                        <label class="form-label">@lang('Property type')</label>
                        <select class="form-select form-control-sm" id="property_type_filter"
                            name="property_type_filter">
                            <option value="all" {{ $propertyTypeFilter == 'all' ? 'selected' : '' }}>
                                @lang('All')
                            </option>
                            @foreach ($propertyTypeIds as $index => $id)
                                <option value="{{ $id }}" {{ $propertyTypeFilter == $id ? 'selected' : '' }}>
                                    {{ $propertyTypeNames[$index] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 col-12 mb-3">
                        <label class="form-label">@lang('Type use')</label>
                        <select class="form-select form-control-sm" id="type_use_filter" name="type_use_filter">
                            <option value="all" {{ $typeUseFilter == 'all' ? 'selected' : '' }}>@lang('All')
                            </option>
                            @foreach ($usages as $usage)
                                <option value="{{ $usage->id }}"
                                    {{ $typeUseFilter == $usage->id ? 'selected' : '' }}>
                                    {{ $usage->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col-12 mb-3">
                        <label class="form-label">@lang('City')</label>
                        <select class="form-select form-control-sm" id="city_filter" name="city_filter">
                            <option value="all" {{ $cityFilter == 'all' ? 'selected' : '' }}>@lang('All')
                            </option>
                            @foreach ($uniqueIds as $index => $id)
                                <option value="{{ $id }}"
                                    data-url="{{ route('Broker.Gallary.GetDistrictByCity', $id) }}"
                                    {{ $cityFilter == $id ? 'selected' : '' }}>
                                    {{ $uniqueNames[$index] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col-12 mb-3">
                        <label class="form-label">@lang('districts')</label>
                        <select class="form-select form-control-sm" id="district_filter" name="district_filter">
                            <option value="all" {{ $districtFilter == 'all' ? 'selected' : '' }}>@lang('All')
                            </option>
                            @foreach ($districts as $index => $district)
                                <option value="{{ $district->district_id }}"
                                    {{ $districtFilter == $district->district_id ? 'selected' : '' }}>
                                    {{ $district->DistrictData->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col-12 mb-3">
                        <label class="form-label">@lang('Project')</label>
                        <select class="form-select form-control-sm" id="project_filter" name="project_filter">
                            <option value="all" {{ $projectFilter == 'all' ? 'selected' : '' }}>@lang('All')
                            </option>
                            @foreach ($projectuniqueIds as $index => $id)
                                <option value="{{ $id }}" {{ $projectFilter == $id ? 'selected' : '' }}>
                                    {{ $projectUniqueNames[$index] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col-12 mb-3">
                        <label class="form-label">@lang('Daily Rent')</label>
                        <select class="form-select form-control-sm" id="daily_filter" name="daily_filter">
                            <option value="all" {{ $dailyFilter == 'all' ? 'selected' : '' }}>@lang('All')
                            </option>
                            @foreach (['Available', 'Not_Available'] as $type)
                                <option value="{{ $type }}" {{ $dailyFilter == $type ? 'selected' : '' }}>
                                    {{ __($type) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary mt-2 btn-sm">@lang('Filter')</button>
                        <a href="{{ route('Broker.Gallery.index') }}"
                            class="btn btn-danger mt-2 btn-sm">@lang('Cancel')</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@push('scripts')
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

        $('#city_filter').on('change', function() {
            var selectedOption = $(this).find(':selected');
            var url = selectedOption.data('url');
            $.ajax({
                type: "get",
                url: url,
                beforeSend: function() {
                    $('#district_filter').fadeOut('fast');
                },
                success: function(data) {
                    $('#district_filter').fadeOut('fast', function() {
                        $(this).empty().append(data);
                        $(this).fadeIn('fast');
                    });
                },
            });
        });


        // Add an event listener to the city dropdown
        // $('#city_filter').on('change', function() {
        //     console.log('City selected:', $(this).val()); // Add this line to check if the event is triggered

        //     var cityId = $(this).val();

        //     // Filter districts based on the selected city
        //     var filteredDistricts = allDistricts.filter(function(district) {
        //         return district.city_id == cityId;
        //     });

        //     // Clear existing options and populate the districts dropdown with filtered data
        //     $('#district_filter').empty();
        //     $('#district_filter').append($('<option>', {
        //         value: 'all',
        //         text: '@lang('All')'
        //     }));

        //     filteredDistricts.forEach(function(district) {
        //         $('#district_filter').append($('<option>', {
        //             value: district.id,
        //             text: district.name
        //         }));
        //     });
        // });
    </script>
@endpush
