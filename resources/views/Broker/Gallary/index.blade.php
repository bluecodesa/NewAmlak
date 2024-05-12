@extends('Admin.layouts.app')

@section('title', __('Gallary'))

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-6 py-3">
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
    function exportToExcel() {
        // Get the table by ID
        var table = document.getElementById('table');


        // Convert the modified table to a workbook
        var wb = XLSX.utils.table_to_book(table, {
            sheet: "Sheet1"
        });

        // Save the workbook as an Excel file
        XLSX.writeFile(wb, @json(__('Roles')) + '.xlsx');
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
@endpush
@endsection
