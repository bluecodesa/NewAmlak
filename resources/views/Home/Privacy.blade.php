@extends('Home.layouts.home.app')
@section('title', __('Gallary'))
@section('content')
    <section class="section-py first-section-pt">
        <div class="container">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('welcome') }}">الرئيسية</a>/
                </span>@lang('our privacy policy')</h4>

            <!--/ Header -->
            <div class="card-body">
                {!! $setting->privacy !!}
            </div>
    </section>



@endsection
