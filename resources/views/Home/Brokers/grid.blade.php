<div id="filtered-results">


    {{-- <div class="card" style="width: 30%; padding: 2%; margin: 1%">
        @if($broker->avatar)
        <img class="card-img-top" src="{{ $broker->avatar }}" alt="Card image cap">
        @else
        <img src="https://www.svgrepo.com/show/29852/user.svg" alt="user" class="rounded-circle">
        @endif
        <div class="card-body">
          <h5 class="card-title">{{ $broker->name }}</h5>
          @if ($broker->is_broker)
          <p class="card-text">مسوق عقاري</p>
          @endif

      <p class="card-text">
        @if ($gallery_name)
        <a href="{{ route('gallery.showByName', ['name' => $gallery_name]) }}" class="btn btn-primary" target="_self">
زيارة المعرض        </a>
    @else
        <!-- Handle case where no galleries are found for the user -->
    @endif
      </p>


        </div>
      </div>--}}

    <section class="system container">
        <div class="row align-items-center">
    <div class="row-cols">
        <div class="row">
            @foreach ($brokers as $broker)

            <div class="col-md-3 system-col">
                <div class="img">
                    <img src="https://www.svgrepo.com/show/29852/user.svg" height="50"
                        class="logo-light-mode  fixed-img" alt="">
                        @if($broker->avatar)
                    <img src="{{ $broker->avatar }}" height="50"
                        class="logo-light-mode  hover-img" alt="">
                        @else

                        <img src="https://www.svgrepo.com/show/29852/user.svg" height="50"
                        class="logo-light-mode  hover-img" alt="">
                        @endif
                </div>
                <div class="content">
                    <h5>{{ $broker->name }} </h5>
                    @if ($broker->is_broker)
                    <p class="card-text">مسوق عقاري</p>
                    @endif
                    @if ($gallery_name)
                    <a href="{{ route('gallery.showByName', ['name' => $gallery_name]) }}"
                        class="btn btn-new" target="_self">
                        زيارة المعرض
                    </a>
                @else
                    <!-- Handle case where no galleries are found for the user -->
                @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
        </div>
    </section>
</div>


