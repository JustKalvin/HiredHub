<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Home</title>
    <style>
        /* Container hero */
        .hero-container {
            position: relative;
            width: 100%;
            height: 100vh;
            /* full screen height */
            overflow: hidden;
            display: flex;
            justify-content: center;
            /* center gambar horizontal */
            align-items: center;
            /* center konten vertikal */
        }

        .hero-container-img {
            width: 90%;
            height: 95%;
            object-fit: cover;
            border-radius: 30px;
            margin-top: 30px;
        }

        /* Konten tengah */
        .hero-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
            text-align: center;
            color: white;
        }

        /* Header di dalam gambar */
        .hero-header {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            /* sama dengan width gambar */
            z-index: 100;
            color: white;
            padding: 1rem 0;
        }

        /* Footer terpisah */
        .footer {
            width: 100%;
            text-align: center;
            color: white;
            /* padding: 1rem 0; */
            margin-top: auto;
        }
    </style>
</head>

<body style="background-color:#172B4D; margin:0;">

    <div class="hero-container">
        <!-- Background Image -->
        <img class="hero-container-img" src="./images/HomeBackground.png" alt="Home Background" class="d-block">

        <!-- Header di dalam gambar -->
        <header class="hero-header">
            @include('components.header')
        </header>

        <!-- Konten Tengah -->
        <div class="hero-content d-flex flex-column justify-content-center align-items-center">

            <!-- Judul dan paragraf -->
            <div class="d-flex flex-row flex-md-row justify-content-between text-start align-items-center mt-5 w-100 gap-5"
                style="max-width:900px;">
                <div class="me-md-3 mb-3 mb-md-0">
                    <p class="fw-bold fs-1">Tired of Searching Jobs?</p>
                </div>
                <div class="w-100" style="max-width:500px;">
                    <p class="fw-bold fs-6 fs-md-5 fs-lg-4 text-start">
                        We understand. HiredHub is your single source of truth.
                        Find all jobs, from all major platforms,
                        presented with the best filters for your career path.
                    </p>
                </div>
            </div>

            <!-- Button dan ikon -->
            <div class="d-flex flex-column justify-content-center align-items-center mt-5">
                <button class="text-white fw-bold"
                    style="width:200px; background-color:#4B5767; border:10px solid transparent; border-radius: 15px">
                    Get Hired Now!
                </button>
                <a href="#" class="mt-4">
                    <img src="./images/ClickLogo.png" style="width:80px;" alt="Click Logo">
                </a>
            </div>

        </div>


    </div>

    <!-- Footer terpisah di bawah container -->
    <footer class="footer">
        @include('components.footer')
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
