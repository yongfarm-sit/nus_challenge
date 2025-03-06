<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Form</title>
</head>
<body>
    <h1>Welcome to Gen AI Audit</h1>
    
    <!-- Form for uploading CSV file -->
    <form action="{{ route('upload.csv') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="csv_file" accept=".csv" required>
        <button type="submit">Upload CSV</button>
    </form>
</body>
</html>
