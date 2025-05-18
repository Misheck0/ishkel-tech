<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 40px;
            color: #333;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
        }
        .company-info {
            text-align: right;
        }
        .logo {
            width: 120px;
        }
        h1 {
            margin-bottom: 5px;
            font-size: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 11px;
        }
        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
        }
        .totals td {
            font-weight: bold;
            
        }
        .footer {
            margin-top: 10px;
            font-size: 11px;
            color: #555;
        }
        table td, table th {
    border: none;
}

    </style>
</head>
<body>
    <div class="company-info" style="position: absolute; right: 0; top: 0; text-align: right; margin-right: 10px;">
        <h1>{{ $company->company_name }}</h1>
        <p>{{ $company->address }}</p>
        <p> {{ $company->number }} / +260 771882005 </p>
        <p> EMAIL: {{ $company->email }} </p>
        <p>TPIN: {{ $company->tpin }} </p>


    </div>
    <div class="header" style="position: relative; display: flex; justify-content: flex-start; align-items: flex-start; margin-bottom: 30px;">
     
        <div class="logo" style="margin-left: 20px;">
            <img src="{{ public_path('Images/logo.jpg') }}" alt="Company Logo" style="width: 140px; height: auto;">

        </div>
    </div>
    
    
    <br><br><br><br>
    <table style="width: 300px; border-collapse: collapse; margin-top: 20px; float: right;">
        <thead>
            <tr style="background-color: #f0f0f0;">
                <th style="padding: 8px; text-align: left; border: 1px solid #999;">Quotation </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding: 8px; border: 1px solid #999; line-height: 1.6;">
                    <strong>Quotation Number:</strong> {{ $invoice->quotation_id }}<br>
                    <strong>Quotation Date:</strong> {{ $invoice->created_at->format('Y-m-d') }}<br>
                    <strong>Due Date:</strong> {{ $invoice->deadline->format('Y-m-d') }}<br>
                </td>
            </tr>
        </tbody>
    </table>
 
  <!-- Sold To -->
  
  <table style="width: 300px; border-collapse: collapse; margin-top: 20px;">
    <thead>
        <tr style="background-color: #f0f0f0;">
            <th style="padding: 8px; text-align: left; border: 1px solid #999;">QUOTATION TO</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="padding: 8px; border: 1px solid #999; line-height: 1.6;">
                <!-- company -->
                <strong>Company</strong><br>
                {{ $invoice->customer->name }}<br>
                {{ $invoice->customer->number }}<br>
               
                {{ $invoice->customer->address ?? 'ZAMBIA LUSAKA' }}
               
            </td>
        </tr>
    </tbody>
</table>



    
    

    <!-- Invoice Items Table -->
    <table>
        <thead style="background-color: #e5e7eb; font-weight: bold;">
            <tr>
                <th>#</th>
                <th>DESCRIPTION</th>
                <th>QTY</th>
                <th>UNIT PRICE (ZMW)</th>
                <th>TOTAL (ZMW)</th>
            </tr>
        </thead>
        
        <tbody>
            @php $subtotal = 0; @endphp
            @foreach ($invoice->items as $index => $item)
                @php
                    $lineTotal = $item->quantity * $item->unit_price;
                    $subtotal += $lineTotal;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->unit_price, 2) }}</td>
                    <td>{{ number_format($lineTotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            @php
                $vat = $subtotal * 0.05;
                $total = $subtotal + $vat;
            @endphp
            <tr class="totals">
                <td colspan="3"></td>
                <td>Sub total</td>
                <td>{{ number_format($subtotal, 2) }} ZMW</td>
            </tr>
            <tr class="totals">
                <td colspan="3"></td>
                <td>VAT (5%)</td>
                <td>{{ number_format($vat, 2) }} ZMW</td>
            </tr>
            <tr class="totals">
                <td colspan="3"></td>
                <td>Total (ZMW)</td>
                <td>{{ number_format($total, 2) }} ZMW</td>
            </tr>
        </tfoot>
        
    </table>

<!-- info that this is a quotation is valid for 7 days -->
    <div style="margin-top: 20px; font-size: 11px; color: #555;">
     <strong>    <p>This quotation is valid for 7 days from the date of issue.</p> </strong>
        <p>Thank you for your business!</p>
    </div>

    <div class="footer">
        <p>For any inquiries, please contact us at {{ $company->email }} or call us at {{ $company->number }}.</p>
    </div>

</body>
</html>
