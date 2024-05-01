    <div class="row view-filters justify-content-between">
        <div class="galler-filter w-auto d-flex gap-3">
        </div>
        <div class="clear-filter-gallery w-auto">
            <img src="{{ asset('dashboard/assets/new-icons/del.png') }}" class="img-fluid" width="35"
                onclick="clearAllFilters()" style="cursor: pointer" />
        </div>
    </div>
    <div class="row change-view grid">
        @include('Home.Brokers.grid')
    </div>

    

