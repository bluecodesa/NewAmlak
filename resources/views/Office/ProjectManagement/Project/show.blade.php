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
                                @lang('Projects') / {{ $project->name }} </h4>
                        </div>

                    </div> <!-- end row -->
                </div>
                <!-- end page-title -->

                <div class="row">

                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="card m-b-30 text-white"
                                            style="background-color: #333; border-color: #333;border-radius: 14px;">
                                            <div class="card-body">
                                                <h3 class="card-title font-16 mt-0">
                                                    <footer class="blockquote-footer font-12">
                                                        {{ $project->name }} <cite title="Source Title"></cite>
                                                    </footer>
                                                </h3>
                                                <div class="row mb-2">
                                                    <div class="col-md-3">
                                                        <h6> @lang('project name') : <span class="badge font-13 badge-primary">
                                                                {{ $project->name }}
                                                            </span> </h6>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <h6> @lang('owner name') : <span class="badge font-13 badge-primary">
                                                                {{ $project->OwnerData->name ?? '' }}
                                                            </span> </h6>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <h6> @lang('Developer name') :
                                                            <span class="badge font-13 badge-primary">
                                                                {{ $project->DeveloperData->name ?? '' }}
                                                            </span>
                                                        </h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h6> @lang('Advisor name') : <span class="badge font-13 badge-primary">
                                                                {{ $project->AdvisorData->name ?? '' }}
                                                            </span> </h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h6> @lang('location name') :
                                                            <span class="badge font-13 badge-primary">
                                                                {{ $project->location ?? '' }}
                                                            </span>
                                                        </h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h6> @lang('city') :
                                                            <span class="badge font-13 badge-primary">
                                                                {{ $project->CityData->name ?? '' }}
                                                            </span>
                                                        </h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h6> @lang('Number Properties') :
                                                            <span class="badge font-13 badge-primary">
                                                                {{ 1 }}
                                                            </span>
                                                        </h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h6> @lang('Employee Name') :
                                                            <span class="badge font-13 badge-primary">
                                                                {{ $project->EmployeeData->UserData->name ?? '' }}
                                                            </span>
                                                        </h6>
                                                    </div>
                                                </div>
                                                <a href="#" class="btn btn-warning">@lang('Edit') </a>
                                                <a href="{{ route('Office.Project.CreateProperty', $project->id) }}"
                                                    class="btn btn-primary">@lang('Add new property')</a>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <img class="rounded mr-2" alt="200x200" style="width: 100%;"
                                            src="{{ url($project->image) }}" data-holder-rendered="true">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div>
        <!-- container-fluid -->

    </div>
@endsection
