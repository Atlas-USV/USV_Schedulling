<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Us Message</title>
</head>
<body>
    <h1>New Message from Contact Us Form</h1>
    <p><strong>First Name:</strong> {{ $contactData['first_name'] }}</p>
    <p><strong>Last Name:</strong> {{ $contactData['last_name'] }}</p>
    <p><strong>Email:</strong> {{ $contactData['email'] }}</p>
    <p><strong>Subject:</strong> {{ $contactData['subject'] }}</p>
    <p><strong>Message:</strong> {{ $contactData['message'] }}</p>
</body>
</html>
