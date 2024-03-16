@extends('Admin.layouts.app')
@section('title', __('Gallary'))
@section('content')

            <div class="account-pages">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                                <div class="text-center mb-5">
                                    <div class="mb-5">
                                        <img src="{{ url($sitting->icon) }}" height="32" alt="logo">
                                    </div>
                                    <h4 class="mt-4 text-uppercase">Let's get started with Amlak</h4>
                                    <p>If several languages coalesce the grammar of the resulting language</p>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="comming-watch text-center mb-5">
                                    <div class="countdown"><div><div class="card card-body p-3"><span class="countdown-num">200</span><span class="text-uppercase">days</span></div><div class="card card-body p-3"><span class="countdown-num">04</span><span class="text-uppercase">hours</span></div></div><div class="lj-countdown-ms "><div class="card card-body p-3"><span class="countdown-num">33</span><span class="text-uppercase">minutes</span></div><div class="card card-body p-3"><span class="countdown-num">09</span><span class="text-uppercase">seconds</span></div></div></div>
                                </div>

                            </div>
                        </div>
                        <!-- end row -->

                        <div class="text-center">
                            <p>تواصل مع المسوق</p>
                                    <button type="submit" class="btn btn-primary">whatsapp</button>
                                    {{-- <a  href="https://web.whatsapp.com/send?phone={{ env('COUNTRY_CODE') . $broker->mobile}}>Whatsapp</a> --}}
                            </div>
                    </div>
                </div>

@endsection
