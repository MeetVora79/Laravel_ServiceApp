<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Report PDF</title>
	<style>
		body {
			font-family: 'Arial', sans-serif;
			font-size: 10px;
		}

		table {
			width: 100%;
			border-collapse: collapse;
		}

		th,
		td {
			border: 1px solid black;
			padding: 4px;
			font-size: 10px;
			text-align: left;
		}

		th {
			background-color: #f2f2f2;
		}

		tr td:first-child {
			background-color: #f2f2f2;
			font-weight: bold;
		}
	</style>
</head>

<body>
	<h2>{{ $reportTitle }}</h2>
	<table>
		<tbody>
			@foreach($transformedData as $row)
			<tr>
				@foreach($row as $cell)
				<td>{{ $cell }}</td>
				@endforeach
			</tr>
			@endforeach
		</tbody>
	</table>
</body>

</html>