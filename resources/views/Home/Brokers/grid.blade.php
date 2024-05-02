<div id="filtered-results">

    @foreach ($brokers as $broker)

    <div class="card" style="width: 30%; padding: 2%; margin: 1%">
        @if($broker->avater)
        <img class="card-img-top" src="{{ $broker->avatar }}" alt="Card image cap">
        @else
        <img src="https://www.svgrepo.com/show/29852/user.svg" alt="user" class="rounded-circle">
        @endif
        <div class="card-body">
          <h5 class="card-title">{{ $broker->name }}</h5>
          @if ($broker->is_broker)
          <p class="card-text">مسوق عقاري</p>
          @endif
      
          <p class="card-text"><a href="" class="btn btn-primary">عرض المزيد من التفاصيل</a>
          </p>
        </div>
      </div>
    @endforeach
</div>


