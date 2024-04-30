
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Allocation Details</title>
</head>
<body>
    <p><strong>Hello, {{ $name }}</strong></p>
    <p>{{ $body }}</p>
    <ul>
        <li><strong>Ticket ID: </strong> {{ $id }}</li>
        <li><strong>Subject: </strong> {{ $subject }}</li>
        <li><strong>Description: </strong> {{ $description }}</li>
		<li><strong>Name of Engineer: </strong>{{ $engineer }}</li>
		<li><strong>Service Date: </strong> {{ $servicedate }}</li>
		<li><strong>Time: </strong> {{ $time }}</li>
    </ul>
    <p>Thank you!</p>
    <p>Service App</p>
</body>
</html>
