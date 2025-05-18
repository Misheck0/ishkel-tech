<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Created</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            margin: auto;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        .button {
            display: inline-block;
            background-color: #3490dc;
            color: #ffffff;
            padding: 12px 24px;
            margin-top: 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }
        .credentials {
            background: #f1f1f1;
            padding: 15px;
            border-radius: 5px;
            margin-top: 15px;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #777777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hello {{ $name }},</h2>

        <p>Your account has been created successfully 🎉.</p>

        <div class="credentials">
            <p><strong>Email:</strong> {{ $email }}</p>
            <p><strong>Password:</strong> {{ $password }}</p>
        </div>

        <p>Please login and change your password after logging in.</p>

        <a href="{{ route('login') }}" class="button">Login Now</a>

        <div class="footer">
            <p>Thanks,<br>{{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>
