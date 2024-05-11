
              <!-- Modal -->
              <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog" role="document">
                   <form action="{{ route('unit_interests.store') }}" method="POST">
                       @csrf
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel1">تسجيل اهتمام</h5>
                      <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                           <input hidden name="unit_id" value="{{ $unit_id }}" />
                           <input hidden name="user_id" value="{{ $user_id }}" />
                      <div class="row">
                        <div class="col mb-3">
                          <label for="nameBasic" class="form-label">@lang('Name')<span class="text-danger">*</span></label>
                          <input type="text" id="nameBasic" name="name" required class="form-control" placeholder="ادخل اسمك" />
                        </div>
                      </div>
                      <div class="row g-2">
                        <div class="col mb-0">
                          <label for="emailBasic" class="form-label">@lang('mobile')<span class="text-danger">*</span></label>
                          <input
                            type="tel"
                            id="emailBasic"
                            class="form-control"
                            minlength="9"
                                       maxlength="9" pattern="[0-9]*"
                                       oninvalid="setCustomValidity('Please enter 9 numbers.')"
                                       onchange="try{setCustomValidity('')}catch(e){}"
                                       name="whatsapp" required="" value=""
                            placeholder="987654356" />
                        </div>

                      </div>

                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        @lang('close')
                      </button>
                      <button type="submit" class="btn btn-primary">@lang('save')</button>
                    </div>
                  </div>
               </form>

                </div>
              </div>
