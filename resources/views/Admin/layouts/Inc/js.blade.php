<script>
    $(document).ready(function() {
        $('#SearchInput').on('input', function() {
            var searchText = $(this).val().toLowerCase();
            $('tbody tr').each(function() {
                var rowText = $(this).text().toLowerCase();
                if (rowText.includes(searchText)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });

    $(document).ready(function() {
        $('#SearchInput2').on('input', function() {
            var searchText = $(this).val().toLowerCase();
            $('tbody tr').each(function() {
                var rowText = $(this).text().toLowerCase();
                if (rowText.includes(searchText)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });

    var firebaseConfig = {
        apiKey: "AIzaSyDaTlIrCFY1OnaNersOjgsgjmZl1AABgJo",
        authDomain: "tryTown.firebaseapp.com",
        projectId: "tryTown",
        storageBucket: "tryTown.appspot.com",
        messagingSenderId: "1093059573465",
        appId: "1:1093059573465:web:72d961e08cc94daab270c8"
    };

    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();

    messaging.requestPermission().then(function() {
        return messaging.getToken()
    }).then(function(token) {
        console.log(token);

        $.ajax({
            url: '{{ route('fcmToken') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                token: token
            },
            success: function(response) {},
            error: function(err) {
                console.log('User Chat Token Error' + err);
            },
        });

    }).catch(function(err) {
        console.log('User Chat Token Error' + err);
    });

    messaging.onMessage(function(payload) {
        const noteTitle = payload.notification.title;
        const noteOptions = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
        const notification = new Notification(noteTitle, noteOptions);
        notification.addEventListener('click', function() {
            // Open the URL from the notification payload when clicked
            window.open(payload.data.url, '_blank');
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all table headers
        const headers = document.querySelectorAll('th');

        // Add click event listeners to each header
        headers.forEach(header => {
            header.addEventListener('click', () => {
                const table = document.querySelector('tbody');
                const rows = Array.from(table.querySelectorAll('tr'));
                const index = Array.from(header.parentNode.children).indexOf(header);
                const direction = header.dataset.sortDirection || 'asc';

                // Remove sort indicators from other headers
                headers.forEach(h => {
                    h.classList.remove('asc', 'desc');
                    delete h.dataset.sortDirection;
                });

                // Sort the rows based on the content of the clicked column
                const sortedRows = rows.sort((a, b) => {
                    const aValue = a.children[index].textContent.trim();
                    const bValue = b.children[index].textContent.trim();

                    if (direction === 'asc') {
                        return aValue.localeCompare(bValue);
                    } else {
                        return bValue.localeCompare(aValue);
                    }
                });

                // Update the sort direction indicator
                header.classList.toggle('asc', direction === 'asc');
                header.classList.toggle('desc', direction === 'desc');
                header.dataset.sortDirection = direction === 'asc' ? 'desc' : 'asc';

                // Reorder the rows in the table
                table.innerHTML = '';
                sortedRows.forEach(row => table.appendChild(row));
            });
        });

        // Initially sort the table by the first column in ascending order
        const initialHeader = headers[0];
        initialHeader.click();
    });
</script>
