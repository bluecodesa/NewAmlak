<!DOCTYPE html>
<html>
<head>
    <title>Your New Owner Account Credentials</title>
</head>
<body>
    <h1>Hello {{ $user->name }},</h1>
    <p>Your new owner account has been created successfully. Here are your login details:</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Password:</strong> {{ $password }}</p>
    <p>Please log in and change your password as soon as possible.</p>
    <p>Thank you!</p>
</body>
</html>
