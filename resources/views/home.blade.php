@extends('Admin.layouts.app')

@section('title', __('dashboard'))

@section('content')



    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4">Page 1</h4>
            <p>
                Sample page.<br />For more layout options use
                <a href="" target="_blank" class="fw-medium">HTML starter template generator</a> and refer
                <a href="https://demos.pixinvent.com/vuexy-html-admin-template/documentation//layouts.html" target="_blank"
                    class="fw-medium">Layout docs</a>.
            </p>
        </div>
        <!-- / Content -->

        <!-- Footer -->

        <!-- / Footer -->

        <div class="content-backdrop fade"></div>
    </div>
    <!-- Pending Payment Modal -->

    {{-- @if ($pendingPayment)
        @include('Home.Payments.pending_payment')
    @endif --}}

    <script></script>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var modalButton = document.getElementById('modalButton');
                if (modalButton) {
                    modalButton.click();
                }
            });
            //
            $('.subscription_type').on('change', function() {
                var url = $(this).data('url');
                $.ajax({
                    type: "get",
                    url: url,
                    success: function(data) {
                        alertify.success(@json(__('Subscription has been updated')));
                    },
                });
            });
        </script>
    @endpush


@endsection
