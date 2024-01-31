@extends('Admin.layouts.app')
@section('title', __('Add New Permission'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">
                                @lang('Add New Permission')</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <form action="{{ route('Admin.Permissions.store') }}" method="POST" class="row">
                                    @csrf
                                    <div class="form-group col-md-6">
                                        <label>@lang('Name') @lang('en') <span class="required-color">*</span>
                                        </label>
                                        <input type="text" required name="name" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>@lang('Name') @lang('ar') <span
                                                class="required-color">*</span></label>
                                        <input type="text" required name="name_ar" class="form-control">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>@lang('Model') <span class="required-color">*</span></label>
                                        <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                            <select name="model" required class="form-control" id="modelSelect">
                                                <option value="" disabled selected> @lang('Model') </option>
                                                @foreach ($models as $model)
                                                    <option value="{{ $model }}">{{ $model }}</option>
                                                @endforeach
                                            </select>
                                            <span class="input-group-btn  input-group-append" data-toggle="modal"
                                                data-target=".bs-example-modal-center"><button
                                                    class="btn btn-primary add-model bootstrap-touchspin-up"
                                                    type="button">+</button></span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label" for="modalRoleNamear"> @lang('type permission') <span
                                                class="required-color">*</span></label>
                                        <div class="d-flex">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" required name="type"
                                                    value="admin" id="customradio1" checked="">
                                                <label class="form-check-label" for="customradio1">@lang('Admin')</label>
                                            </div>
                                            <div class="form-check mb-2 mx-2">
                                                <input class="form-check-input" type="radio" name="type" value="user"
                                                    id="customradio2" checked="">
                                                <label class="form-check-label"
                                                    for="customradio2">@lang('User')</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-primary" type="submit">@lang('save')</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div>
        <!-- container-fluid -->
        <div class="modal fade bs-example-modal-center" id="myModal" tabindex="-1" role="dialog"
            aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0">@lang('add') @lang('Model')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="modelInput" placeholder="@lang('Model')">
                            <button type="button" class="btn col mt-1 btn-sm btn-success"
                                onclick="addModelOptionAndClose()">@lang('save')</button>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    </div>
    @push('scripts')
        <script>
            function addModelOptionAndClose() {
                var modelInput = document.getElementById('modelInput');
                var modelSelect = document.getElementById('modelSelect');

                var newModel = modelInput.value;

                if (newModel.trim() !== '') {
                    var option = document.createElement('option');
                    option.value = newModel;
                    option.text = newModel;
                    modelSelect.add(option);
                    modelInput.value = '';

                    // Close the modal
                    $('#myModal').modal('hide');
                }
            }
        </script>
    @endpush

@endsection
