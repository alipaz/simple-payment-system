<!DOCTYPE html>
<html>
<head>
    <title>Payment Successful</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        .container {
            width: 90%;
            margin: auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0px 0px 5px #cccccc;
        }
        h1 {
            color: #3c763d;
            font-size: 28px;
        }
        p {
            color: #555555;
            font-size: 16px;
            line-height: 1.5;
        }
        .success-message {
            color: #3c763d;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .order-details {
            margin-bottom: 20px;
        }
        .order-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .order-details table td {
            padding: 5px;
            border: 1px solid #cccccc;
        }
        .order-details table th {
            padding: 5px;
            border: 1px solid #cccccc;
            text-align: left;
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Payment Successful</h1>
    <div class="success-message">Thank you for your payment!</div>
    <div class="order-details">
        <p>Here are the details of your order:</p>
        <table>
            <tr>
                <th>Order ID</th>
                <td>{{ $payment->order_id }}</td>
            </tr>
            <tr>
                <th>Order Total</th>
                <td>{{ $payment->amount . " Rial" }}</td>
            </tr>
            <tr>
                <th>Payment Transaction Id</th>
                <td>{{ $payment->transaction_id }}</td>
            </tr>
            <tr>
                <th>Payment Tracking Code</th>
                <td>{{ $payment->tracking_code }}</td>
            </tr>
            <tr>
                <th>Payment Date</th>
                <td>{{ $payment->payed_at }}</td>
            </tr>
        </table>
    </div>
    <p>Thank you for shopping with us!</p>
</div>
</body>
</html>
