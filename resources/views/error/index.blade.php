<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error Page</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .error-container {
            max-width: 500px;
            margin: 100px auto;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 40px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 32px;
            color: #d9534f;
            margin-bottom: 20px;
            text-align: center;
        }
        p {
            font-size: 18px;
            margin-bottom: 30px;
            text-align: center;
        }
        .btn {
            padding: 10px 20px;
            font-size: 18px;
            display: block;
            margin: 0 auto;
            width: 50%;
        }
    </style>
</head>
<body>
    <div class="container error-container">
        <h1>Oops! Something went wrong.</h1>
        <p>I apologize for the inconvenience. Talk With MIS</p>
        <a href="{{ url('/home') }}" class="btn btn-danger" onclick="goBack()">GO Back</a>
    </div>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
