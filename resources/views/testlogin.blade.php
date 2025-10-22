<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Opsi: Style untuk gambar agar mengisi kolom tanpa terdistorsi */
        .login-image {
            width: auto;
            height: 90vh;
            object-fit: cover;
            border-radius: 30px;
        }
    </style>
</head>

<body style="background-color: #172B4D">

    <div class="container-fluid">
        <div class="min-vh-100 d-flex flex-row justify-content-start align-items-center">

            <div class="col-lg-7 d-none d-lg-flex align-items-center justify-content-center p-0">
                <img src="./images/LoginImage.png" alt="Login Visual" class="login-image">
            </div>

            <div class="col-lg-5 d-flex flex-column justify-content-center align-items-center text-center p-4">

                <div class="mb-4">
                    <img src="./images/HiredHubLogo.png" alt="HiredHub Logo" class="img-fluid"
                        style="max-width: 250px;">
                </div>

                <div class="d-flex flex-column align-items-center mb-5">
                    <p class="fw-bold text-white fs-2 mb-2">Get Started</p>
                    <hr style="border: 1px solid white; width: 10rem;">
                </div>

                <div>
                    @auth
                        <div class="text-white mb-4">
                            <p class="fs-5 mb-0">Welcome, <strong>{{ auth()->user()->name }}</strong></p>
                            <p class="text-white-50 small">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ route('logout') }}" class="btn btn-danger btn-lg px-5">
                            Logout
                        </a>
                    @endauth

                    @guest
                        <a href="/auth/google" class="btn btn-light btn-lg px-5">
                            Login with Google
                        </a>
                    @endguest
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
