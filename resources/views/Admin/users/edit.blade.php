@extends('Admin.layouts.app')
@section('title', __('User management'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">
                                @lang('User management')</h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item"><a href="{{ route('Admin.users.edit',$user->id) }}">@lang('Edit')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('Admin.users.index') }}">@lang('User management')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('Admin.home') }}">@lang('dashboard')</a></li>
                            </ol>
                        </div>

                    </div> <!-- end row -->
                </div>
                <!-- end page-title -->

                <div class="row">

                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">

                                <form action="{{ route('Admin.users.update', $user->id) }}" method="post" class="row">
                                    @csrf
                                    @method('PUT')
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                {{ __('Name') }} <span class="required-color">*</span></label>
                                            <input name="name" required value="{{ $user->name }}" type="text"
                                                value="{{ old('name') }}"
                                                class="form-control @error('name') is-invalid @enderror"
                                                placeholder="{{ __('Name') }}">
                                            @if ($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                {{ __('Email') }} <span class="required-color">*</span></label>
                                            <input name="email" required type="email" value="{{ $user->email }}"
                                                class="form-control @error('email') is-invalid @enderror"
                                                placeholder="{{ __('Email') }}">
                                            @if ($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                {{ __('password') }} <span class="required-color">*</span>
                                            </label>
                                            <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('password') }}">
                                            @if ($errors->has('password'))
                                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                {{ __('Confirm Password') }} <span class="required-color">*</span>
                                            </label>
                                            <input name="password_confirmation" type="password" class="form-control" placeholder="{{ __('Confirm Password') }}">
                                        </div>
                                    </div>


                                    <div class="form-group col-md-4">
                                        <label>@lang('role name')<span class="required-color">*</span> </label>
                                        <select class="form-control" name="roles" required>
                                            <option disabled value="">@lang('role name')</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}"
                                                    {{ $role->id == $user->roles[0]->id ? 'selected' : '' }}>
                                                    {{ app()->getLocale() == 'ar' ? $role->name_ar : $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-md-12">
                                        <input type="submit" class="btn btn-primary" value="@lang('save')">
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div>
        <!-- container-fluid -->

    </div>
@endsection
