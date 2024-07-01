<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Packaging Selector</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    @if(isset($errorMessage))
        <div class="error-message" style="color: red;">
            {{ $errorMessage }}
        </div>
    @endif
    <h1 class="mb-4">Product Packaging Selector</h1>
    <form method="POST" action="{{ route('product-packaging-selector.process') }}">
        @csrf
        <div class="row">
            @for ($i = 1; $i <= 10; $i++)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Product {{ $i }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="product{{ $i }}_length" class="form-label">Length (cm)</label>
                                <input type="number" step="0.01" class="form-control" id="product{{ $i }}_length" name="product{{ $i }}_length" placeholder="Length">
                            </div>
                            <div class="mb-3">
                                <label for="product{{ $i }}_width" class="form-label">Width (cm)</label>
                                <input type="number" step="0.01" class="form-control" id="product{{ $i }}_width" name="product{{ $i }}_width" placeholder="Width">
                            </div>
                            <div class="mb-3">
                                <label for="product{{ $i }}_height" class="form-label">Height (cm)</label>
                                <input type="number" step="0.01" class="form-control" id="product{{ $i }}_height" name="product{{ $i }}_height" placeholder="Height">
                            </div>
                            <div class="mb-3">
                                <label for="product{{ $i }}_weight" class="form-label">Weight (kg)</label>
                                <input type="number" step="0.01" class="form-control" id="product{{ $i }}_weight" name="product{{ $i }}_weight" placeholder="Weight">
                            </div>
                            <div class="mb-3">
                                <label for="product{{ $i }}_quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="product{{ $i }}_quantity" name="product{{ $i }}_quantity" placeholder="Quantity">
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
        <button type="submit" class="btn btn-primary mt-3">Calculate Packaging</button>
    </form>
</div>
</body>
</html>
