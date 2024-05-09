@extends('Admin.layouts.app')
@section('title', __('Settings'))

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 py-3">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        @lang('Settings')</h4>
                </div>
            </div>


            <div class="nav-align-top nav-tabs-shadow mb-4">
                <ul class="nav nav-tabs nav-fill p-1" role="tablist">
                    @if (Auth::user()->hasPermission('update-PlatformSettings'))
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-justified-home" aria-controls="navs-justified-home"
                                aria-selected="false" tabindex="-1">
                                @lang('Website Setting')
                            </button>
                        </li>
                    @endif

                    @if (Auth::user()->hasPermission('update-payment-gateway'))
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-justified-profile" aria-controls="navs-justified-profile"
                                aria-selected="false" tabindex="-1">
                                @lang('PayTabs')
                            </button>
                        </li>
                    @endif

                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-justified-messages" aria-controls="navs-justified-messages"
                            aria-selected="true">
                            @lang('Notification Mange')
                        </button>
                    </li>
                    @if (Auth::user()->hasPermission('update-Billing'))
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-justified-tax" aria-controls="navs-justified-tax"
                                aria-selected="true">
                                @lang('Mange of invoices')
                            </button>
                        </li>
                    @endif

                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-justified-HomePage" aria-controls="navs-justified-HomePage"
                            aria-selected="true">
                            @lang('Domain settings')
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-justified-Gallary" aria-controls="navs-justified-Gallary"
                            aria-selected="true">
                            @lang('Gallary Mange')
                        </button>
                    </li>
                </ul>
                <div class="tab-content">
                    @if (Auth::user()->hasPermission('update-PlatformSettings'))
                        <div class="tab-pane fade active show" id="navs-justified-home" role="tabpanel">
                            @include('Admin.settings.inc._GeneralSetting')
                        </div>
                    @endif
                    @if (Auth::user()->hasPermission('update-payment-gateway'))
                        <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
                            @include('Admin.settings.inc._paymentGateways')
                        </div>
                    @endif
                    <div class="tab-pane fade" id="navs-justified-messages" role="tabpanel">
                        @include('Admin.settings.inc._NotificationsManagement')
                    </div>
                    @if (Auth::user()->hasPermission('update-Billing'))
                        <div class="tab-pane fade" id="navs-justified-tax" role="tabpanel">
                            @include('Admin.settings.inc._texRate')
                        </div>
                    @endif

                    @if (Auth::user()->hasPermission('update-DomainSettings'))
                        <div class="tab-pane fade" id="navs-justified-HomePage" role="tabpanel">
                            @include('Admin.settings.inc._LandingPage')
                        </div>
                    @endif

                    @if (Auth::user()->hasPermission('update-DomainSettings'))
                        <div class="tab-pane fade" id="navs-justified-Gallary" role="tabpanel">
                            @include('Admin.settings.InterestType.index')
                        </div>
                    @endif

                </div>
            </div>

        </div>

        <div class="content-backdrop fade"></div>
    </div>


    @push('scripts')
        <script>
            function exportToExcel() {
                // Get the table by ID
                var table = document.getElementById('table');

                // Remove the last <td> from each row
                var rows = table.rows;
                for (var i = 0; i < rows.length; i++) {
                    rows[i].deleteCell(-1); // Deletes the last cell (-1) from each row
                }

                // Convert the modified table to a workbook
                var wb = XLSX.utils.table_to_book(table, {
                    sheet: "Sheet1"
                });

                // Save the workbook as an Excel file
                XLSX.writeFile(wb, @json(__('Roles')) + '.xlsx');
            }
        </script>
    @endpush

    <!-- Modal for Add New Payment -->
    {{-- @include('Admin.settings.Payments.create-modal') --}}


    <!-- Modal structure update the payment  -->
    @foreach ($paymentGateways as $paymentGateway)
        @include('Admin.settings.Payments.edit-modal', ['paymentGateway' => $paymentGateway])
    @endforeach

    <script>
        $(document).ready(function() {
            $('#editModal').on('show.bs.modal', function(event) {
                // Triggered when the modal is about to be shown
                var button = $(event.relatedTarget); // Button that triggered the modal
                var title_ar = button.data('title-ar'); // Extract info from data-* attributes
                var title_en = button.data('title-en');

                // Set the input values in the modal
                $('#title_ar_modal').val(title_ar);
                $('#title_en_modal').val(title_en);
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#color').change(function() {
                var color = $(this).val();
                $('#left-side-menu').css('background-color', color);
            });
        });
        //

        $(document).ready(function() {
            $('.toggleHomePage').change(function() {
                var url = $(this).data('url');
                if (this.checked) {
                    var active_home_page = 1
                } else {
                    var active_home_page = 0
                }
                $.ajax({
                    url: url,
                    method: "get",
                    data: {
                        active_home_page: active_home_page,
                    },
                    success: function(data) {
                        if (active_home_page == 0) {
                            alertify.success(@json(__('Home page has been suspended')));
                        } else {
                            alertify.success(@json(__('home page has been activated')));
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });
        });
    </script>
@endsection
