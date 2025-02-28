<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            max-height: 80px;
        }

        .header h1 {
            font-size: 24px;
            margin: 0;
        }

        .details, .summary, .items {
            margin-bottom: 20px;
        }

        .details h2, .summary h2, .items h2 {
            font-size: 18px;
            color: #555;
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
            padding-bottom: 5px;
        }

        .items table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .items table th, .items table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .items table th {
            background-color: #f4f4f4;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
    <img src="{{ URL::to('assets/img/logo.png') }}" alt="Logo" width="30" height="30">
        <h1>Billing Statement</h1>
    </div>

    <!-- Vendor & Bill Details -->
    <div class="details">
        <h2>Vendor Details</h2>
        <p><strong>Vendor Name:</strong> {{ $bill->vendor->CompanyName }}</p>
        <p><strong>Vendor Address:</strong> {{ $bill->vendor->Address }}</p>
        <p><strong>Contact:</strong> {{ $bill->vendor->MobileNumber }}</p>
        <p><strong>Email:</strong> {{ $bill->vendor->ContactEmail }}</p>
    </div>

    <div class="details">
        <h2>Bill Details</h2>
        <p><strong>Bill No:</strong> {{ $bill->bill_no }}</p>
        <p><strong>Bill Date:</strong> {{ \Carbon\Carbon::parse($bill->bill_date)->format('d M Y') }}</p>
        <p><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($bill->due_date)->format('d M Y') }}</p>
        <p><strong>Status:</strong> {{ $bill->bill_status }}</p>
        <p><strong>Payment Term:</strong> {{ $bill->payment_term }}</p>
        <p><strong>Billing Address:</strong> {{ $bill->billing_address }}</p>
    </div>

    <!-- Items -->
    <div class="items">
        <h2>Items</h2>
        <table>
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bill->items as $item)
                <tr>
                    <td>{{ $item->item_name }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>${{ number_format($item->unit_price, 2) }}</td>
                    <td>${{ number_format($item->total_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Summary -->
    <div class="summary">
        <h2>Summary</h2>
        <p><strong>Total Amount:</strong> ${{ number_format($bill->total_amount, 2) }}</p>
        <p><strong>Memo:</strong> {{ $bill->memo }}</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Thank you for your business!</p>
        <p>If you have any questions, contact us at info@company.com</p>
    </div>
</body>
</html>
