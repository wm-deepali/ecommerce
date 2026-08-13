<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Something Went Wrong</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f1f2f4;
            color: #202223;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }
        .error-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,.08), 0 0 0 1px #e3e5e8;
            padding: 48px 40px;
            max-width: 460px;
            text-align: center;
        }
        .error-icon {
            width: 64px;
            height: 64px;
            background: #fce8e8;
            color: #b22222;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin: 0 auto 20px;
        }
        h1 { font-size: 20px; font-weight: 650; margin-bottom: 8px; }
        p { font-size: 14px; color: #6d7175; line-height: 1.6; margin-bottom: 24px; }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #303d89;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 22px;
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            transition: background .15s;
        }
        .btn:hover { background: #252f70; }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="error-icon">!</div>
        <h1>Something went wrong on our end</h1>
        <p>We've hit an unexpected error. Our team has been notified and is looking into it. Please try again in a few minutes.</p>
        <a href="/" class="btn">Back to Homepage</a>
    </div>
</body>
</html>