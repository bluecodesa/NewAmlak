<div class="row mb-3">
    <!-- Accordion with Icon -->
    <div class="col-md mb-4 mb-md-2">
      <small class="text-light fw-medium">@lang('offered service')</small>
      @forelse ($providerServices as $providerService )
      <div class="accordion mt-3" id="accordionWithIcon">
        <div class="card accordion-item active">
          <h2 class="accordion-header d-flex align-items-center">
            <button
              type="button"
              class="accordion-button"
              data-bs-toggle="collapse"
              data-bs-target="#accordionWithIcon-1"
              aria-expanded="true">
              <i class="ti ti-star ti-xs me-2"></i>
              {{ $providerService->providerServiceType->name }}
            </button>
          </h2>

          <div id="accordionWithIcon-1" class="accordion-collapse collapse show">
            <div class="accordion-body">
            <h3>{{ $providerService->price }}</h3>

          {{ $providerService->description }}
            </div>
          </div>
        </div>
      </div>
      @empty
      <td colspan="5">
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <span class="alert-icon text-danger me-2">
                <i class="ti ti-ban ti-xs"></i>
            </span>
            @lang('No Data Found!')
        </div>
    </td>
      @endforelse

    </div>
    <!--/ Accordion with Icon -->
    <!-- Accordion Border styling -->

    <!--/ Accordion Border styling -->
  </div>
