<div id="filtered-results">

    @foreach ($brokers as $broker)

    <div class="card" style="width: 30%; padding: 2%; margin: 1%">
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
        <a href="{{ route('gallery.showByName', ['name' => $broker->UserBrokerData->GalleryData->gallery_name]) }}" class="btn btn-primary" target="_self">
زيارة المعرض        </a>

      </p>


        </div>
      </div>
    @endforeach
</div>


