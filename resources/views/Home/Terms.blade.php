@extends('Home.layouts.home.app')
@section('title', __('Gallary'))
@section('content')
    <section class="section-py first-section-pt">
        <div class="container">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('welcome') }}">الرئيسية</a>/
                </span>@lang('Terms')</h4>

            <!--/ Header -->
            <div class="card-body">
                {!! $setting->terms !!}
            </div>
    </section>



@endsection
