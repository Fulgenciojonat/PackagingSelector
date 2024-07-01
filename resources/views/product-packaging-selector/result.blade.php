<!-- resources/views/result.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Packaging Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Packaging Result</h1>
    @foreach ($result as $index => $packaging)
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">Box {{ $index + 1 }}: {{ $packaging['box']->name }}</h3>
            </div>
            <div class="card-body">
                <p><strong>Box Dimensions:</strong> {{ $packaging['box']->length }}x{{ $packaging['box']->width }}x{{ $packaging['box']->height }} cm</p>
                <p><strong>Weight Limit:</strong> {{ $packaging['box']->weight_limit }} kg</p>
                <h4>Products in this box:</h4>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Dimensions (cm)</th>
                        <th>Weight (kg)</th>
                        <th>Quantity</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($packaging['products'] as $product)
                        <tr>
                            <td>{{ $product->length }}x{{ $product->width }}x{{ $product->height }}</td>
                            <td>{{ $product->weight }}</td>
                            <td>{{ $product->quantity }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
    <a href="{{ route('product-packaging-selector.form') }}" class="btn btn-secondary">Back to Input Form</a>
</div>
</body>
</html>
