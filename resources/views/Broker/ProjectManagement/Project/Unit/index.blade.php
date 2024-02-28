@extends('Admin.layouts.app')
@section('title', __('Units'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">
                                @lang('Units')</h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item active"><a
                                        href="{{ route('Broker.Unit.index') }}">@lang('Units')</a>
                                </li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('Broker.Property.index') }}">@lang('properties')</a></li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('Broker.Project.index') }}">@lang('Projects')</a></li>
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
                                <div class="col-6">
                                    <div class="card-title">
                                        <a href="{{ route('Broker.Unit.create') }}"
                                            class="btn btn-primary waves-effect waves-light">@lang('Add units')</a>

                                    </div>
                                </div>

                                <div class="table-responsive b-0" data-pattern="priority-columns">
                                    <table id="datatable-buttons"
                                        class="table table-striped table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('Residential number')</th>
                                                <th>@lang('owner name')</th>
                                                <th>@lang('number rooms')</th>
                                                <th>@lang('Number bathrooms')</th>
                                                <th>@lang('Area (square metres)')</th>
                                                <th>@lang('price')</th>
                                                <th>@lang('Ad type')</th>
                                                <th>@lang('Action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($units as $index => $unit)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $unit->number_unit ?? '' }}</td>
                                                    <td>{{ $unit->OwnerData->name ?? '' }}</td>
                                                    <td>{{ $unit->rooms ?? '' }}</td>
                                                    <td>{{ $unit->bathrooms ?? '' }}</td>
                                                    <td>{{ $unit->space ?? '' }}</td>
                                                    <td>{{ $unit->price ?? '' }} <sup>@lang('SAR')</sup> </td>
                                                    <td>{{ __($unit->type) ?? '' }}</td>

                                                    <td>
                                                        <a href="{{ route('Broker.Unit.show', $unit->id) }}"
                                                            class="btn btn-outline-warning btn-sm waves-effect waves-light">@lang('Show')</a>

                                                        <a href="{{ route('Broker.Unit.edit', $unit->id) }}"
                                                            class="btn btn-outline-info btn-sm waves-effect waves-light">@lang('Edit')</a>

                                                        <a href="javascript:void(0);"
                                                            onclick="handleDelete('{{ $unit->id }}')"
                                                            class="btn btn-outline-danger btn-sm waves-effect waves-light delete-btn">@lang('Delete')</a>
                                                        <form id="delete-form-{{ $unit->id }}"
                                                            action="{{ route('Broker.Unit.destroy', $unit->id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div>
        <!-- container-fluid -->

    </div>


    {{-- @if ($pendingPayment)
        @include('Home.Payments.pending_payment')
@endif --}}



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
