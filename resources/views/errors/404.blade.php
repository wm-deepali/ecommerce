<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404 - Page Not Found</title>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f9fafb;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .box {
            text-align: center;
        }

        h1 {
            font-size: 120px;
            margin: 0;
            color: #f97316;
        }

        h2 {
            margin: 10px 0;
            font-size: 24px;
        }

        p {
            color: #6b7280;
            margin-bottom: 20px;
        }

        a {
            padding: 12px 25px;
            background: #f97316;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
        }

        a:hover {
            background: #ea580c;
        }
    </style>
</head>
<body>

<div class="box">
    <h1>404</h1>
    <h2>Oops! Page Not Found</h2>
    <p>The page you are looking for does not exist.</p>

    <a href="{{ url('/') }}">Go Home</a>
</div>

</body>
</html>