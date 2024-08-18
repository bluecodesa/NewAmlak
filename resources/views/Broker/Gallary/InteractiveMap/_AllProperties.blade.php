              <!-- Filter Dropdowns -->
              <div class="row mb-3">
                <div class="col-md-2">
                    <select id="adTypeFilter" class="form-select">
                        <option value="">@lang('Ad type')</option>
                        <option value="rent">@lang('rent')</option>
                        <option value="sale">@lang('sale')</option>
                        <option value="rent and sale">@lang('rent and sale')</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="propertyTypeFilter" class="form-select">
                        <option value="">@lang('Property type')</option>
                        <!-- Populate property types dynamically -->
                        @foreach($propertyTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="typeUseFilter" class="form-select">
                        <option value="">@lang('Type use')</option>
                        <!-- Populate usages dynamically -->
                        @foreach($usages as $usage)
                            <option value="{{ $usage->id }}">{{ $usage->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="cityFilter" class="form-select">
                        <option value="">@lang('City')</option>
                        <!-- Populate cities dynamically -->
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="districtFilter" class="form-select">
                        <option value="">@lang('districts')</option>
                        <!-- Populate districts dynamically -->
                        @foreach($districts as $district)
                            <option value="{{ $district->id }}">{{ $district->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="projectFilter" class="form-select">
                        <option value="">@lang('Project')</option>
                        <!-- Populate projects dynamically -->
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    @include('Admin.layouts.Inc._errors')
                    <div id="mapAll" style="width: 100%; height: 70vh;"></div>
                </div>
            </div>
