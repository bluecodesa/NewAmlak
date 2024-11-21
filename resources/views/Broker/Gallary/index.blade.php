@extends('Admin.layouts.app')

@section('title', __('Gallary'))
<style>
    @keyframes pulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(2);
        }
        100% {
            transform: scale(1);
        }
    }

    .animate-alarm {
        color: red; /* Change the color to red */
        animation: pulse 1s infinite; /* Add pulse animation */
    }

    .icon {
        font-size: 2rem !important; /* Adjust the size of the icon here */
        transition: transform 0.2s; /* Smooth scale effect on hover */
    }

    </style>
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        @lang('Gallary')</h4>

                </div>
            </div>
            <!-- DataTable with Buttons -->

            <div class="card">


                <div class="card-body">
                    @include('Admin.layouts.Inc._errors')


                    <!--Gallery cover-->
                    @include('Broker.Gallary.inc._GalleryCover')

                    <!--End of gallery cover-->

                    <!--Filter-->
                    @include('Broker.Gallary.inc._FilterGallery')
                    <!--End of filter-->

                    <div class="nav-align-top nav-tabs-shadow mb-4">
                        <ul class="nav nav-tabs nav-fill" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-justified-home" aria-controls="navs-justified-home"
                                    aria-selected="true">
                                    <i class="tf-icons ti ti-home ti-xs me-1"></i> @lang('List')
                                    <span
                                        class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">{{ $units->count() }}</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-justified-profile" aria-controls="navs-justified-profile"
                                    aria-selected="false" tabindex="-1">
                                    <i class="tf-icons ti ti-cards ti-xs me-1"></i> @lang('Card')
                                </button>
                            </li>

                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="navs-justified-home" role="tabpanel">
                                @include('Broker.Gallary.inc._MenuGallery')
                            </div>
                            <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
                                <div class="col-12">
                                    <div class="row">
                                        @include('Broker.Gallary.inc._ListGallery')
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>



                    {{--
                <div class="col-12">
                    <div class="tab-content" id="v-pills-tabContent">


                        <!--Menu Gallery-->


                        <!--End Menu-->




                        <!--List Gallery-->



                        <!--End list-->
                    </div>



                </div> --}}
                </div>
            </div>
            <!-- Modal to add new record -->
            @include('Broker.Gallary.inc._shareGallery')
            <!--/ DataTable with Buttons -->


        </div>

        <div class="content-backdrop fade"></div>
    </div>


    @push('scripts')
        <script>
        function copyToClipboardAll(element) {
            var url = $(element).data('url'); // Retrieve the data-url attribute
            var $temp = $("<input>"); // Create a temporary input element
            $("body").append($temp); // Append the input to the body
            $temp.val(url).select(); // Set the input's value to the URL and select it
            document.execCommand("copy"); // Copy the selected value
            $temp.remove(); // Remove the temporary input
            alertify.success(@json(__('copy done'))); // Show success message
        }


            function exportToExcel() {
                // Get the table by ID
                var table = document.getElementById('table');


                // Convert the modified table to a workbook
                var wb = XLSX.utils.table_to_book(table, {
                    sheet: "Sheet1"
                });

                // Save the workbook as an Excel file
                XLSX.writeFile(wb, @json(__('Roles')) + '.xlsx');
                alertify.success(@json(__('Download done')));
            }
        </script>
        <script>
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
            function copyToClipboard(elementId) {
                var copyText = document.getElementById(elementId);
                copyText.select();
                copyText.setSelectionRange(0, 99999); // For mobile devices
                document.execCommand("copy");

                alertify.success(@json(__('copy done')));
            }
        </script>
    @endpush
@endsection
