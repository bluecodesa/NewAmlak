@extends('Admin.layouts.app')
@section('title', __('Projects'))
@section('content')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-6 py-3 mb-3">
                <h4 class="">
                    <a href="{{ route('Broker.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                    @lang('Projects')</h4>
            </div>

        </div>

        <div class="card">
            <div class="row">
                <div class="col-9">
                    <h5 class="card-header">@lang('Types subscriptions')
                        <button type="button" onclick="exportToExcel()"
                            class="btn btn-sm btn-icon btn-success waves-effect waves-light">
                            <span class="ti ti-table-export"></span>
                        </button>
                    </h5>

                </div>
                <div class="col-3 py-1">
                    <input id="SearchInput" class="form-control  rounded-pill mt-3" type="text"
                        placeholder="@lang('search...')">
                </div>


            </div>

            <div class="col-6">
                <div class="card-title">
                    @if (Auth::user()->hasPermission('create-project'))
                        <a href="{{ route('Broker.Project.create') }}"
                            class="btn btn-primary waves-effect waves-light">@lang('Add New Project')</a>
                    @endif
                    @if (Auth::user()->hasPermission('create-building'))
                        <a href="{{ route('Broker.Property.create') }}"
                            class="btn btn-secondary waves-effect waves-light">@lang('Add new property')</a>
                    @endif
                    @if (Auth::user()->hasPermission('create-unit'))
                        <a href="{{ route('Broker.Unit.create') }}"
                            class="btn btn-info waves-effect waves-light">@lang('Add unit')</a>
                    @endif
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table" id="table2">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>@lang('project name')</th>
                            <th>@lang('city')</th>
                            <th>@lang('Number Properties')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($Projects as $index => $project)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $project->name ?? '' }}</td>
                            {{-- <td>{{ $project->DeveloperData->name ?? '' }}</td> --}}
                            {{-- <td>{{ $project->AdvisorData->name ?? '' }}</td> --}}
                            {{-- <td>{{ $project->OwnerData->name ?? '' }}</td> --}}
                            <td>{{ $project->CityData->name ?? '' }}</td>
                            {{-- <td>{{ $project->ServiceTypeData->name ?? '' }}</td> --}}
                            {{-- <td>{{ $project->location ?? '' }}</td> --}}
                            <td> {{ $project->PropertiesProject->count() }} </td>
                            {{-- <td> {{ $project->PropertiesProject->PropertyUnits->count() }} </td> --}}
                            <td>

                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu" style="">
                                        <a class="dropdown-item"
                                        href="{{ route('Broker.Project.show', $project->id) }}">@lang('Show')</a>
                                        @if (Auth::user()->hasPermission('read-project'))
                                          <a class="dropdown-item"
                                                href="{{ route('Broker.Project.edit', $project->id) }}">@lang('Edit')</a>
                                        @endif
                                        @if (Auth::user()->hasPermission('delete-project'))
                                        <a href="javascript:void(0);"
                                                onclick="handleDelete('{{ $project->id }}')"
                                                class="dropdown-item delete-btn">@lang('Delete')</a>
                                            <form id="delete-form-{{ $project->id }}"
                                                action="{{ route('Broker.Project.destroy', $project->id) }}"
                                                method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endif

                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
            </div> <!-- end row -->

        </div>
        <!-- container-fluid -->



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
