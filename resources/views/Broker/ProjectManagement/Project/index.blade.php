@extends('Admin.layouts.app')
@section('title', __('Projects'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">
                                @lang('Projects')</h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-right">
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
                                        <a href="{{ route('Broker.Project.create') }}"
                                            class="btn btn-primary waves-effect waves-light">@lang('Add New Project')</a>
                                        <a href="{{ route('Broker.Property.create') }}"
                                            class="btn btn-dark waves-effect waves-light">@lang('Add new property')</a>

                                        <a href="{{ route('Broker.Unit.create') }}"
                                            class="btn btn-info waves-effect waves-light">@lang('Add unit')</a>
                                    </div>
                                </div>

                                <div class="table-responsive b-0" data-pattern="priority-columns">
                                    <table id="datatable-buttons"
                                        class="table table-striped table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('project name')</th>
                                                <th>@lang('Developer name')</th>
                                                <th>@lang('Advisor name')</th>
                                                <th>@lang('owner name')</th>
                                                <th>@lang('city')</th>
                                                <th>@lang('service type')</th>
                                                <th>@lang('location name')</th>
                                                <th>@lang('Number Properties')</th>
                                                <th>@lang('Action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($Projects as $index => $project)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $project->name ?? '' }}</td>
                                                    <td>{{ $project->DeveloperData->name ?? '' }}</td>
                                                    <td>{{ $project->AdvisorData->name ?? '' }}</td>
                                                    <td>{{ $project->OwnerData->name ?? '' }}</td>
                                                    <td>{{ $project->CityData->name ?? '' }}</td>
                                                    <td>{{ $project->ServiceTypeData->name ?? '' }}</td>
                                                    <td>{{ $project->location ?? '' }}</td>
                                                    <td>1</td>

                                                    <td>

                                                        <a href="{{ route('Broker.Project.show', $project->id) }}"
                                                            class="btn btn-outline-warning btn-sm waves-effect waves-light">@lang('Show')</a>

                                                        <a href="{{ route('Broker.Project.edit', $project->id) }}"
                                                            class="btn btn-outline-info btn-sm waves-effect waves-light">@lang('Edit')</a>

                                                        <a href="javascript:void(0);"
                                                            onclick="handleDelete('{{ $project->id }}')"
                                                            class="btn btn-outline-danger btn-sm waves-effect waves-light delete-btn">@lang('Delete')</a>
                                                        <form id="delete-form-{{ $project->id }}"
                                                            action="{{ route('Broker.Project.destroy', $project->id) }}"
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
