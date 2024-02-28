<script>
    var firebaseConfig = {
        apiKey: "AIzaSyDaTlIrCFY1OnaNersOjgsgjmZl1AABgJo",
        authDomain: "tryamlak.firebaseapp.com",
        projectId: "tryamlak",
        storageBucket: "tryamlak.appspot.com",
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
