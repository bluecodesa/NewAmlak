@extends('Home.layouts.home.app')
@section('title', __('Real Estate Brokers'))
@section('content')
    <section class="section-py bg-body first-section-pt">
        <div class="container mt-2">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('welcome') }}">الرئيسية</a>/
                </span> @lang('Real Estate Brokers') </h4>

            <div class="row g-4">
                @foreach ($users as $broker)
                    <div class="col-xl-4 col-lg-6 col-md-6">

                        <div class="card h-100">
                            <div class="card-body text-center">

                                <div class="user-avatar-section">
                                    <div class=" d-flex align-items-center flex-column">
                                        @if ($broker->avatar)
                                            <img class="img-fluid rounded mb-3 pt-1 mt-4" src="{{ $broker->avatar }}"
                                                height="100" width="100" alt="User avatar">
                                        @else
                                            <img class="img-fluid rounded mb-3 pt-1 mt-4"
                                                src="{{ asset('HOME_PAGE/img/avatars/14.png') }}" height="100"
                                                width="100" alt="User avatar">
                                        @endif
                                        <div class="user-info text-center">
                                            <h4 class="mb-2">{{ $broker->name }}</h4>
                                            @if ($broker->is_broker)
                                                <span class="badge bg-label-secondary mt-1">@lang('Broker')</span>
                                            @else
                                                <span class="badge bg-label-secondary mt-1">@lang('Office')</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-around flex-wrap mt-3 pt-3 pb-4 ">
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('gallery.showByName', ['name' => $broker->UserBrokerData->GalleryData->gallery_name]) }}"
                                            class="btn btn-primary waves-effect waves-light">زيارة المعرض</a>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

        </div>
        <!-- Pagination -->

        <!-- End Pagination -->
    </section>
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="demo-inline-spacing">
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                {{ $users->links() }}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('Home.layouts.inc.__addSubscriberModal')
@endsection

<script>
    function redirectToCreateBroker() {
        window.location.href = "{{ route('Home.Brokers.CreateBroker') }}";
    }

    function redirectToCreateOffice() {
        window.location.href = "{{ route('Home.Offices.CreateOffice') }}";

    }
</script>
