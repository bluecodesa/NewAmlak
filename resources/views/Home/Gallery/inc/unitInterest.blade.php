<!-- Modal -->
<div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <form action="{{ route('unit_interests.store') }}" method="POST">
          @csrf
          <input type="text" name="key_phone" hidden value="996" id="key_phone">
          <input type="text" name="full_phone" hidden id="full_phone" value="996">
          <div class="modal-content">
             <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">تسجيل اهتمام</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                <input type="hidden" name="unit_id" id="modal_unit_id" />
                <input type="hidden" name="user_id" id="modal_user_id" />
                {{-- <input hidden name="unit_id" value="{{ $unit->id }}" />
                <input hidden name="user_id" value="{{ $unit->BrokerData->user_id }}" /> --}}
                      <div class="row">
                        <div class="col mb-3">
                          <label for="nameBasic" class="form-label">@lang('Name')<span class="text-danger">*</span></label>
                          <input type="text" id="nameBasic" name="name" required class="form-control" placeholder="ادخل اسمك" />
                        </div>
                      </div>
                      <div class="row g-2">
                        <div class="col mb-0">
                          <label for="emailBasic" class="form-label">@lang('mobile')<span class="text-danger">*</span></label>

            <div class="input-group">
                <input type="text" placeholder="123456789" id="phone" name="whatsapp"
                    value="" class="form-control" maxlength="9" pattern="\d{1,9}"
                    oninput="updateFullPhone(this)"
                    aria-label="Text input with dropdown button">
                <button class="btn btn-outline-primary dropdown-toggle waves-effect"
                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    996
                </button>
                <ul class="dropdown-menu dropdown-menu-end" style="">
                    <li><a class="dropdown-item" data-key="971"
                            href="javascript:void(0);">971</a></li>
                    <li><a class="dropdown-item" data-key="996"
                            href="javascript:void(0);">996</a></li>
                </ul>

            </div>
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


              <script>
                function updateFullPhone(input) {
                    input.value = input.value.replace(/[^0-9]/g, '').slice(0, 9);
                    var key_phone = $('#key_phone').val();
                    var fullPhone = key_phone + input.value;
                    document.getElementById('full_phone').value = fullPhone;
                }
                $(document).ready(function() {
                    $('.dropdown-item').on('click', function() {
                        var key = $(this).data('key');
                        var phone = $('#phone').val();
                        $('#key_phone').val(key);
                        $('#full_phone').val(key + phone);
                        $(this).closest('.input-group').find('.btn.dropdown-toggle').text(key);
                    });
                });
            </script>

<script>
    function updateFullPhone(input) {
       input.value = input.value.replace(/[^0-9]/g, '').slice(0, 9);
       var key_phone = $('#key_phone').val();
       var fullPhone = key_phone + input.value;
       document.getElementById('full_phone').value = fullPhone;
    }

    $(document).ready(function() {
       $('.dropdown-item').on('click', function() {
          var key = $(this).data('key');
          var phone = $('#phone').val();
          $('#key_phone').val(key);
          $('#full_phone').val(key + phone);
          $(this).closest('.input-group').find('.btn.dropdown-toggle').text(key);
       });

       $('#basicModal').on('show.bs.modal', function(event) {
          var button = $(event.relatedTarget); // Button that triggered the modal
          var unitId = button.data('unit-id'); // Extract info from data-* attributes
          var userId = button.data('user-id'); // Extract info from data-* attributes

          var modal = $(this);
          modal.find('#modal_unit_id').val(unitId);
          modal.find('#modal_user_id').val(userId);
       });
    });
 </script>

