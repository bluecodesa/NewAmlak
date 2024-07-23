<div class="row g-4">
    @foreach($requests as $request)
    <div class="col-xl-4 col-lg-6 col-md-6">
        <div class="card" data-id="{{ $request->id }}">
            <div class="card-header">
                <div class="d-flex align-items-start">
                    <div class="d-flex align-items-start">
                        <div class="avatar me-2">
                            <img
                              src="{{ url('Offices/Projects/default.svg') }}"
                              alt="Avatar"
                              class="rounded-circle" />
                        </div>
                        <div class="me-2 ms-1">
                            <h5 class="mb-0">
                                <a href="javascript:;" class="stretched-link text-body">{{ $request->propertyType->name ?? '' }}</a>
                                <span>({{ __($request->ad_type) }})</span>
                            </h5>
                            <div class="client-info">
                                <span class="fw-medium"></span><span class="text-muted">{{ $request->city->name }}</span>/
                                <span class="fw-medium"></span><span class="text-muted">{{ $request->district->name ?? '' }}</span>

                            </div>
                        </div>
                    </div>
                    <div class="ms-auto">
                        <div class="dropdown z-2">
                            <a href="javascript:void(0);" class="text-body"
                            ><i class="ti ti-eye ti-sm"></i>0</a
                          >
                            <button
                              type="button"
                              class="btn dropdown-toggle hide-arrow p-0"
                              data-bs-toggle="dropdown"
                              aria-expanded="false">
                                <i class="ti ti-dots-vertical text-muted"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if ($request->request_valid == 'canceled')
                                <li><a class="dropdown-item" href="javascript:void(0);" data-status="active">@lang('تفعيل الطلب')</a></li>
                                @else
                                <li><a class="dropdown-item text-danger" href="javascript:void(0);" data-status="canceled">@lang('الغاء الطلب')</a></li>
                                @endif
                            </ul>                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center flex-wrap">
                    <div class="bg-lighter px-3 py-2 rounded me-auto mb-3">
                        <h6 class="mb-0">{{ $request->area ?? '' }}<span class="text-body fw-normal"> @lang('sq.m')</span></h6>
                        <span>{{ $request->rooms ?? '' }} @lang('number rooms')</span>
                    </div>

                </div>
                <p class="mb-0">{{ $request->description }}</p>
            </div>
            <div class="card-body border-top">
                <div class="d-flex align-items-center mb-3">
                    <h6 class="mb-1">@lang('Create Date') <span class="text-body fw-normal">{{ $request->created_at }}</span></h6>
                  </div>
                <div class="d-flex align-items-center mb-3">
                 </span>
                    @if($request->request_valid == 'active')
                    <h6 class="mb-1">@lang('Validation'): <span class="badge bg-primary mt-1">{{ __($request->request_valid) }}</span></h6>
                   @else
                   <h6 class="mb-1">@lang('Validation'): <span class="badge bg-danger mt-1">{{ __($request->request_valid) }}</span></h6>
                   @endif
                    <h6 class="mb-1">@lang('Request Number'): <span class="badge bg-primary mt-1">{{ $request->number_of_requests }}</span></h6>
                  
                </div>
            </div>
            <div class="card-body border-top">
                <div class="d-flex align-items-center mb-3">
                    <h6 class="mb-1">
                        @lang('جاري التواصل'): <span class="badge bg-primary mt-1">{{ $request->status_count_3 }}</span>
                    </h6>
                    <h6 class="mb-1">
                        @lang('تحديد موعد للمعاينة'): <span class="badge bg-primary mt-1">{{ $request->status_count_8 }}</span>
                  
                </div>
            </div>

            {{-- @foreach ($request->requestStatuses as $status) 
            @if ($status->interestType->id == 3)
            {{ $status->interestType->name }} : <span class="badge bg-primary mt-1">{{ $request->status_count_3 }}</span>
             </h6>
            @elseif ($status->interestType->id == 8)
            <h6 class="mb-1">
                {{ $status->interestType->name }}: <span class="badge bg-primary mt-1">{{ $request->status_count_8 }}</span>
            </h6>
            @endif
         @endforeach --}}

        </div>
    </div>
    @endforeach
</div>
