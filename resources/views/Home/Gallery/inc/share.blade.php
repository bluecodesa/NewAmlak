  <!-- Two Factor Auth Modal -->

  <div class="modal fade" id="twoFactorAuth{{$unit->id}}" tabindex="-1" aria-hidden="true" data-unit-id="{{ $unit->id }}">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-simple">
      <div class="modal-content p-3 p-md-5">
        <div class="modal-body">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="text-center mb-4">
            <h3 class="mb-2">مشاركة المعرض</h3>

          </div>
          <div class="row">
            <div class="col-12 mb-3">
              <div class="form-check custom-option custom-option-basic">
                <label
                  class="form-check-label custom-option-content ps-3"
                  for="customRadioTemp1"
                  data-bs-target="#twoFactorAuthOne{{$unit->id}}"
                  data-bs-toggle="modal">
                  <input
                    name="customRadioTemp"
                    class="form-check-input d-none"
                    type="radio"
                    value=""
                    id="customRadioTemp1" />
                  <span class="d-flex align-items-start">
                    <i class="ti ti-settings ti-xl me-3"></i>
                    <span>
                      <span class="custom-option-header">
                        <span class="h4 mb-2">الباركود</span>
                      </span>
                      <span class="custom-option-body">
                        <span class="mb-0"
                          >مشاركة المعرض عن طريق الباركود</span
                        >
                      </span>
                    </span>
                  </span>
                </label>
              </div>
            </div>
            <div class="col-12">
              <div class="form-check custom-option custom-option-basic">
                <label
                  class="form-check-label custom-option-content ps-3"
                  for="customRadioTemp2"
                  data-bs-target="#twoFactorAuthTwo{{$unit->id}}"
                  data-bs-toggle="modal">
                  <input
                    name="customRadioTemp"
                    class="form-check-input d-none"
                    type="radio"
                    value=""
                    id="customRadioTemp2" />
                  <span class="d-flex align-items-start">
                    <i class="ti ti-message ti-xl me-3"></i>
                    <span>
                      <span class="custom-option-header">
                        <span class="h4 mb-2">مشاركة رابط المعرض</span>
                      </span>
                      <span class="custom-option-body">
                      </span>
                    </span>
                  </span>
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Authentication App -->
  <div class="modal fade" id="twoFactorAuthOne{{$unit->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-simple">
      <div class="modal-content p-3 p-md-5">
        <div class="modal-body">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

          <h5 class="mb-2 pt-1 text-break">قم بتحميل الكود لكي تستطيع مشاركته مع اصدقائك لكي يمكنهم الوصول الي بيانات هذا العقار عن طريق الجوال</h5>

          <div class="mb-4 text-center">
                {!! QrCode::size(150)->generate(route('gallery.showUnitPublic', ['gallery_name' => $gallery->gallery_name, 'id' => $unit->id])) !!}

          </div>

          <div class="text-end">
            <button
              type="button"
              class="btn btn-label-secondary me-sm-3 me-1"
              data-bs-toggle="modal"
              data-bs-target="#twoFactorAuth">
              <i class="ti ti-arrow-left ti-xs me-1 scaleX-n1-rtl"></i
              ><span class="align-middle d-none d-sm-inline-block">Back</span>
            </button>
            @php
            $url = "route('gallery.showUnitPublic', ['gallery_name' => $gallery->gallery_name, 'id' => $unit->id])";
        @endphp

            <a href="{{ route('download.qrcode', $url) }}" class="btn btn-primary">
              <span class="align-middle d-none d-sm-inline-block">تحميل الباركود</span
              ><i class="ti ti-download ti-xs ms-1 scaleX-n1-rtl"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Authentication via SMS -->
  <div class="modal fade" id="twoFactorAuthTwo{{$unit->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-simple">
      <div class="modal-content p-3 p-md-5">
        <div class="modal-body">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <h5 class="mb-2 pt-1">   مشاركة الرابط
        </h5>
          <p class="mb-4">
            مشاركة لينك العقار او انسخه في موقعك
          </p>
          <div class="mb-4">
            <input readonly type="text" class="form-control" id="twoFactorAuthInputSms"
            value="{{ route('gallery.showUnitPublic', ['gallery_name' => $gallery->gallery_name, 'id' => $unit->id])}} " />
          </div>
          <div class="text-end">
            <button
              type="button"
              class="btn btn-label-secondary me-sm-3 me-1"
              data-bs-toggle="modal"
              data-bs-target="#twoFactorAuth">
              <i class="ti ti-arrow-left ti-xs me-1 scaleX-n1-rtl"></i
              >
              <span class="align-middle d-none d-sm-inline-block">Back</span>
            </button>
            @php
             $url = route('gallery.showUnitPublic', ['gallery_name' => $gallery->gallery_name, 'id' => $unit->id]) ;
             @endphp

            <a href='https://web.whatsapp.com/send?text=Check%20out%20this%20link:%20{{ urlencode("$url") }}' class="btn btn-success">
                <i class="ti ti-brand-whatsapp"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ Two Factor Auth Modal -->
