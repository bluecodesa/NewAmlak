
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ url('HOME_PAGE/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{ url('HOME_PAGE/vendor/js/bootstrap.js')}}"></script>
    <script src="{{ url('HOME_PAGE/vendor/libs/node-waves/node-waves.js')}}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ url('HOME_PAGE/vendor/libs/nouislider/nouislider.js')}}"></script>
    <script src="{{ url('HOME_PAGE/vendor/libs/swiper/swiper.js')}}"></script>

    <!-- Main JS -->
    <script src="{{ url('HOME_PAGE/js/front-main.js')}}"></script>

    <!-- Page JS -->
    <script src="{{ url('HOME_PAGE/js/front-page-landing.js')}}"></script>


<script>
    // Track whether a request is already in progress to prevent multiple requests
    let isLoading = false;

    // Function to check if the user has scrolled to the bottom of the page
    function isBottomOfPage() {
        return window.innerHeight + window.scrollY >= document.body.offsetHeight;
    }

    // Function to load more brokers
    function loadMoreBrokers() {
        // If a request is already in progress or there are no more brokers to load, return
        if (isLoading) return;

        // Check if the user has scrolled to the bottom of the page
        if (isBottomOfPage()) {
            // Set isLoading to true to prevent multiple requests
            isLoading = true;

            // Make an AJAX request to load more brokers
            $.ajax({
                url: "{{ route('loadMoreBrokers') }}",
                method: 'GET',
                success: function(response) {
                    // Append the new brokers to the DOM
                    $('#brokersContainer').append(response);
                    // Set isLoading back to false
                    isLoading = false;
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    // Set isLoading back to false in case of error
                    isLoading = false;
                }
            });
        }
    }

    // Event listener for scrolling
    $(window).scroll(function() {
        loadMoreBrokers();
    });
</script>