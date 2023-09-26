<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        /* Internal CSS for styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            border:1px solid black;
            max-width: 800px;
            margin: 0 auto;
        }
        .invoice-header {
            text-align: center;
            background-color: #333;
            color: #fff;
            padding: 10px;
        }
        .invoice-header h1 {
            margin: 0;
        }
        .invoice-body {
            padding: 20px;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .invoice-table th, .invoice-table td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }
        .invoice-total {
            text-align: right;
            margin-top: 20px;
        }
        .invoice-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="invoice-header">
        <h1>Invoice</h1>
        <div>Order ID:</strong> {{$order->order_id}}</div>
    </div>
    <div class="invoice-body">

        <table class="invoice-table">
            <caption><strong>Order Date :</strong> {{$order->created_at}}</caption>
            <tr>
                <th>Bill to</th>
                <th>Shop Information</th>
            </tr>
            <tr>
                <td>
                     {{$order->name}}<br>
                     {{$order->phone}}<br>
                     {{$order->address}}<br>
                </td>
                <td>
                    {{getSetting('site_name')}}<br>
                    {!! getSetting('site_address') !!}<br>
                    {{getSetting('support_number')}}<br>
                    {{getSetting('facebook')}}<br>
                </td>
            </tr>
        </table>

        <table class="invoice-table">
            <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->products as $product)
                <tr>
                    <td>{{$product->title}}</td>
                    <td>{{$product['pivot']['quantity']}}</td>
                    <td>{{getSetting('currency')}}{{$product['pivot']['price']}}</td>
                    <td>{{getSetting('currency')}}{{$product['pivot']['sub_total']}}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th class="text-end" colspan="3">Sub Total</th>
                <th>{{getSetting('currency')}}{{$order->subtotal}}</th>
            </tr>
            <tr>
                <th class="text-end" colspan="3">Delivery Charge</th>
                <th>{{getSetting('currency')}}{{$order->delivery_charge}}</th>
            </tr>
            <tr>
                <th class="text-end" colspan="3">Total</th>
                <th>{{getSetting('currency')}}{{$order->delivery_charge + $order->subtotal}}</th>
            </tr>
            </tfoot>
        </table>
    </div>
    <div class="invoice-footer">
        <p>Thank you for your business! | Invoice Date:</strong> {{ $date }}</p>
    </div>
</div>
</body>
</html>
