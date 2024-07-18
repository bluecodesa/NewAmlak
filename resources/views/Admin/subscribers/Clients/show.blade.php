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
                  <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1"></span>
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
                  <i class="tf-icons ti ti-presentation-analytics ti-xs me-1"></i> @lang('statistics')
                </button>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">
                <div class="col-xl-12 col-lg-12 col-md-12 order-1 order-md-0 justify-content-center">
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
                              <span class="badge bg-label-secondary mt-1">
                                @foreach ($client->roles as $role)
                                {{ __($role->name) ?? '' }}
                                @if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                            </div>
                          </div>
                        </div>
                        <div class="d-flex justify-content-around flex-wrap mt-3 pt-3 pb-4 border-bottom">
                          {{-- <div class="d-flex align-items-start me-4 mt-3 gap-2">
                            <span class="badge bg-label-primary p-2 rounded"><i class="ti ti-checkbox ti-sm"></i></span>
                            <div>
                              <p class="mb-0 fw-medium">1.23k</p>
                              <small>Tasks Done</small>
                            </div>
                          </div> --}}
                          {{-- <div class="d-flex align-items-start mt-3 gap-2">
                            <span class="badge bg-label-primary p-2 rounded"><i class="ti ti-briefcase ti-sm"></i></span>
                            <div>
                              <p class="mb-0 fw-medium">568</p>
                              <small>Projects Done</small>
                            </div>
                          </div> --}}
                        </div>
                        <p class="mt-4 small text-uppercase text-muted">@lang('Details')</p>
                        <div class="info-container">
                          <ul class="list-unstyled">
                            <li class="mb-2">
                              <span class="fw-medium me-1">@lang('Name'):</span>
                              <span>{{ $client->name }}</span>
                            </li>
                            <li class="mb-2 pt-1">
                              <span class="fw-medium me-1">@lang('Email'):</span>
                              <span>{{ $client->email }}</span>
                            </li>
                            <li class="mb-2 pt-1">
                              <span class="fw-medium me-1">@lang('Account Type'):</span>
                              <span class="badge bg-label-success">  @foreach ($client->roles as $role)
                                {{ __($role->name) ?? '' }}
                                @if (!$loop->last)
                                    ,
                                @endif
                            @endforeach</span>
                            </li>
                            <li class="mb-2 pt-1">
                              <span class="fw-medium me-1">@lang('id number'):</span>
                              <span>{{ $client->id_number }}</span>
                            </li>
                            <li class="mb-2 pt-1">
                              <span class="fw-medium me-1">@lang('mobile') :</span>
                              <span>{{ $client->full_phone }}</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-medium me-1">@lang('Created By'):</span>
                                @if(empty($client->UserRenterData->OfficeData))
                                    <span></span>
                                @else
                                    @foreach ($client->UserRenterData->OfficeData as $office)
                                    <span>{{ $office->UserData->customer_id }}</span>
                                    @if (!$loop->last)
                                    ,
                                    @endif
                                    @endforeach
                                @endif
                              </li>
                            <li class="mb-2 pt-1">
                              <span class="fw-medium me-1">@lang('Created Date'):</span>
                              <span>{{ $client->created_at }}</span>
                            </li>
                        
                          </ul>
                          {{-- <div class="d-flex justify-content-center">
                            <a
                              href="javascript:;"
                              class="btn btn-primary me-3"
                              data-bs-target="#editUser"
                              data-bs-toggle="modal"
                              >Edit</a
                            >
                            <a href="javascript:;" class="btn btn-label-danger suspend-user">Suspended</a>
                          </div> --}}
                        </div>
                      </div>
                    </div>
                    <!-- /User Card -->
                    <!-- Plan Card -->
              
                    <!-- /Plan Card -->
                  </div>
              </div>
              <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
                <div class="row g-4 mb-4">
                    <div class="col-sm-6 col-xl-3">
                      <div class="card">
                        <div class="card-body">
                          <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                              <span>@lang('Units')</span>
                              <div class="d-flex align-items-center my-2">
                                <h3 class="mb-0 me-2">0</h3>
                              </div>
                            </div>
                            <div class="avatar">
                              <span class="avatar-initial rounded bg-label-primary">
                                <i class="ti ti-building-arch ti-sm"></i>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                      <div class="card">
                        <div class="card-body">
                          <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                              <span>@lang('Contracts')</span>
                              <div class="d-flex align-items-center my-2">
                                <h3 class="mb-0 me-2">@if(!empty($client->UserRenterData->ContractData))
                                    {{ $client->UserRenterData->ContractData()->count() }}
                                    @else 0
                                @endif
                                </h3>
                              </div>
                            </div>
                            <div class="avatar">
                              <span class="avatar-initial rounded bg-label-danger">
                                <i class="ti ti-page-break ti-sm"></i>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                      <div class="card">
                        <div class="card-body">
                          <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                              <span>@lang('Interests Order')</span>
                              <div class="d-flex align-items-center my-2">
                                <h3 class="mb-0 me-2">{{ $client->unitInterests()->count() }}</h3>
                              </div>
                            </div>
                            <div class="avatar">
                              <span class="avatar-initial rounded bg-label-success">
                                <i class="ti ti-heart ti-sm"></i>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                      <div class="card">
                        <div class="card-body">
                          <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                              <span>طلبات عقارية</span>
                              <div class="d-flex align-items-center my-2">
                                <h3 class="mb-0 me-2">0</h3>
                              </div>
                            </div>
                            <div class="avatar">
                              <span class="avatar-initial rounded bg-label-warning">
                                <i class="ti ti-menu-order ti-sm"></i>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
          
            </div>
        </div>
     </div>
        </div>
</div>
@endsection