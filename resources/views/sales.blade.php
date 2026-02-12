<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Top 10 Customers by Total Purchase</title>
    @vite('resources/css/app.css')
</head>
<body>
    <h1 class="mb-5 font-bold">Top 10 Customers by Sales:</h1>
    <table class="border">
        <thead>
            <tr>
                <th>Company Name</th>
                <th>Country</th>
                <th>Total Purchase</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $topSales)
            <tr>
                <td>{{ $topSales->company_name }}</td>
                <td>{{ $topSales->country }}</td>
                <td>${{ $topSales->total_purchase }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
