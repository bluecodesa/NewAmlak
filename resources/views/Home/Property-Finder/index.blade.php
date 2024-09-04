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
                                {{-- @if ($finder->avatar) --}}
                                <img src="{{ $finder->avatar ? asset($finder->avatar) : asset('HOME_PAGE/img/avatars/14.png') }}"
                                alt="user image"
                                        class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img" alt="user image"
                                        height="150" width="100" />
                                {{-- @else
                                    <img src="asset('HOME_PAGE/img/avatars/14.png')" alt="user image"
                                        class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img" />
                                @endif --}}

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
                                                @if (session('active_role') == 'Renter')
                                                    @lang('Renter')
                                                @elseif(session('active_role') == 'Property-Finder')
                                                    @lang('Property Finder')
                                                @elseif(session('active_role') == 'Owner')
                                                @lang('owner')
                                                @endif
                                            </li>
                                            <li class="list-inline-item d-flex gap-1">
                                                <i class="ti ti-calendar"></i>عضو منذ {{ $finder->created_at }}
                                            </li>
                                        </ul>
                                    </div>
                                    @php
                                        $activeRole = session('active_role') ?? 'Switch Account';

                                        $specificRoles = collect(['Owner', 'Office-Admin', 'RS-Broker']);

                                        $availableRoles = $specificRoles->diff($userRoles->pluck('name'));
                                    @endphp


                                {{-- <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="roleDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        @lang($activeRole) <!-- Display the active role as the button label -->
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="roleDropdown">
                                        @foreach ($roles as $role)
                                            @if ($userRoles->contains('name', $role->name) && $role->name !== $activeRole)
                                                <li><a class="dropdown-item" href="{{ route('switch.role', $role->name) }}">@lang($role->name)</a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div> --}}

                                <!-- Add New Account Button -->
                                {{-- @if ($availableRoles->isNotEmpty())
                                    <div class="mt-3">
                                        <button class="btn btn-primary dropdown-toggle" type="button" id="addAccountDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        @lang('Add New Account')
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="addAccountDropdown">
                                            @foreach ($availableRoles as $role)
                                                <li><a class="dropdown-item" href="#" onclick="handleRoleRedirect('{{ $role }}')">@lang($role)</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif --}}





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
                @if (Auth::user()->hasPermission('Read-favorite-properties') ||
                Auth::user()->hasPermission('Read-favorite-properties-admin'))
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-justified-requests" aria-controls="navs-justified-requests"
                    aria-selected="false" tabindex="-1">
                    <i class="tf-icons ti ti-heart ti-xs me-1"></i>الطلبات العقارية
                </button>
            </li>
        @endif
        @if (session('active_role') === 'Owner')
        <li class="nav-item" role="presentation">
            <button type="button" class="nav-link" role="tab"
                    data-bs-toggle="tab" data-bs-target="#navs-justified-My_Properties"
                    aria-controls="navs-justified-My_Properties" aria-selected="false" tabindex="-1">
                <i class="tf-icons ti ti-building-arch ti-xs me-1"></i>@lang('My Properties')
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
                <div class="tab-pane fade" id="navs-justified-requests" role="tabpanel">
                    @include('Home.Property-Finder.inc._requests')

                </div>
                @if ($finder->is_owner && Auth::user()->hasPermission('read-building'))

                <div class="tab-pane fade" id="navs-justified-My_Properties" role="tabpanel">
                    @include('Home.Property-Finder.inc._myProperties')

                </div>
                @endif
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.dropdown-menu .dropdown-item').on('click', function() {
            var status = $(this).data('status');
            var requestId = $(this).closest('.card').data('id');

            if (requestId && status) {
                $.ajax({
                    url: '{{ route('PropertyFinder.updateRequestStatus', '') }}/' + requestId,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: status
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert('Failed to update request status');
                        }
                    },
                    error: function() {
                        alert('Error occurred while updating status');
                    }
                });
            }
        });
    });
</script>

<script>
//     function handleRoleRedirect(role) {
//         if (role === 'Office') {
//             redirectToCreateOffice();
//         } else if (role === 'RS-Broker') {
//             redirectToCreateBroker();
//         } else if (role === 'Owner' || role === 'Property-Finder') {
//             redirectToCreatePropertyFinder();
//         } else {
//             alert('No redirection available for this role.');
//         }
//     }

//     function redirectToCreateBroker() {
//         let formData = {
//         name: document.getElementById('name').value,
//         id_number: document.getElementById('id_number').value,
//         email: document.getElementById('email').value,
//         phone: document.getElementById('phone').value,
//         key_phone: document.getElementById('key_phone').value,
//         avatar: document.querySelector('input[name="avatar"]').files[0]
//     };

//     // Store form data and role in session storage
//     sessionStorage.setItem('formData', JSON.stringify(formData));
//     sessionStorage.setItem('role', role);

//     window.location.href = "{{ route('Home.Broker.CreateNewBroker') }}";
//     }

//     function redirectToCreatePropertyFinder() {
//         window.location.href = "{{ route('Home.PropertyFinders.CreatePropertyFinder') }}";
//     }

//     function redirectToCreateOffice() {
//         window.location.href = "{{ route('Home.Offices.CreateOffice') }}";
//     }

//     function handleRoleRedirect(role) {
//     if (role === 'Office') {
//         redirectToCreateOffice();
//     } else if (role === 'RS-Broker') {
//         redirectToCreateBroker();
//     } else if (role === 'Owner' || role === 'Property-Finder') {
//         redirectToCreatePropertyFinder();
//     } else {
//         alert('No redirection available for this role.');
//     }
// }

function handleRoleRedirect(role) {
    if (role === 'Office-Admin') {
        redirectToCreateOffice();
    } else if (role === 'RS-Broker') {
        redirectToCreateBroker();
    } else if (role === 'Owner' || role === 'Property-Finder') {
        redirectToCreatePropertyFinder();
    } else {
        alert('No redirection available for this role.');
    }
}

function redirectToCreateOffice() {
    // storeFormData();
    window.location.href = "{{ route('Home.Offices.CreateNewOffice') }}";
}

function redirectToCreateBroker() {
    // storeFormData();
    window.location.href = "{{ route('Home.Broker.CreateNewBroker') }}";
}

function redirectToCreatePropertyFinder() {
    // storeFormData();
    window.location.href = "{{ route('Home.PropertyFinder.CreateNewPropertyFinder') }}";
}

function storeFormData() {
    let formData = {
        name: document.getElementById('name').value,
        id_number: document.getElementById('id_number').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        key_phone: document.getElementById('key_phone').value,
        avatar: document.querySelector('input[name="avatar"]').files[0]
    };

    sessionStorage.setItem('formData', JSON.stringify(formData));
}

</script>

    @endpush
@endsection
