@extends('Admin.layouts.app')
@section('title', __('Add unit'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-sm-6">
                                    <h4 class="page-title">
                                        @lang('Add unit')</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            @include('Admin.layouts.Inc._errors')
                            <div class="card-body">
                                <form action="{{ route('Broker.Property.StoreUnit', $id) }}" method="POST" class="row"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('post')
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                {{ __('Residential unit number') }} <span
                                                    class="required-color">*</span></label>
                                            <input type="text" required id="modalRoleName" name="number_unit"
                                                class="form-control" placeholder="{{ __('Residential unit number') }}">
                                        </div>
                                    </div>


                                    <div class="form-group col-md-4 mb-3">
                                        <label>@lang('owner name') <span class="required-color">*</span> </label>
                                        <select class="form-control" name="owner_id" required>
                                            <option disabled selected value="">@lang('owner name')</option>
                                            @foreach ($owners as $owner)
                                                <option value="{{ $owner->id }}">
                                                    {{ $owner->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-sm-12 col-md-4 mb-3">
                                        <label class="form-label">@lang('Area (square metres)') <span
                                                class="required-color">*</span></label>
                                        <input type="number" required name="space" class="form-control"
                                            placeholder="@lang('Area (square metres)')" value="{{ old('Area (square metres)') }}" />
                                    </div>


                                    <div class="col-sm-12 col-md-4 mb-3">
                                        <label class="form-label">@lang('number rooms') <span
                                                class="required-color">*</span></label>
                                        <input type="number" required name="rooms" class="form-control"
                                            placeholder="@lang('number rooms')" value="{{ old('number rooms') }}" />
                                    </div>



                                    <div class="col-sm-12 col-md-4 mb-3">
                                        <label class="form-label">@lang('Number bathrooms') <span
                                                class="required-color">*</span></label>
                                        <input type="number" required name="bathrooms" class="form-control"
                                            placeholder="@lang('Number bathrooms')" value="{{ old('Number bathrooms') }}" />
                                    </div>



                                    <div class="col-sm-12 col-md-4 mb-3">
                                        <label class="form-label">@lang('price') <span
                                                class="required-color">*</span></label>
                                        <input type="number" required name="price" class="form-control"
                                            placeholder="@lang('price')" value="{{ old('price') }}" />
                                    </div>


                                    <div class="form-group col-md-6">
                                        <label>@lang('Ad type') <span class="required-color">*</span> </label>
                                        <select class="form-control" name="type" id="type" required>
                                            <option disabled value="">@lang('Ad type') </option>
                                            @foreach (['rent', 'sale', 'rent_sale'] as $type)
                                                <option value="{{ $type }}">
                                                    {{ __($type) }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="form-group col-md-6 mb-3">
                                        <label>@lang('services') <span class="required-color">*</span> </label>
                                        <select class="select2 form-control" name="service_id[]" multiple="multiple"
                                            required>
                                            <option disabled value="">@lang('services')</option>
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id }}">
                                                    {{ $service->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    {{-- <div class="form-group col-md-4 mb-3">


                                        <label class="form-label">@lang('features') <span
                                                class="required-color">*</span></label>
                                        <div class="row" id="features">
                                            <div class="col">
                                                <input type="number" required name="name[]" class="form-control"
                                                    placeholder="@lang('feature name')" value="{{ old('feature name') }}" />
                                            </div>
                                            <div class="col">
                                                <input type="number" required name="qty" class="form-control"
                                                    placeholder="@lang('qty')" value="{{ old('qty') }}" />
                                            </div>
                                            <div class="col">
                                                <button type="button" onclick="addFeature()"
                                                    class="btn btn-primary">@lang('Add feature') </button>
                                            </div>
                                        </div>

                                    </div> --}}
                                    <div class="form-group col-12 mb-3">
                                        <label class="form-label">@lang('features') <span
                                                class="required-color">*</span></label>
                                        <div id="features" class="row">
                                            <div class="col">
                                                <input type="text" required name="name[]" class="form-control search"
                                                    placeholder="@lang('feature name')" value="{{ old('feature name') }}" />
                                            </div>
                                            <div class="col">
                                                <input type="number" required name="qty[]" class="form-control"
                                                    placeholder="@lang('qty')" value="{{ old('qty') }}" />
                                            </div>
                                            <div class="col">
                                                <button type="button" class="btn btn-primary"
                                                    onclick="addFeature()">@lang('Add feature')</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 mb-3">
                                        <label class="form-label">@lang('Pictures property') </label>
                                        <input type="file" name="images[]" multiple class="dropify"
                                            accept="image/jpeg, image/png" />
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary me-1">

                                            {{ __('save') }}
                                        </button>

                                    </div>
                                </form>

                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div>
        <!-- container-fluid -->

    </div>
    @push('scripts')
        <script>
            var path = "{{ route('Broker.Property.autocomplete') }}";

            $(document).on("focus", ".search", function() {
                $(this).autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: path,
                            type: 'GET',
                            dataType: "json",
                            data: {
                                search: request.term
                            },
                            success: function(data) {
                                response(data);
                            }
                        });
                    },
                    select: function(event, ui) {
                        $(this).val(ui.item.label);
                        console.log(ui.item);
                        return false;
                    }
                });
            });

            function addFeature() {
                const featuresContainer = document.getElementById('features');
                const newRow = document.createElement('div');
                newRow.classList.add('row', 'mb-3'); // Add any additional classes that your grid system requires

                // Use the exact same class names and structure as your existing rows
                newRow.innerHTML = `
        <div class="col">
            <input type="text" required name="name[]" class="form-control search" placeholder="@lang('feature name')" value="" />
        </div>
        <div class="col">
            <input type="number" required name="qty[]" class="form-control" placeholder="@lang('qty')" value="" />
        </div>
        <div class="col">
            <button type="button" class="btn btn-danger" onclick="removeFeature(this)">@lang('Remove')</button>
        </div>
    `;

                featuresContainer.appendChild(newRow);
            }

            function removeFeature(button) {
                const rowToRemove = button.parentNode.parentNode;
                rowToRemove.remove();
            }
        </script>
    @endpush
@endsection
