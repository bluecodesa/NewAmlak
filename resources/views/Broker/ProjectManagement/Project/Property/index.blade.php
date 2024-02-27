@extends('Admin.layouts.app')
@section('title', __('properties'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">
                                @lang('properties')</h4>
                        </div>
                        <div class="col-6">
                            <div class="card-title">
                                <a href="{{ route('Broker.Property.create') }}"
                                    class="btn btn-dark waves-effect waves-light">@lang('Add new property')</a>
                            </div>
                        </div>

                    </div> <!-- end row -->
                </div>
                <!-- end page-title -->

                <div class="row">

                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">

                                <div class="table-responsive b-0" data-pattern="priority-columns">
                                    <table id="datatable-buttons"
                                        class="table table-striped table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('property name')</th>
                                                <th>@lang('city')</th>
                                                <th>@lang('location')</th>
                                                <th>@lang('Property type')</th>
                                                <th>@lang('Type use')</th>
                                                <th>@lang('owner name')</th>
                                                <th>@lang('Instrument number')</th>
                                                <th>@lang('Action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($properties as $index => $property)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $property->name ?? '' }}</td>
                                                    <td>{{ $property->CityData->name ?? '' }}</td>
                                                    <td>{{ $property->location ?? '' }}</td>
                                                    <td>{{ $property->PropertyTypeData->name ?? '' }}</td>
                                                    <td>{{ $property->PropertyUsageData->name ?? '' }}</td>
                                                    <td>{{ $property->OwnerData->name ?? '' }}</td>
                                                    <td>{{ $property->instrument_number ?? '' }}</td>

                                                    <td>

                                                        <a href="{{ route('Broker.Property.CreateUnit', $property->id) }}"
                                                            class="btn btn-outline-dark btn-sm waves-effect waves-light">@lang('Add units')</a>


                                                        <a href="{{ route('Broker.Property.show', $property->id) }}"
                                                            class="btn btn-outline-warning btn-sm waves-effect waves-light">@lang('Show')</a>

                                                        <a href="{{ route('Broker.Property.edit', $property->id) }}"
                                                            class="btn btn-outline-info btn-sm waves-effect waves-light">@lang('Edit')</a>

                                                        <a href="javascript:void(0);"
                                                            onclick="handleDelete('{{ $property->id }}')"
                                                            class="btn btn-outline-danger btn-sm waves-effect waves-light delete-btn">@lang('Delete')</a>
                                                        <form id="delete-form-{{ $property->id }}"
                                                            action="{{ route('Broker.Property.destroy', $property->id) }}"
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
