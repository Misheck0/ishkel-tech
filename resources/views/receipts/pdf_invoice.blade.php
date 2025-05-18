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
            margin-top: 50px;
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
        <p> {{ $company->email }} </p>
        <p> {{ $company->tpin }} </p>


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
                <th style="padding: 8px; text-align: left; border: 1px solid #999;">Invoice </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding: 8px; border: 1px solid #999; line-height: 1.6;">
                    <strong>Quotation Number:</strong> {{ $invoice->quotation_id }}<br>
                    <strong>Invoice Number:</strong> {{ $invoice->invoice_number }}<br>
                    <strong>Invoice Date:</strong> {{ $invoice->created_at }}<br>
                   
                </td>
            </tr>
        </tbody>
    </table>
 
  <!-- Sold To -->
  
  <table style="width: 300px; border-collapse: collapse; margin-top: 20px;">
    <thead>
        <tr style="background-color: #f0f0f0;">
            <th style="padding: 8px; text-align: left; border: 1px solid #999;">SOLD TO</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="padding: 8px; border: 1px solid #999; line-height: 1.6;">
                <!-- company -->
                <strong>Company</strong><br>
                {{ $invoice->customer->name }}<br>
                {{ $invoice->customer->number }}<br>
                TPIN: {{ $invoice->customer->customer_tpin ?? '-' }} <br> 
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
                <th>Description</th>
                <th>Qty</th>
                <th>Unit Price (ZMW)</th>
                <th>Total (ZMW)</th>
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
                $vat = $subtotal * 0.00;
                $total = $subtotal + $vat;
            @endphp
            <tr class="totals">
                <td colspan="3"></td>
                <td>Subtotal</td>
                <td>{{ number_format($subtotal, 2) }} ZMW</td>
            </tr>
            <tr class="totals">
                <td colspan="3"></td>
                <td>VAT (0%)</td>
                <td>{{ number_format($vat, 2) }} ZMW</td>
            </tr>
            <tr class="totals">
                <td colspan="3"></td>
                <td>Total (ZMW)</td>
                <td>{{ number_format($total, 2) }} ZMW</td>
            </tr>
        </tfoot>
        
    </table>

<!-- we have images in the public folder for the company -->
    <br><br><br><br><br><br><br>
<!-- bank details  should be on botton left side  -->
<div style=" bottom: 0; left: 0; width: 100%; text-align: left; font-size: 11px; color: #555; padding-bottom: 10px;">
    <p><strong>Bank Details:</strong></p>
    <p>Bank Name: Zambia Industrial Commercial Bank (ZICB) </p>
    <p>Account Name: ISHKEL TECH ENTERPRISES</p>
    <p>Account Number: 1010178142884 </p>
    <p>Sort Code: 140012 </p>
    <p>SWIFT Code: ZICBZMLU</p>
    <p> Branch name: LUSAKA Industrial Branch </p>
</div>

   <!-- Sticky footer -->
   <div class="footer" style="
   position: absolute;
   bottom: 0;
   left: 0;
   width: 100%;
   text-align: center;
   font-size: 11px;
   color: #555;
   padding-top: 10px;
   border-top: 1px solid #ccc;
">
   <p>For any inquiries, please contact us.. </p>
</div>
</body>
</html>
<!-- This is a Blade template for generating a PDF invoice. It includes the company logo, customer details, invoice items, and totals. The layout is styled using inline CSS for better compatibility with PDF generation libraries. -->