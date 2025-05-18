<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt #{{ $receipt->receipt_number  }}</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .content { margin: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Payment Receipt</h2>
        <p>Receipt #: {{ $receipt->receipt_number }}</p>
        <p>Invoice No #: {{ $receipt->invoice->invoice_number }}</p>
    </div>

    <div class="content">
        <p><strong>Customer:</strong> {{ $receipt->customer->name }}</p>
        <p><strong>Amount Paid:</strong> ${{ number_format($receipt->amount_paid, 2) }}</p>
        <p><strong>Payment Date:</strong> {{ $receipt->paid_at}}</p>
    </div>
    <div class="content">
        <h3>Payment Details</h3>
        <p><strong>Payment Method:</strong> {{ $receipt->payment_method }}</p>
        
    <footer style="margin-top: 50px; text-align: center;">
        Thank you for your payment!
    </footer>
</body>
</html>
