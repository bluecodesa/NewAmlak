@extends('Home.layouts.home.app')
@section('title', __('حسابي'))

@section('content')
    {{-- <section class="section-py bg-body first-section-pt">
    <div class="container mt-2">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('welcome') }}">الرئيسية</a>/ </span>الوسطاء العقاريين</h4>

        <div class="row g-4">

        </div>
    </div>
</section> --}}



    <section class="section-py bg-body first-section-pt">
        <div class="container mt-2">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('welcome') }}">الرئيسيه</a>/ </span>حسابي
            </h4>



            {{-- <h4 class="py-3 mb-4"><span class="text-muted fw-light">User Profile /</span> Profile</h4> --}}

            <!-- Header -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">

                        <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                            <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                                @if ($finder->avatar)
                                    <img src="{{ $finder->avatar }}" alt="user image"
                                        class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img" alt="user image"
                                        height="150" width="100" />
                                @else
                                    <img src="asset('HOME_PAGE/img/avatars/14.png')" alt="user image"
                                        class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img" />
                                @endif

                            </div>
                            <div class="flex-grow-1 mt-3 mt-sm-5">
                                <div
                                    class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                                    <div class="user-profile-info">
                                        <h4>{{ $finder->name }}</h4>
                                        <ul
                                            class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                            <li class="list-inline-item d-flex gap-1">
                                                <i class="ti ti-color-swatch"></i>
                                                @if ($finder->is_renter)
                                                    @lang('Renter')
                                                @elseif($finder->is_property_finder)
                                                    @lang('Property Finder')
                                                @endif
                                            </li>
                                            <li class="list-inline-item d-flex gap-1">
                                                <i class="ti ti-calendar"></i>عضو منذ {{ $finder->created_at }}
                                            </li>
                                        </ul>
                                    </div>
                                    {{-- <a href="javascript:void(0)" class="btn btn-primary">
                    <i class="ti ti-check me-1"></i>Connected
                  </a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Header -->




            <ul class="nav nav-tabs nav-fill" role="tablist">
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-justified-home" aria-controls="navs-justified-home" aria-selected="true">
                        <i class="tf-icons ti ti-user ti-xs me-1"></i> البروفايل
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">3</span>
                    </button>
                </li>
                @if (Auth::user()->hasPermission('Read-favorite-properties') ||
                        Auth::user()->hasPermission('Read-favorite-properties-admin'))
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-justified-profile" aria-controls="navs-justified-profile"
                            aria-selected="false" tabindex="-1">
                            <i class="tf-icons ti ti-heart ti-xs me-1"></i> المفضلة
                        </button>
                    </li>
                @endif
                @if (Auth::user()->hasPermission('update-user-profile'))
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-justified-messages" aria-controls="navs-justified-messages"
                            aria-selected="false" tabindex="-1">
                            <i class="tf-icons ti ti-lock ti-xs me-1 ti-xs me-1"></i> الحماية
                        </button>
                    </li>
                @endif
            </ul>


            <div class="tab-content">
                <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">
                    @include('Home.Property-Finder.inc._profile')

                </div>
                <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
                    @include('Home.Property-Finder.inc._favorite')

                </div>
                <div class="tab-pane fade" id="navs-justified-messages" role="tabpanel">
                    @include('Home.Property-Finder.inc._security')

                </div>
            </div>



            <!--/ Navbar pills -->
        </div>
    </section>

    @push('scripts')
        <script>
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
            function updateFullPhone(input) {
                input.value = input.value.replace(/[^0-9]/g, '').slice(0, 9);
                var key_phone = $('#key_phone').val();
                var fullPhone = key_phone + input.value;
                document.getElementById('full_phone').value = fullPhone;
            }
            $(document).ready(function() {
                $('.dropdown-item').on('click', function() {
                    var key = $(this).data('key');
                    var phone = $('#phone').val();
                    $('#key_phone').val(key);
                    $('#full_phone').val(key + phone);
                    $(this).closest('.input-group').find('.btn.dropdown-toggle').text(key);
                });
            });
        </script>
    @endpush
@endsection
