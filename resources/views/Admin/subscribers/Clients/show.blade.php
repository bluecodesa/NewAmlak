@extends('Admin.layouts.app')

@section('title', __('Show Clients'))

@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6">

                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Admin.Subscribers.index') }}" class="text-muted fw-light">@lang('Subscribers') </a> /
                        @lang('Client Name') : {{ $client->name }}
                
                    </h4>
                </div>

            </div>
     <div class="row">
        <div class="nav-align-top nav-tabs-shadow mb-4">
            <ul class="nav nav-tabs nav-fill" role="tablist">
              <li class="nav-item">
                <button
                  type="button"
                  class="nav-link active"
                  role="tab"
                  data-bs-toggle="tab"
                  data-bs-target="#navs-justified-home"
                  aria-controls="navs-justified-home"
                  aria-selected="true">
                  <i class="tf-icons ti ti-home ti-xs me-1"></i> @lang('Basic Details')
                  <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">3</span>
                </button>
              </li>
              <li class="nav-item">
                <button
                  type="button"
                  class="nav-link"
                  role="tab"
                  data-bs-toggle="tab"
                  data-bs-target="#navs-justified-profile"
                  aria-controls="navs-justified-profile"
                  aria-selected="false">
                  <i class="tf-icons ti ti-user ti-xs me-1"></i> @lang('statistics')
                </button>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">
                <div class="col-xl-9 col-lg-9 col-md-9 order-1 order-md-0 justify-content-center">
                    <!-- User Card -->
                    <div class="card mb-4">
                      <div class="card-body">
                        <div class="user-avatar-section">
                          <div class="d-flex align-items-center flex-column">
                            <img
                              class="img-fluid rounded mb-3 pt-1 mt-4"
                              src="{{ $client->avatar ?? url('HOME_PAGE/img/avatars/14.png') }}"
                              height="100"
                              width="100"
                              alt="User avatar" />
                            <div class="user-info text-center">
                              <h4 class="mb-2">{{ $client->name }}</h4>
                              <span class="badge bg-label-secondary mt-1">{{ __($client->roles->pluck('name')->implode(', ')) }}</span>
                            </div>
                          </div>
                        </div>
                        <div class="d-flex justify-content-around flex-wrap mt-3 pt-3 pb-4 border-bottom">
                          <div class="d-flex align-items-start me-4 mt-3 gap-2">
                            <span class="badge bg-label-primary p-2 rounded"><i class="ti ti-checkbox ti-sm"></i></span>
                            <div>
                              <p class="mb-0 fw-medium">1.23k</p>
                              <small>Tasks Done</small>
                            </div>
                          </div>
                          <div class="d-flex align-items-start mt-3 gap-2">
                            <span class="badge bg-label-primary p-2 rounded"><i class="ti ti-briefcase ti-sm"></i></span>
                            <div>
                              <p class="mb-0 fw-medium">568</p>
                              <small>Projects Done</small>
                            </div>
                          </div>
                        </div>
                        <p class="mt-4 small text-uppercase text-muted">Details</p>
                        <div class="info-container">
                          <ul class="list-unstyled">
                            <li class="mb-2">
                              <span class="fw-medium me-1">Username:</span>
                              <span>violet.dev</span>
                            </li>
                            <li class="mb-2 pt-1">
                              <span class="fw-medium me-1">Email:</span>
                              <span>vafgot@vultukir.org</span>
                            </li>
                            <li class="mb-2 pt-1">
                              <span class="fw-medium me-1">Status:</span>
                              <span class="badge bg-label-success">Active</span>
                            </li>
                            <li class="mb-2 pt-1">
                              <span class="fw-medium me-1">Role:</span>
                              <span>Author</span>
                            </li>
                            <li class="mb-2 pt-1">
                              <span class="fw-medium me-1">Tax id:</span>
                              <span>Tax-8965</span>
                            </li>
                            <li class="mb-2 pt-1">
                              <span class="fw-medium me-1">Contact:</span>
                              <span>(123) 456-7890</span>
                            </li>
                            <li class="mb-2 pt-1">
                              <span class="fw-medium me-1">Languages:</span>
                              <span>French</span>
                            </li>
                            <li class="pt-1">
                              <span class="fw-medium me-1">Country:</span>
                              <span>England</span>
                            </li>
                          </ul>
                          <div class="d-flex justify-content-center">
                            <a
                              href="javascript:;"
                              class="btn btn-primary me-3"
                              data-bs-target="#editUser"
                              data-bs-toggle="modal"
                              >Edit</a
                            >
                            <a href="javascript:;" class="btn btn-label-danger suspend-user">Suspended</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- /User Card -->
                    <!-- Plan Card -->
                    <div class="card mb-4">
                      <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                          <span class="badge bg-label-primary">Standard</span>
                          <div class="d-flex justify-content-center">
                            <sup class="h6 pricing-currency mt-3 mb-0 me-1 text-primary fw-normal">$</sup>
                            <h1 class="mb-0 text-primary">99</h1>
                            <sub class="h6 pricing-duration mt-auto mb-2 text-muted fw-normal">/month</sub>
                          </div>
                        </div>
                        <ul class="ps-3 g-2 my-3">
                          <li class="mb-2">10 Users</li>
                          <li class="mb-2">Up to 10 GB storage</li>
                          <li>Basic Support</li>
                        </ul>
                        <div class="d-flex justify-content-between align-items-center mb-1 fw-medium text-heading">
                          <span>Days</span>
                          <span>65% Completed</span>
                        </div>
                        <div class="progress mb-1" style="height: 8px">
                          <div
                            class="progress-bar"
                            role="progressbar"
                            style="width: 65%"
                            aria-valuenow="65"
                            aria-valuemin="0"
                            aria-valuemax="100"></div>
                        </div>
                        <span>4 days remaining</span>
                        <div class="d-grid w-100 mt-4">
                          <button class="btn btn-primary" data-bs-target="#upgradePlanModal" data-bs-toggle="modal">
                            Upgrade Plan
                          </button>
                        </div>
                      </div>
                    </div>
                    <!-- /Plan Card -->
                  </div>
              </div>
              <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
                <p>
                  Donut dragée jelly pie halvah. Danish gingerbread bonbon cookie wafer candy oat cake ice
                  cream. Gummies halvah tootsie roll muffin biscuit icing dessert gingerbread. Pastry ice cream
                  cheesecake fruitcake.
                </p>
                <p class="mb-0">
                  Jelly-o jelly beans icing pastry cake cake lemon drops. Muffin muffin pie tiramisu halvah
                  cotton candy liquorice caramels.
                </p>
              </div>
          
            </div>
        </div>
     </div>
        </div>
</div>
@endsection