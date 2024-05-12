@extends('Admin.layouts.app')
@section('title', __('Edit'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 ">

                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Admin.users.index') }}" class="text-muted fw-light">@lang('Users')
                        </a> /
                        @lang('Edit')
                    </h4>
                </div>

            </div>
            <!-- DataTable with Buttons -->
            <div class="card">
                @include('Admin.layouts.Inc._errors')
                <div class="card-body">
                    <form action="{{ route('Admin.users.update', $user->id) }}" method="post" class="row">
                        @csrf
                        @method('PUT')
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label">
                                {{ __('Name') }} <span class="required-color">*</span></label>
                            <input name="name" required value="{{ $user->name }}" type="text"
                                value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror"
                                placeholder="{{ __('Name') }}">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif

                        </div>


                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label">
                                {{ __('Email') }} <span class="required-color">*</span></label>
                            <input name="email" required type="email" value="{{ $user->email }}"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="{{ __('Email') }}">
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif

                        </div>


                        <div class="form-password-toggle col-md-4 col-12 mb-3">
                            <label class="form-label" for="basic-default-password33">@lang('password') </label>
                            <div class="input-group input-group-merge">
                                <input type="password" class="form-control" name="password" id="basic-default-password33"
                                    placeholder="············" aria-describedby="basic-default-password">
                                <span class="input-group-text cursor-pointer" id="basic-default-password"><i
                                        class="ti ti-eye-off"></i></span>
                            </div>

                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>


                        <div class="form-password-toggle col-md-4 col-12 mb-3">
                            <label class="form-label" for="basic-default-password32">@lang('Confirm Password') </label>
                            <div class="input-group input-group-merge">
                                <input type="password" class="form-control" name="password_confirmation"
                                    id="basic-default-password32" placeholder="············"
                                    aria-describedby="basic-default-password">
                                <span class="input-group-text cursor-pointer" id="basic-default-password"><i
                                        class="ti ti-eye-off"></i></span>
                            </div>
                        </div>


                        <div class="col-md-4 col-12 mb-3">
                            <label>@lang('role name')<span class="required-color">*</span> </label>
                            <select class="form-select" name="roles" required>
                                <option disabled value="">@lang('role name')</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ $role->id == $user->roles[0]->id ? 'selected' : '' }}>
                                        {{ app()->getLocale() == 'ar' ? $role->name_ar : $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-12">
                            <button class="btn btn-primary waves-effect waves-light"
                                type="submit">@lang('save')</button>
                        </div>

                    </form>
                </div>
            </div>
            <!-- Modal to add new record -->

            <!--/ DataTable with Buttons -->


        </div>

        <div class="content-backdrop fade"></div>
    </div>


@endsection
