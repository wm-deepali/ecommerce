<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        {{ $general?->site_name ?? config('app.name') }} - Maintenance
    </title>

    <link rel="icon"
        href="{{ $general?->favicon
            ? asset('storage/'.$general->favicon)
            : asset('favicon.ico') }}">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f9f5f6;
            font-family: Arial, Helvetica, sans-serif;
            padding: 20px;
        }

        .maintenance-wrapper {
            max-width: 700px;
            width: 100%;
            text-align: center;
            background: #fff;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0,0,0,.08);
        }

        .logo img {
            max-width: 180px;
            height: auto;
            margin-bottom: 25px;
        }

        .icon {
            font-size: 70px;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 36px;
            color: #222;
            margin-bottom: 15px;
        }

        p {
            color: #666;
            font-size: 16px;
            line-height: 1.8;
        }

        .brand {
            color: #c98f9d;
            font-weight: 700;
        }

        .contact-box {
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px solid #eee;
        }

        .contact-box a {
            color: #c98f9d;
            text-decoration: none;
            font-weight: 600;
        }

        .footer-text {
            margin-top: 25px;
            color: #999;
            font-size: 13px;
        }

        @media(max-width:768px) {
            .maintenance-wrapper {
                padding: 30px 20px;
            }

            h1 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>

<div class="maintenance-wrapper">

    <div class="logo">
        @if($general?->logo)
            <img
                src="{{ asset('storage/'.$general->logo) }}"
                alt="{{ $general?->site_name }}">
        @endif
    </div>

    <div class="icon">
        🛠️
    </div>

    <h1>We're Improving Our Website</h1>

    <p>
        Thank you for visiting
        <span class="brand">
            {{ $general?->site_name ?? config('app.name') }}
        </span>.
    </p>

    <p style="margin-top:10px;">
        Our website is currently undergoing scheduled maintenance to improve
        your shopping experience. We will be back online shortly.
    </p>

    <div class="contact-box">

        @if($general?->support_email)
            <p>
                Support:
                <a href="mailto:{{ $general->support_email }}">
                    {{ $general->support_email }}
                </a>
            </p>
        @endif

        @if($general?->phone)
            <p style="margin-top:8px;">
                Phone:
                <a href="tel:{{ $general->phone }}">
                    {{ $general->phone }}
                </a>
            </p>
        @endif

    </div>

    <div class="footer-text">
        © {{ date('Y') }}
        {{ $general?->site_name ?? config('app.name') }}
        • All Rights Reserved
    </div>

</div>

</body>
</html>