<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test Login</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* FONT PENTING */
        body {
            /* 1. SEMUA TEKS default-nya adalah Inter */
            font-family: 'Inter', sans-serif !important; 
            background-color: white;
            color: #172B4D; /* Warna teks default */
        }

        h1, h2, h3, h4, h5, h6, .font-montserrat {
            /* 2. JUDUL/HEADER/ELEMEN PENTING adalah Montserrat */
            font-family: 'Montserrat', sans-serif !important;
            font-weight: 700;
        }
        
        /* 3. TEXT SHADOW (Untuk Judul di Halaman Lain) */
        .text-shadow-custom {
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
        }
        
        /* --- STYLE KHUSUS HALAMAN INI --- */
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
