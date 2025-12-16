<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    
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
        
        /* 3. TEXT SHADOW */
        .text-shadow-custom {
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5); /* Dibuat lebih gelap untuk hero image */
        }
        
        /* --- STYLE KHUSUS HALAMAN HOME --- */
        
        /* Container hero */
        .hero-container {
            position: relative;
            width: 100%;
            height: 100vh;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
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
            /* Kita ubah warna ini agar sesuai dengan font, tapi tetap putih karena di atas gambar */
            color: white !important; 
        }

        /* Header di dalam gambar */
        .hero-header {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            z-index: 100;
            color: white !important;
            padding: 1rem 0;
        }

        /* Footer terpisah */
        .footer {
            width: 100%;
            text-align: center;
            color: white;
            margin-top: auto;
        }
    </style>
</head>

<body style="background-color:#172B4D; margin:0;">
    <x-chatbot />
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
                    <p class="fw-bold fs-1 font-montserrat text-shadow-custom">Tired of Searching Jobs?</p>
                </div>
                <div class="w-100" style="max-width:500px;">
                    <p class="fw-semibold fs-6 fs-md-5 fs-lg-4 text-start font-inter text-shadow-custom">

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
