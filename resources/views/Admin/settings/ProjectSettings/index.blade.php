@extends('Admin.layouts.app')

@section('title', __('Project Settings'))

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">

            <div class="row">
                <div class="col-12">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>

                        <span class="text-muted fw-light">@lang('Settings') /</span> <span
                            class="text-muted fw-light">@lang('Real estate settings') /</span>

                        @lang('Project Settings')
                    </h4>
                </div>
            </div>


            <!-- DataTable with Buttons -->

            <div class="card">

                <div class="row p-1 mb-1">
                    <div class="col-xl-12">
                        <div class="nav-align-top mb-4">
                          <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                            <li class="nav-item">
                                <button
                                  type="button"
                                  class="nav-link"
                                  role="tab"
                                  data-bs-toggle="tab"
                                  data-bs-target="#navs-justified-home"
                                  aria-controls="navs-justified-home"
                                  aria-selected="true">
                                  <i class="tf-icons ti ti-home ti-xs me-1"></i> @lang('Project status')
                                  <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">3</span>
                                </button>
                              </li>
                            {{-- <li class="nav-item">
                              <button
                                type="button"
                                class="nav-link"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-pills-justified-profile"
                                aria-controls="navs-pills-justified-profile"
                                aria-selected="false">
                                <i class="tf-icons ti ti-user ti-xs me-1"></i> حالات التسليم
                              </button>
                            </li> --}}

                          </ul>
                          <div class="tab-content">
                            <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
                           @include('Admin.settings.ProjectSettings.inc._indexProjectStatus')
                            </div>
                            <div class="tab-pane fade" id="navs-pills-justified-profile" role="tabpanel">
                                @include('Admin.settings.ProjectSettings.inc._indexDeliveryCases')

                            </div>
                            <div class="tab-pane fade" id="navs-pills-justified-messages" role="tabpanel">
                              <p>
                                Oat cake chupa chups dragée donut toffee. Sweet cotton candy jelly beans macaroon gummies
                                cupcake gummi bears cake chocolate.
                              </p>
                              <p class="mb-0">
                                Cake chocolate bar cotton candy apple pie tootsie roll ice cream apple pie brownie cake. Sweet
                                roll icing sesame snaps caramels danish toffee. Brownie biscuit dessert dessert. Pudding jelly
                                jelly-o tart brownie jelly.
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
            </div>
        </div>
    </div>
@endsection
