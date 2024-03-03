@extends('Admin.layouts.app')
@section('title', __('Settings'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">@lang('Settings')</h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item"><a href="{{ route('Broker.Setting.index') }}">@lang('Settings')</a></li>
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
                                <div class="row">
                                    <div class="col-3">
                                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                            aria-orientation="vertical">
                                            <button class="nav-link active" id="v-pills-home-tab" data-toggle="pill"
                                                data-target="#v-pills-home" type="button" role="tab"
                                                aria-controls="v-pills-home" aria-selected="true">
                                                @lang('الملف التعريفي')</button>
                                            <button class="nav-link" id="v-pills-messages-tab" data-toggle="pill"
                                                data-target="#v-pills-messages" type="button" role="tab"
                                                aria-controls="v-pills-messages" aria-selected="false">
                                                @lang('Notification Mange')</button>
                                            <button class="nav-link" id="v-pills-gallary-tab" data-toggle="pill"
                                                data-target="#v-pills-gallary" type="button" role="tab"
                                                aria-controls="v-pills-gallary"
                                                aria-selected="false">@lang('Gallary Mange')</button>

                                        </div>
                                    </div>

                                    <!--  -->

                        <div class="tab-pane fade" id="v-pills-gallary" role="tabpanel"
                            aria-labelledby="v-pills-gallary-tab">


                            <div class="page-title-box">
                                <div class="card m-b-30">
                                    <div class="card-body">
                                        <h6>
                                            @lang('Gallary Mange')
                                        </h6>
                                        <div class="col-12">
                                            {{-- <form class="row">

                                                <div class="row link justify-content-between">
                                                    <div class="w-auto" onclick="copy()" style="cursor: pointer"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="20.782" height="30.633"
                                                            viewBox="1039.055 450.797 19.891 24.817">
                                                            <g data-name="copy">
                                                                <path
                                                                    d="M1044.82 450.851c-.543.204-.941.558-1.18 1.049-.198.422-.237.975-.082 1.233.258.412.923.422 1.194.014.044-.068.093-.228.117-.354.044-.282.121-.418.3-.524.122-.068.685-.078 6.04-.078 6.51 0 6.068-.02 6.257.291.073.127.078.85.078 8.554 0 8.242 0 8.417-.097 8.568-.112.184-.214.242-.49.286-.433.063-.675.33-.675.738 0 .238.16.49.388.607.136.068.233.082.476.058a1.977 1.977 0 0 0 1.728-1.36c.073-.227.077-.96.068-8.98l-.015-8.738-.15-.315a2.059 2.059 0 0 0-.942-.942l-.316-.15-6.262-.01c-5.073-.005-6.296.005-6.437.053Z"
                                                                    fill="#497aac" fill-rule="evenodd" data-name="Path 29137" />
                                                                <path
                                                                    d="M1040.616 455.152c-.694.141-1.262.65-1.49 1.335-.073.228-.077.961-.068 8.98l.015 8.739.15.315c.194.403.54.748.942.942l.316.15H1053.102l.315-.15c.403-.194.748-.539.942-.942l.15-.315.015-8.748c.01-8.68.01-8.748-.087-9.01-.214-.572-.612-.99-1.15-1.208l-.282-.112-6.092-.01c-3.35 0-6.185.015-6.297.034Zm12.238 1.471c.287.19.272-.335.272 8.777 0 7.505-.01 8.369-.077 8.514-.156.335.237.316-6.258.316-6.47 0-6.087.02-6.257-.306-.078-.146-.083-.781-.068-8.612l.015-8.451.116-.126a.73.73 0 0 1 .267-.17c.087-.03 2.67-.044 6-.039 5.583.01 5.86.015 5.99.097Z"
                                                                    fill="#497aac" fill-rule="evenodd" data-name="Path 29138" />
                                                            </g>
                                                        </svg></div>
                                                    <input readonly class="w-75" style="text-align: left" id="share-url"
                                                        value="{{ route('Broker.Gallary.index') }}" />
                                                </div>
                                                <div class="row link justify-content-between">

                                                <input type="checkbox"
                                                    data-url=""
                                                    class="toggleHomePage"
                                                
                                                    data-toggle="toggle" data-onstyle="primary">
                                                    </div>
                                            </form> --}}
                                        </div>

                                    </div>

                                </div> <!-- end row -->
                            </div>

                        </div>


                                 <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                    aria-labelledby="v-pills-home-tab">

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card m-b-30">
                                                <div class="card-body">
                                                    <form action="{{ route('Broker.Setting.update', $broker->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')

                                                        @if ($errors->any())
                                                            <div class="alert alert-danger">
                                                                <ul>
                                                                    @foreach ($errors->all() as $error)
                                                                        <li>{{ $error }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endif

                                                        <div class="mb-3 row">
                                                            <div class="col-md-6">
                                                                <label for="name"> @lang('Broker name')<span class="text-danger">*</span></label>

                                                                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="license_number"> @lang('license number')<span class="text-danger">*</span></label>

                                                                <input type="text" class="form-control" id="license_number" name="license_number" value="{{ $broker->broker_license }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <div class="col-md-6">
                                                                <label for="email">@lang('Email')<span class="text-danger">*</span></label>

                                                                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                                                            </div>

                                                            <div class="col-md-6">

                                                                <label for="mobile">@lang('Mobile Whats app')<span
                                                                        class="text-danger">*</span></label>
                                                                <div style="position:relative">

                                                                    <input type="tel" class="form-control" id="mobile" minlength="9"
                                                                        maxlength="9" pattern="[0-9]*"
                                                                        oninvalid="setCustomValidity('Please enter 9 numbers.')"
                                                                        onchange="try{setCustomValidity('')}catch(e){}" placeholder="599123456"
                                                                        name="mobile" required="" value="{{ $broker->mobile }}">

                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="mb-3 row">
                                                            <div class="col-md-4 mb-4">
                                                                <label for="broker_logo">@lang('Broker logo')</label>
                                                                <span class="not_required">(@lang('optional'))</span>
                                                                <input type="file" class="form-control" id="broker_logo"
                                                                    name="company_logo" accept="image/png, image/jpg, image/jpeg">
                                                                <img id="broker_logo_preview" src="https://www.svgrepo.com/show/29852/user.svg"
                                                                    class="d-flex mr-3 rounded-circle" height="64" style="cursor: pointer;" />
                                                            </div>

                                                            <div class="form-group col-md-4">
                                                                <label>@lang('Region') <span
                                                                    class="text-danger">*</span></label>
                                                                <select class="form-control" id="Region_id" required>
                                                                    <option  selected value="{{ $region->id }}">{{ $region->name }}</option>
                                                                    @foreach ($Regions as $Region)
                                                                        <option value="{{ $Region->id }}"
                                                                            data-url="{{ route('Admin.Region.show', $Region->id) }}">
                                                                            {{ $Region->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group col-md-4">
                                                                <label>@lang('city') <span
                                                                    class="text-danger">*</span></label>
                                                                <select class="form-control" name="city_id" id="CityDiv" value="" required>
                                                                    <option  selected value="{{ $city->id }}">{{ $city->name }}</option>
                                                                </select>
                                                            </div>

                                                        </div>

                                                        <div class="mb-3 row">

                                                            <div class="col-md-6">
                                                                <label for="password"> @lang('password') <span
                                                                    class="text-danger">*</span></label>
                                                      <input type="password" class="form-control" id="password" name="password" required>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label for="password_confirmation"> @lang('Confirm Password') <span
                                                                    class="text-danger">*</span></label>
                                                                     <input type="password" class="form-control" id="password_confirmation"
                                                                    name="password_confirmation" required >
                                                            </div>
                                                        </div>


                                                        <div class="mb-3 row">
                                                            <div class="col-md-6">
                                                                <label for="id_number" class="col-form-label">@lang('id number')</label>
                                                                <input type="text" class="form-control" id="id_number" name="id_number" value="{{ $broker->id_number }}">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-4"></div>
                                                            <div class="col-md-8">
                                                                <button type="submit" class="btn btn-primary">@lang('save')</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div> <!-- end col -->
                                    </div> <!-- end row -->
                                    <!--  اعدادات المنصه -->

                                </div>


                                <!-- اداره المعرض-->
                      
                                          
                         


                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $('#Region_id').on('change', function() {
                var selectedOption = $(this).find(':selected');
                var url = selectedOption.data('url');
                $.ajax({
                    type: "get",
                    url: url,
                    beforeSend: function() {
                        $('#CityDiv').fadeOut('fast');
                    },
                    success: function(data) {
                        $('#CityDiv').fadeOut('fast', function() {
                            $(this).empty().append(data);
                            $(this).fadeIn('fast');
                        });
                    },
                });
            });
            //
            $('#company_logo_preview').click(function() {
                $('#company_logo').click(); // Trigger file input click on image click
            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#company_logo_preview').attr('src', e.target.result); // Update the preview image
                    };

                    reader.readAsDataURL(input.files[0]); // Convert image to base64 string
                }
            }

            $("#company_logo").change(function() {
                readURL(this); // Call readURL function when a file is selected
            });
        </script>
    @endpush
@endsection
