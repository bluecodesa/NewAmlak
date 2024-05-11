@extends('Home.layouts.home.app')

@section('content')


<section class="section-py bg-body first-section-pt">
    <div class="container mt-2">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('welcome') }}">الرئيسية</a>/ </span>المسوقين العقاريين</h4>

        <div class="row g-4">
            @foreach ($brokers as $broker)

            <div class="col-xl-4 col-lg-6 col-md-6">

              <div class="card">
                <div class="card-body text-center">

                    <div class="user-avatar-section">
                        <div class=" d-flex align-items-center flex-column">
                            @if($broker->avatar)
                          <img class="img-fluid rounded mb-3 pt-1 mt-4" src="{{ $broker->avatar }}" height="100" width="100" alt="User avatar">
                          @else
                          <img class="img-fluid rounded mb-3 pt-1 mt-4" src="https://www.svgrepo.com/show/29852/user.svg" height="100" width="100" alt="User avatar">
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
                            <a href="{{ route('gallery.showByName', ['name' => $broker->UserBrokerData->GalleryData->gallery_name]) }}" class="btn btn-primary me-3 waves-effect waves-light" >زيارة المعرض</a>

                          </div>
                      </div>

                </div>
              </div>
            </div>
            @endforeach
          </div>
    </div>
  </section>

  @endsection
