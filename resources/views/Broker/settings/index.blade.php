@extends('Admin.layouts.app')
@section('title', __('Settings'))
@section('content')
    <style>
        .nav-pills .nav-link {
            background-color: transparent;
            border: 2px solid silver;
            margin-bottom: 4px;
            border-radius: 10px;
        }
    </style>
    @php
        $sectionsIds = Auth::user()
            ->UserBrokerData->UserSubscription->SubscriptionSectionData->pluck('section_id')
            ->toArray();
    @endphp
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
                                <li class="breadcrumb-item">
                                    <a href="{{ route('Broker.Setting.index') }}">@lang('Settings')</a>
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
                                <div class="row">
                                    <div class="col-3">
                                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                            aria-orientation="vertical">
                                            @if (Auth::user()->hasPermission('update-user-profile'))
                                                <button class="nav-link active" id="v-pills-home-tab" data-toggle="pill"
                                                    data-target="#v-pills-home" type="button" role="tab"
                                                    aria-controls="v-pills-home" aria-selected="true">
                                                    @lang('profile')</button>
                                            @endif
                                            <button class="nav-link" id="v-pills-gallary-tab" data-toggle="pill"
                                                data-target="#v-pills-gallary" type="button" role="tab"
                                                aria-controls="v-pills-gallary"
                                                aria-selected="false">@lang('Gallary Mange')</button>
                                        </div>
                                    </div>
                                    <div class="col-9">


                                        <div class="tab-content" id="v-pills-tabContent">

                                            @if (Auth::user()->hasPermission('update-user-profile'))
                                                @include('Broker.settings.inc._GeneralSetting')
                                            @endif
                                            <!--  اعدادات المعرض البروفيل -->



                                            <!-- gallary mange -->
                                            @if ($gallery)
                                                @include('Broker.settings.inc._GalleryMange')
                                                {{-- @elseif(in_array(18, $sectionsIds))
                                                @include('Broker.settings.inc._GalleryEnable') --}}
                                            @else
                                                <div class="tab-pane fade" id="v-pills-gallary" role="tabpanel"
                                                    aria-labelledby="v-pills-gallary-tab">
                                                    <div class="row justify-content-center">
                                                        <div class="col-lg-10">
                                                            <div class="card timeline shadow">
                                                                <div class="card-header">
                                                                    <h5 class="card-title">@lang('لا يوجد معرض')</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <p>@lang(' الاشتراك الحالي لا يحتوي ع المعرض ')</p>
                                                                    {{-- <form action="{{ route('Broker.Gallery.create') }}"
                                                                        method="post">
                                                                        @csrf --}}
                                                                    <button type="button" data-toggle="modal"
                                                                        data-target="#exampleModal"
                                                                        class="btn btn-primary">@lang('Subscription upgrade')</button>
                                                                    {{-- </form> --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @include('Broker.settings.inc._upgradePackage')
                                            @endif





                                            <!--  اعدادات المعرض البروفيل -->


                                            <!--  اعدادات التنبيهات -->

                                            {{-- <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                                                aria-labelledby="v-pills-messages-tab">

                                                @include('Broker.settings.inc._NotificationsManagement')
                                                <!-- نهايه التنبيهات-->
                                            </div> --}}
                                            <!--  اعدادات التنبيهات -->



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
                $('#broker_logo_preview').click(function() {
                    $('#broker_logo').click(); // Trigger file input click on image click
                });

                function readURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            $('#broker_logo_preview').attr('src', e.target.result); // Update the preview image
                        };

                        reader.readAsDataURL(input.files[0]); // Convert image to base64 string
                    }
                }

                $("#broker_logo").change(function() {
                    readURL(this); // Call readURL function when a file is selected
                });
            </script>

            <script>
                function selectText() {
                    var inputElement = document.getElementById("galleryName");
                    inputElement.focus();
                    inputElement.select();
                    document.execCommand("copy");
                }
            </script>
            {{--
<script>
    // Check conditions and submit form if necessary
    if (@if (($gallery && !in_array('Realestate-gallery', $sectionNames)) || in_array('المعرض العقاري', $sectionNames)) true @else false @endif) {
        // Enable the form and change method to POST
        var form = document.getElementById('galleryForm');
        form.disabled = false;
        form.method = 'PUT';
        form.submit();

    }
</script> --}}
        @endpush
    @endsection
