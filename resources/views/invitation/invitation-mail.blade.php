<!DOCTYPE html>
<html>
<head>
    <title>Invitation</title>
</head>
<body>
    <h1>You are invited!</h1>
    <p>Hello,</p>
    <p>You have been invited to our system. Click the link below to register:</p>
    <a href="{{ $signedUrl }}">
        Accept Invitation
    </a>
    <p>This invitation will expire on {{ $invitation->expiration_date }}.</p>
</body>
</html>
