<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice Details</title>
</head>
<body>
    <h2>Invoice Details</h2>
    <p><strong>Invoice ID:</strong> {{ $invoice->InvoiceID }}</p>
    <p><strong>Invoice Date:</strong> {{ $invoice->InvoiceDate }}</p>
    <p><strong>Total Amount:</strong> ${{ $invoice->TotalAmount }}</p>
    <p><strong>Status:</strong> {{ $invoice->Status }}</p>
    <p>Thank you for your business!</p>
</body>
</html>
