<div class="row g-4">
    @foreach($requests as $request)
    <div class="col-xl-4 col-lg-6 col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-start">
                    <div class="d-flex align-items-start">
                        <div class="avatar me-2">
                            <img
                              src="../../assets/img/icons/brands/social-label.png"
                              alt="Avatar"
                              class="rounded-circle" />
                        </div>
                        <div class="me-2 ms-1">
                            <h5 class="mb-0">
                                <a href="javascript:;" class="stretched-link text-body">{{ $request->propertyType->name ?? 'No Property Type' }}</a>
                            </h5>
                            <div class="client-info">
                                <span class="fw-medium"></span><span class="text-muted">{{ $request->user->name }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="ms-auto">
                        <div class="dropdown z-2">
                            <button
                              type="button"
                              class="btn dropdown-toggle hide-arrow p-0"
                              data-bs-toggle="dropdown"
                              aria-expanded="false">
                                <i class="ti ti-dots-vertical text-muted"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="javascript:void(0);">View details</a></li>
                                <li><a class="dropdown-item text-danger" href="javascript:void(0);">Cancel Request</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center flex-wrap">
                    <div class="bg-lighter px-3 py-2 rounded me-auto mb-3">
                        <h6 class="mb-0">{{ $request->area ?? 'N/A' }}<span class="text-body fw-normal"> @lang('Area (square metres)')</span></h6>
                        <span>{{ $request->rooms ?? 'N/A' }} @lang('number rooms')</span>
                    </div>
                    <div class="text-end mb-3">
                        <h6 class="mb-0">@lang('City'): <span class="text-body fw-normal">{{ $request->city->name ?? 'N/A' }}</span></h6>
                        <h6 class="mb-1">@lang('district'): <span class="text-body fw-normal">{{ $request->district->name ?? 'N/A' }}</span></h6>
                    </div>
                </div>
                <p class="mb-0">{{ $request->description }}</p>
            </div>
            <div class="card-body border-top">
                <div class="d-flex align-items-center mb-3">
                    <h6 class="mb-1">@lang('Create Date') <span class="text-body fw-normal">{{ $request->created_at }}</span></h6>
                  </div>
                <div class="d-flex align-items-center mb-3">
                    <h6 class="mb-1">@lang('status'): <span class="badge bg-label-success ms-auto">{{ __($request->request_valid) }}</span></h6>
                    <a href="javascript:void(0);" class="text-body"
                    ><i class="ti ti-eye ti-sm"></i>0</a
                  >
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>