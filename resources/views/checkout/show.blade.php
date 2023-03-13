<!doctype html>
<html lang="en">
<head>
    <title>Checkout</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            color: #333;
        }
        .container {
            max-width: 960px;
            margin: 0 auto;
            padding: 20px;
        }
        h1, h2 {
            margin-top: 0;
        }
        table {
            border-collapse: collapse;
            margin-bottom: 20px;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
            box-sizing: border-box;
        }
        button[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: none;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Checkout</h1>
    <h2>Order Summary</h2>
    <table>
        <thead>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total price</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $order->product_title }}</td>
            <td>{{ $order->total_cost . ' Rial' }}</td>
            <td>{{ 1 }}</td>
            <td>{{ $order->total_cost * 1 . ' Rial' }}</td>
        </tr>
        </tbody>
    </table>
    <form action="{{ route('payment.pay', $order->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="card_number">Card Number</label>
            <input type="text" name="card_number" id="card_number" required>
            @error('card_number')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit">Pay Now</button>
    </form>
</div>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
