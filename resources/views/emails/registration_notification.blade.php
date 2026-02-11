<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Registration Notification</title>
</head>
<body>
    <h1>Registration {{ ucfirst($outcome) }}</h1>

    @if($outcome === 'success')
        <p>Dear {{ $user->name }},</p>
        <p>Congratulations! Your registration has been successful.</p>
        <p>You can now log in to your account using your email and password.</p>
    @else
        <p>Dear {{ $user ? $user->name : 'User' }},</p>
        <p>Unfortunately, your registration was denied.</p>
        @if($reason)
            <p>Reason: {{ $reason }}</p>
        @endif
        <p>Please try again or contact support if you need assistance.</p>
    @endif

    <p>Best regards,<br>PathFit AI Team</p>
</body>
</html>
