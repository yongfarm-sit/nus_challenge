<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Microsoft 365 Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom Styles */
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        
        .full-page {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        
        .container {
            max-width: 600px;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .btn-primary {
            background-color: #007bff;
            border-color: #0069d9;
            font-size: 1.2rem;
            padding: 15px 30px;
        }
        
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .alert {
            background-color: #e3f2fd;
            border-color: #bbdefb;
        }
    </style>
</head>
<body>
    <div class="full-page">
        <div class="container">
            <div class="alert alert-info">
                <h3>Welcome to FinTrack</h3>
                <p>We use Microsoft 365 for accessing this webpage. Click the button below to login.</p>
            </div>
            <a href="{{ route('connect') }}" class="btn btn-primary btn-lg mt-3">Login with your Microsoft Account</a>
        </div>
    </div>

    <!-- Bootstrap JS (Optional for additional components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
