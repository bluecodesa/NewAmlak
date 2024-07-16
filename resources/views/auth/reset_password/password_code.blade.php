<!DOCTYPE html>
<html lang="en">
<head>
    {!! $sitting->google_tag !!}

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password Code</title>
</head>
<body>
    <p>Your reset password code is: <strong>{{ $code }}</strong></p>
    <p>Please use this code to reset your password. This code will expire in 30 minutes.</p>
    {!! $sitting->zoho_salesiq !!}

</body>
</html>
