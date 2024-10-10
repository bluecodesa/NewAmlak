@extends('Admin.layouts.app')

@section('title', __('Settings'))

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        @lang('Settings')</h4>
                </div>
            </div>
            <!-- DataTable with Buttons -->
            @php
                $sectionsIds = Auth::user()
                    ->UserOfficeData->UserSubscription->SubscriptionSectionData->pluck('section_id')
                    ->toArray();
            @endphp


            <div class="col-12">

                <div class="nav-align-top  mb-4">


                    <div class="nav-align-top nav-tabs-shadow mb-4">
                        <ul class="nav nav-tabs nav-fill" role="tablist">
                            @if (Auth::user()->hasPermission('update-user-profile'))
                                <li class="nav-item">
                                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-justified-home" aria-controls="navs-justified-home"
                                        aria-selected="true">
                                        <i class="tf-icons ti ti-user ti-xs me-1"></i>@lang('ملف المنشأة')
                                        {{-- <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">3</span> --}}
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-justified-profile" aria-controls="navs-justified-profile"
                                        aria-selected="true">
                                        <i class="tf-icons ti ti-user ti-xs me-1"></i>@lang('profile')
                                        {{-- <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">3</span> --}}
                                    </button>
                                </li>
                               @endif

                               <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-justified-fal" aria-controls="navs-justified-fal"
                                    aria-selected="false">
                                    <i class="tf-icons ti ti-picture-in-picture ti-xs me-1"></i>
                                    @lang('REGA License')
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-justified-gallery" aria-controls="navs-justified-gallery"
                                    aria-selected="false">
                                    <i class="tf-icons ti ti-picture-in-picture ti-xs me-1"></i>
                                    @lang('Gallary Mange')
                                </button>
                            </li>

                            @if (Auth::user()->hasPermission('update-user-profile'))
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-justified-security" aria-controls="navs-justified-security"
                                    aria-selected="false" tabindex="-1">
                                    <i class="tf-icons ti ti-lock ti-xs me-1 ti-xs me-1"></i> @lang('Securtiy')
                                </button>
                            </li>
                            @endif

                        </ul>


                        <div class="tab-content">
                            {{-- @if (Auth::user()->hasPermission('update-user-profile')) --}}
                            <div class="tab-pane fade active show" id="navs-justified-home" role="tabpanel">
                                @include('Office.settings.inc._GeneralSetting')
                            </div>
                            <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
                                @include('Office.settings.inc._ProfileSetting')
                            </div>
                            <div class="tab-pane fade" id="navs-justified-security" role="tabpanel">
                                @include('Office.settings.inc._security')
                            </div>
                            {{-- @endif --}}
                            <div class="tab-pane fade" id="navs-justified-fal" role="tabpanel">
                                @include('Office.settings.inc.FalLicense.index')

                            </div>
                            @if ($gallery)
                                <div class="tab-pane fade" id="navs-justified-gallery" role="tabpanel">
                                    @include('Office.settings.inc._GalleryMange')
                                </div>
                            @else
                                <div class="tab-pane fade" id="navs-justified-gallery" role="tabpanel">

                                    <div class="col-lg-12">
                                        <div class="card timeline shadow">
                                            <div class="card-header">
                                                <h5 class="card-title">@lang('لا يوجد معرض')</h5>
                                            </div>
                                            <div class="card-body">
                                                <p>@lang(' الاشتراك الحالي لا يحتوي ع المعرض ')</p>

                                                <button type="button" data-toggle="modal" data-target="#exampleModal"
                                                    class="btn btn-primary">@lang('Subscription upgrade')</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- @include('Office.settings.inc._upgradePackage') --}}
                            @endif
                        </div>
                    </div>
                </div>



                <!-- Modal to add new record -->



            </div>

            <div class="content-backdrop fade"></div>
        </div>
        @push('scripts')
            <script>

                $(document).ready(function() {
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
                                    // Empty the city select element
                                    $(this).empty();
                                    // Append the new options based on the received data
                                    $.each(data, function(key, city) {
                                        $('#CityDiv').append($('<option>', {
                                            value: city.id,
                                            text: city.name
                                        }));
                                    });
                                    // Fade in the city select element with new options
                                    $(this).fadeIn('fast');
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                    });
                });


                function readURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            $('#uploadedAvatar').attr('src', e.target.result); // Update the preview image
                        };

                        reader.readAsDataURL(input.files[0]); // Convert image to base64 string
                    }
                }

                $("#upload").change(function() {
                    readURL(this); // Call readURL function when a file is selected
                });

                // JavaScript to handle the reset button functionality
                $('#account-image-reset').click(function() {
                    // Reset the file input by clearing its value
                    $('#upload').val('');

                    // Reset the preview image to the default avatar
                    $('#uploadedAvatar').attr('src', '{{ asset('HOME_PAGE/img/avatars/14.png') }}');
                });

                function copyUrl() {
                    var id = $(this).data("url");
                    var input = $("<input>").val(id).appendTo("body").select();
                    document.execCommand("copy");
                    input.remove();
                    Swal.fire({
                        icon: "success",
                        text: @json(__('copy done')),
                        timer: 1000,
                    });
                }
            </script>

<script>
    function updateFullPhone1(input) {
                input.value = input.value.replace(/[^0-9]/g, '').slice(0, 9);
                var key_phone = $('#key_phone1').val();
                var fullPhone = key_phone + input.value;
                document.getElementById('full_phone1').value = fullPhone;
            }
            $(document).ready(function() {
                $('.dropdown-item').on('click', function() {
                    var key = $(this).data('key');
                    var phone = $('#company_number').val();
                    $('#key_phone1').val(key);
                    $('#full_phone1').val(key + phone);
                    $(this).closest('.input-group').find('.btn.dropdown-toggle').text(key);
                });
            });


</script>
<script>
    function updateFullPhone2(input) {
                input.value = input.value.replace(/[^0-9]/g, '').slice(0, 9);
                var key_phone = $('#key_phone2').val();
                var fullPhone = key_phone + input.value;
                document.getElementById('full_phone2').value = fullPhone;
            }
            $(document).ready(function() {
                $('.dropdown-item').on('click', function() {
                    var key = $(this).data('key');
                    var phone = $('#phone1').val();
                    $('#key_phone2').val(key);
                    $('#full_phone2').val(key + phone);
                    $(this).closest('.input-group').find('.btn.dropdown-toggle').text(key);
                });
            });


</script>

        @endpush

    @endsection
