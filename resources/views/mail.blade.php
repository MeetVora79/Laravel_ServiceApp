{{-- resources/views/mail.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Information</title>
</head>
<body>
    <p><strong>Hello, Admin</strong></p>
    <p>{{ $body }}</p>
    <ul>
        <li><strong>Subject: </strong> {{ $subject }}</li>
        <li><strong>Description: </strong> {{ $description }}</li>
    </ul>
    <p>Thank you!</p>
    <p>{{ $name }}</p>
</body>
</html>
