<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment Failed</title>
    <style>
        /* Inline CSS styles */
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
            font-size: 16px;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        h1 {
            font-size: 32px;
            color: #d8000c;
            margin-bottom: 30px;
        }

        p {
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #d8000c;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: #c6000a;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Payment Failed</h1>
    <p>{{ $errorMessage }}</p>
    <p>Please check your payment details and try again later.</p>
</div>
</body>
</html>
