<!DOCTYPE html>
<html>
<head>
    <title>Generate Property Description</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Generate Property Description</h2>
    <form action="{{ route('Office.generate-description') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="property_id">Property ID</label>
            <input type="text" class="form-control" id="property_id" name="property_id" required>
        </div>
        <div class="form-group">
            <label for="productType">Product Type</label>
            <input type="text" class="form-control" id="productType" name="productType" value="property-description" required>
        </div>
        <div class="form-group">
            <label for="language">Language</label>
            <input type="text" class="form-control" id="language" name="language" value="English" required>
        </div>
        <!-- Add more input fields as needed -->
        <button type="submit" class="btn btn-primary">Generate Description</button>
    </form>

    @if (isset($description))
        <div class="mt-5">
            <h4>Generated Description:</h4>
            <p>{{ $description }}</p>
        </div>
    @endif
</div>
</body>
</html>
