<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Schedule Details</title>
</head>
<body>
    <p><strong>Hello, {{ $name }}</strong></p>
    <p>{{ $body }}</p>
    <ul>
        <li><strong>Asset ID: </strong> {{ $id }}</li>
        <li><strong>Asset Name: </strong> {{ $assetname }}</li>
        <li><strong>Description: </strong> {{ $description }}</li>
        <li><strong>Location: </strong> {{ $location }}</li>
		<li><strong>Service Date: </strong> {{ $servicedate }}</li>
		<li><strong>Instruction: </strong> {{ $instruction }}</li>
    </ul>
    <p>Thank you!</p>
    <p>Service App</p>
</body>
</html>
