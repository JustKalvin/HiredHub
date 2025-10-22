<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            background-color: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-family: Arial, sans-serif;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 320px;
        }

        .google-btn,
        .logout-btn {
            background-color: #4285F4;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 15px;
        }

        .logout-btn {
            background-color: #d9534f;
        }

        .google-btn:hover {
            background-color: #357ae8;
        }

        .logout-btn:hover {
            background-color: #c9302c;
        }

        img {
            border-radius: 50%;
            width: 80px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        @if (Auth::check())
            <h2>Welcome, {{ Auth::user()->name }}!</h2>
            <p>{{ Auth::user()->email }}</p>
            @if (Auth::user()->avatar)
                <img src="{{ Auth::user()->avatar }}" alt="User Avatar">
            @endif
            <form action="{{ route('logout') }}" method="GET">
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        @else
            <h2>Login to HireHub</h2>
            <p>Silakan login menggunakan akun Google Anda</p>
            <a href="{{ url('/auth/google') }}">
                <button class="google-btn">Login with Google</button>
            </a>
        @endif
    </div>
</body>

</html>
