   <!-- User Profile Content -->
   <div class="row">
    <div class="col-xl-4 col-lg-5 col-md-5">
      <!-- About User -->
      <div class="card mb-4">
        <div class="card-body">
          <small class="card-text text-uppercase">About</small>
          <ul class="list-unstyled mb-4 mt-3">
            <li class="d-flex align-items-center mb-3">
              <i class="ti ti-user text-heading"></i
              ><span class="fw-medium mx-2 text-heading">@lang('Name'):</span> <span>{{ $finder->name }}</span>
            </li>

          </ul>
          <small class="card-text text-uppercase">Contacts</small>
          <ul class="list-unstyled mb-4 mt-3">
            <li class="d-flex align-items-center mb-3">
              <i class="ti ti-phone-call"></i><span class="fw-medium mx-2 text-heading">@lang('phone'):</span>
              <span>{{ $finder->full_phone }}</span>
            </li>

            <li class="d-flex align-items-center mb-3">
              <i class="ti ti-mail"></i><span class="fw-medium mx-2 text-heading">@lang('Email'):</span>
              <span>{{ $finder->email }}</span>
            </li>
          </ul>

        </div>
      </div>
      <!--/ About User -->
      <!-- Profile Overview -->
      <div class="card mb-4">
        <div class="card-body">
          <p class="card-text text-uppercase">Overview</p>
          <ul class="list-unstyled mb-0">
            <li class="d-flex align-items-center mb-3">
              <i class="ti ti-check"></i><span class="fw-medium mx-2">Task Compiled:</span>
              <span>13.5k</span>
            </li>
            <li class="d-flex align-items-center mb-3">
              <i class="ti ti-layout-grid"></i><span class="fw-medium mx-2">Projects Compiled:</span>
              <span>146</span>
            </li>
            <li class="d-flex align-items-center">
              <i class="ti ti-users"></i><span class="fw-medium mx-2">Connections:</span> <span>897</span>
            </li>
          </ul>
        </div>
      </div>
      <!--/ Profile Overview -->
    </div>
    <div class="col-xl-8 col-lg-7 col-md-7">
      <!-- Activity Timeline -->
      <div class="card card-action mb-4">
        <div class="card-header align-items-center">
          <h5 class="card-action-title mb-0">تعديل البيانات الشخصية</h5>
          <div class="card-action-element">
            <div class="dropdown">
              <button
                type="button"
                class="btn dropdown-toggle hide-arrow p-0"
                data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="ti ti-dots-vertical text-muted"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="javascript:void(0);">Share timeline</a></li>
                <li><a class="dropdown-item" href="javascript:void(0);">Suggest edits</a></li>
                <li>
                  <hr class="dropdown-divider" />
                </li>
                <li><a class="dropdown-item" href="javascript:void(0);">Report bug</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="card-body pb-0">

            <form action="{{ route('Broker.Setting.updateBroker', $finder->id) }}" class="row" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('Admin.layouts.Inc._errors')
<div class="row">
                <input type="text" name="key_phone" hidden id="key_phone" value="{{ $finder->key_phone ?? '996' }}">

                <div class="col-md-6 col-12 mb-3">
                    <label for="name">
                        @lang('Finder name')<span class="text-danger">*</span></label>

                    <input type="text" class="form-control" id="name" name="name" value="{{ $finder->name }}"
                        required>
                </div>


                <div class="col-md-6 col-12 mb-3">

                    <label for="id_number" class="form-label">@lang('id number')</label>
                    <input type="text" class="form-control" id="id_number" name="id_number"
                        value="">
                </div>

                <div class="col-md-6 col-12 mb-3">
                    <label for="email">@lang('Email')<span class="text-danger">*</span></label>

                    <input type="email" class="form-control" id="email" name="email" value="{{ $finder->email }}">
                </div>



                <div class="col-12 mb-3 col-md-6">
                    <label for="color" class="form-label">@lang('Mobile Whats app') <span class="required-color">*</span></label>
                    <div class="input-group">
                        <input type="text" placeholder="123456789" name="mobile" value="{{ $finder->phone }}"
                            class="form-control" maxlength="9" pattern="\d{1,9}"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 9);"
                            aria-label="Text input with dropdown button">
                        <button class="btn btn-outline-primary dropdown-toggle waves-effect" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ $finder->key_phone ?? '996' }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" style="">
                            <li><a class="dropdown-item" data-key="971" href="javascript:void(0);">971</a></li>
                            <li><a class="dropdown-item" data-key="996" href="javascript:void(0);">996</a></li>
                        </ul>
                    </div>
                </div>



                <div class="col-md-12 col-12 mb-3">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="{{ $finder->avatar ? asset($finder->avatar) : asset('HOME_PAGE/img/avatars/14.png') }}"
                            alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
                        <div class="button-wrapper">
                            <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                                <span class="d-none d-sm-block">اختر صورة شخصيه</span>
                                <i class="ti ti-upload d-block d-sm-none"></i>
                                <input type="file" id="upload" class="account-file-input" name="broker_logo" hidden
                                    accept="image/png, image/jpeg" />
                            </label>
                            <button type="button" id="account-image-reset"
                                class="btn btn-label-secondary account-image-reset mb-3">
                                <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">@lang('إعادة تعيين الصورة')</span>
                            </button>

                            <div class="text-muted">Allowed JPG,PNG. Max size 800K</div>
                        </div>
                    </div>
                </div>




                <div class="col-md-12 mb-3">
                    <button type="submit" class="btn btn-primary">@lang('save')</button>
                </div>

            </div>
            </form>



        </div>
      </div>
      <!--/ Activity Timeline -->


    </div>
  </div>
  <!--/ User Profile Content -->