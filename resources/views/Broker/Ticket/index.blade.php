@extends('Admin.layouts.app')
@section('title', __('advisors'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">
                                @lang('Tickets')</h4>

                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item"><a href="{{ route('Broker.Tickets.index') }}">@lang('Tickets')</a></li>
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

                                <h4 class="mt-0 header-title">

                                    <a href="{{ route('Broker.Tickets.create') }}" class="btn btn-primary btn-sm"><i
                                            class="bi bi-plus-circle"></i>
                                        @lang('Add New Ticket') </a>
                                </h4>
                                <div class="table-responsive b-0" data-pattern="priority-columns">
                                    <table id="datatable-buttons" class="table  table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">@lang('Ticket Number')</th>
                                                <th scope="col">@lang('Ticket Type')</th>
                                                <th scope="col">@lang('Ticket Address')</th>
                                                <th scope="col">@lang('Ticket Status')</th>
                                                <th scope="col">@lang('Action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <tr>
                                                    <th scope="row"></th>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <a href=""
                                                            class="btn btn-outline-info btn-sm waves-effect waves-light">@lang('Edit')</a>
                                                        <a href="javascript:void(0);"
                                                            onclick="handleDelete()"
                                                            class="btn btn-outline-danger btn-sm waves-effect waves-light delete-btn">
                                                            @lang('Delete')
                                                        </a>
                                                        <form id="delete-form"
                                                            action=""
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </td>
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div>
        <!-- container-fluid -->

    </div>

    {{-- @if($pendingPayment)
        @include('Home.Payments.pending_payment')
@endif
 --}}


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Show the modal when the page is fully loaded
        var modal = document.getElementById('pendingPaymentModal');
        if (modal) {
            modal.classList.add('show');
            modal.style.display = 'block';
            modal.removeAttribute('aria-hidden');
        }
    });
</script>

@endsection
